<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/16/18
 * Time: 5:35 PM
 */

namespace Netraa\WPB;


/**
 * Class Component
 *
 * @package Netraa\WPB
 */
interface dsdsINT_Component {
	/**
	 * @return mixed
	 */
	public function getPostId();

	/**
	 * @param mixed $post_id
	 *
	 * @return INT_Component
	 */
	public function setPostId( $post_id );

	/**
	 * @return mixed
	 */
	public function getAssemblyId();

	/**
	 * @param mixed $assembly_id
	 *
	 * @return INT_Component
	 */
	public function setAssemblyId( $assembly_id );

	/**
	 * @return mixed
	 */
	public function getPostType();

	/**
	 * @param mixed $post_type
	 *
	 * @return INT_Component
	 */
	public function setPostType( $post_type );

	/**
	 * @return mixed
	 */
	public function getAssemblyItemList();

	/**
	 * @param mixed $assembly_item_list
	 *
	 * @return INT_Component
	 */
	public function setAssemblyItemList( $post_id = 0, $index = 0 );

	public function setSub( $post_id );

	public function parse_sub( $sub );

	public function parse_tiers();

	/**
	 * @return mixed
	 */
	public function getAssemblySubList();

	/**
	 * @param mixed $assembly_sub_list
	 *
	 * @return INT_Component
	 */
	public function setAssemblySubList( $assembly_sub_list );

	/**
	 * @return mixed
	 */
	public function getItemParent();

	/**
	 * @param mixed $item_parent
	 *
	 * @return INT_Component
	 */
	public function setItemParent( $item_parent );

	/**
	 * @return mixed
	 */
	public function getItems();

	/**
	 * @param mixed $items
	 *
	 * @return INT_Component
	 */
	public function setItems( $post_id = 0 );

	/**
	 * @return mixed
	 */
	public function getItemsPart( $id );

	/**
	 * @param mixed $items_part
	 *
	 * @return INT_Component
	 */
	public function setItemsPart( $post_id, $items_part );

	/**
	 * @return mixed
	 */
	public function getItemsAssembly();

	/**
	 * @param mixed $items_assembly
	 *
	 * @return INT_Component
	 */
	public function setItemsAssembly( $post_id, $items_assembly );

	/**
	 * @return mixed
	 */
	public function getAssemblyPartList();

	/**
	 * @param mixed $assembly_part_list
	 *
	 * @return INT_Component
	 */
	public function setAssemblyPartList( $assembly_part_list );

	/**
	 * @return array
	 */
	public function getCfItems();

	/**
	 * @param array $cf_items
	 *
	 * @return INT_Component
	 */
	public function setCfItems( array $cf_items );

	/**
	 * @return array
	 */
	public function getCfAssemSubitems();

	/**
	 */
	public function setCfAssemSubitems( $obj );

	/**
	 * @return array
	 */
	public function getCfAssemParts();

	/**
	 * @param array $cf_assem_parts
	 *
	 * @return INT_Component
	 */
	public function setCfAssemParts( array $cf_assem_parts );

	/**
	 * @return array
	 */
	public function getCfAssemItems();

	public function setCfAssemItems( $post_id );

	/**
	 * @return mixed
	 */
	public function getAcfField();

	/**
	 * @param $acf_field
	 *
	 * @return
	 */
	public function setAcfField( $key, $post_ID );

	/**
	 * @return mixed
	 */
	public function getPartList();

	/**
	 * @param mixed $part_list
	 *
	 * @return INT_Component
	 */
	public function setPartList( $part_list );

	/**
	 * @return mixed
	 */
	public function getSubList();

	/**
	 * @param mixed $sub_list
	 *
	 * @return INT_Component
	 */
	public function setSubList( $sub_list );

	/**
	 * @return mixed
	 */
	public function getPost();

	/**
	 * @param mixed $post_id
	 *
	 * @return INT_Component
	 */
	public function setPost( $post_id );
}