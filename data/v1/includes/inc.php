<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 3/10/2017
 * Time: 9:11 PM
 */

function acf_installed() {

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	$acf     = 'advanced-custom-fields/acf.php';
	$active  = in_array( $acf, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	$has_acf = plugin_dir_url( $acf );

	if ( $has_acf && $active ) {

		deactivate_plugins( __FILE__ );

		$message =
			'<div style="text-align: center;"><h3>' .
			'<strong>ACF</strong> must be deactivated as ACF Pro is required and included in this plugin.' .
			'You must deactivate it before using this plugin.' .
			'<a href=' . admin_url( 'plugins.php' ) . '>Back to plugins&nbsp;&rarr;</a></div>';
		wp_die( $message );

	} elseif ( $has_acf && ! $active ) {

		$message =
			'<div style="text-align: center;"><h3>' .
			'<strong>ACF</strong> must be deactivated as ACF Pro is required and included in this plugin.' .
			'If ACF is activated it could cause fatal errors.' .
			'<a href=' . admin_url( 'plugins.php' ) . '>Back to plugins&nbsp;&rarr;</a></div>';

		print( $message );

		require_once $has_acf;

	} else {

		require_once __DIR__ . '/assets/dist/acf/acf.php';

	}
}