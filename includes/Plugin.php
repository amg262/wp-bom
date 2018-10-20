<?php
/**
 * WP-Reactivate
 *
 *
 * @package   WP-Reactivate
 * @author    Pangolin
 * @license   GPL-3.0
 * @link      https://gopangolin.com
 * @copyright 2017 Pangolin (Pty) Ltd
 */

namespace Netraa\WPB;

/**
 * @subpackage Plugin
 */
class Plugin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	/**
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'wp-bom';


	protected $settings = [];

	protected  $wpb_settings = [];

	protected $parts = [];
	protected $asm = [];
	protected $req = [];
	protected $ecn = [];
	protected $bom = [];
	protected $prod = [];
	/**
	 * Setup instance attributes
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		$this->plugin_version = WP_BOM_VERSION;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return string
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return the plugin version.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_version() {
		return $this->plugin_version;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
		flush_rewrite_rules();
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	public function deactivate() {
		flush_rewrite_rules();

	}

	public function upgrade_data() {
		global $wpdb;
		$tbl = $wpdb->prefix . WP_BOM_TBL;
		$sql = "CREATE TABLE IF NOT EXISTS $tbl (
					id int(11) NOT NULL AUTO_INCREMENT,
					post_id int(11),
					type varchar(255),
					data text ,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					active tinyint(1) DEFAULT -1,
					PRIMARY KEY  (id)
				);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	/**
	 *
	 */
	public function create_options() {
		//			'wp_bom_data' => [ 'init' => true, 'ver' => $this->plugin_version ],
		if ( ! add_option( 'wp_bom', [ 'init' => true, 'ver' => WP_BOM_VERSION ] ) ) {

		}
		if ( ! add_option( 'wp_bom_data', [ 'init' => true, 'ver' => WP_BOM_VERSION ] ) ) {
		}

		return true;
	}

	public function delete_options() {
		$sections = [
			'wpb_settings',
			'wpb_advanced',
			'wpb_others',
			'wpb_io',
			'wpb_support',
		];

		foreach ( $sections as $val ) {
			delete_option( $val );

		}
	}

	public function delete_posts( $options ) {

		$i = 0;
		$j = 0;

		$defaults = [
			'on'    => true,
			'types' => [ 'part', 'assembly', 'requisition' ],
			//'taxs'  => [ 'item-category', 'item-tag', 'vendor', 'requisition-type' ],
		];
		$args = wp_parse_args( $options, $defaults );
		$types = $args['types'];

		foreach ( $types as $type ) {

			$posts_array = get_posts( [ 'posts_per_page' => - 1, 'post_type' => $type, ] );

			foreach ( $posts_array as $post ) {
				wp_delete_post( $post->ID );
				$i ++;
			}
		}
		return $i;
	}

	/**
	 *
	 */
	public function install_data() {
		global $wpdb;

		$table_name = $wpdb->prefix . WP_BOM_VERSION;

		$wpdb->insert( $table_name, [
			'post_id' => 3,
			'type'    => 'part',
			'data'    => 'yo',
			'time'    => current_time( 'mysql' ),
			'active'  => - 1,
		] );
	}

	/**
	 *
	 */
	public function delete_db() {
		global $wpdb;

		$table_name = $wpdb->prefix . WP_BOM_VERSION;

		//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name ;" );
	}
}
