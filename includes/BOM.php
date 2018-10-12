<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/11/18
 * Time: 7:22 PM
 */

namespace Netraa\WPB;


class BOM {


	private $bom;

	public function __construct( $id ) {
		include_once __DIR__ . '/Component.php';

		$this->bom = new Component( $id );
		$this->bom->setAcfField( 'assembly_id', $id );

		$this->bom->setCfAssemItems($id);


	}

	public function get_asi() {
		return $this->bom->getCfAssemSubItems();
	}
	public function get_ai() {
		return $this->bom->getCfAssemItems();
	}

	public function get_comp() {
		return $this->bom;
	}

	public function create_assembly_bom( $id ) {
		include_once __DIR__ . '/Component.php';

		$assembly = new Component();
		$idd      = $assembly->setPostId( $id );
		$assembly->setPost( new \WP_Post( $idd ) );
		$obj = $assembly->getPost();

		//$post  = get_post( $post_id );
		$aid   = get_field( 'assembly_id', $obj->ID );
		$assem = get_field( 'assembly_list', $obj->ID );
		$obj   = get_field( 'object_list', $obj->ID );

		return $assem;

	}


}