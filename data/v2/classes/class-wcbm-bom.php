<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 4/28/18
 * Time: 4:14 PM
 */

class WC_Bom_Builder {

	private $product_assembly = [];

	private $product = null;

	private $assembly_items = [];

	private $parts = [];

	private $part_data = [];

	/**
	 * WC_Bom_Builder constructor.
	 */
	public function __construct() {
	}

	public function dothis( $prod_id ) {

		if ( have_rows( 'product_assembly', $p->ID ) ) {

			$i = 0;
			while ( have_rows( 'product_assembly', $p->ID ) ) : the_row();


			endwhile;
		}

	}

	public function dothisj( $prod_id ) {

		if ( have_rows( 'assembly_items', $pos->ID ) ) {


			while ( have_rows( 'assembly_items', $pos->ID ) ) : the_row();


			endwhile;

		}
	}


	public function dothihs(
		$prod_id
	) {

		if ( have_rows( 'product_assembly', $p->ID ) ) {

			$i = 0;
			while ( have_rows( 'product_assembly', $p->ID ) ) : the_row();
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

										endwhile;*/

									}

								endwhile;
							}

						endwhile;

					}
				}

				echo $ass . '<br>' . $qty;
				//get_sub_field('assembl')
			endwhile;
		}


		$arg = [];
		$set = $_POST['settings'];
		$in  = $_POST['input'];


		update_option( 'wcb_options', $in );

		echo $in;
		echo json_encode( $parrr_arr );
		echo '<br><hr><br>';
		echo json_encode( $parr_arr );
		echo '<br><hr><br>';
		echo json_encode( $asss_arr );
		echo '<br><hr><br>';
		echo json_encode( $ass_arr );
		echo '<br><hr><br>';
		echo json_encode( $par_arr );
	}

}