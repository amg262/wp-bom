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
	private $assembly_keys = [ 'assembly_id', 'levels', 'object_list', 'related_assemblies' ];

	private $sku;

	private $weight;

	private $dimensions;

	private $key;

	private $value;


	private $meta;
	private $meta_fields;
	private $meta_keys;
	private $post_type;
	private $items;

	private $levels = [];

	public function __construct( $post_id ) {

		$this->setPost( $post_id );


	}

	public function get_meta_data( $keys = null, $post_id = 0 ) {

		$this->meta_keys[] = ( $keys !== null ) ? $keys : $this->assembly_keys;
		$post_id           = ( $post_id === 0 ) ? $this->getPostId() : $post_id;

		foreach ( $this->meta_keys as $key ) {
			$this->meta[ $key ] = get_field( $key, $post_id );
		}

		return $this->meta;
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


	public function get_field( $key, $post_id ) {
		$this->meta = get_field( $key, $post_id );

		return $this->meta;
	}

	public function set_field( $key, $value, $post_id ) {
		$this->meta = update_field( $key, $value, $post_id );

		return $this->meta;
	}


	/**
	 * @return mixed
	 */
	public function getPost() {
		return $this->post;
	}

	public function setPost( $post_id ) {
		$this->setPostId( $post_id );
		$this->post = get_post( $post_id );

		return $this->post;
	}

	public function set_levels( $post_id ) {

		$i = 0;
		$j = 0;
		if ( have_rows( 'items', $post_id ) ) {

			while ( have_rows( 'items', $post_id ) ) : the_row();

				$type     = get_sub_field( 'type' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );

				$obj       = get_post( $item );
				$item_type = $obj->post_type;


				if ( $obj->post_type === 'assembly' ) {

				}

				$data = [

					'ID'   => $obj->ID,
					//'title' => $obj->post_title,
					'type' => $obj->post_type,
					'qty'  => $quantity,
					'item' => $item,
					//'sub'   => $this->setSub( $obj->ID ),

				];

				$this->levels[ $i ][] = $data;
				$i ++;
			endwhile;
		}

		foreach ( $this->levels as $level ) {

			$type = $level['type'];
			$id   = $level['ID'];
			if ( $type === 'assembly' ) {


				if ( have_rows( 'items', $id ) ) {

					while ( have_rows( 'items', $id ) ) : the_row();

						$type     = get_sub_field( 'type' );
						$quantity = get_sub_field( 'quantity' );
						$item     = get_sub_field( 'item' );

						$obj       = get_post( $item );
						$item_type = $obj->post_type;


						$data = [

							'ID'   => $obj->ID,
							//'title' => $obj->post_title,
							'type' => $obj->post_type,
							'qty'  => $quantity,
							'item' => $item,
							'sub2' => $this->setSub( $obj->ID ),

						];

						$this->levels[ $j ][] = $data;
						$j ++;
					endwhile;
				}
			}

		}

		return $this->levels;
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

	public function set_levels2( $post_id ) {

		$i     = 0;
		$j     = 0;
		$line  = [];
		$part  = [];
		$sub   = [];
		$assem = [];
		if ( have_rows( 'items', $post_id ) ) {

			while ( have_rows( 'items', $post_id ) ) : the_row();

				$type     = get_sub_field( 'type' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );
				$obj      = get_post( $item );

				$data = [

					'ID'   => $obj->ID,
					//'title' => $obj->post_title,
					'type' => $obj->post_type,
					'qty'  => $quantity,
					'item' => $item,
					//'sub'   => $this->setSub( $obj->ID ),

				];


				if ( $obj->post_type === 'assembly' ) {
					$assem[ $i ] = [ 'i' => $obj->ID, 't' => $obj->post_type ];
				}
				if ( $obj->post_type === 'part' ) {
					$part[ $i ] = [ 'i' => $obj->ID, 't' => $obj->post_type ];
				}


				$line[] = [
						'i' => $obj->ID,
						't' => $obj->post_type,
						'n' => $obj->post_title,
						'c' => $i,

				];


				$i ++;
			endwhile;


		}


		return $line;
	}


	public function do_it( $post_id = 0, $data = null, $index = 0 ) {

		$post_id = ( $post_id === 0 ) ? $this->getPostId() : (int) $post_id;


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


}