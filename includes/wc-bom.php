<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

namespace WooBom;

/*
 * Exit if accessed directly
 */
use const WC_BOM_PASS;
use function wp_enqueue_style;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No no no!' );
}

/*
*
*
*
* Plugin Name: WooBOM - WooCommerce Bill of Materials
* Plugin URI: http://andrewgunn.org
* Description: Bill of Materials add-on for WooCommerce for raw material tracking, inventory, and production metrics.
* Version: 1.0.0
* Author: Andrew Gunn
* Author URI: https/andrewgunn.org
* Text Domain: wc-bom
* License: license.txt
*
*
*
*/
global $wc_bom_options, $wc_bom_settings;

const WC_BOM_BETA_KEY = 'beta1';
/**
 *
 */
const WC_BOM_VERSION = '1.0.0';

const WC_BOM_TABLE = 'woocommerce_bom';
/**
 *
 */
const WC_BOM_OPTIONS = 'wc_bom_options';
/**
 *
 *
 */
const WC_BOM_SETTINGS = 'wc_bom_settings';

const WC_BOM_FILE = __FILE__;

const WC_BOM_DIR = __DIR__;

const WC_BOM_LOGS = __DIR__ . '/assets/logs/';

const WC_BOM_TMP = __DIR__ . '/assets/tmp/';

const WC_BOM_DIST = __DIR__ . '/assets/dist/';


const WC_BOM_ADMIN = 'Andrew Gunn';

const WC_BOM_ADMIN_EMAIL = 'andrewmgunn26@gmail.com';


//require_once WC_BOM_ABSTRACT . 'WC_Abstract_Bom.php';
//require_once __DIR__ . '/assets/dist/acf/acf.php';
//include_once __DIR__ . '/includes/bom-fields.php';

/**
 * Class WC_Bom
 *
 * @package WooBom
 */
class WC_Bom {

	const WC_BOM_BETA_KEY = 'beta1';
	/**
	 * @var null
	 */
	protected static $instance = null;

	private function __construct() {
		$this->init();
		//$this->delete_db();

	}

	/**
	 *
	 */
	public function init() {

		$this->create_options();
		$this->install();
		$this->install_data();
		$this->load_classes();
		$this->require_woocommerce();
		$this->require_acf();

		//add_action( 'admin_init', [ $this, 'create_options' ] );
		add_action( 'init', [ $this, 'load_assets' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );

		//$this->load_classes();
		$settings = WC_Bom_Settings::getInstance();
		$post     = WC_Bom_Post::getInstance();

		//include_once 'uninstall.php';
		//flush_rewrite_rules();
		//
//var_dump($settings);
	}

	/**
	 * @return mixed
	 */
	public function create_options() {

		global $wc_bom_options;
		global $wc_bom_settings;

		$key            = 'init';
		$wc_bom_options = get_option( WC_BOM_OPTIONS );
		if ( $wc_bom_options[ $key ] !== true ) {
			add_option( WC_BOM_OPTIONS, [ $key => true ] );
		}
		$key             = 'setup';
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );
		if ( $wc_bom_settings[ $key ] !== true ) {
			add_option( WC_BOM_SETTINGS, [ $key => false ] );
		}
		//delete_option( 'wc_bom_settings' );
		//delete_option( 'wc_bom_options' );
	}

