<?php
/**
 * Script and style loading.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Loads the plugin's own CSS and JS, and nothing else.
 *
 * The previous version enqueued jQuery plugins from a CDN and from a
 * node_modules path that was never shipped, on the init hook rather than an
 * enqueue hook. Everything here is local, versioned, and correctly hooked.
 */
final class Assets {

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'front' ] );
	}

	/**
	 * Admin CSS and the line-item repeater script.
	 *
	 * @param string $hook Current admin page.
	 */
	public function admin( string $hook ): void {
		$screen = get_current_screen();
		$is_bom = $screen instanceof \WP_Screen && in_array( $screen->post_type, PostTypes::all(), true );

		// Also load on the settings page so the shared styles apply there.
		$is_settings = str_contains( $hook, Settings::PAGE_SLUG );

		if ( ! $is_bom && ! $is_settings ) {
			return;
		}

		wp_enqueue_style(
			'wpbom-admin',
			WPBOM_URL . 'assets/css/wpbom-admin.css',
			[],
			VERSION
		);

		if ( ! $is_bom ) {
			return;
		}

		wp_enqueue_script(
			'wpbom-admin',
			WPBOM_URL . 'assets/js/wpbom-admin.js',
			[],
			VERSION,
			true
		);

		wp_localize_script(
			'wpbom-admin',
			'wpBomL10n',
			[
				'confirmRemove' => __( 'Remove this line item?', 'wp-bom' ),
				'emptyRow'      => __( 'No line items yet.', 'wp-bom' ),
			]
		);
	}

	/**
	 * Front-end CSS, only when the shortcode has asked for it.
	 */
	public function front(): void {
		wp_register_style(
			'wpbom',
			WPBOM_URL . 'assets/css/wpbom.css',
			[],
			VERSION
		);
	}
}
