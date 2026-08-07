<?php
/**
 * Plugin Name:       WP BOM
 * Plugin URI:        https://github.com/amg262/wp-bom
 * Description:       Bill of Materials for WordPress. Track parts and assemblies, nest assemblies to any depth, and explode a multi-level BOM with quantity, cost and weight roll-up. No page builder, no ACF, no build step.
 * Version:           2.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            amg262
 * Author URI:        https://github.com/amg262
 * Text Domain:       wp-bom
 * Domain Path:       /languages
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VERSION = '2.0.0';

define( 'WPBOM_FILE', __FILE__ );
define( 'WPBOM_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPBOM_URL', plugin_dir_url( __FILE__ ) );

/**
 * PSR-4 style autoloader for the WPBom namespace.
 *
 * Maps WPBom\Foo\Bar to includes/Foo/Bar.php. Anything outside the namespace is
 * left for other autoloaders.
 */
spl_autoload_register(
	static function ( string $class ): void {
		$prefix = __NAMESPACE__ . '\\';
		$len    = strlen( $prefix );

		if ( 0 !== strncmp( $prefix, $class, $len ) ) {
			return;
		}

		$relative = substr( $class, $len );
		$path     = WPBOM_DIR . 'includes/' . str_replace( '\\', '/', $relative ) . '.php';

		// Keep the autoloader inside includes/ even if a bad class name shows up.
		$real = realpath( $path );
		$base = realpath( WPBOM_DIR . 'includes' );

		if ( false !== $real && false !== $base && str_starts_with( $real, $base ) ) {
			require_once $real;
		}
	}
);

register_activation_hook( __FILE__, [ Install::class, 'activate' ] );
register_deactivation_hook( __FILE__, [ Install::class, 'deactivate' ] );

/**
 * Boot the plugin once all plugins are loaded.
 */
add_action(
	'plugins_loaded',
	static function (): void {
		Plugin::instance()->boot();
	}
);
