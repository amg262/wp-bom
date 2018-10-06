<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

namespace Netraa\WPB;

use WP_Post;

/**
 * @subpackage Plugin
 */
class Assembly2 {


	private $post;
	private $assembly;
	private $assembly_id;
	private $subassembly_list = [];
	private $assembly_items = [];


	/**
	 * Setup instance attributes
	 *
	 * @since     1.0.0
	 */
	public function __construct() {
		global $post, $post_ID;
//
//		$this->post     = new WP_Post( $post );
//		$this->assembly = new WP_Post( $post );

	}

	public function return_list( $id ) {

		if ( have_rows( 'assembly_items', $id ) ) {


			while ( have_rows( 'assembly_items', $id ) ) : the_row();

				$item = get_sub_field( 'item' );
				$qty  = get_sub_field( 'quantity' );
				$is   = get_sub_field( 'part_or_sub_assembly' );


			endwhile;

		}
	}

	public function yeah() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array (
				'key' => 'group_58bec9c065391',
				'title' => 'Assembly',
				'fields' => array (
					array (
						'key' => 'field_59077aa89c6ff',
						'label' => 'Assembly ID',
						'name' => 'assembly_id',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5bb80d769c545',
						'label' => 'Assembly List',
						'name' => 'assembly_list',
						'type' => 'post_object',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '75',
							'class' => '',
							'id' => '',
						),
						'post_type' => array (
							0 => 'part',
							1 => 'assembly',
						),
						'taxonomy' => array (
						),
						'allow_null' => 1,
						'multiple' => 1,
						'return_format' => 'object',
						'ui' => 1,
					),
					array (
						'key' => 'field_5bb813757ccd5',
						'label' => 'Object List',
						'name' => 'object_list',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'assembly',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array (
				'key' => 'group_5bb80c60b265d',
				'title' => 'Items',
				'fields' => array (
					array (
						'key' => 'field_5bb80c6bc205e',
						'label' => 'Items',
						'name' => 'items',
						'type' => 'repeater',
						'instructions' => 'Enter qty of parts & sub-assemblies used in building this assmelby.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => 'field_5bb80c6cc2061',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => 'Add Item',
						'sub_fields' => array (
							array (
								'key' => 'field_5bb814c6de101',
								'label' => 'Level',
								'name' => 'level',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '15',
									'class' => 'wpb_items',
									'id' => 'wpb_item_type',
								),
								'default_value' => 1,
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array (
								'key' => 'field_5bb80c6cc205f',
								'label' => 'Type',
								'name' => 'type',
								'type' => 'select',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '15',
									'class' => 'wpb_items',
									'id' => 'wpb_item_type',
								),
								'choices' => array (
									'Part' => 'Part',
									'Assembly' => 'Assembly',
								),
								'default_value' => array (
									0 => 'Part',
								),
								'allow_null' => 1,
								'multiple' => 0,
								'ui' => 1,
								'ajax' => 0,
								'return_format' => 'value',
								'placeholder' => '',
							),
							array (
								'key' => 'field_5bb80c6cc2062',
								'label' => 'Quantity',
								'name' => 'quantity',
								'type' => 'number',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '15',
									'class' => 'wpb_items',
									'id' => 'wpb_item_qty',
								),
								'default_value' => '1.0',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'min' => '',
								'max' => '',
								'step' => '',
							),
							array (
								'key' => 'field_5bb80c6cc2061',
								'label' => 'Item',
								'name' => 'item',
								'type' => 'post_object',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => 'wpb_items',
									'id' => 'wpb_item',
								),
								'post_type' => array (
									0 => 'part',
									1 => 'assembly',
								),
								'taxonomy' => array (
								),
								'allow_null' => 1,
								'multiple' => 0,
								'return_format' => 'object',
								'ui' => 1,
							),
						),
					),
					array (
						'key' => 'field_5bb80d0076ac0',
						'label' => 'Assembly Items',
						'name' => 'assembly_items',
						'type' => 'repeater',
						'instructions' => 'Enter qty of parts & sub-assemblies used in building this assmelby.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => 'Add Item',
						'sub_fields' => array (
							array (
								'key' => 'field_5bb80d0076ac1',
								'label' => 'Type',
								'name' => 'type',
								'type' => 'select',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => 'wpb_items',
									'id' => 'wpb_item_type',
								),
								'choices' => array (
									'Part' => 'Part',
									'Assembly' => 'Assembly',
								),
								'default_value' => array (
									0 => 'Part',
								),
								'allow_null' => 1,
								'multiple' => 0,
								'ui' => 1,
								'ajax' => 0,
								'return_format' => 'value',
								'placeholder' => '',
							),
							array (
								'key' => 'field_5bb80d0076ac2',
								'label' => 'Quantity',
								'name' => 'quantity',
								'type' => 'number',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '30',
									'class' => 'wpb_items',
									'id' => 'wpb_item_qty',
								),
								'default_value' => '1.0',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'min' => '',
								'max' => '',
								'step' => '',
							),
							array (
								'key' => 'field_5bb80d0076ac3',
								'label' => 'Item',
								'name' => 'item',
								'type' => 'post_object',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '70',
									'class' => 'wpb_items',
									'id' => 'wpb_item',
								),
								'post_type' => array (
									0 => 'part',
									1 => 'assembly',
								),
								'taxonomy' => array (
								),
								'allow_null' => 1,
								'multiple' => 1,
								'return_format' => 'object',
								'ui' => 1,
							),
						),
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'assembly',
						),
					),
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'product',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array (
				'key' => 'group_58be21633a48e',
				'title' => 'Part',
				'fields' => array (
					array (
						'key' => 'field_58be224180f49',
						'label' => 'Part No.',
						'name' => 'part_no',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5ae4d247994c8',
						'label' => 'SKU',
						'name' => 'sku',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array (
						'key' => 'field_58be26e874984',
						'label' => 'Cost',
						'name' => 'cost',
						'type' => 'number',
						'instructions' => 'Unit price of part',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '$',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array (
						'key' => 'field_58be25d7bc42b',
						'label' => 'Weight',
						'name' => 'weight',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => 'lbs',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array (
						'key' => 'field_5af1f8533f9bc',
						'label' => 'Vendor',
						'name' => 'vendor',
						'type' => 'taxonomy',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45',
							'class' => '',
							'id' => '',
						),
						'taxonomy' => 'vendor',
						'field_type' => 'select',
						'allow_null' => 1,
						'add_term' => 1,
						'save_terms' => 1,
						'load_terms' => 1,
						'return_format' => 'id',
						'multiple' => 0,
					),
					array (
						'key' => 'field_5af1f875a3e69',
						'label' => 'Category',
						'name' => 'category',
						'type' => 'taxonomy',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '45',
							'class' => '',
							'id' => '',
						),
						'taxonomy' => 'product_cat',
						'field_type' => 'checkbox',
						'allow_null' => 1,
						'add_term' => 1,
						'save_terms' => 1,
						'load_terms' => 1,
						'return_format' => 'id',
						'multiple' => 0,
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'part',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => 'Part object used in process of manufacturing assemblies or products.',
			));

		endif;
	}
	/**
	 * @return mixed
	 */
	public function getAssembly() {
		return $this->assembly;
	}

	/**
	 * @param mixed $assembly
	 */
	public function setAssembly( $assembly ): void {
		$this->assembly = new WP_Post( $assembly );
	}

	/**
	 * @return array
	 */
	public function getSubassemblyList(): array {
		return $this->subassembly_list;
	}

	/**
	 * @param array $subassembly_list
	 */
	public function setSubassemblyList( array $subassembly_list ): void {
		$this->subassembly_list = $subassembly_list;
	}

	/**
	 * @return array
	 */
	public function getAssemblyItems(): array {
		return $this->assembly_items;
	}

	/**
	 * @param array $assembly_items
	 */
	public function set_assembly_items( array $assembly_items ): void {
		$this->assembly_items = $assembly_items;
	}


}
