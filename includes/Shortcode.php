<?php
/**
 * Front-end shortcode.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * [wp_bom] renders an exploded bill of materials on the front end.
 *
 * Attributes:
 *   id      Assembly, part or BOM post ID. Defaults to the current post.
 *   qty     Build quantity. Defaults to 1, or the BOM's stored quantity.
 *   view    tree | flat | both. Defaults to tree.
 *   totals  yes | no. Defaults to yes.
 *   depth   Override the configured maximum depth.
 */
final class Shortcode {

	public const TAG = 'wp_bom';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_shortcode( self::TAG, [ $this, 'render' ] );

		// The 2018 releases documented the tag with a hyphen. Keep it working.
		add_shortcode( 'wp-bom', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode.
	 *
	 * @param array<string, string>|string $atts Shortcode attributes.
	 */
	public function render( array|string $atts = [] ): string {
		$atts = shortcode_atts(
			[
				'id'     => 0,
				'qty'    => 0,
				'view'   => 'tree',
				'totals' => 'yes',
				'depth'  => 0,
			],
			is_array( $atts ) ? $atts : [],
			self::TAG
		);

		$id = absint( $atts['id'] );

		if ( 0 === $id ) {
			$id = (int) get_the_ID();
		}

		if ( $id <= 0 ) {
			return '';
		}

		$target = Rest::resolve_target( $id, (float) $atts['qty'] );

		if ( null === $target ) {
			return $this->notice( __( 'No bill of materials found for that item.', 'wp-bom' ) );
		}

		if ( ! $this->can_view( $id ) ) {
			return $this->notice( __( 'You do not have permission to view this bill of materials.', 'wp-bom' ) );
		}

		$tree = Explosion::tree( $target['id'], $target['qty'], absint( $atts['depth'] ) );

		if ( null === $tree ) {
			return $this->notice( __( 'That item cannot be exploded.', 'wp-bom' ) );
		}

		wp_enqueue_style( 'wpbom' );

		$view   = in_array( $atts['view'], [ 'tree', 'flat', 'both' ], true ) ? $atts['view'] : 'tree';
		$totals = ! in_array( strtolower( (string) $atts['totals'] ), [ 'no', 'false', '0' ], true );

		$html = '<div class="wpbom-shortcode">';

		if ( $totals ) {
			$html .= Render::totals( Explosion::summary( $tree ) );
		}

		if ( 'tree' === $view || 'both' === $view ) {
			$html .= Render::tree_table( $tree, false );
		}

		if ( 'flat' === $view || 'both' === $view ) {
			$html .= Render::flat_table( Explosion::flatten( $tree, false, false ), false );
		}

		return $html . '</div>';
	}

	/**
	 * Whether the current visitor may see this BOM.
	 */
	private function can_view( int $post_id ): bool {
		if ( current_user_can( 'read_post', $post_id ) ) {
			return true;
		}

		return Settings::public_bom() && 'publish' === get_post_status( $post_id );
	}

	/**
	 * A small inline message.
	 */
	private function notice( string $message ): string {
		return '<p class="wpbom-notice">' . esc_html( $message ) . '</p>';
	}
}
