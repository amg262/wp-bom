<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/16/18
 * Time: 1:19 PM
 */

namespace Netraa\WPB;

use WP_Post;

class PostObject {


	/**
	 * @var
	 */
	private $part_no;
	/**
	 * @var
	 */
	private $cost;
	/**
	 * @var
	 */
	private $post;
	private $post_id;
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


	private $key;
	/**
	 * @var
	 */
	private $value;


	private $meta;


	private $post_type;

	private $post_meta;

	private $items;

	private $item_object;

	private $item_fields = [];


	public function __construct( $post_id ) {
		$this->post_id = $post_id;
		$this->setPost( $this->getPostId() );
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


	public function setPost( $post ) {

		if ( is_int( $post ) ) {
			$this->post = get_post( $post );

		} else {
			$this->post = new WP_Post( $post );
		}

		$this->setPostType( $this->post->post_type );

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

				$sub = $this->setSub( $obj->ID );
				if ( is_array( $sub ) ) {
					$j = count( $sub );
				} else {
					$j = 0;
				}

				$data = [

					'ID'    => $obj->ID,
					'title' => $obj->post_title,
					'type'  => $obj->post_type,
					'qty'   => $quantity,
					'j'     => $j,
					'sub'   => $sub,

				];

				if ( $item_type === 'assembly' ) {
					$subitems[] = $data;
				}

				$this->items['parts'][] = $data

					$index ++;

			endwhile;


			foreach ( $subitems as $it ) {

			}

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


					if ( $item_type === 'assembly' ) {
						$sub['subassem'][] = [
							'ID'    => $obj->ID,
							'title' => $obj->post_title,
							'type'  => $obj->post_type,
							'qty'   => $quantity,
							//'sub2'  => $this->setSub( $obj->ID ),
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


	
	public function setItemData() {


		if ( have_rows( 'items', $post_id ) ) {

			while ( have_rows( 'items', $post_id ) ) : the_row();

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );

			endwhile;
		}
	}
}