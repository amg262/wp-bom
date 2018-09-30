<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/7/18
 * Time: 7:11 PM
 */

class WCB_Part {

	private $meta = [
		[ 'part_no', 'sku', 'cost', 'weight', 'stock' ],
	];

	private $fields = [];

	private $part_data = [];

	private $post_data = [];

	private $assembly_data = [];

	private $assembly_items = [];
//	const PART_META = [ 'part_no', 'sku', 'cost', 'weight', 'stock' ];

	/**
	 * WCB_Part constructor.
	 */
	public function __construct() {

		$a = func_get_args();
		$i = func_num_args();
		if ( method_exists( $this, $f = '__construct' . $i ) ) {
			call_user_func_array( [ $this, $f ], $a );
		}
	}

	/*public function __construct1( $a1 ) {
		echo( '__construct with 1 param called: ' . $a1 . PHP_EOL );
	}

	public function __construct2( $a1, $a2 ) {
		echo( '__construct with 2 params called: ' . $a1 . ',' . $a2 . PHP_EOL );
	}*/

	public function get_assembly_sub_assem( $post_id ) {

		/*$assembly = get_post( $post_id );
		$has_sub  = false;
		$part_arr = [];

		if ( $assembly->post_type === 'assembly' ) {

			if ( have_rows( 'assembly_items', $post_id ) ) {

				while ( have_rows( 'assembly_items', $post_id ) ) : the_row();

					$item = get_sub_field( 'item' );
					$qty  = get_sub_field( 'qty' );
					$type = get_sub_field( 'type' );
					$part = get_sub_field( 'part' );

					$sub_assem = get_sub_field( 'assembly' );

					if ( $type === 'Part' ) {

						$part_arr[] = [ 'Type' => 'Part', 'Assembly ID' => $sub_assem->ID, 'Part ID' => $part->ID, ]

					} elseif ( $type === 'Sub-assembly' ) {
						$has_sub = true;

					}

					$this->assembly_items[] = [ $item, $qty ];

				endwhile;

			}

		}*/

	}

	public function get_assembly_data( $post_id ) {

		if ( have_rows( 'assembly_items', $post_id ) ) {

			while ( have_rows( 'assembly_items', $post_id ) ) : the_row();

				$item = get_sub_field( 'item' );
				$qty  = get_sub_field( 'qty' );

				$this->assembly_items[] = [ $item, $qty ];

			endwhile;

		}

		return $this->assembly_items;

	}

	public function getsdfa() {
		//$p         = get_post( $product );
		$parrr_arr = [];
		$ass4_arr  = [];
		$asss5_arr = [];
		$parr_arr  = [];
		$ass_arr   = [];
		$asss_arr  = [];
		$par_arr   = [];
		//$po        = get_post_meta( $p->ID );
		//if ( have_rows( 'product_assembly', $p->ID ) ) {

		$i = 0;
		/*while ( have_rows( 'product_assembly', $p->ID ) ) : the_row();
			$i ++;

			$ass = get_sub_field( 'assembly' );
			$qty = get_sub_field( 'qty' );

			//$ark[] = ['']
			$pos = get_post( $ass );

			if ( $pos->post_type === 'assembly' ) {
				if ( have_rows( 'assembly_items', $pos->ID ) ) {


					while ( have_rows( 'assembly_items', $pos->ID ) ) : the_row();
						$ass2 = get_sub_field( 'item' );
						$qty2 = get_sub_field( 'qty' );

						$asss      = get_post( $ass2 );
						$ass_arr[] = [
							'ID'      => $pos->ID,
							'assemby' => $ass2,
							'type'    => $asss->post_type,
							'qty'     => $qty2,
						];

						if ( $asss->post_type === 'part' ) {
							$par_arr[] = $asss->ID;
						} elseif ( $asss->post_type === 'assembly' ) {
							while ( have_rows( 'assembly_items', $asss->ID ) ) : the_row();
								$asss2 = get_sub_field( 'item' );
								$qtyy2 = get_sub_field( 'qty' );

								$asss3      = get_post( $asss2 );
								$asss_arr[] = [
									'ID'      => $asss->ID,
									'assemby' => $asss2,
									'type'    => $asss3->post_type,
									'qty'     => $qtyy2,
								];

								if ( $asss3->post_type === 'part' ) {
									$parr_arr[] = $asss3->ID;
								} elseif ( $asss3->post_type === 'assembly' ) {
									echo 'shit';

									/*while ( have_rows( 'assembly_items', $asss3->ID ) ) : the_row();
										$asss32 = get_sub_field( 'item' );
										$qtyy32 = get_sub_field( 'qty' );

										$asss33      = get_post( $asss2 );
										$asss_arr[] = [
											'ID'      => $asss3->ID,
											'assemby' => $asss32,
											'type'    => $asss33->post_type,
											'qty'     => $qtyy32,
										];

										if ( $asss33->post_type === 'part' ) {
											$parrr_arr[] = $asss33->ID;
										} elseif ( $asss33->post_type === 'assembly' ) {
											echo 'shit';



										}

									endwhile;

								}

							endwhile;
						}

					endwhile;

				}
			}

			echo $ass . '<br>' . $qty;
			//get_sub_field('assembl')
		endwhile;
	}*/
	}

	public function get_part_data( $post_id ) {

		$post = get_post( $post_id );

		if ( isset( $post ) ) {


			$part_no = get_post_meta( $post_id, 'part_no', true );
			$sku     = get_post_meta( $post_id, 'sku', true );
			$cost    = get_post_meta( $post_id, 'cost', true );
			$weight  = get_post_meta( $post_id, 'weight', true );
			$stock   = get_post_meta( $post_id, 'stock', true );


			$this->part_data['id']      = $post_id;
			$this->part_data['part_no'] = $part_no;
			$this->part_data['sku']     = $sku;
			$this->part_data['cost']    = $cost;
			$this->part_data['weight']  = $weight;
			$this->part_data['stock']   = $stock;
		}

		//$meta = get_post_meta( $post_id );

		//return $meta;

		return $this->part_data;

	}

}