<?php
/*
Plugin Name: Bill of Materials
Description: Select your own related products instead of pulling them in by category.
Version:     1.0
Plugin URI:  http://andrewgunn.net
Author:      amg26
Author URI:  http://andrewgunn.net
*/
/**
 *
 */
const WCB_VER = '1.0.0';

/**
 *
 */
const WCB_REL = 'beta';


/**
 *
 */
const WCB_FILE = 'wcb.txt';


/**
 *
 */
const WCB_KEY = 'wcb.key';
/**
 *
 */
const WCB_DB = 8808;
/**
 *
 *
 */
const WCB = __FILE__;
/**
 *
 */
const WCB_SETTINGS = 'wc_bom_settings';
/**
 *
 */
const WC_BOM_OPTIONS = 'wc_bom_options';

/**
 *
 */
const WCB_PREFIX = '';

/**
 *
 */
const WCB_OPTIONS = 'wcb_options';


/**
 *
 */
const WCB_TBL = 'wc_bill_materials';

/**
 *
 */
const WCB_DATA = 'wcb_data';


const PART_META = [ 'part_no', 'sku', 'cost', 'weight', 'stock' ];

const PROD_META  = [ 'product_assembly' => [ 'qty', 'assembly' ] ];
const ASSEM_META = [ 'assembly_id', 'revision', 'assembly_items' => [ 'qty', 'item' ] ];
const INVEN_META = [ 'inventory_id', 'type', 'inventory_items' => [ 'qty', 'vendor', 'item' ] ];

global $wcb_args, $wcb_options, $wcb_data;

/**
 * Class WC_Related_Products
 */
class wc_bill_materials {


	/**
	 * @var null
	 */
	protected static $instance = null;


	public $data_vals = [];

	public $option_vals = [];

	/**
	 * @var array
	 */
	public $data = [
		'init' => true,
		'db'   => WCB_DB,
		'rel'  => WCB_REL,
		'ver'  => WCB_VER,
		'file' => WCB_FILE,
	];


	/**
	 * WC_Related_Products constructor.
	 */
	protected function __construct() {
		$this->init();
	}

	/**
	 * WC_Related_Products constructor.
	 */
	public function init() {
		global $wcb_options, $wcb_data;


		//delete_option( WCB_OPTIONS );
		//delete_option( WCB_DATA );
		//	$wcb_data = $this->wcb_data();
		add_action( 'init', [ $this, 'load_assets' ] );
		add_action( 'admin_init', [ $this, 'check_init' ] );
		//register_activation_hook( __FILE__, [ $this, 'activate' ] );

		//register_deactivation_hook( __FILE__, [ $this, 'activate' ] );
		include_once __DIR__ . '/classes/class-wcbm-settings.php';

		include_once __DIR__ . '/classes/tax_vendor.php';

		require __DIR__.'/classes/class.settings-api.php';
		require __DIR__.'/classes/oop-example.php';

		$n = new Settings();

		//include_once __DIR__.'/classes/functions.php';
		$set = WC_Bom_Settings::getInstance();
		//	add_action( 'admin_init', [ $this, 'create_options' ] );
		//add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		//$this->zah();
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


	/**
	 *
	 */
	public function check_init() {
		global $wcb_data, $wcb_options;
		//delete_option( WCB_DATA );

		if ( ! get_option( WCB_DATA ) ) {
			add_option( WCB_DATA, $this->data );

		}

		$wcb_data = ( ! isset( $wcb_data ) ) ? get_option( WCB_DATA ) : $wcb_data;
		//$wcb_options = ( ! isset( $wcb_options ) ) ? get_option( WCB_OPTIONS ) : $wcb_options;
		//$this->delete_db();
		$this->upgrade_data();

	}

	/**
	 *
	 */
	public function delete_db() {
		global $wpdb;

		$table_name = $wpdb->prefix . WCB_TBL;

		//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
		$wpdb->query( "DROP TABLE IF EXISTS " . $table_name . "" );
		$wpdb->query( "DROP TABLE IF EXISTS " . 'wp_wcbm_part' . "" );
		$wpdb->query( "DROP TABLE IF EXISTS " . 'wp_wcbm_assembly' . "" );
	}

	/**
	 *
	 */
	public function upgrade_data() {
		global $wpdb;

		global $wcb_data;


		if ( $wcb_data['init'] !== true || $wcb_data['db'] !== WCB_DB ) {

			$table_name = $wpdb->prefix . WCB_TBL;

			$sql  = "CREATE TABLE IF NOT EXISTS $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					title varchar(255),
					post_id int(11),
					type varchar(255),
					sub_ids text,
					data text ,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					active tinyint(1) DEFAULT -1 NOT NULL,
					PRIMARY KEY  (id)
				);";
			$sql2 = "CREATE TABLE IF NOT EXISTS wp_wcbm_part (
					id int(11) NOT NULL AUTO_INCREMENT,
					post_id int(11),
					part_no int(11),
					sku varchar(255),
					cost double(11, 2),
					weight double(11,2),
					stock double(11,2),
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					active tinyint(1) DEFAULT -1 NOT NULL,
					PRIMARY KEY  (id)
				);";

			$sql3 = "CREATE TABLE IF NOT EXISTS wp_wcbm_assembly (
					id int(11) NOT NULL AUTO_INCREMENT,
					post_id int(11),
					assembly_id int(11),
					revision varchar(255),
					part_ids text,
					sub_ids text,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					active tinyint(1) DEFAULT -1 NOT NULL,
					PRIMARY KEY  (id)
				);";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$this->data['init'] = true;

