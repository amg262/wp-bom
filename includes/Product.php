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
class Product {


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
		//add_action( 'init', [ $this, 'register_assembly' ] );
		//add_action( 'init', [ $this, 'register_assembly_cat' ] );
		add_action( 'init', [ $this, 'add_product_group' ] );

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
