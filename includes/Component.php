<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/11/18
 * Time: 6:49 PM
 */

namespace Netraa\WPB;

/**
 * Class Component
 *
 * @package Netraa\WPB
 */
class Component implements INT_Component {


	/**
	 * @var
	 */
	private $part_no;
	/**
	 * @var
	 */
	private $assembly_id;
	/**
	 * @var
	 */
	private $post_type;
	/**
	 * @var
	 */
	private $cost;
	/**
	 * @var
	 */
	private $post_id;
	/**
	 * @var
	 */
	private $post;
	/**
	 * @var
	 */
	private $part_name;
	/**
	 * @var
	 */
	private $vendor;
	/**
	 * @var array
	 */
	private $cats = [];
	/**
	 * @var array
	 */
	private $tags = [];
	/**
	 * @var
	 */
	private $sku;
	/**
	 * @var
	 */
	private $weight;
	/**
	 * @var
	 */
	private $dimensions;
	/**
	 * @var
	 */
	private $image;
	/**
	 * @var
	 */
	private $description;
	/**
	 * @var
	 */
	private $po_num;
	/**
	 * @var
	 */
	private $date;
	/**
	 * @var
	 */
	private $key;
	/**
	 * @var
	 */
	private $value;
	/**
	 * @var
	 */
	private $custom_field;
	/**
	 * @var
	 */
	private $acf_field;

	/**
	 * @var array
	 */
	private $sub_items = [];
	/**
	 * @var array
	 */
	private $part_items = [];

	private $obj;

	private $parent_post;
	private $child_post;

	private $cf_items = [];
	private $cf_items_labels = [ 'level', 'type', 'quantity', 'item' ];


	private $cf_assem_subitems = [];
	private $cf_assem_parts = [];
	private $cf_assem_items = [];
	private $cf_prod_items = [];
	private $cf_req_items = [];


	private $part_list;
	private $sub_list;
	private $item_parent;
	private $items;
	private $items_part;
	private $items_assembly;

	private $assembly;
	private $assembly_part_list;
	private $assembly_item_list;
	private $assembly_sub_list;

	private $item_level;
	private $item_type;
	private $item_qty;
	private $item_post = [];
	private $item_tiers;

	/**
	 * Component constructor.
	 */
	public function __construct( $post_id ) {

		$this->post_id = $post_id;
		$this->setPost( $this->getPostId() );
		$this->setItems( $this->getPostId() );
	}

	/**
	 * @return mixed
	 */
	public function getPostId() {

		return $this->post_id;
	}

