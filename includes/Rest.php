<?php
/**
 * REST API endpoints.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Read-only endpoints under wp-bom/v1.
 *
 * These replace the untouched "Hello world" boilerplate controller the plugin
 * shipped with. Both routes require the caller to be able to read the item.
 */
final class Rest {

	private const NAMESPACE = 'wp-bom/v1';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register the routes.
	 */
	public function register_routes(): void {
		register_rest_route(
			self::NAMESPACE,
			'/items',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'search_items' ],
				'permission_callback' => [ $this, 'can_edit_items' ],
				'args'                => [
					'search' => [
						'type'              => 'string',
						'required'          => false,
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field',
					],
					'type'   => [
						'type'     => 'string',
						'required' => false,
						'default'  => '',
						'enum'     => [ '', PostTypes::PART, PostTypes::ASSEMBLY ],
					],
					'limit'  => [
						'type'              => 'integer',
						'required'          => false,
						'default'           => 30,
						'sanitize_callback' => 'absint',
					],
				],
			]
		);

		register_rest_route(
			self::NAMESPACE,
			'/bom/(?P<id>\d+)',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_bom' ],
				'permission_callback' => [ $this, 'can_read_item' ],
				'args'                => [
					'id'  => [
						'type'              => 'integer',
						'required'          => true,
						'sanitize_callback' => 'absint',
					],
					'qty' => [
						'type'     => 'number',
						'required' => false,
						'default'  => 1,
					],
				],
			]
		);
	}

	/**
	 * Only editors can enumerate the catalogue.
	 */
	public function can_edit_items(): bool {
		return current_user_can( 'edit_posts' );
	}

	/**
	 * A caller may read a BOM if they can read the underlying post.
	 *
	 * @param \WP_REST_Request $request Current request.
	 */
	public function can_read_item( \WP_REST_Request $request ): bool {
		$id   = absint( $request->get_param( 'id' ) );
		$post = get_post( $id );

		if ( ! $post instanceof \WP_Post ) {
			return false;
		}

		if ( 'publish' === $post->post_status && Settings::public_bom() ) {
			return true;
		}

		return current_user_can( 'read_post', $id );
	}

	/**
	 * Search parts and assemblies.
	 *
	 * @param \WP_REST_Request $request Current request.
	 */
	public function search_items( \WP_REST_Request $request ): \WP_REST_Response {
		$search = (string) $request->get_param( 'search' );
		$type   = (string) $request->get_param( 'type' );
		$limit  = min( 100, max( 1, (int) $request->get_param( 'limit' ) ) );

		$posts = get_posts(
			[
				'post_type'        => '' !== $type ? $type : PostTypes::ITEM_TYPES,
				'post_status'      => [ 'publish', 'draft', 'pending', 'private' ],
				'posts_per_page'   => $limit,
				's'                => $search,
				'orderby'          => 'title',
				'order'            => 'ASC',
				'no_found_rows'    => true,
				'suppress_filters' => false,
			]
		);

		$results = [];

		foreach ( $posts as $post ) {
			$results[] = [
				'id'          => $post->ID,
				'title'       => $post->post_title,
				'type'        => $post->post_type,
				'part_number' => Meta::get_string( $post->ID, Meta::PART_NUMBER ),
				'revision'    => Meta::get_string( $post->ID, Meta::REVISION ),
				'uom'         => Meta::get_string( $post->ID, Meta::UOM ),
				'unit_cost'   => Meta::get_float( $post->ID, Meta::UNIT_COST ),
			];
		}

		return rest_ensure_response( $results );
	}

	/**
	 * Return the exploded tree, flat list and totals for an item.
	 *
	 * @param \WP_REST_Request $request Current request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function get_bom( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error {
		$id  = absint( $request->get_param( 'id' ) );
		$qty = (float) $request->get_param( 'qty' );

		$target = self::resolve_target( $id, $qty );

		if ( null === $target ) {
			return new \WP_Error(
				'wpbom_not_found',
				__( 'No part, assembly or BOM with that ID.', 'wp-bom' ),
				[ 'status' => 404 ]
			);
		}

		$tree = Explosion::tree( $target['id'], $target['qty'] );

		if ( null === $tree ) {
			return new \WP_Error(
				'wpbom_not_found',
				__( 'That item cannot be exploded.', 'wp-bom' ),
				[ 'status' => 404 ]
			);
		}

		return rest_ensure_response(
			[
				'root'    => [
					'id'    => $tree['id'],
					'title' => $tree['title'],
					'type'  => $tree['type'],
				],
				'summary' => Explosion::summary( $tree ),
				'tree'    => $tree,
				'flat'    => Explosion::flatten( $tree, false, false ),
			]
		);
	}

	/**
	 * Resolve an ID that may be a BOM document into the assembly it points at.
	 *
	 * @param int   $id  Requested ID.
	 * @param float $qty Requested quantity; 0 or less falls back to the stored one.
	 *
	 * @return array{id:int, qty:float}|null
	 */
	public static function resolve_target( int $id, float $qty = 1.0 ): ?array {
		$post = get_post( $id );

		if ( ! $post instanceof \WP_Post ) {
			return null;
		}

		if ( PostTypes::BOM === $post->post_type ) {
			$root_id = (int) get_post_meta( $id, Meta::ROOT_ID, true );

			if ( $root_id <= 0 ) {
				return null;
			}

			if ( $qty <= 0 ) {
				$stored = Meta::get_float( $id, Meta::BUILD_QTY );
				$qty    = $stored > 0 ? $stored : 1.0;
			}

			return [
				'id'  => $root_id,
				'qty' => $qty,
			];
		}

		if ( ! in_array( $post->post_type, PostTypes::ITEM_TYPES, true ) ) {
			return null;
		}

		return [
			'id'  => $id,
			'qty' => $qty > 0 ? $qty : 1.0,
		];
	}
}
