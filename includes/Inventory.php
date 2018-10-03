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

use WP_Post;

/**
 * @subpackage Plugin
 */
class Inventory {


	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Setup instance attributes
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'register_inventory' ] );
		//add_action( 'init', [ $this, 'register_assembly_cat' ] );
		//add_action( 'init', [ $this, 'add_assembly_group' ] );

	}



	public function register_inventory() {

		/**
		 * Post Type: Inventory Items.
		 */

		$labels = [
			"name"          => __( "Inventory", "wc-bill-materials" ),
			"singular_name" => __( "Inventory", "wc-bill-materials" ),
			'menu_name'     => __( 'Inventory', 'wc-bom' ),
			'all_items'     => __( 'All Inventory', 'wc-bom' ),

		];

		$args = [
			'label'               => __( 'Inventory', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'query_var'           => true,
			'menu_icon'           => 'dashicons-clipboard',
			'supports'            => [
				'title',
				//'editor',
				'thumbnail',
				//'excerpt',
				//'comments',
				'revisions',
				'author',
				'page-attributes',
			],
		];

		register_post_type( "inventory", $args );
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
}
