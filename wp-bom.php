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


const WP_BOM_BUILD         = 'build';
const WP_BOM_PROD          = 'prod';
const WP_BOM               = WP_BOM_BUILD;
const WP_BOM_JS            = '/assets/js/wp-bom.js';
const WP_BOM_MIN_JS        = '/dist/js/wp-bom.min.js';
const WP_BOM_ADMIN_JS      = '/assets/js/wp-bom-admin.js';
const WP_BOM_ADMIN_MIN_JS  = '/dist/js/wp-bom-admin.min.js';
const WP_BOM_CSS           = '/assets/css/wp-bom.css';
const WP_BOM_MIN_CSS       = '/dist/css/wp-bom.min.css';
const WP_BOM_ADMIN_CSS     = '/assets/css/wp-bom-admin.css';
const WP_BOM_ADMIN_MIN_CSS = '/dist/css/wp-bom-admin.min.css';


global $wp_bom_data;
global $cache;


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
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'activate' ] );
register_activation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'upgrade_data' ] );
register_activation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'create_options' ] );
register_deactivation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'deactivate' ] );
//register_deactivation_hook( __FILE__, [ 'Netraa\\WPB\\Plugin', 'delete_posts' ] );
add_action( 'plugins_loaded', 'Netraa\\WPB\\init' );
add_action( 'admin_enqueue_scripts', 'Netraa\\WPB\\load_assets' );
add_action( 'init', 'Netraa\\WPB\\load_assets' );
//add_action( 'init', 'Netraa\\WPB\\load_admin_assets' );
add_action( 'widgets_init', 'Netraa\\WPB\\widget_init' );


/**
 * Initialize Plugin
 *
 * @since 1.0.0
 */
function init() {

	require __DIR__ . '/includes/acfload.php';
	$wpb  = Plugin::get_instance();
	$post = Post::get_instance();


	$wpb_admin = Admin::get_instance();

	$wpb_shortcode = Shortcode::get_instance();
	$wpb_rest      = Endpoint\Example::get_instance();
	$wpb_settings  = new Settings();

//	$module = new Module();
//	$data   = Data::get_instance();
//
//	$po = new PostObject( 5667 );
//	//var_dump( $po->set_levels2( 5640 ) );
//	$one = $po->set_levels2( 5667 );
//
//
////	var_dump( $one );
//
//
//	$html .= '<strong><i>' . $po->getPostId() . '</i></strong><strong>Assembly: </strong>' . $po->getPost()->post_title . ' ';
//	$html .= '<table class="form-table" style="margin: 0 auto;
//    width: 60%;">
//            <tbody>';
//	$html .= '<tr><th scope="row">' . $po->getPostId() . '</th><hr></tr><hr>';
//
//	foreach ( $one as $o ) {
//
//
//		$html .= '<th scope="row"><u>' . $o['i'] . '</u>  :  ' . $po->getPost()->post_title . '</th>';
//		$html .= '<td>' . $o['n'] . '</td>' . '<td>' . $o['t'] . '</td><td>' . $o['c'] . '</td></tr>';
//		if ( $o['t'] === 'assembly' ) {
//
//			$aa    = new PostObject( $o['i'] );
//			$two[] = $aa->set_levels2( $aa->getPostId() );
//
//			foreach ( $two as $oo ) {
//				$html .= '<tr><th scope="row">' . $aa->getPostId() . '</th><td>two</td><hr></tr>';
//
//				foreach ( $oo as $ooo ) {
//
//					$html .= '<th scope="row"><u>' . $ooo['i'] . '</u>  :  ' . $po->getPost()->post_title . '</th>';
//					$html .= '<td>' . $ooo['n'] . '</td>' . '<td>' . $ooo['t'] . '</td><td>' . $ooo['c'] . '</td></tr>';
//					//echo $o;
//					if ( $ooo['t'] === 'assembly' ) {
//
//						$aaa    = new PostObject( $ooo['i'] );
//						$two2[] = $aaa->set_levels2( $aaa->getPostId() );
//
//
//					}
//				}
//
//			}
//		}
//
//
//	}
//
//	foreach ( $two as $oo ) {
//		$html .= '<tr><th scope="row">' . $aa->getPostId() . '</th><td>two</td><hr></tr>';
//
//		foreach ( $oo as $o ) {
//
//			$html .= '<th scope="row"><u>' . $o['i'] . '</u>  :  ' . $po->getPost()->post_title . '</th>';
//			$html .= '<td>' . $o['n'] . '</td>' . '<td>' . $o['t'] . '</td><td>' . $o['c'] . '</td></tr>';
//			//echo $o;
//			if ( $o['t'] === 'assembly' ) {
//
//				$aaa    = new PostObject( $o['i'] );
//				$two2[] = $aaa->set_levels2( $aaa->getPostId() );
//
//
//			}
//		}
//
//	}
//	foreach ( $two2 as $oo ) {
//		$html .= '<tr><th scope="row">' . $aaa->getPostId() . '</th><td>two2</td><hr></tr><hr>';
//
//		foreach ( $oo as $o ) {
//
//			$html .= '<th scope="row"><u>' . $o['n'] . '</u>  :  ' . $o['i'] . '</th>';
//			$html .= '<td>' . $o['n'] . '</td>' . '<td>' . $o['t'] . '</td><td>' . $o['c'] . '</td></tr>';
//			//echo $o;
//			if ( $o['t'] === 'assembly' ) {
//
//				$aaaa    = new PostObject( $o['i'] );
//				$two22[] = $aaaa->set_levels2( $aaaa->getPostId() );
//
//
//			}
//		}
//
//	}

	$html .= '</tbody></table>';

//
	//echo $html;
	//var_dump( $one );

//	var_dump( $two );
//	var_dump( $two2 );

	//var_dump( $to );

}


