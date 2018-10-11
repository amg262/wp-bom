<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/5/18
 * Time: 4:58 PM
 */

namespace Netraa\WPB;


class Module {


	private $cache = [];

	private $items_list = [];
	private $assembly;
	private $subassembly_ids;

	private $item_assem = [];
	private $item_parts = [];
	private $sub_item_assem = [];

	public function __construct() {

		//echo json_encode( $this->get_posts( [ 'post_type' => [ 'assembly' ] ] ) );

		echo json_encode( $this->get_item_data( 5638 ) );
		echo json_encode( $this->get_item_data( 5638 ) );


	}

	public function init() {

	}

	public function get_items() {

	}

	public function get_posts( $args ) {

		$defaults = [ 'post_type' => 'assembly', 'post_status' => 'publish', 'posts_per_page' => - 1 ];

		$args  = wp_parse_args( $args, $defaults );
		$posts = get_posts( $args );

		return $posts;
	}

	public function get_assembly_data( $post_id ) {

		$post  = get_post( $post_id );
		$id    = get_field( 'assembly_id', $post->ID );
		$assem = get_field( 'assembly_list', $post->ID );
		$obj   = get_field( 'object_list', $post->ID );


	}


	public function handle_type( $assembly_id, $post_type ) {

		if ( $post_type === 'assembly' ) {
			$this->sub_item_assem[] = $assembly_id;

		}
	}

	public function get() {

		foreach ($this->item_assem as $assem) {

			$ass = new WP_Post($assem->ID);

			

		}
	}
	public function get_item_data( $assembly_id ) {
		if ( have_rows( 'items', $assembly_id ) ) {

			$i = 0;
			$j = 0;
			while ( have_rows( 'items', $assembly_id ) ) : the_row();
				$i ++;

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );


				$sub_item = new \WP_Post( $item );

				if ( strtolower( $type ) !== strtolower( $sub_item->post_type ) ) {
					update_sub_field( 'type', $sub_item->post_type );
				}


				//$this->handle_type( $assembly_id, $sub_item->post_type );

				$this->item_parts[] = [
					'id'    => $sub_item,
					'qty'   => $quantity,
					'level' => $level,
					'type'  => get_sub_field( 'type' ),
				];

				if ( $sub_item->post_type === 'assembly' ) {
					$this->item_assem[] = [
						'id'    => $sub_item,
						'qty'   => $quantity,
						'level' => $level,
						'type'  => get_sub_field( 'type' ),
					];

				} elseif ( $sub_item->post_type === 'part' ) {
					$this->item_parts[] = [
						'id'    => $sub_item,
						'qty'   => $quantity,
						'level' => $level,
						'type'  => get_sub_field( 'type' ),
					];
				}


				//$pos = get_post( $ass );

			endwhile;

			echo $i . $j;

			return [ 'ASSEM' => $this->item_assem ];
		}
	}

}