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
			'has_archive'         => 'ecns',

			'supports'              => [
				'title',
				'editor',
				'thumbnail',
				//'excerpt',
				'comments',
				'revisions',
				'author',
				'page-attributes',
			],
		];

		register_post_type( 'ecn', $args );
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
		register_taxonomy( 'item-category', [ 'part', 'assembly','requisition' ], $args );


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


	public function register_post_types() {

		$this->register_part();
		$this->register_assembly();
		$this->register_requisition();
		$this->register_ecn();

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

//
//	public function add_assembly_group() {
//		if ( function_exists( 'acf_add_local_field_group' ) ) {
//			acf_add_local_field_group( [
//				'key'                   => 'group_58bec9c065391',
//				'title'                 => 'Assembly',
//				'fields'                => [
//					[
//						'key'               => 'field_59077aa89c6ff',
//						'label'             => 'Assembly ID',
//						'name'              => 'assembly_id',
//						'type'              => 'text',
//						'instructions'      => 'ID number of assembly',
//						'required'          => 1,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'default_value'     => '',
//						'placeholder'       => 'GBPP-808',
//						'prepend'           => '',
//						'append'            => '',
//						'maxlength'         => '',
//					],
//					[
//						'key'               => 'field_58bec9fc4dcd4',
//						'label'             => 'Assembly Items',
//						'name'              => 'assembly_items',
//						'type'              => 'repeater',
//						'instructions'      => 'Enter qty of parts & sub-assemblies used in building this assmelby.',
//						'required'          => 0,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'collapsed'         => '',
//						'min'               => 0,
//						'max'               => 0,
//						'layout'            => 'table',
//						'button_label'      => 'Add Item',
//						'sub_fields'        => [
//							[
//								'key'               => 'field_5baa9f1eee1b3',
//								'label'             => 'Part or Sub-Assembly',
//								'name'              => 'part_or_sub_assembly',
//								'type'              => 'select',
//								'instructions'      => '',
//								'required'          => 1,
//								'conditional_logic' => 0,
//								'wrapper'           => [
//									'width' => '',
//									'class' => '',
//									'id'    => '',
//								],
//								'choices'           => [
//									'Part'         => 'Part',
//									'Sub-Assembly' => 'Sub-Assembly',
//								],
//								'default_value'     => [
//									0 => 'Part',
//								],
//								'allow_null'        => 0,
//								'multiple'          => 0,
//								'ui'                => 1,
//								'ajax'              => 0,
//								'return_format'     => 'value',
//								'placeholder'       => '',
//							],
//							[
//								'key'               => 'field_58beca774dcd6',
//								'label'             => 'Quantity',
//								'name'              => 'quantity',
//								'type'              => 'number',
//								'instructions'      => '',
//								'required'          => 0,
//								'conditional_logic' => 0,
//								'wrapper'           => [
//									'width' => '20',
//									'class' => '',
//									'id'    => '',
//								],
//								'default_value'     => 1,
//								'placeholder'       => '',
//								'prepend'           => '',
//								'append'            => 'units',
//								'min'               => '',
//								'max'               => '',
//								'step'              => '',
//							],
//							[
//								'key'               => 'field_58beca404dcd5',
//								'label'             => 'Item',
//								'name'              => 'item',
//								'type'              => 'post_object',
//								'instructions'      => '',
//								'required'          => 0,
//								'conditional_logic' => 0,
//								'wrapper'           => [
//									'width' => '80',
//									'class' => '',
//									'id'    => '',
//								],
//								'post_type'         => [
//									0 => 'part',
//									1 => 'assembly',
//								],
//								'taxonomy'          => [
//								],
//								'allow_null'        => 0,
//								'multiple'          => 0,
//								'return_format'     => 'object',
//								'ui'                => 1,
//							],
//						],
//					],
//				],
//				'location'              => [
//					[
//						[
//							'param'    => 'post_type',
//							'operator' => '==',
//							'value'    => 'assembly',
//						],
//					],
//				],
//				'menu_order'            => 0,
//				'position'              => 'normal',
//				'style'                 => 'default',
//				'label_placement'       => 'top',
//				'instruction_placement' => 'label',
//				'hide_on_screen'        => '',
//				'active'                => 1,
//				'description'           => 'Collection of components, parts, sub-assemblies to create an assembly used in creation of products.',
//			] );
//
//			return true;
//		}
//
//		return false;
//	}
//
//	public function add_part_group() {
//		if ( function_exists( 'acf_add_local_field_group' ) ) {
//			acf_add_local_field_group( [
//				'key'                   => 'group_58be21633a48e',
//				'title'                 => 'Part',
//				'fields'                => [
//					[
//						'key'               => 'field_58be224180f49',
//						'label'             => 'Part No.',
//						'name'              => 'part_no',
//						'type'              => 'text',
//						'instructions'      => 'Unique identifier of part',
//						'required'          => 1,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'default_value'     => 'STEEL-9032',
//						'placeholder'       => 'STEEL-9032',
//						'prepend'           => '',
//						'append'            => '',
//						'maxlength'         => '',
//					],
//					[
//						'key'               => 'field_5ae4d247994c8',
//						'label'             => 'SKU',
//						'name'              => 'sku',
//						'type'              => 'text',
//						'instructions'      => 'Unique identifier of part',
//						'required'          => 1,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'default_value'     => '',
//						'placeholder'       => 'ST9',
//						'prepend'           => '',
//						'append'            => '',
//						'maxlength'         => '',
//					],
//					[
//						'key'               => 'field_58be26e874984',
//						'label'             => 'Cost',
//						'name'              => 'cost',
//						'type'              => 'number',
//						'instructions'      => 'Unit price of part',
//						'required'          => 1,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'default_value'     => '1.00',
//						'placeholder'       => '',
//						'prepend'           => '$',
//						'append'            => '',
//						'min'               => '',
//						'max'               => '',
//						'step'              => '',
//					],
//					[
//						'key'               => 'field_58be25d7bc42b',
//						'label'             => 'Weight',
//						'name'              => 'weight',
//						'type'              => 'number',
//						'instructions'      => '',
//						'required'          => 1,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'default_value'     => '1.5',
//						'placeholder'       => '',
//						'prepend'           => '',
//						'append'            => 'lbs',
//						'min'               => '',
//						'max'               => '',
//						'step'              => '.5',
//					],
//					[
//						'key'               => 'field_5ae7bba2657f8',
//						'label'             => 'Stock',
//						'name'              => 'stock',
//						'type'              => 'number',
//						'instructions'      => '',
//						'required'          => 0,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'default_value'     => 10,
//						'placeholder'       => '',
//						'prepend'           => '',
//						'append'            => 'units',
//						'min'               => '',
//						'max'               => '',
//						'step'              => '',
//					],
//					[
//						'key'               => 'field_5af1f8533f9bc',
//						'label'             => 'Vendor',
//						'name'              => 'vendor',
//						'type'              => 'taxonomy',
//						'instructions'      => '',
//						'required'          => 0,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'taxonomy'          => 'vendor',
//						'field_type'        => 'select',
//						'allow_null'        => 1,
//						'add_term'          => 1,
//						'save_terms'        => 1,
//						'load_terms'        => 1,
//						'return_format'     => 'id',
//						'multiple'          => 0,
//					],
//					[
//						'key'               => 'field_5af1f875a3e69',
//						'label'             => 'Category',
//						'name'              => 'category',
//						'type'              => 'taxonomy',
//						'instructions'      => '',
//						'required'          => 0,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'taxonomy'          => 'product_cat',
//						'field_type'        => 'checkbox',
//						'allow_null'        => 1,
//						'add_term'          => 1,
//						'save_terms'        => 1,
//						'load_terms'        => 1,
//						'return_format'     => 'id',
//						'multiple'          => 0,
//					],
//				],
//				'location'              => [
//					[
//						[
//							'param'    => 'post_type',
//							'operator' => '==',
//							'value'    => 'part',
//						],
//					],
//				],
//				'menu_order'            => 0,
//				'position'              => 'acf_after_title',
//				'style'                 => 'default',
//				'label_placement'       => 'left',
//				'instruction_placement' => 'label',
//				'hide_on_screen'        => '',
//				'active'                => 1,
//				'description'           => 'Part object used in process of manufacturing assemblies or products.',
//			] );
//
//			return true;
//		}
//
//		return false;
//	}
//
//	public function add_product_group() {
//		if ( function_exists( 'acf_add_local_field_group' ) ) {
//			acf_add_local_field_group( [
//				'key'                   => 'group_590779985a45c',
//				'title'                 => 'Product',
//				'fields'                => [
//					[
//						'key'               => 'field_5ae4d314160cc',
//						'label'             => 'Product Assembly',
//						'name'              => 'product_assembly',
//						'type'              => 'repeater',
//						'instructions'      => 'Parts, Assemblies used in creation of this product.',
//						'required'          => 0,
//						'conditional_logic' => 0,
//						'wrapper'           => [
//							'width' => '',
//							'class' => '',
//							'id'    => '',
//						],
//						'collapsed'         => 'field_5ae4d348160cd',
//						'min'               => 0,
//						'max'               => 0,
//						'layout'            => 'table',
//						'button_label'      => 'Add Item',
//						'sub_fields'        => [
//							[
//								'key'               => 'field_5baaa26dfa0d1',
//								'label'             => 'Part or Assembly',
//								'name'              => 'part_or_assembly',
//								'type'              => 'select',
//								'instructions'      => '',
//								'required'          => 0,
//								'conditional_logic' => 0,
//								'wrapper'           => [
//									'width' => '',
//									'class' => '',
//									'id'    => '',
//								],
//								'choices'           => [
//									'Part'     => 'Part',
//									'Assembly' => 'Assembly',
//								],
//								'default_value'     => [
//									0 => 'Part',
//								],
//								'allow_null'        => 0,
//								'multiple'          => 0,
//								'ui'                => 1,
//								'ajax'              => 1,
//								'return_format'     => 'value',
//								'placeholder'       => '',
//							],
//							[
//								'key'               => 'field_5ae4d366160ce',
//								'label'             => 'Quantity',
//								'name'              => 'quantity',
//								'type'              => 'number',
//								'instructions'      => '',
//								'required'          => 0,
//								'conditional_logic' => 0,
//								'wrapper'           => [
//									'width' => '20',
//									'class' => '',
//									'id'    => '',
//								],
//								'default_value'     => 1,
//								'placeholder'       => '',
//								'prepend'           => '',
//								'append'            => 'units',
//								'min'               => '',
//								'max'               => '',
//								'step'              => '',
//							],
//							[
//								'key'               => 'field_5ae4d348160cd',
//								'label'             => 'Item',
//								'name'              => 'item',
//								'type'              => 'post_object',
//								'instructions'      => '',
//								'required'          => 0,
//								'conditional_logic' => 0,
//								'wrapper'           => [
//									'width' => '80',
//									'class' => '',
//									'id'    => '',
//								],
//								'post_type'         => [
//									0 => 'part',
//									1 => 'assembly',
//								],
//								'taxonomy'          => [
//								],
//								'allow_null'        => 0,
//								'multiple'          => 0,
//								'return_format'     => 'object',
//								'ui'                => 1,
//							],
//						],
//					],
//				],
//				'location'              => [
//					[
//						[
//							'param'    => 'post_type',
//							'operator' => '==',
//							'value'    => 'product',
//						],
//					],
//				],
//				'menu_order'            => 0,
//				'position'              => 'normal',
//				'style'                 => 'default',
//				'label_placement'       => 'top',
//				'instruction_placement' => 'label',
//				'hide_on_screen'        => '',
//				'active'                => 1,
//				'description'           => 'List of parts, assemblies and their quantities to create products.',
//			] );
//
//			return true;
//		}
//
//		return false;
//	}
//
//	public function add_acf_post_groups() {
//		if ( function_exists( 'acf_add_local_field_group' ) ) {
//			$this->add_part_group();
//			$this->add_assembly_group();
//			$this->add_product_group();
//
//			return true;
//		}
//
//		return false;
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
}
