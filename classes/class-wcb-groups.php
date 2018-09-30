<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 9/25/18
 * Time: 4:23 PM
 */

class WCB_Field_Groups {


	private $groups = [
		'part'      => '',
		'assembly'  => '',
		'product'   => '',
		'inventory' => '',
	];


	protected static $instance = null;


	private function __construct() {
		$this->init();
	}

	protected function init() {
		add_action( 'init', [ $this, 'add_all_groups' ] );
	}


	public static function getInstance() {
		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
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
				$this->add_part_group();
			} elseif ( $post->post_title === 'Assembly' ) {
				$this->add_assembly_group();
			} elseif ( $post->post_title === 'Product' ) {
				$this->add_product_group();
			}
		}

	}

	public function add_all_groups() {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			$this->add_part_group();
			$this->add_assembly_group();
			$this->add_product_group();
		}
	}

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

	public function add_product_group() {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group( [
				'key'                   => 'group_590779985a45c',
				'title'                 => 'Product',
				'fields'                => [
					[
						'key'               => 'field_5ae4d314160cc',
						'label'             => 'Product Assembly',
						'name'              => 'product_assembly',
						'type'              => 'repeater',
						'instructions'      => 'Parts, Assemblies used in creation of this product.',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'collapsed'         => 'field_5ae4d348160cd',
						'min'               => 0,
						'max'               => 0,
						'layout'            => 'table',
						'button_label'      => 'Add Item',
						'sub_fields'        => [
							[
								'key'               => 'field_5baaa26dfa0d1',
								'label'             => 'Part or Assembly',
								'name'              => 'part_or_assembly',
								'type'              => 'select',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => [
									'width' => '',
									'class' => '',
									'id'    => '',
								],
								'choices'           => [
									'Part'     => 'Part',
									'Assembly' => 'Assembly',
								],
								'default_value'     => [
									0 => 'Part',
								],
								'allow_null'        => 0,
								'multiple'          => 0,
								'ui'                => 1,
								'ajax'              => 1,
								'return_format'     => 'value',
								'placeholder'       => '',
							],
							[
								'key'               => 'field_5ae4d366160ce',
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
								'key'               => 'field_5ae4d348160cd',
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
							'value'    => 'product',
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
				'description'           => 'List of parts, assemblies and their quantities to create products.',
			] );

			return true;
		}

		return false;
	}

}