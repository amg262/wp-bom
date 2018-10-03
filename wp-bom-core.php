<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/3/18
 * Time: 1:41 PM
 */

namespace Netraa\WPB;


const WP_BOM_JS      = 'wp-bom.js';
const WP_BOM_JS_MIN  = 'wp-bom.min.js';
const WP_BOM_CSS     = 'wp-bom.css';
const WP_BOM_MIN_CSS = 'wp-bom.min.css';
const PATHS          = [
	'dir'         => __DIR__,
	'wp-bom'      => '/wp-bom.php',
	'assets'      => [
		'assets' => '/assets/',
		'css'    => '/assets/css/',
		'js'     => '/assets/js/',
		'images' => '/assets/images/',
	],
	'app'         => __DIR__ . '/app/',
	'acf'         => __DIR__ . '/acf/',
	'acfphp'      => __DIR__ . '/acf/acf.php',
	'data'        => __DIR__ . '/data/',
	'dist'        => [
		'dist'   => '/dist/',
		'css'    => '/dist/css/',
		'js'     => '/dist/js/',
		'images' => '/dist/images/',
	],
	'includes'    => __DIR__ . '/includes/',
	'test'        => __DIR__ . '/test/',
	'logs'        => __DIR__ . '/logs/',
	'wpb-core'    => __DIR__ . '/wp-bom-core.php',
	'gulp'        => __DIR__ . '/gulpfile.js',
	'stylesheets' => [ 'admin.css', 'shortcode.css', 'widget.css', 'wp-bom.css' ],
	'scripts'     => [ 'admin', 'shortcode', 'widget', 'wp-bom' ],

];
const DIST_JS        = __DIR__ . '/dist/';


class WP_Bom {


	protected static $instance = null;

	/**
	 * WCB_Init constructor.
	 */
	private function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	protected function init() {

		add_action( 'init', [ $this, 'load_assets' ] );
		//add_action( 'init', [ $this, 'check_acf' ] );
		//add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

	}


	public static function get_instance() {
		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}


	/**
	 *
	 */
	public function activate() {

		flush_rewrite_rules();
	}

	/**
	 *
	 */
	public function deactivate() {

		flush_rewrite_rules();
	}

	/**
	 *
	 */
	public function load_assets() {


		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
		wp_register_script( 'wpb_min_js', plugins_url( PATHS['dist']['js'] . WP_BOM_JS_MIN, __FILE__ ), ['jquery'] );
		wp_register_script( 'wpb_js', plugins_url( PATHS['assets']['js'] . WP_BOM_JS, __FILE__ ), ['jquery'] );
		wp_register_style( 'wpb_min_css', plugins_url( PATHS['dist']['css'] . WP_BOM_MIN_CSS, __FILE__ ) );
		wp_register_style( 'wpb_css', plugins_url( PATHS['assets']['css'] . WP_BOM_CSS, __FILE__ ) );

		if (WP_BOM_PROD === true) {
			wp_enqueue_script( 'wpb_min_js' );
			wp_enqueue_style( 'wpb_min_css' );
		} else {
			wp_enqueue_script( 'wpb_js' );
			wp_enqueue_style( 'wpb_css' );
		}

	}
}
