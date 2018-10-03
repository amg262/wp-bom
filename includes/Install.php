<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 9/29/18
 * Time: 1:33 AM
 */

class Install {


	public function __construct() {
//		add_action( 'admin_init', [ $this, 'upgrade_data' ]);
//
//		register_activation_hook( __FILE__, [ $this, 'upgrade_data' ] );
//		add_action( 'admin_init', [ $this, 'upgrade_data' ] );
//		add_action( 'admin_init', [ $this, 'install_data' ] );
//		add_action( 'admin_init', [ $this, 'delete_db' ] );
	}

	/**
	 *
	 */
	function create_options() {

		$wcb_options = [];
		if ( ! add_option( 'wcb_options', [ 'init' => true ] ) ) {
			return 'bullshit';
		} else {
			return 'faggot';

		}

	}


	function delete_options() {
		if ( get_option( 'wcb_options' ) === false ) {
			delete_option( 'wcb_options' );
		}
	}

	function delete_posts( $post_types = ['part','assembly'] ) {

		$i = 0;
		$j = 0;
		foreach ( $post_types as $type ) {

			$args        = [
				'posts_per_page'   => - 1,
				'post_type'        => $type,
				//'post_status'      => 'publish',
				'suppress_filters' => true,
			];
			$posts_array = get_posts( $args );

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
	function install_data() {
		global $wpdb;

		$table_name = $wpdb->prefix . WCB_TBL;

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
	function delete_db() {
		global $wpdb;

		$table_name = $wpdb->prefix . WCB_TBL;

		//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name ;" );
	}

//
//	function install_stock() {
//		$table_name = $wpdb->prefix . WCB_TBL;
//
//		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
//					id int(11) NOT NULL AUTO_INCREMENT,
//					post_id int(11),
//					type varchar(255),
//					data text ,
//					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
//					active tinyint(1) DEFAULT -1,
//					PRIMARY KEY  (id)
//				);";
//	}
	/**
	 *
	 */
	function upgrade_data( $table, $sql = false ) {
		global $wpdb;

		$tbl = ( ! isset( $table ) ) ? $wpdb->prefix . WCB_TBL : $wpdb->prefix . $table;


		if ( $sql === false ) {
			$sql = "CREATE TABLE IF NOT EXISTS $tbl (
					id int(11) NOT NULL AUTO_INCREMENT,
					post_id int(11),
					type varchar(255),
					data text ,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					active tinyint(1) DEFAULT -1,
					PRIMARY KEY  (id)
				);";
		}
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}

