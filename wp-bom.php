<?php
/**
 * WP-Bom
 *
 *
 * @package   WP-Bom
 * @author    amg262
 * @license   GPL-3.0
 * @link      https://.com
 * @copyright 2018 amg262 (Pty) Ltd
 *
 * @wordpress-plugin
 * Plugin Name:       WP-Bom
 * Plugin URI:        https://.com
 * Description:       React boilerplate for WordPress plugins
 * Version:           1.0.0
 * Author:            amg262
 * Author URI:        https://gopangolin.com
 * Text Domain:       wp-bom
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */


namespace Netraa\WPB;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_BOM_VERSION', '1.0.0' );
define( 'WP_BOM_TBL', 'wpb_bom' );
define( 'WP_BOM_BUILD', 'prod' );

const WP_BOM_BUILD = 'dev';
const WP_BOM_PROD  = false;
const WP_BOM_DEV   = true;

global $wp_bom_settings;
/*
 * Autoloader
 *
 * @param string $class The fully-qualified class name.
 * @return void
 *
 *  * @since 1.0.0
 */
try {
	spl_autoload_register( function ( $class ) {

		// project-specific namespace prefix
		$prefix = __NAMESPACE__;

		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/includes/';

		// does the class use the namespace prefix?
		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr( $class, $len );

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		}
	} );
} catch ( \Exception $e ) {
}

/**
 * Initialize Plugin
 *
 * @since 1.0.0
 */
function init() {


	require __DIR__ . '/dist/acfload.php';

	$wpb           = Plugin::get_instance();
	$wpb_shortcode = Shortcode::get_instance();
	$wpb_admin     = Admin::get_instance();
	$wpb_rest      = Endpoint\Example::get_instance();

	$wpb_part      = Part::get_instance();
	$wpb_assembly  = Assembly::get_instance();
	$wpb_product   = Product::get_instance();
	$wpb_inventory = Inventory::get_instance();


//	require __DIR__ . '/dist/acf/acf.php';


	$wpb_settings = Settings::get_instance();
	require __DIR__ . '/wp-bom-core.php';
	$core = WP_Bom::get_instance();


}

add_action( 'plugins_loaded', 'Netraa\\WPB\\init' );


/**
 * Register the widget
 *
 * @since 1.0.0
 */
function widget_init() {
	return register_widget( new Widget );
}

add_action( 'widgets_init', 'Netraa\\WPB\\widget_init' );

/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'deactivate' ] );