	/**
	 *
	 */
	public function install() {

		global $wpdb;
		global $wc_bom_settings;
		$wc_bom_settings = get_option( 'wc_bom_settings' );

		$table_name = $wpdb->prefix . 'woocommerce_bom';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					name tinytext NOT NULL,
					data text NOT NULL,
					url varchar(255) DEFAULT '' NOT NULL,
					PRIMARY KEY  (id)
				);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		if ( null === $wc_bom_settings['db_version'] ) {
			update_option( 'wc_bom_settings', [ 'db_version' => WC_BOM_VERSION ] );
		}
		dbDelta( $sql );
	}

	/**
	 *
	 */
	public function install_data() {
		global $wpdb;

		$welcome_name = 'Mr. WordPress';
		$welcome_text = 'Congratulations, you just completed the installation!';

		$table_name = $wpdb->prefix . WC_BOM_TABLE;

		$wpdb->insert(
			$table_name,
			[
				'time' => current_time( 'mysql' ),
				'name' => $welcome_name,
				'data' => $welcome_name . ' ' . $welcome_text,
				'url'  => 'http://andrewgunn.org',
			]
		);
	}

	/**
	 *
	 */
	public function load_classes() {
		//include_once __DIR__ . '/classes/class-wc-bom-data.php';
		include_once __DIR__ . '/classes/class-wc-bom-post.php';
		include_once __DIR__ . '/classes/class-wc-bom-settings.php';
		include_once __DIR__ . '/classes/class-wc-bom-logger.php';
		//include_once __DIR__ . '/includes/bom-fields.php';
	}

	/**
	 * @return bool
	 */
	public function require_woocommerce() {

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		$active        = 'active_plugins';
		$woo           = 'woocommerce/woocommerce.php';
		$is_woo_active = in_array( $woo, apply_filters( $active, get_option( $active ) ), true );
		if ( ! $is_woo_active ) {
			//if ( plugin_dir_url( WC_BOM_WOO ) ) { activate_plugin( WC_BOM_WOO ); }
			deactivate_plugins( __FILE__ );
			$message =
				'<div style="text-align: center;"><h3>' .
				'WooCommerce is required by <strong>WooBOM</strong></h3>' .
				'<a href=' . admin_url( 'plugins.php' ) . '>&nbps;' .
				'Back to plugins&nbsp;&rarr;</a>' .
				'</div>';
			wp_die( $message );
		}
	}

	/**
	 * @return bool
	 */
	public function require_acf() {
		require_once __DIR__ . '/assets/dist/acf/acf.php';
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$acf     = 'advanced-custom-fields/acf.php';
		$active  = in_array( $acf, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
		$has_acf = plugin_dir_url( $acf );

		if ( $has_acf && $active ) {

			deactivate_plugins( $acf );
			deactivate_plugins( __FILE__ );

			$message =
				'<div style="text-align: center;"><h3>' .
				'ACF Pro is included in <strong>WooBOM</strong>.' .
				'&nbsp;<a href=' . admin_url( 'plugins.php' ) . '>Back to plugins&nbsp;&rarr;</a></div>';
			wp_die( $message );

		}
		if ( function_exists( 'acf_add_options_page' ) ) {

			acf_add_options_page(
				[
					'page_title' => 'BOM Fields',
					'menu_title' => 'BOM Fields',
					'menu_slug'  => 'wc-bom-fields',
					'capability' => 'edit_posts',
					'redirect'   => false,
				] );
		}


		return true;
	}

	public function delete_db() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'woocommerce_bom';

		$wpdb->query( "DROP TABLE IF EXISTS " . $table_name . "" );

		delete_option( 'wc_bom_settings' );
		delete_option( 'wc_bom_options' );
		//update_option( 'wc_bom_settings', [ 'db_version' => null ] );
	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	public function acf_field_groups() {

	}

	public function upgrade_data() {
		global $wpdb;
		global $wc_bom_settings;
		global $wc_bom_options;

		$key             = 'db_version';
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );

		if ( $wc_bom_settings[ $key ] !== WC_BOM_VERSION ) {

			$table_name = $wpdb->prefix . 'woocommerce_bom';

			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					name tinytext NOT NULL,
					data text NOT NULL,
					url varchar(255) DEFAULT '' NOT NULL,
					PRIMARY KEY  (id)
				);";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			update_option( WC_BOM_SETTINGS, [ $key => WC_BOM_VERSION ] );


			dbDelta( $sql );

		}
	}

	/**
	 *
	 */
	public function load_assets() {
		$url  = 'assets/dist/scripts/';
		$url2 = 'assets/dist/styles/';
		wp_register_script( 'bom_js', plugins_url( $url . 'wc-bom.min.js', __FILE__ ) );
		wp_register_script( 'bom_adm_js', plugins_url( $url . 'wc-bom-admin.min.js', __FILE__ ) );
		//wp_register_script( 'api_js', plugins_url( $url . 'wc-bom-api.min.js', __FILE__ ) );
		wp_register_script( 'wp_js', plugins_url( $url . 'wc-bom-wp.min.js', __FILE__ ) );
		wp_register_style( 'bom_css', plugins_url( $url2 . 'wc-bom.min.css', __FILE__ ) );
		wp_register_script( 'chosen_js',
			'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js' );
		wp_register_style( 'chosen_css',
			'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css' );

		wp_enqueue_script( 'postbox' );

		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

		wp_enqueue_script( 'bom_js' );
		wp_enqueue_script( 'bom_adm_js' );
		wp_enqueue_script( 'chosen_js' );
		wp_enqueue_style( 'chosen_css' );
		//wp_enqueue_script( 'ajax_js' );
		//wp_enqueue_script( 'api_js' );
		//wp_enqueue_script( 'wp_js' );
		wp_enqueue_style( 'bom_css' );

	}


	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public
	function plugin_links(
		$actions, $plugin_file
	) {
		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [
				'settings' => '<a href="admin.php?page=wc-bom-settings">' . __( 'Settings', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}

$wc_bom = WC_Bom::getInstance();
//global $wc_bom_settings;

//var_dump( $wc_bom_settings );
//add_filter('acf/settings/show_admin', '__return_false');
