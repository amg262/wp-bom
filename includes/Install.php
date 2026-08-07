<?php
/**
 * Activation, deactivation and version upgrades.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Install-time work.
 *
 * These are static because register_activation_hook() calls them statically.
 * The previous version registered instance methods here, which is a fatal error
 * on PHP 8 and meant activation never completed.
 */
final class Install {

	private const VERSION_OPTION = 'wpbom_version';

	/**
	 * Run on plugin activation.
	 */
	public static function activate(): void {
		// Post types must exist before rewrite rules can be generated for them.
		$post_types = new PostTypes();
		$post_types->register_post_types();
		$post_types->register_taxonomies();

		add_option( Settings::OPTION, Settings::defaults() );
		update_option( self::VERSION_OPTION, VERSION );

		flush_rewrite_rules();
	}

	/**
	 * Run on plugin deactivation.
	 */
	public static function deactivate(): void {
		flush_rewrite_rules();
	}

	/**
	 * Handle upgrades for sites whose files changed without re-activation.
	 */
	public static function maybe_upgrade(): void {
		$installed = (string) get_option( self::VERSION_OPTION, '0' );

		if ( version_compare( $installed, VERSION, '>=' ) ) {
			return;
		}

		// 2.0.0 introduced the denormalised child index used by "where used".
		if ( version_compare( $installed, '2.0.0', '<' ) ) {
			self::rebuild_child_index();
		}

		add_option( Settings::OPTION, Settings::defaults() );
		update_option( self::VERSION_OPTION, VERSION );

		flush_rewrite_rules();
	}

	/**
	 * Rewrite the where-used index from stored line items.
	 */
	private static function rebuild_child_index(): void {
		$assemblies = get_posts(
			[
				'post_type'        => PostTypes::ASSEMBLY,
				'post_status'      => 'any',
				'posts_per_page'   => -1,
				'fields'           => 'ids',
				'no_found_rows'    => true,
				'suppress_filters' => false,
			]
		);

		foreach ( $assemblies as $assembly_id ) {
			$assembly_id = (int) $assembly_id;

			Meta::set_items( $assembly_id, Meta::get_items( $assembly_id ) );
		}
	}
}
