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
