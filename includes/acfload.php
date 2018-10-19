<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 9/28/18
 * Time: 10:18 PM
 */


namespace Netraa\WPB;


/** Start: Detect ACF Pro plugin. Include if not present. */
if ( ! class_exists( 'acf' ) ) { // if ACF Pro plugin does not currently exist
	/** Start: Customize ACF path */
	add_filter( 'acf/settings/path', 'Netraa\\WPB\\wpb_acf_settings_path' );
	function wpb_acf_settings_path( $path ) {

		$path = plugin_dir_path( __FILE__ ) . 'acf/';

		return $path;
	}

	/** End: Customize ACF path */
	/** Start: Customize ACF dir */
	add_filter( 'acf/settings/dir', 'Netraa\\WPB\\wpb_acf_settings_dir' );
	function wpb_acf_settings_dir( $path ) {

		$dir = plugin_dir_url( __FILE__ ) . 'acf/';

		return $dir;
	}

	/** End: Customize ACF path */
	/** Start: Hide ACF field group menu item */
	//  add_filter( 'acf/settings/show_admin', '__return_false' );
	/** End: Hide ACF field group menu item */
	/** Start: Include ACF */
	include_once( plugin_dir_path( __FILE__ ) . 'acf/acf.php' );
	/** End: Include ACF */
	/** Start: Create JSON save point */
	add_filter( 'acf/settings/save_json', 'Netraa\\WPB\\wpb_acf_json_save_point' );
	function wpb_acf_json_save_point( $path ) {

		$path = plugin_dir_path( __FILE__ ) . 'acf-json/';

		return $path;
	}

	/** End: Create JSON save point */
	/** Start: Create JSON load point */
	add_filter( 'acf/settings/load_json', 'Netraa\\WPB\\wpb_acf_json_load_point' );
	/** End: Create JSON load point */
	/** Start: Stop ACF upgrade notifications */
	add_filter( 'site_transient_update_plugins', 'Netraa\\WPB\\wpb_stop_acf_update_notifications', 11 );
	function wpb_stop_acf_update_notifications( $value ) {

		unset( $value->response[ plugin_dir_path( __FILE__ ) . 'acf/acf.php' ] );

		return $value;
	}
	/** End: Stop ACF upgrade notifications */
} else { // else ACF Pro plugin does exist
	/** Start: Create JSON load point */
	add_filter( 'acf/settings/load_json', 'Netraa\\WPB\\wpb_acf_json_load_point' );
	/** End: Create JSON load point */
} // end-if ACF Pro plugin does not currently exist
/** End: Detect ACF Pro plugin. Include if not present. */
/** Start: Function to create JSON load point */
function wpb_acf_json_load_point( $paths ) {

	$paths[] = plugin_dir_path( __FILE__ ) . 'acf-json-load';

	return $paths;
}

if ( function_exists( 'acf_add_options_page' ) ) {

	$option_page = acf_add_options_page( [
		'page_title'  => 'Theme General Settings',
		'menu_title'  => 'Theme Settings',
		'menu_slug'   => 'theme-general-settings',
		'capability'  => 'edit_posts',
		'parent_slug' => 'wp-bom',
		'redirect'    => false,
	] );

}
