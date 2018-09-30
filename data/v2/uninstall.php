<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 4/24/18
 * Time: 4:56 PM
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}




delete_option('wc_bom_settings');
delete_option('wc_bom_options');
delete_option( 'wc_rp_empty_behavior' );

delete_post_meta_by_key( '_related_ids' );