<?php
/**
 * Post type and taxonomy registration.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Registers the BOM content model.
 *
 * The original plugin gated registration on get_option('wpb_settings')['activecpt']
 * without checking the option existed, which fatals on a fresh install and meant
 * no post type was ever registered. Everything here falls back to a hard-coded
 * default set, so a fresh activation always produces a usable plugin.
 */
final class PostTypes {

	public const PART     = 'part';
	public const ASSEMBLY = 'assembly';
	public const BOM      = 'bom';

	public const TAX_VENDOR   = 'wpbom_vendor';
	public const TAX_CATEGORY = 'wpbom_category';
	public const TAX_LOCATION = 'wpbom_location';

	/**
	 * Post types that can appear as a BOM line item.
	 *
	 * @var string[]
	 */
	public const ITEM_TYPES = [ self::PART, self::ASSEMBLY ];

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'init', [ $this, 'register_post_types' ], 5 );
		add_action( 'init', [ $this, 'register_taxonomies' ], 6 );
		add_filter( 'post_updated_messages', [ $this, 'post_updated_messages' ] );
		add_action( 'admin_menu', [ $this, 'reorder_menu' ] );
	}

	/**
	 * Every post type this plugin owns.
	 *
	 * @return string[]
	 */
	public static function all(): array {
		return [ self::PART, self::ASSEMBLY, self::BOM ];
	}

	/**
	 * Human label for a post type slug.
	 */
	public static function label( string $post_type ): string {
		$labels = [
			self::PART     => __( 'Part', 'wp-bom' ),
			self::ASSEMBLY => __( 'Assembly', 'wp-bom' ),
			self::BOM      => __( 'BOM', 'wp-bom' ),
		];

		return $labels[ $post_type ] ?? $post_type;
	}

	/**
	 * Register part, assembly and BOM post types.
	 */
	public function register_post_types(): void {
		register_post_type(
			self::PART,
			$this->post_type_args(
				[
					'plural'   => __( 'Parts', 'wp-bom' ),
					'singular' => __( 'Part', 'wp-bom' ),
					'slug'     => 'part',
					'icon'     => 'dashicons-screenoptions',
					'position' => 26,
				]
			)
		);

		register_post_type(
			self::ASSEMBLY,
			$this->post_type_args(
				[
					'plural'   => __( 'Assemblies', 'wp-bom' ),
					'singular' => __( 'Assembly', 'wp-bom' ),
					'slug'     => 'assembly',
					'icon'     => 'dashicons-forms',
					'position' => 27,
				]
			)
		);

		register_post_type(
			self::BOM,
			$this->post_type_args(
				[
					'plural'   => __( 'Bills of Materials', 'wp-bom' ),
					'singular' => __( 'BOM', 'wp-bom' ),
					'slug'     => 'bom',
					'icon'     => 'dashicons-media-spreadsheet',
					'position' => 28,
					'supports' => [ 'title', 'editor', 'revisions', 'author' ],
				]
			)
		);
	}

	/**
	 * Build register_post_type() args from a short spec.
	 *
	 * @param array<string, mixed> $spec Post type spec.
	 *
	 * @return array<string, mixed>
	 */
	private function post_type_args( array $spec ): array {
		$plural   = $spec['plural'];
		$singular = $spec['singular'];

		$labels = [
			'name'                  => $plural,
			'singular_name'         => $singular,
			'menu_name'             => $plural,
			'all_items'             => sprintf( /* translators: %s: plural post type label. */ __( 'All %s', 'wp-bom' ), $plural ),
			'add_new'               => __( 'Add New', 'wp-bom' ),
			'add_new_item'          => sprintf( /* translators: %s: singular post type label. */ __( 'Add New %s', 'wp-bom' ), $singular ),
			'edit_item'             => sprintf( /* translators: %s: singular post type label. */ __( 'Edit %s', 'wp-bom' ), $singular ),
			'new_item'              => sprintf( /* translators: %s: singular post type label. */ __( 'New %s', 'wp-bom' ), $singular ),
			'view_item'             => sprintf( /* translators: %s: singular post type label. */ __( 'View %s', 'wp-bom' ), $singular ),
			'search_items'          => sprintf( /* translators: %s: plural post type label. */ __( 'Search %s', 'wp-bom' ), $plural ),
			'not_found'             => sprintf( /* translators: %s: plural post type label. */ __( 'No %s found', 'wp-bom' ), strtolower( $plural ) ),
			'not_found_in_trash'    => sprintf( /* translators: %s: plural post type label. */ __( 'No %s found in Trash', 'wp-bom' ), strtolower( $plural ) ),
			'items_list'            => $plural,
			'item_published'        => sprintf( /* translators: %s: singular post type label. */ __( '%s published.', 'wp-bom' ), $singular ),
			'item_updated'          => sprintf( /* translators: %s: singular post type label. */ __( '%s updated.', 'wp-bom' ), $singular ),
			'attributes'            => sprintf( /* translators: %s: singular post type label. */ __( '%s Attributes', 'wp-bom' ), $singular ),
			'featured_image'        => __( 'Image', 'wp-bom' ),
			'set_featured_image'    => __( 'Set image', 'wp-bom' ),
			'remove_featured_image' => __( 'Remove image', 'wp-bom' ),
		];

		return [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => false,
			'show_in_rest'       => true,
			'menu_icon'          => $spec['icon'],
			'menu_position'      => $spec['position'],
			'capability_type'    => 'post',
			'map_meta_cap'       => true,
			// Flat, not hierarchical: nesting is expressed by line items, not by
			// post_parent. The original plugin set hierarchical => true, which put
			// a misleading "Parent" box on every screen.
			'hierarchical'       => false,
			'has_archive'        => true,
			'rewrite'            => [
				'slug'       => $spec['slug'],
				'with_front' => false,
			],
			'query_var'          => true,
			'supports'           => $spec['supports'] ?? [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'author' ],
		];
	}

	/**
	 * Register vendor, category and location taxonomies.
	 */
	public function register_taxonomies(): void {
		register_taxonomy(
			self::TAX_VENDOR,
			[ self::PART, self::ASSEMBLY ],
			$this->taxonomy_args(
				[
					'plural'       => __( 'Vendors', 'wp-bom' ),
					'singular'     => __( 'Vendor', 'wp-bom' ),
					'slug'         => 'vendor',
					'hierarchical' => false,
				]
			)
		);

		register_taxonomy(
			self::TAX_CATEGORY,
			[ self::PART, self::ASSEMBLY ],
			$this->taxonomy_args(
				[
					'plural'       => __( 'Part Categories', 'wp-bom' ),
					'singular'     => __( 'Part Category', 'wp-bom' ),
					'slug'         => 'part-category',
					'hierarchical' => true,
				]
			)
		);

		register_taxonomy(
			self::TAX_LOCATION,
			[ self::PART, self::ASSEMBLY ],
			$this->taxonomy_args(
				[
					'plural'       => __( 'Locations', 'wp-bom' ),
					'singular'     => __( 'Location', 'wp-bom' ),
					'slug'         => 'stock-location',
					'hierarchical' => true,
				]
			)
		);
	}

	/**
	 * Build register_taxonomy() args from a short spec.
	 *
	 * @param array<string, mixed> $spec Taxonomy spec.
	 *
	 * @return array<string, mixed>
	 */
	private function taxonomy_args( array $spec ): array {
		$plural   = $spec['plural'];
		$singular = $spec['singular'];

		return [
			'labels'            => [
				'name'          => $plural,
				'singular_name' => $singular,
				'menu_name'     => $plural,
				'search_items'  => sprintf( /* translators: %s: plural taxonomy label. */ __( 'Search %s', 'wp-bom' ), $plural ),
				'all_items'     => sprintf( /* translators: %s: plural taxonomy label. */ __( 'All %s', 'wp-bom' ), $plural ),
				'edit_item'     => sprintf( /* translators: %s: singular taxonomy label. */ __( 'Edit %s', 'wp-bom' ), $singular ),
				'add_new_item'  => sprintf( /* translators: %s: singular taxonomy label. */ __( 'Add New %s', 'wp-bom' ), $singular ),
				'new_item_name' => sprintf( /* translators: %s: singular taxonomy label. */ __( 'New %s Name', 'wp-bom' ), $singular ),
			],
			'public'            => true,
			'hierarchical'      => $spec['hierarchical'],
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [
				'slug'       => $spec['slug'],
				'with_front' => false,
			],
		];
	}

	/**
	 * Give the post types friendlier update notices.
	 *
	 * @param array<string, array<int, string>> $messages Existing messages.
	 *
	 * @return array<string, array<int, string>>
	 */
	public function post_updated_messages( array $messages ): array {
		foreach ( self::all() as $post_type ) {
			$label = self::label( $post_type );

			$messages[ $post_type ] = [
				0  => '',
				1  => sprintf( /* translators: %s: post type label. */ __( '%s updated.', 'wp-bom' ), $label ),
				4  => sprintf( /* translators: %s: post type label. */ __( '%s updated.', 'wp-bom' ), $label ),
				6  => sprintf( /* translators: %s: post type label. */ __( '%s published.', 'wp-bom' ), $label ),
				7  => sprintf( /* translators: %s: post type label. */ __( '%s saved.', 'wp-bom' ), $label ),
				8  => sprintf( /* translators: %s: post type label. */ __( '%s submitted.', 'wp-bom' ), $label ),
				10 => sprintf( /* translators: %s: post type label. */ __( '%s draft updated.', 'wp-bom' ), $label ),
			];
		}

		return $messages;
	}

	/**
	 * Placeholder for menu ordering; kept so the hook surface is stable.
	 */
	public function reorder_menu(): void {
		// Menu order is driven by menu_position in post_type_args().
	}
}
