<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 4/28/18
 * Time: 1:12 AM
 */
namespace Netraa\WPB;

class WCB_Post {

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
		add_action( 'init', [ $this, 'register_part' ] );
		add_action( 'init', [ $this, 'register_assembly' ] );
		add_action( 'init', [ $this, 'register_inventory' ] );
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
	public function register_assembly() {

		$labels = [
			'name'          => __( 'Assembly', 'wc-bom' ),
			'singular_name' => __( 'Assembly', 'wc-bom' ),
			'menu_name'     => __( 'Assembly', 'wc-bom' ),
			'all_items'     => __( 'All Assemblies', 'wc-bom' ),
		];
		$args   = [
			'label'               => __( 'Assemblies', 'wc-bom' ),
			'labels'              => $labels,
			//'description'         => 'Post type for assemblies build by combining materials with parts.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'assembly',
			'has_archive'         => 'assemblies',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search' => false,
			'capability_type'     => 'product',
			'map_meta_cap'        => true,
			'hierarchical'        => true,
			'query_var'           => true,
			'menu_icon'           => 'dashicons-hammer',
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				//'revisions',
				'author',
				'page-attributes',
			],
		];
		register_post_type( 'assembly', $args );
	}


	/**
	 *
	 */
	public function register_part() {

		$labels = [
			'name'          => __( 'Parts', 'wc-bom' ),
			'singular_name' => __( 'Part', 'wc-bom' ),
			'menu_name'     => __( 'Parts', 'wc-bom' ),
			'all_items'     => __( 'All Parts', 'wc-bom' ),

		];

		$args = [
			'label'               => __( 'Parts', 'wc-bom' ),
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
			'menu_icon'           => 'dashicons-hammer',
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

		register_post_type( 'part', $args );
	}

	/**
	 *
	 */
	public function register_part_cat() {

		$labels = [
			'name'          => __( 'Part Categories', 'wc-bom' ),
			'singular_name' => __( 'Part Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Part Categories', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'part-category', [ 'part', 'assembly' ], $args );


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


}
