<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

namespace WooBom;

use function add_action;
use function get_posts;
use function var_dump;

/**
 * Class WC_Bom_Post
 *
 * @package WooBom
 */
class WC_Bom_Post {

	/**
	 * @var null
	 */
	protected static $instance;
	private $parts, $assemblies, $products;

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
		add_action( 'init', [ $this, 'register_part_cat' ] );
		add_action( 'init', [ $this, 'register_assembly_cat' ] );

		add_action( 'init', [ $this, 'register_material_tags' ] );

		add_action( 'admin_init', [ $this, 'get_parts' ] );



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
			'name'          => __( 'Assemblies', 'wc-bom' ),
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
				//'editor',
				'thumbnail',
				'revisions',
				'author',
				'page-attributes',
			],
		];
		register_post_type( 'assembly', $args );
	}

	/**
	 *
	 */
	public function register_assembly_cat() {

		$labels = [
			'name'          => __( 'Assembly Categories', 'wc-bom' ),
			'singular_name' => __( 'Assembly Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];
		$args   = [
			'label'              => __( 'Assembly Categories', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => true,
			//'label' => 'Inventory Types',
			'show_ui'            => false,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rest_base'          => 'sssembly-category',
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'assembly_category', [ 'assembly' ], $args );
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
			'menu_icon'           => 'dashicons-admin-tools',
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
			'show_ui'            => false,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'part-category', [ 'part' ], $args );


	}

	/**
	 *
	 */
	public function register_material_tags() {

		$labels = [
			'name'          => __( 'Material Tags', 'wc-bom' ),
			'singular_name' => __( 'Material Tag', 'wc-bom' ),
			'menu_name'     => __( 'Tags', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Material Tags', 'wc-bom' ),
			'labels'             => $labels,
			'public'             => true,
			'hierarchical'       => false,
			//'label' => 'Inventory Types',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => true,
		];
		register_taxonomy( 'material-tags', [ 'part', 'assembly' ], $args );
	}

}
