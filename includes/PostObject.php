<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/16/18
 * Time: 1:19 PM
 */

namespace Netraa\WPB;

class PostObject {


	private $post;
	private $post_id;

	private $part_name;

	private $vendor;

	private $cats = [];

	private $tags = [];
	private $part_meta_keys = [ 'part_no', 'sku', 'cost', 'weight', 'vendor', 'category', 'tags' ];
	private $part_meta_val = [ 'part_no', 'sku', 'cost', 'weight', 'vendor', 'category', 'tags' ];

	private $sku;

	private $weight;

	private $dimensions;

	private $key;

	private $value;


	private $meta;
	private $meta_fields;


	private $post_type;

	private $post_meta;

	private $item;

	private $items;

	private $item_object;

	private $item_fields = [];

	private $post_parent;

	private $item_parent;
	private $item_post;
	private $item_list;
	private $item_qty;
	private $item_type;
	private $item_level;

	public function __construct( $post_id ) {

		$this->setPost( $post_id );


	}

	/**
	 * @return array
	 */
	public function getPartMetaVal(): array {
		return $this->part_meta_val;
	}

	/**
	 * @param array $part_meta_val
	 *
	 * @return PostObject
	 */
	public function setPartMetaVal() {

		foreach ( $this->part_meta_keys as $lbl ) {

			$this->meta_fields[] = [ 'key' => $lbl, 'value' => get_field( $lbl, $this->getPostId() ) ];

		}

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPostId() {
		return $this->post_id;
	}

	public function setPostId( $post_id ) {
		$this->post_id = $post_id;

		return $this->post_id;
	}

	public function getMeta() {


		return $this->meta;
	}

	public function setMeta( $key, $post_id ) {
		$this->meta = get_field( $key, $post_id );

		return $this->meta;
	}

	public function updateMeta( $key, $value, $post_id ) {
		$this->meta = update_field( $key, $value, $post_id );

		return $this->meta;
	}

	/**
	 * @return mixed
	 */
	public function getPostType() {
		return $this->post_type;
	}

	public function setPostType( $post_type ) {
		$this->post_type = $post_type;

		return $this->post_type;
	}

	/**
	 * @return mixed
	 */
	public function getPost() {
		return $this->post;
	}

	public function setPost( $post_id ) {

		$this->setPostId( $post_id );
		$this->post = get_post( $this->getPostId() );
		$this->setPostType( $this->getPost()->post_type );


		return $this->post;
	}

	/**
	 * @return mixed
	 */
	public function getItems() {
		return $this->items;
	}

	public function setItems( $post_id = 0, $index = 0 ) {

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


				$data = [

					'ID'    => $obj->ID,
					'title' => $obj->post_title,
					'type'  => $obj->post_type,
					'qty'   => $quantity,
					'sub'   => $this->setSub( $obj->ID ),

				];


				$this->items[ $obj->post_title ][ $index ] = $data;

				$index ++;

			endwhile;


		}


		return $this->items;
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

					$sub2 = [];
					$next = [];
					$sub3 = [];

					if ( get_field( 'items', $obj->ID ) !== null ) {

						$sub2 = get_field( 'items', $obj->ID );
//						var_dump($sub2);

//						foreach ( $sub2 as $s ) {
//
//							$id   = $s['item'];
//							$type = $s['type'];
//
//							if ( $type === 'assembly' ) {
//
//
//								if ( have_rows( 'items', $id ) ) {
//									$next = get_field( 'items', $id );
//								}
//
//								$sub3[] = [ $next['item'], $next['type'], $next['quantity'] ];
//							}
//						}
					}

					//var_dump($next);
					$sub[ $obj->post_title ] = [
						'sub' => [
							'id'    => $obj->ID,
							'title' => $obj->post_title,
							'type'  => $obj->post_type,
							'qty'   => $quantity,
							'sub2'  => $sub2,
//							'sub3'  => $sub3,
						],
					];

				endwhile;

			}
		}

		return $sub;

	}

	public function setSubb( $post_id ) {

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


					$sub[] = [
						'sub' => [
							'id'   => $obj->ID,
							'type' => $obj->post_type,
							'qty'  => $quantity,
							'sub2' => get_field( 'items', $obj->ID
							),
						],
					];

				endwhile;

			}
		}

		return $sub;

	}

	public function setSub2( $post_id ) {


		if ( have_rows( 'items', $post_id ) ) {
			$count = 0;

			while ( have_rows( 'items', $post_id ) ) : the_row();

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );
				$obj      = get_post( $item );

				if ( have_rows( 'items', $obj->ID ) ) {
					$count = 0;
					$sub2  = [];

					while ( have_rows( 'items', $obj->ID ) ) : the_row();
						$type     = get_sub_field( 'type' );
						$level    = get_sub_field( 'level' );
						$quantity = get_sub_field( 'quantity' );
						$item     = get_sub_field( 'item' );
						$obj      = get_post( $item );

						$sub2[] = [
							'id'   => $obj->ID,
							'type' => $obj->post_type,
							'qty'  => $quantity,
							//'sub2'  => $this->setSub( $obj->ID ),
						];
					endwhile;
				}

				$sub[] = [
					'id'   => $obj->ID,
					'type' => $obj->post_type,
					'qty'  => $quantity,
					'sub'  => $sub2,
				];
			endwhile;


		}

		return $sub;

	}

	/**
	 * @return mixed
	 */
	public
	function getPostMeta() {
		return $this->post_meta;
	}

	/**
	 * @param mixed $post_meta
	 *
	 * @return PostObject
	 */
	public
	function setPostMeta(
		$post_meta
	) {
		$this->post_meta = $post_meta;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public
	function getItemObject() {
		return $this->item_object;
	}

	/**
	 * @param mixed $item_object
	 *
	 * @return PostObject
	 */
	public
	function setItemObject(
		$item_object
	) {
		$this->item_object = $item_object;

		return $this;
	}

	/**
	 * @return array
	 */
	public
	function getItemFields() {
		return $this->item_fields;
	}

	/**
	 */
	public
	function setItemFields(
		$post_id
	) {

		if ( have_rows( 'items', $post_id ) ) {

			while ( have_rows( 'items', $post_id ) ) : the_row();
				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );

				$post                = get_post( $item );
				$this->item_fields[] = [ 'id' => $item, 'qty' => $quantity, 'type' => $type ];

			endwhile;
		}

		return $this->item_fields;
	}

	/**
	 * @return mixed
	 */
	public
	function getItem() {
		return $this->item;
	}

	/**
	 * @param mixed $item
	 *
	 * @return PostObject
	 */
	public
	function setItem(
		$item
	) {
		$this->item = $item;

		return $this;
	}


}