			$this->data['db'] = WCB_DB;

			update_option( WCB_DATA, $this->data );
			dbDelta( $sql );
			dbDelta( $sql2 );

			dbDelta( $sql3 );

		}

		return true;

	}

	/**
	 *
	 */
	public function load_assets() {
		$url  = 'assets/';
		$url2 = 'assets/';

		//$val = 'http://cdnjs.cloudflare.com/ajax/libs/validate.js/0.12.0/validate.min.js';
		//wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js' );
		//wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
		//wp_register_script( 'bom_adm_js', plugins_url( $url . 'wc-bom-admin.js', __FILE__ ), [ 'jquery' ] );
		//wp_register_style( 'bom_css', plugins_url( $url2 . 'wc-bom.css', __FILE__ ) );

		//wp_enqueue_script( 'valjs', $val );

		wp_register_script( 'bom_adm_js', plugins_url( $url . 'wc-bom-admin.js', __FILE__ ), [ 'jquery' ] );
		wp_register_script( 'bom_adm_min_js', plugins_url( $url . 'wc-bom-admin.min.js', __FILE__ ), [ 'jquery' ] );

		wp_enqueue_script( 'bom_adm_js' );
		//wp_enqueue_script( 'bom_adm_min_js' );
		//}

		//	if ( file_exists( __DIR__ . '/dist/wc-bom.min.css' ) ) {
		wp_register_style( 'bom_css', plugins_url( $url . 'wc-bom.css', __FILE__ ) );
		wp_register_style( 'bom_min_css', plugins_url( $url . 'wc-bom.min.css', __FILE__ ) );

		wp_enqueue_style( 'bom_css' );
		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

		wp_register_script( 'chosen_js', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js', [ 'jquery' ] );
		wp_register_style( 'chosen_css', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css' );
		wp_enqueue_script( 'postbox' );
		//wp_enqueue_script( 'bom_adm_js' );
		wp_enqueue_script( 'chosen_js' );
		wp_enqueue_style( 'chosen_css' );
		//wp_enqueue_style( 'bom_css' );
	}

	/**
	 *
	 */
	public function install_data() {
		global $wpdb;

		$welcome_name = 'Mr. WordPress';
		$welcome_text = 'Congratulations, you just completed the installation!';

		$table_name = $wpdb->prefix . WCB_TBL;

		$wpdb->insert( $table_name, [
			'time' => current_time( 'mysql' ),
			'name' => $welcome_name,
			'data' => $welcome_text,
			'url'  => 'http://cloudground.net/',
		] );
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links( $actions, $plugin_file ) {
		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [
				'settings' => '<a href="admin.php?page=wc-bill-materials">' . __( 'Settings', 'wc-bom' ) . '</a>',
				'parts'    => '<a href="edit.php?post_type=part">' . __( 'Parts', 'wc-bom' ) . '</a>',
				'assembly' => '<a href="edit.php?post_type=assembly">' . __( 'Assembly', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}


}

$wcrp = wc_bill_materials::getInstance();

