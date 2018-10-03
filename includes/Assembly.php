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
class Assembly {


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
		add_action( 'init', [ $this, 'register_assembly' ] );
		//add_action( 'init', [ $this, 'register_assembly_cat' ] );
		add_action( 'init', [ $this, 'add_assembly_group' ] );

	}

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
				$this->add_assembly_group();
			}

		}

	}


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
			'name'          => __( 'Assembly Categories', 'wp-bom' ),
			'singular_name' => __( 'Assembly Category', 'wp-bom' ),
			'menu_name'     => __( 'Categories', 'wp-bom' ),
		];

		$args = [
			'label'              => __( 'Assembly Categories', 'wp-bom' ),
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
		register_taxonomy( 'assembly-category', ['assembly' ], $args );


	}

	public function add_assembly_group() {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group( [
				'key'                   => 'group_58bec9c065391',
				'title'                 => 'Assembly',
				'fields'                => [
					[
						'key'               => 'field_59077aa89c6ff',
						'label'             => 'Assembly ID',
						'name'              => 'assembly_id',
						'type'              => 'text',
						'instructions'      => 'ID number of assembly',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '',
						'placeholder'       => 'GBPP-808',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					],
					[
						'key'               => 'field_58bec9fc4dcd4',
						'label'             => 'Assembly Items',
						'name'              => 'assembly_items',
						'type'              => 'repeater',
						'instructions'      => 'Enter qty of parts & sub-assemblies used in building this assmelby.',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'collapsed'         => '',
						'min'               => 0,
						'max'               => 0,
						'layout'            => 'table',
						'button_label'      => 'Add Item',
						'sub_fields'        => [
							[
								'key'               => 'field_5baa9f1eee1b3',
								'label'             => 'Part or Sub-Assembly',
								'name'              => 'part_or_sub_assembly',
								'type'              => 'select',
								'instructions'      => '',
								'required'          => 1,
								'conditional_logic' => 0,
								'wrapper'           => [
									'width' => '',
									'class' => '',
									'id'    => '',
								],
								'choices'           => [
									'Part'         => 'Part',
									'Sub-Assembly' => 'Sub-Assembly',
								],
								'default_value'     => [
									0 => 'Part',
								],
								'allow_null'        => 0,
								'multiple'          => 0,
								'ui'                => 1,
								'ajax'              => 0,
								'return_format'     => 'value',
								'placeholder'       => '',
							],
							[
								'key'               => 'field_58beca774dcd6',
								'label'             => 'Quantity',
								'name'              => 'quantity',
								'type'              => 'number',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => [
									'width' => '20',
									'class' => '',
									'id'    => '',
								],
								'default_value'     => 1,
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => 'units',
								'min'               => '',
								'max'               => '',
								'step'              => '',
							],
							[
								'key'               => 'field_58beca404dcd5',
								'label'             => 'Item',
								'name'              => 'item',
								'type'              => 'post_object',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => [
									'width' => '80',
									'class' => '',
									'id'    => '',
								],
								'post_type'         => [
									0 => 'part',
									1 => 'assembly',
								],
								'taxonomy'          => [
								],
								'allow_null'        => 0,
								'multiple'          => 0,
								'return_format'     => 'object',
								'ui'                => 1,
							],
						],
					],
				],
				'location'              => [
					[
						[
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'assembly',
						],
					],
				],
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => 'Collection of components, parts, sub-assemblies to create an assembly used in creation of products.',
			] );

			return true;
		}

		return false;
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