/**
 * Register the widget
 *
 * @since 1.0.0
 */
function widget_init() {

	return register_widget( new Widget );
}

function setOptions() {

	$settings = [
		'wpb_settings',
		'wpb_advanced',
		'wpb_others',
		'wpb_io',
		'wpb_support',
		'wp_bom_data',
		'wp_bom',
	];

	foreach ( $settings as $setting ) {
		$opt       = get_option( $setting['id'] );
		$options[] = [ $setting['id'] => $opt ];
	}


	return $options;
}


function get_cache( $post ) {


	wp_cache_set( $post, get_posts( [ 'posts_per_page' => - 1, 'post_type' => $post ] ) );


	return wp_cache_get( $post );
}

function load_assets() {
	wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
	wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

	wp_enqueue_script( 'select2js', plugins_url( 'node_modules/select2/dist/js/select2.full.js', __FILE__ ) );
//	wp_enqueue_script( 'chartjs', plugins_url( 'node_modules/chartjs/chartjs.js', __FILE__ ) );
	wp_enqueue_style( 'select2css', plugins_url( 'node_modules/select2/dist/css/select2.css', __FILE__ ) );


	wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
	wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

	wp_enqueue_script( 'handsontablejs' );
	wp_enqueue_style( 'handsontablecss' );
	wp_register_script( 'wp_bom_js', plugins_url( WP_BOM_JS, __FILE__ ), [ 'jquery' ] );
	wp_register_script( 'handsontablejs', plugins_url( 'node_modules/handsontable/dist/handsontable.full.min.js', __FILE__ ), [ 'jquery' ] );
	wp_register_style( 'handsontablecss', plugins_url( 'node_modules/handsontable/dist/handsontable.full.min.css', __FILE__ ) );
	wp_register_script( 'wp_bom_min_js', plugins_url( WP_BOM_MIN_JS, __FILE__ ), [ 'jquery' ] );
	wp_register_style( 'wp_bom_css', plugins_url( WP_BOM_CSS, __FILE__ ) );
	wp_register_style( 'wp_bom_min_css', plugins_url( WP_BOM_MIN_CSS, __FILE__ ) );

	wp_enqueue_script( 'wp_bom_js' );
	wp_enqueue_style( 'wp_bom_css' );

	if ( WP_BOM === WP_BOM_PROD ) {
		wp_enqueue_script( 'wp_bom_js' );
		wp_enqueue_style( 'wp_bom_css' );

	} else {
		//wp_enqueue_script( 'wp_bom_min_js' );
		wp_enqueue_style( 'wp_bom_min_css' );
	}
}


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



//require __DIR__ . '/api.php';
