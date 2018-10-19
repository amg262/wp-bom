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
class Post {


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
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'register_taxonomy' ] );
		//add_action( 'init', [ $this, 'add_acf_post_groups' ] );
		//add_action( 'save_post', [ $this, 'save_post' ], 10, 2 );
		//add_action( 'init', [ $this, 'save_post' ], 10, 1 );

		add_action( 'save_post_part', [ $this, 'save_post' ] );
		add_action( 'save_post_assembly', [ $this, 'save_post' ] );
		add_action( 'save_post_product', [ $this, 'save_post' ] );
	}

//	/**
//	 *
//	 */
//	public function check_field_groups() {
//
//		$args = [
//			'posts_per_page'   => - 1,
//			'post_type'        => 'acf-field-group',
//			'post_status'      => 'publish',
//			'suppress_filters' => true,
//		];
//
//		$posts_array = get_posts( $args );
//
//		foreach ( $posts_array as $post ) {
//			$post = new WP_Post( $post );
//			if ( $post->post_title === 'Part' ) {
//				$this->add_part_group();
//			}
//
//		}
//
//	}

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

	public function save_post( $post ) {
		global $product;
		global $post;

		$type = get_post_type( $post );

		if ( 'product' === $type ) {
			$prod = wc_get_product( $post->ID );
			$sku  = $prod->get_sku();

			if ( $sku !== '' ) {

				if ( $prod->get_short_description() !== $sku ) {
					$prod->set_short_description( $sku );
					$prod->save();
				} else {
					echo 'bruce';
				}
			}
		} else {
			//$obj               = new WP_Post( $post );
			//$obj->post_excerpt = 'Dude';
			//$post->post_excerpt = 'Dude';
			//wp_update_post( $post );

			//setup_postdata( $post->ID );


			//wp_update_post( $arr );
			//return $post;
		}

		//	return $product;
	}

	public function register_assembly_cat() {

		$labels = [
			'name'          => __( 'Item Group', 'wp-bom' ),
			'singular_name' => __( 'Item Group', 'wp-bom' ),
			'menu_name'     => __( 'Item Group', 'wp-bom' ),
		];

		$args = [
			'label'              => __( 'Item Group', 'wp-bom' ),
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
		register_taxonomy( 'group', [ 'part', 'assembly', 'requisition' ], $args );


	}

	function register_requisition_type() {

		/**
		 * Taxonomy: Requisition Types.
		 */

		$labels = [
			"name"          => __( "Requisition Type", "storefront" ),
			"singular_name" => __( "Requisition Type", "storefront" ),
			"menu_name"     => __( "Req Type", "storefront" ),
		];

		$args = [
			"label"              => __( "Requisition Types", "storefront" ),
			"labels"             => $labels,
			"public"             => true,
			"hierarchical"       => true,
			"label"              => "Requisition Type",
			"show_ui"            => true,
			"show_in_menu"       => true,
			"show_in_nav_menus"  => true,
			"query_var"          => true,
			"rewrite"            => [ 'slug' => 'type', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"  => true,
			"show_in_rest"       => true,
			"rest_base"          => "req-type",
			"show_in_quick_edit" => true,
		];
		register_taxonomy( "requisition-type", [ "requisition" ], $args );
	}

	public function register_post_types() {

		$this->register_part();
		$this->register_prod();
		$this->register_assembly();
		$this->register_requisition();
		$this->register_ecn();

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
			'label'                 => __( 'Parts', 'wc-bom' ),
			'labels'                => $labels,
			//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'show_in_menu'          => true,
			'rest_base'             => 'parts-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search'   => false,
			'capability_type'       => 'post',
			'map_meta_cap'          => true,
			'hierarchical'          => true,
			'query_var'             => true,
			'menu_icon'             => 'dashicons-hammer',
			'supports'              => [
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

	public function register_prod() {

		$labels = [
			'name'          => __( 'Products', 'wc-bom' ),
			'singular_name' => __( 'Products', 'wc-bom' ),
			'menu_name'     => __( 'Products', 'wc-bom' ),
			'all_items'     => __( 'All Products', 'wc-bom' ),

		];

		$args = [
			'label'                 => __( 'Products', 'wc-bom' ),
			'labels'                => $labels,
			//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'show_in_menu'          => true,
			'rest_base'             => 'product',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search'   => false,
			'capability_type'       => 'post',
			"rewrite"             => [ "slug" => "product", "with_front" => true ],

			'map_meta_cap'          => true,
			'hierarchical'          => true,
			'query_var'             => true,
			'menu_icon'             => 'dashicons-hammer',
			'supports'              => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'comments',
				'revisions',
				'author',
				'post-formats',
				'page-attributes',
			],
		];

		register_post_type( 'products', $args );
	}

	/**
	 * @return bool
	 */

	public function register_assembly() {

		$labels = [
			'name'          => __( 'Assembly', 'wp-bom' ),
			'singular_name' => __( 'Assembly', 'wp-bom' ),
			'menu_name'     => __( 'Assembly', 'wp-bom' ),
			'all_items'     => __( 'All Assemblies', 'wp-bom' ),
		];
		$args   = [
			'label'               => __( 'Assemblies', 'wp-bom' ),
			'labels'              => $labels,
			//'description'         => 'Post type for assemblies build by combining materials with parts.',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'assembly',
			'has_archive'         => 'assemblies',
			'show_in_menu'        => true,
			//'show_in_menu_string' => 'wp-bom-admin',
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

	public function register_requisition() {

		/**
		 * Post Type: Requisitions.
		 */

		$labels = [
			"name"          => __( "Requisitions", "storefront" ),
			"singular_name" => __( "Requisition", "storefront" ),
		];

		$args = [
			"label"               => __( "Requisitions", "storefront" ),
			"labels"              => $labels,
			"description"         => "",
			"public"              => true,
			"publicly_queryable"  => true,
			"show_ui"             => true,
			"show_in_rest"        => true,
			"rest_base"           => "req",
			"has_archive"         => true,
			"show_in_menu"        => true,
			"show_in_nav_menus"   => true,
			"exclude_from_search" => false,
			"capability_type"     => "post",
			"map_meta_cap"        => true,
			"hierarchical"        => true,
			"rewrite"             => [ "slug" => "req", "with_front" => true ],
			"query_var"           => true,
			"menu_icon"           => "dashicons-migrate",
			"supports"            => [ "title", "editor", "thumbnail", "excerpt", "post-formats" ],
			"taxonomies"          => [ "item-category", "requisition-type", "vendor" ],
		];

		register_post_type( "requisition", $args );
	}

	public function register_ecn() {

		$labels = [
			'name'          => __( 'Engineer Change Notice', 'wc-bom' ),
			'singular_name' => __( 'Engineer Change Notice', 'wc-bom' ),
			'menu_name'     => __( 'ECN', 'wc-bom' ),
			'all_items'     => __( 'All Parts', 'wc-bom' ),

		];

		$args = [
			'label'                 => __( 'Engineer Change Notice', 'wc-bom' ),
			'labels'                => $labels,
			//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'show_in_menu'          => true,
			'rest_base'             => 'ecn-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			//'show_in_menu_string' => 'wc-bom-admin',
			'exclude_from_search'   => false,
			'capability_type'       => 'post',
			'map_meta_cap'          => true,
			'hierarchical'          => true,
			'query_var'             => true,
			'menu_icon'             => 'dashicons-hammer',
			'has_archive'           => 'ecns',

			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'comments',
				'revisions',
				'author',
				'post-formats',
				'page-attributes',
			],
		];

		register_post_type( 'ecn', $args );
	}

	/**
	 *
	 */
	public function register_taxonomy() {

		$this->register_part_cat();
		//$this->register_assembly_cat();
		$this->register_vendor();
		$this->register_location();
		//$this->register_requisition_type();
		$this->register_item_tag();


	}

	/**
	 *
	 */
	public function register_part_cat() {

		$labels = [
			'name'          => __( 'Item Category', 'wc-bom' ),
			'singular_name' => __( 'Item Category', 'wc-bom' ),
			'menu_name'     => __( 'Categories', 'wc-bom' ),
		];

		$args = [
			'label'                 => __( 'Item Category', 'wc-bom' ),
			'labels'                => $labels,
			'public'                => true,
			'hierarchical'          => true,
			//'label' => 'Inventory Types',
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'query_var'             => true,
			'show_admin_column'     => true,
			'show_in_rest'          => true,
			'show_in_quick_edit'    => true,
			'rest_base'             => 'category',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		];
		register_taxonomy( 'item-category', [ 'part', 'assembly', 'requisition' ], $args );


	}

	/**
	 *
	 */
	public function register_vendor() {

		$labels = [
			'name'          => __( 'Vendors', 'wc-bom' ),
			'singular_name' => __( 'Vendor', 'wc-bom' ),
			'menu_name'     => __( 'Vendor', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Vendors', 'wc-bom' ),
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
		register_taxonomy( 'vendor', [ 'part', 'assembly', 'requisition' ], $args );


	}

	/**
	 *
	 */
	public function register_location() {

		$labels = [
			'name'          => __( 'Locations', 'wc-bom' ),
			'singular_name' => __( 'Location', 'wc-bom' ),
			'menu_name'     => __( 'Locations', 'wc-bom' ),
		];

		$args = [
			'label'              => __( 'Locations', 'wc-bom' ),
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
		register_taxonomy( 'location', [ 'part', 'assembly', 'requisition' ], $args );


	}

	function register_item_tag() {

		/**
		 * Taxonomy: Item Tags.
		 */

		$labels = [
			"name"          => __( "Item Tags", "storefront" ),
			"singular_name" => __( "Item Tag", "storefront" ),
			"menu_name"     => __( "Tags", "storefront" ),
		];

		$args = [
			"label"              => __( "Item Tags", "storefront" ),
			"labels"             => $labels,
			"public"             => true,
			"hierarchical"       => false,
			"label"              => "Item Tags",
			"show_ui"            => true,
			"show_in_menu"       => true,
			"show_in_nav_menus"  => true,
			"query_var"          => true,
			"rewrite"            => [ 'slug' => 'tag', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"  => true,
			"show_in_rest"       => true,
			"rest_base"          => "item-tag",
			"show_in_quick_edit" => true,
		];
		register_taxonomy( "item_tag", [ "product", "part", "assembly", "requisition" ], $args );
	}
}
