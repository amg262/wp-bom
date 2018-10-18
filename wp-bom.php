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
define( 'WCB_TBL', 'wp_bom_data' );
define( 'WCB_VER', '1' );


const WP_BOM_BUILD = 'build';
const WP_BOM_PROD  = 'prod';

const WP_BOM = WP_BOM_BUILD;

//const WP_BOM_DIST = plugins_url( '/dist/license/license-key/test.php', __FILE__ );

const WP_BOM_JS            = '/assets/js/wp-bom.js';
const WP_BOM_MIN_JS        = '/dist/js/wp-bom.min.js';
const WP_BOM_ADMIN_JS      = '/assets/js/wp-bom-admin.js';
const WP_BOM_ADMIN_MIN_JS  = '/dist/js/wp-bom-admin.min.js';
const WP_BOM_CSS           = '/assets/css/wp-bom.css';
const WP_BOM_MIN_CSS       = '/dist/css/wp-bom.min.css';
const WP_BOM_ADMIN_CSS     = '/assets/css/wp-bom-admin.css';
const WP_BOM_ADMIN_MIN_CSS = '/dist/css/wp-bom-admin.min.css';


global $wp_bom_data;


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

	require __DIR__ . '/includes/acfload.php';
	$wpb       = Plugin::get_instance();
	$wpb_admin = Admin::get_instance();

	if ( file_exists( __DIR__ . '/app.key' ) ) {
		$post          = Post::get_instance();
		$wpb_shortcode = Shortcode::get_instance();
		$wpb_rest      = Endpoint\Example::get_instance();

		$wpb_settings = new Settings();

		$module = new Module();


		$po = new PostObject( 5640 );
		//$po->setItems();


		file_put_contents( __DIR__ . '/zap.json', json_encode( $po->setItems() ) );
		//echo json_encode( $po->getItems() );
//		var_dump( $po );

		//run_assem();

	} else {
		echo '<h1>ENTER YO KEY BRUH</h1>';
	}
	//echo json_encode( $a->get_asi() );
	//	var_dump( $a->get_comp() );

}

function run_assem() {
	$args        = [
		'posts_per_page' => - 1,
		'post_type'      => 'assembly',
	];
	$posts_array = get_posts( $args );


	//$a    = new BOM( 5640 );
	$i = 0;
	foreach ( $posts_array as $obj ) {

		$post  = new \WP_Post( $obj );
		$comp  = new Component( $post->ID );
		$items = $comp->setItems( $post->ID );
		$parts = $comp->getItemsPart( $post->ID );
		$sub   = $comp->getItemsAssembly();
		$i ++;
	}

//		$post  = new \WP_Post( $obj );
	$comp2 = new Component( 5638 );
	$p2s   = $comp2->getPartList();
	$sub2s = $comp2->getSubList();
	$list  = $comp2->setAssemblyItemList();
//
//	foreach ( $list as $item ) {
//
//		//	echo $item[1];
//
//		//$list2[] = $comp2->setAssemblyItemList( $item[1] );
//
//
//	}


	file_put_contents( __DIR__ . '/data.json', json_encode( $list ) );

	echo json_encode( $list );
	echo '<br>';

	//echo json_encode( $list2 );
	echo '<br>';

//
//	foreach ( $sub2s as $ah ) {
//
//		//echo $ah['ID'];
//		$bah = new Component( $ah['ID'] );
//
//		$sid = $bah->getSubList();
//
//		foreach ( $sid as $s ) {
//			$bah2 = new Component( $ah['ID'] );
//
//			$sidd  = $bah2->getSubList();
//			$var[] = $bah2->getPartList();
//
//		}
//		$var[] = $bah->getPartList();
//
//	}
//
//	echo json_encode( $var );
//	//	echo json_encode( $p2s );
//	echo '<br>';
//	echo $i;
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
function load_assets() {

	wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
	wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
	wp_register_script( 'wp_bom_js', plugins_url( WP_BOM_JS, __FILE__ ), [ 'jquery' ] );
	wp_register_script( 'wp_bom_min_js', plugins_url( WP_BOM_MIN_JS, __FILE__ ), [ 'jquery' ] );
	wp_register_style( 'wp_bom_css', plugins_url( WP_BOM_CSS, __FILE__ ) );
	wp_register_style( 'wp_bom_min_css', plugins_url( WP_BOM_MIN_CSS, __FILE__ ) );


	if ( WP_BOM === WP_BOM_PROD ) {
		wp_enqueue_script( 'wp_bom_js' );
		wp_enqueue_style( 'wp_bom_css' );

	} else {
		wp_enqueue_script( 'wp_bom_min_js' );
		wp_enqueue_style( 'wp_bom_min_css' );
	}
}

add_action( 'init', 'Netraa\\WPB\\load_assets' );
add_action( 'init', 'Netraa\\WPB\\load_admin_assets' );


function load_admin_assets() {

	wp_register_script( 'wp_bom_admin_js', plugins_url( WP_BOM_ADMIN_JS, __FILE__ ), [ 'jquery' ] );
	wp_register_script( 'wp_bom_admin_min_js', plugins_url( WP_BOM_ADMIN_MIN_JS, __FILE__ ), [ 'jquery' ] );
	wp_register_style( 'wp_bom_admin_css', plugins_url( WP_BOM_ADMIN_CSS, __FILE__ ) );
	wp_register_style( 'wp_bom_admin_min_css', plugins_url( WP_BOM_ADMIN_MIN_CSS, __FILE__ ) );


	if ( WP_BOM === WP_BOM_PROD ) {
		wp_enqueue_script( 'wp_bom_admin_js' );
		wp_enqueue_style( 'wp_bom_admin_css' );

	} else {
		wp_enqueue_script( 'wp_bom_admin_min_js' );
		wp_enqueue_style( 'wp_bom_admin_min_css' );
	}
}

/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'activate' ] );
register_activation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'upgrade_data' ] );
register_activation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'create_options' ] );
register_deactivation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'deactivate' ] );
//register_deactivation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'delete_posts' ] );

//require __DIR__ . '/api.php';
