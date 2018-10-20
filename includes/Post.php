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
		//add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'register_post_types2' ] );
		//	add_action( 'init', [ $this, 'register_taxonomy' ] );
		//add_action( 'init', [ $this, 'add_acf_post_groups' ] );
		//add_action( 'save_post', [ $this, 'save_post' ], 10, 2 );
		//add_action( 'init', [ $this, 'save_post' ], 10, 1 );

		//add_action( 'save_post_part', [ $this, 'save_post' ] );
		add_action( 'save_post_assembly', [ $this, 'save_post' ] );
		add_action( 'save_post_product', [ $this, 'save_post' ] );
	}


	/**
	 * @return \Netraa\WPB\Post|object
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function register_post_types2() {
		$labels = [
			'name'          => __( 'Parts', 'wc-bom' ),
			'singular_name' => __( 'Part', 'wc-bom' ),
			'menu_name'     => __( 'Parts', 'wc-bom' ),
			'all_items'     => __( 'All Parts', 'wc-bom' ),
			'id'            => 'part',

		];
		$args   = [
			'label'                 => __( 'Parts', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'parts-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'part', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];


		$this->gen_cpt( $labels, $args );

		$labels = [
			'name'          => __( 'Assembly', 'wc-bom' ),
			'singular_name' => __( 'Assembly', 'wc-bom' ),
			'menu_name'     => __( 'Assembly', 'wc-bom' ),
			'id'            => 'assembly',

		];
		$args   = [
			'label'                 => __( 'Assembly', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'assembly-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'assembly', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];


		$this->gen_cpt( $labels, $args );


		$labels = [
			'name'          => __( 'Requisition', 'wc-bom' ),
			'singular_name' => __( 'Requisition', 'wc-bom' ),
			'menu_name'     => __( 'Requisition', 'wc-bom' ),
			'id'            => 'requisition',

		];
		$args   = [
			'label'                 => __( 'Requisition', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'req-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'req', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];


		$this->gen_cpt( $labels, $args );


		$labels = [
			'name'          => __( 'BOM', 'wc-bom' ),
			'singular_name' => __( 'BOM', 'wc-bom' ),
			'menu_name'     => __( 'BOM', 'wc-bom' ),
			'id'            => 'bom',

		];
		$args   = [
			'label'                 => __( 'Bill of Materials', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'bom-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'bom', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];


		$this->gen_cpt( $labels, $args );


		$labels = [
			'name'          => __( 'ECN', 'wc-bom' ),
			'singular_name' => __( 'ECN', 'wc-bom' ),
			'menu_name'     => __( 'ECN', 'wc-bom' ),
			'id'            => 'ecn',

		];
		$args   = [
			'label'                 => __( 'Engineer Change Notice', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'ecn-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'ecn', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];


		$this->gen_cpt( $labels, $args );
	}

	public function gen_cpt( $labels, $args ) {

		$default_lbl = [
			'name'          => __( 'Parts', 'wc-bom' ),
			'singular_name' => __( 'Part', 'wc-bom' ),
			'menu_name'     => __( 'Parts', 'wc-bom' ),
			'all_items'     => __( 'All Parts', 'wc-bom' ),
			'id'            => 'part',

		];

		$labels = wp_parse_args( $labels, $default_lbl );


		$default_args = [
			'label'                 => __( 'Parts', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'parts-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'part', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];

		$args = wp_parse_args( $args, $default_args );


		$options = get_option( 'wpb_settings' );

		if ( isset( $options['activecpt'] ) ) {


		}

		if ( in_array( $labels['singular_name'], $options['activecpt'] ) ) {

			register_post_type( $labels['id'], $args );
		}
	}

	/**
	 *
	 */
	public function register_post_types() {


		$defaults = [
			'name'          => 'Parts',
			'singular_name' => "Part",
			'menu_name'     => "Parts",
			'slug'          => "part",
			'icon'          => "dashicons-laptop",
		];

		$this->generate_post_type( $defaults );


		$labels = [
			'name'          => 'Produc',
			'singular_name' => 'Produc',
			'menu_name'     => 'Produc',
			'slug'          => 'produ',
			'icon'          => "dashicons-cloud",

		];

		$this->generate_post_type( $labels );
		$labels = [
			'name'          => 'Assemblies',
			'singular_name' => 'Assembly',
			'menu_name'     => 'Assembly',
			'slug'          => 'assembly',
			'icon'          => "dashicons-clipboard",

		];
		$this->generate_post_type( $labels );
		$labels = [
			'name'          => 'Requisitions',
			'singular_name' => 'Requisition',
			'menu_name'     => 'Requisition',
			'slug'          => 'req',
			'icon'          => "dashicons-clipboard",

		];
		$this->generate_post_type( $labels );

		$labels = [
			'name'          => 'Engineer Change Notices',
			'singular_name' => 'Engineer Change Notice',
			'menu_name'     => 'ECN',
			'slug'          => 'ecn',
			'icon'          => "dashicons-clipboard",

		];
		$this->generate_post_type( $labels );

		$labels = [
			'name'          => 'Bill of Materials',
			'singular_name' => 'Bill of Material',
			'menu_name'     => 'BOM',
			'slug'          => 'bom',
			'icon'          => "dashicons-clipboard",

		];
		$this->generate_post_type( $labels );


		$this->register_taxonomy();


	}

	/**
	 * @param array $args
	 */
	public function generate_post_type( $args = [] ) {

		$options = get_option( 'wpb_settings' );

		if ( isset( $options['activecpt'] ) ) {

			var_dump( $options['activecpt'] );

		}

		$defaults = [
			'capability_type' => "post",
			'icon'            => "dashicons-laptop",
		];

		// Parse incoming $args into an array and merge it with $defaults
		$data = wp_parse_args( $args, $defaults );
		$rest = strtolower( $data['slug'] ) . '-api';


		$labels = [
			"name"          => __( $data['name'], "wp-bom" ),
			"singular_name" => __( $data['singular_name'], "wp-bom" ),
			"menu_name"     => __( $data['menu_name'], "wp-bom" ),
		];

		$fields = [
			"label"                 => __( $data['name'], "wp-bom" ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			"rest_base"             => strtolower( $data['slug'] ) . '-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			"capability_type"       => $data['capability_type'],
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => $data['slug'], "with_front" => true ],
			"query_var"             => true,
			"menu_icon"             => $data['icon'],
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];

		//if ( in_array( $data['singular_name'], $options['activecpt'] ) ) {
		register_post_type( $data['slug'], $fields );
		//} else {
		echo 'no';
		//}
	}


	/**
	 *
	 */
	public function register_taxonomy() {
		$this->register_material();
		$this->register_vendor();
		$this->register_location();
		$this->register_keyword();
	}

	/**
	 *
	 */
	public function register_material() {

		/**
		 * Taxonomy: Materials.
		 */

		$labels = [
			"name"          => __( "Materials", "wp-bom" ),
			"singular_name" => __( "Material", "wp-bom" ),
		];

		$args = [
			"label"                 => __( "Materials", "wp-bom" ),
			"labels"                => $labels,
			"public"                => true,
			"hierarchical"          => true,
			"label"                 => "Materials",
			"show_ui"               => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"query_var"             => true,
			"rewrite"               => [ 'slug' => 'material', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"     => true,
			"show_in_rest"          => true,
			"rest_base"             => "material-api",
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"show_in_quick_edit"    => true,
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,


		];
		register_taxonomy( "material", [ "part", "assembly" ], $args );
	}

	/**
	 *
	 */
	public function register_vendor() {

		$labels = [
			'name'          => __( 'Vendors', 'wp-bom' ),
			'singular_name' => __( 'Vendor', 'wp-bom' ),
			'menu_name'     => __( 'Vendor', 'wp-bom' ),
		];

		$args = [
			'label'                 => __( 'Vendors', 'wp-bom' ),
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
			"rewrite"               => [ 'slug' => 'vendor', 'with_front' => true, 'hierarchical' => true, ],
			"rest_base"             => "vendor-api",
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,
		];
		register_taxonomy( 'vendor', [ 'part', 'assembly', 'requisition' ], $args );


	}

	/**
	 *
	 */
	public function register_location() {

		$labels = [
			'name'          => __( 'Location', 'wp-bom' ),
			'singular_name' => __( 'Location', 'wp-bom' ),
			'menu_name'     => __( 'Locations', 'wp-bom' ),
		];

		$args = [
			'label'                 => __( 'Locations', 'wp-bom' ),
			'labels'                => $labels,
			'public'                => true,
			'hierarchical'          => true,
			//'label' => 'Inventory Types',
			"show_ui"               => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"query_var"             => true,
			"rewrite"               => [ 'slug' => 'location', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"     => true,
			"show_in_rest"          => true,
			"rest_base"             => "location-api",
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"show_in_quick_edit"    => true,
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,
		];
		register_taxonomy( 'location', [ 'part', 'assembly', 'requisition' ], $args );


	}

	/**
	 *
	 */
	public function register_keyword() {

		/**
		 * Taxonomy: Item Tags.
		 */

		$labels = [
			"name"          => __( "Keyword", "wp-bom" ),
			"singular_name" => __( "Keyword", "wp-bom" ),
			"menu_name"     => __( "Keywords", "wp-bom" ),
		];

		$args = [
			"label"                 => __( "Keywords", "wp-bom" ),
			"labels"                => $labels,
			"public"                => true,
			"hierarchical"          => false,
			"label"                 => "Keywords",
			"show_ui"               => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"query_var"             => true,
			"rewrite"               => [ 'slug' => 'keyword', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"     => true,
			"show_in_rest"          => true,
			"rest_base"             => "keyword",
			"show_in_quick_edit"    => true,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,

		];
		register_taxonomy( "keyword", [ "product", "part", "assembly", "requisition" ], $args );
	}
}
