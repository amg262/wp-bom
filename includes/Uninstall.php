<?php
// If uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
  exit();


class Uninstall {
	/**
	 * @var null
	 */
	protected static $instance;

	/**
	 * WC_Bom_Post_Type constructor.
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 *
	 */
	public function init() {
	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( null === static::$instance ) {
			static::$instance = new static;
		}

		return static::$instance;
	}
	/**
	 *
	 */
	public function delete_db() {
		global $wpdb;

		$table_name = $wpdb->prefix . WCB_TBL;

		$wpdb->query( "DROP TABLE IF EXISTS " . $table_name . "" );
	}

	public function delete_options() {
		delete_option( 'wcb_options' );
		delete_option( 'wcb_settings' );
		delete_option( 'wcb_advanced' );
		delete_option( 'wcb_basic' );
		delete_option( 'wpb_example_setting' );
	}
}