	/**
	 * @param mixed $post_id
	 *
	 * @return INT_Component
	 */
	public function setPostId(
		$post_id
	) {

		$this->post_id = $post_id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAssemblyId() {
		return $this->assembly_id;
	}

	/**
	 * @param mixed $assembly_id
	 *
	 * @return INT_Component
	 */
	public function setAssemblyId( $assembly_id ) {
		$this->assembly_id = $assembly_id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPostType() {
		return $this->post_type;
	}

	/**
	 * @param mixed $post_type
	 *
	 * @return INT_Component
	 */
	public function setPostType( $post_type ) {
		$this->post_type = $post_type;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAssemblyItemList() {
		return $this->assembly_item_list;
	}

	/**
	 * @param mixed $assembly_item_list
	 *
	 * @return INT_Component
	 */
	public function setAssemblyItemList( $post_id = 0, $index = 0 ) {

		if ( $post_id === 0 ) {
			$post_id = $this->getPostId();
		}

		if ( have_rows( 'items', $post_id ) ) {

			while ( have_rows( 'items', $post_id ) ) : the_row();

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );

				$obj       = get_post( $item );
				$item_type = $obj->post_type;

			//	$sub = $this->setSub( $obj->ID );
				if ( is_array( $sub ) ) {
					$j = count( $sub );
				} else {
					$j = 0;
				}

				$this->item_tiers[ $index ] = [

					'ID'    => $obj->ID,
					'title' => $obj->post_title,
					'type'  => $obj->post_type,
					'qty'   => $quantity,
					'j'     => $j,
					'sub'   => $sub,

				];

				$index ++;

			endwhile;

		}


		return $this->item_tiers;
	}

	public function setSub( $post_id ) {

		$post = get_post( $post_id );

		if ( $post->post_type === 'assembly' ) {

			if ( have_rows( 'items', $post->ID ) ) {

				while ( have_rows( 'items', $post->ID ) ) : the_row();

					$type     = get_sub_field( 'type' );
					$level    = get_sub_field( 'level' );
					$quantity = get_sub_field( 'quantity' );
					$item     = get_sub_field( 'item' );

					$obj       = get_post( $item );
					$item_type = $obj->post_type;


					if ( $item_type === 'assembly' ) {
						$sub[] = [
							'ID'    => $obj->ID,
							'title' => $obj->post_title,
							'type'  => $obj->post_type,
							'qty'   => $quantity,
							'sub2'  => $this->setSub( $obj->ID ),
						];
					} else {
						$sub[] = [
							'ID'    => $obj->ID,
							'title' => $obj->post_title,
							'type'  => $obj->post_type,
							'qty'   => $quantity,
						];
					}
				endwhile;

			}
		}

		return $sub;

	}

	public function parse_sub( $sub ) {

		foreach ( $sub as $s ) {

			$post = get_post( $s['ID'] );


		}
	}

	public function parse_tiers() {


	}

	/**
	 * @return mixed
	 */
	public function getAssemblySubList() {
		return $this->assembly_sub_list;
	}

	/**
	 * @param mixed $assembly_sub_list
	 *
	 * @return INT_Component
	 */
	public function setAssemblySubList( $assembly_sub_list ) {
		$this->assembly_sub_list = $assembly_sub_list;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getItemParent() {
		return $this->item_parent;
	}

	/**
	 * @param mixed $item_parent
	 *
	 * @return INT_Component
	 */
	public function setItemParent( $item_parent ) {
		$this->item_parent = $item_parent;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getItems() {
		return $this->items;
	}

	/**
	 * @param mixed $items
	 *
	 * @return INT_Component
	 */
	public function setItems( $post_id = 0 ) {

		if ( $post_id === 0 ) {
			$post_id = $this->getPostId();
		}
		if ( have_rows( 'items', $post_id ) ) {

			$i = 0;
			$j = 0;

			$this->setItemParent( get_post( $post_id ) );

			while ( have_rows( 'items', $post_id ) ) : the_row();
				$i ++;

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );

				$obj       = get_post( $item );
				$item_type = $obj->post_type;

				$args = [
					'id'    => $obj->ID,
					'title' => $obj->post_title,
					'qty'   => $quantity,
					'level' => $level,
					'type'  => $type,
				];


				if ( $item_type === 'assembly' ) {
					$sel = [
						'label' => 'assembly',
						'value' => 'assembly',
					];
				} elseif ( $item_type === 'part' ) {
					$sel = [
						'label' => 'part',
						'value' => 'part',
					];
				}

				update_sub_field( 'type', $sel['value'], $obj->ID );

				if ( $item_type === 'part' ) {

					$this->cf_assem_items[] = $args;
					$this->cf_assem_parts[] = [
						'ID'    => $obj->ID,
						'title' => $obj->post_title,
						'qty'   => $quantity,
						'level' => $level,
						'type'  => get_sub_field( 'type', $obj->ID ),
					];


				} elseif ( $item_type === 'assembly' ) {
					$this->cf_assem_items[]    = $args;
					$this->cf_assem_subitems[] = [
						'ID'    => $obj->ID,
						'title' => $obj->post_title,
						'qty'   => $quantity,
						'level' => $level,
						'type'  => get_sub_field( 'type', $obj->ID ),
					];
				}

				//				if ( strtolower( $type ) !== strtolower( $obj->post_type ) ) {
				//					update_sub_field( 'type', $obj->post_type );
				//				}


//				if ( $item_type === 'assembly' ) {
//
//					$this->setCfAssemSubitems( $obj->ID );
//				}
//
//				if ( $parent_post->post_type === 'assembly' && $obj->post_type === 'assembly' ) {
//					$this->cf_assem_subitems[] = $args;
//					$this->cf_assem_items[]    = $args;
//
//					$add                    = $this->setCfAssemSubitems( $obj->ID );
//					$this->cf_assem_parts[] = $add;
//
//				}
//
//
//				if ( $obj->post_type === 'part' ) {
//					$this->cf_assem_parts[] = $args;
//					$this->cf_assem_items[] = $args;
//
//				}
				$this->cf_assem_items[] = $args;


				//$pos = get_post( $ass );

			endwhile;

			$this->setItemsPart( $post_id, [ $this->cf_assem_parts ] );
			$this->setItemsAssembly( $post_id, [ $this->cf_assem_subitems ] );
			update_field( 'object_list', $args, $post_id );


		}


		return $this->items;
	}

	/**
	 * @return mixed
	 */
	public function getItemsPart( $id ) {
		$val = get_field( 'part_list', $id );

		return $val;
	}

	/**
	 * @param mixed $items_part
	 *
	 * @return INT_Component
	 */
	public function setItemsPart( $post_id, $items_part ) {

		$this->items_part = $items_part;
		update_field( 'part_list', $this->cf_assem_parts, $post_id );

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getItemsAssembly() {
		return $this->items_assembly;
	}

	/**
	 * @param mixed $items_assembly
	 *
	 * @return INT_Component
	 */
	public function setItemsAssembly( $post_id, $items_assembly ) {

		$this->items_assembly = $items_assembly;
		update_field( 'sub_assembly_list', $this->cf_assem_subitems, $post_id );

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAssemblyPartList() {
		return $this->assembly_part_list;
	}

	/**
	 * @param mixed $assembly_part_list
	 *
	 * @return INT_Component
	 */
	public function setAssemblyPartList( $assembly_part_list ) {


		return $this;
	}

	/**
	 * @return array
	 */
	public function getCfItems() {

		return $this->cf_items;
	}

	/**
	 * @param array $cf_items
	 *
	 * @return INT_Component
	 */
	public function setCfItems( array $cf_items ) {

		$this->cf_items = $cf_items;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCfAssemSubitems() {

		return $this->cf_assem_subitems;
	}

	/**
	 */
	public function setCfAssemSubitems( $obj ) {

		$this->cf_assem_subitems[] = $obj;

		return $this->cf_assem_subitems;
	}

	/**
	 * @return array
	 */
	public function getCfAssemParts() {

		return $this->cf_assem_parts;
	}

	/**
	 * @param array $cf_assem_parts
	 *
	 * @return INT_Component
	 */
	public function setCfAssemParts( array $cf_assem_parts ) {

		$this->cf_assem_parts = $cf_assem_parts;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCfAssemItems() {

		return $this->cf_assem_items;
	}

	public function setCfAssemItems(
		$post_id
	) {

		if ( have_rows( 'items', $post_id ) ) {

			$i           = 0;
			$j           = 0;
			$parent_post = get_post( $post_id );

			while ( have_rows( 'items', $post_id ) ) : the_row();
				$i ++;

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );

				$obj       = get_post( $item );
				$item_type = $obj->post_type;

				$args = [
					'id'    => $obj->ID,
					'title' => $obj->post_title,
					'q'     => $quantity,
					't'     => $type,
					'i'     => $item_type,
				];


				if ( $item_type === 'assembly' ) {
					$sel = [
						'label' => 'assembly',
						'value' => 'assembly',
					];
				} elseif ( $item_type === 'part' ) {
					$sel = [
						'label' => 'part',
						'value' => 'part',
					];
				}

				update_field( 'object_list', $args, $post_id );
				update_field( 'object_list', $args, $post_id );
				update_sub_field( 'type', $sel, $obj->ID );

				if ( $item_type === 'part' ) {
					$this->cf_assem_items[] = $args;
					$this->cf_assem_parts[] = $args;

				} elseif ( $item_type === 'assembly' ) {
					$this->cf_assem_items[]    = $args;
					$this->cf_assem_subitems[] = $args;
				}

				//				if ( strtolower( $type ) !== strtolower( $obj->post_type ) ) {
				//					update_sub_field( 'type', $obj->post_type );
				//				}


//				if ( $item_type === 'assembly' ) {
//
//					$this->setCfAssemSubitems( $obj->ID );
//				}
//
//				if ( $parent_post->post_type === 'assembly' && $obj->post_type === 'assembly' ) {
//					$this->cf_assem_subitems[] = $args;
//					$this->cf_assem_items[]    = $args;
//
//					$add                    = $this->setCfAssemSubitems( $obj->ID );
//					$this->cf_assem_parts[] = $add;
//
//				}
//
//
//				if ( $obj->post_type === 'part' ) {
//					$this->cf_assem_parts[] = $args;
//					$this->cf_assem_items[] = $args;
//
//				}
				$this->cf_assem_items[] = $args;


				//$pos = get_post( $ass );

			endwhile;
			update_field( 'object_list', $args, $post_id );
			update_field( 'part_list', $this->cf_assem_parts, $post_id );
			update_field( 'sub_assembly_list', $this->cf_assem_subitems, $post_id );

			return $this->cf_assem_parts;

		}

		return false;
	}


	/**
	 * @return mixed
	 */
	public function getAcfField() {

		return $this->acf_field;

	}

	/**
	 * @param $acf_field
	 *
	 * @return
	 */
	public function setAcfField(
		$key, $post_ID
	) {

		$this->acf_field = get_field( $key, $post_ID );

		return $this->acf_field;
	}

	/**
	 * @return mixed
	 */
	public function getPartList() {
		return $this->part_list;
	}

	/**
	 * @param mixed $part_list
	 *
	 * @return INT_Component
	 */
	public function setPartList( $part_list ) {
		$this->part_list = $part_list;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSubList() {
		return $this->sub_list;
	}

	/**
	 * @param mixed $sub_list
	 *
	 * @return INT_Component
	 */
	public function setSubList( $sub_list ) {
		$this->sub_list = $sub_list;

		return $this;
	}


	/**
	 * @return mixed
	 */
	public function getPost() {

		return $this->post;
	}

	/**
	 * @param mixed $post_id
	 *
	 * @return INT_Component
	 */
	public function setPost( $post_id ) {
		$this->post_id   = $post_id;
		$this->post      = get_post( $post_id );
		$this->post_type = $this->post->post_type;
		$this->part_list = get_field( 'part_list', $this->post_id );
		$this->sub_list  = get_field( 'sub_assembly_list', $this->post_id );

		return $this->post;
	}


}