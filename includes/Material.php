<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/5/18
 * Time: 5:02 PM
 */
abstract class Material {


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
		add_action( 'init', [ $this, 'register_part' ] );
		add_action( 'init', [ $this, 'register_part_cat' ] );
		add_action( 'init', [ $this, 'register_vendor' ] );
		add_action( 'init', [ $this, 'add_part_group' ] );

	}

	/**
	 *
	 */
	public function check_field_groups() {

		$args = [
			'posts_per_page'   => - 1,
			'post_type'        => 'acf-field-group',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		];

		$posts_array = get_posts( $args );

		foreach ( $posts_array as $post ) {
			$post = new WP_Post( $post );
			if ( $post->post_title === 'Part' ) {
				$this->add_part_group();
			}

		}

	}

	/**
	 *
	 */
	public function add_all_groups() {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			$this->add_part_group();
//			$this->add_assembly_group();
//			$this->add_product_group();
		}
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
		register_taxonomy( 'vendor', [ 'part', 'assembly' ], $args );


	}

	public function register_taxonomy() {

	}


	public function register_post_type() {

	}



	public function add_acf_field_group() {

	}

	/**
	 * @return bool
	 */
	public function add_part_group() {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group( [
				'key'                   => 'group_58be21633a48e',
				'title'                 => 'Part',
				'fields'                => [
					[
						'key'               => 'field_58be224180f49',
						'label'             => 'Part No.',
						'name'              => 'part_no',
						'type'              => 'text',
						'instructions'      => 'Unique identifier of part',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => 'STEEL-9032',
						'placeholder'       => 'STEEL-9032',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					],
					[
						'key'               => 'field_5ae4d247994c8',
						'label'             => 'SKU',
						'name'              => 'sku',
						'type'              => 'text',
						'instructions'      => 'Unique identifier of part',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '',
						'placeholder'       => 'ST9',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					],
					[
						'key'               => 'field_58be26e874984',
						'label'             => 'Cost',
						'name'              => 'cost',
						'type'              => 'number',
						'instructions'      => 'Unit price of part',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '1.00',
						'placeholder'       => '',
						'prepend'           => '$',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
					],
					[
						'key'               => 'field_58be25d7bc42b',
						'label'             => 'Weight',
						'name'              => 'weight',
						'type'              => 'number',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '1.5',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => 'lbs',
						'min'               => '',
						'max'               => '',
						'step'              => '.5',
					],
					[
						'key'               => 'field_5ae7bba2657f8',
						'label'             => 'Stock',
						'name'              => 'stock',
						'type'              => 'number',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => 10,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => 'units',
						'min'               => '',
						'max'               => '',
						'step'              => '',
					],
					[
						'key'               => 'field_5af1f8533f9bc',
						'label'             => 'Vendor',
						'name'              => 'vendor',
						'type'              => 'taxonomy',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'taxonomy'          => 'vendor',
						'field_type'        => 'select',
						'allow_null'        => 1,
						'add_term'          => 1,
						'save_terms'        => 1,
						'load_terms'        => 1,
						'return_format'     => 'id',
						'multiple'          => 0,
					],
					[
						'key'               => 'field_5af1f875a3e69',
						'label'             => 'Category',
						'name'              => 'category',
						'type'              => 'taxonomy',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'taxonomy'          => 'product_cat',
						'field_type'        => 'checkbox',
						'allow_null'        => 1,
						'add_term'          => 1,
						'save_terms'        => 1,
						'load_terms'        => 1,
						'return_format'     => 'id',
						'multiple'          => 0,
					],
				],
				'location'              => [
					[
						[
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'part',
						],
					],
				],
				'menu_order'            => 0,
				'position'              => 'acf_after_title',
				'style'                 => 'default',
				'label_placement'       => 'left',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => 'Part object used in process of manufacturing assemblies or products.',
			] );

			return true;
		}

		return false;
	}


	public function register( $labels, $args, $type = 'post') {


		$label_default = [
			'type'   => 'post',
			'before' => "<p>",
			'after'  => "</p> \n",
			'echo'   => true,
			'obj'    => [
				'part' => '',
			],
		];

		$labels = wp_parse_args( $labels, $label_default );

		$default = [
			'type'   => 'post',
			'before' => "<p>",
			'after'  => "</p> \n",
			'echo'   => true,
			'obj'    => [
				'part' => '',
			],
		];

		$args = wp_parse_args( $args, $default );



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