<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

namespace WooBom;

global $postdata_cache;


use function get_sub_field;
use function json_encode;

class WC_Bom_Calculate {

	/**
	 * @var null
	 */

	private $posts = [];
	private $json = [];

	public function __construct() {

		$this->init();
		//add_action('save_post_{$post->post_type}')
	}

	/**
	 *
	 */
	public function init() {

		//wc_cache_get('wc_bom_posts');
	}

	public function get_single_product( $prod_ID ) {

		$prod = $this->get_post_objs( $prod_ID, 'product' );
		$objs = [];
		if ( have_rows( 'material' ) ):

			while ( have_rows( 'material' ) ) : the_row();

				$objs[] = [ 'obj' => get_sub_field( 'assembly' ), 'qty' => get_sub_field( 'qty' ) ];

			endwhile;

		endif;

		return $objs;


	}

	public function get_post_objs( $id, $type, $title = null ) {

		$args = [
			'ID'               => $id,
			'post_title'       => $title,
			'post_types'       => $type,
			'posts_per_page'   => - 1,
			'post_status'      => 'publish',
			'suppress_filters' => true,
		];

		$posts = get_posts( $args );

		$this->posts = $posts;
		$this->json  = json_encode( $posts );

		return $this->posts;
	}

	public function get_single_assembly( $assembly_ID ) {
		$id       = get_field( 'assembly_no', $assembly_ID );
		$sku      = get_field( 'assembly_sku', $assembly_ID );
		$sub      = 'sub_assemblies';
		$sub_objs = [];
		$objs     = [];

		if ( have_rows( 'sub_assemblies' ) ):

			while ( have_rows( 'sub_assemblies' ) ) : the_row();

				// Your loop code
				$assembly_objs = get_sub_field( 'assembly' );
				$qty           = get_sub_field( 'qty' );

				$objs = [ $assembly_objs, $qty ];

				$sub_objs[] = $objs;
			endwhile;
			//else :
		endif;

		$objs = [ $id, $sku, $sub_objs ];

		return $objs;

	}

	public function get_single_part( $part_ID ) {

		$part_data = [];

		$part_no   = get_field( 'part_no', $part_ID );
		$part_name = get_field( 'part_name', $part_ID );
		$part_cost = get_field( 'part_cost', $part_ID );


		$part_data = [ $part_no, $part_name, $part_cost ];

		return $part_data;

	}
}