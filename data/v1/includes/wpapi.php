<?php
/*
Plugin Name: Give It A REST API Plugin
Plugin URI: http://deliciousbrains.com/blog
Description: Enables the Give it a REST API
Author: Jeff Gould
Version: 0.1
Author URI: http://deliciousbrains.com
*/
if ( ! defined( 'ABSPATH' ) ) { die('No no no!'); } // Exit if accessed directly

register_activation_hook( __FILE__, 'giar_activate' );
/**
 *
 */
function giar_activate() {

	flush_rewrite_rules();
}

add_action( 'rest_api_init', 'dt_register_api_hooks' );
/**
 *
 */
function dt_register_api_hooks() {

	$namespace = 'give-it-a-rest/v1';
	register_rest_route( $namespace, '/list-posts/', [
		'methods'  => 'GET',
		'callback' => 'giar_get_posts',
	] );
	register_rest_route( $namespace, '/vote/', [
		'methods'  => 'POST',
		'callback' => 'giar_process_vote',
	] );
}

/**
 * @return \WP_REST_Response
 */
function giar_get_posts() {

	if ( 0 || false === ( $return = get_transient( 'dt_all_posts' ) ) ) {
		$query     = apply_filters( 'giar_get_posts_query', [
			'numberposts' => 10,
			'post_type'   => 'post',
			'post_status' => 'publish',
		] );
		$all_posts = get_posts( $query );
		$return    = [];
		foreach ( $all_posts as $post ) {
			$return[] = [
				'ID'        => $post->ID,
				'title'     => $post->post_title,
				'permalink' => get_permalink( $post->ID ),
				'upvotes'   => intval( get_post_meta( $post->ID, 'giar_upvotes', true ) ),
				'downvotes' => intval( get_post_meta( $post->ID, 'giar_downvotes', true ) ),
			];
		}
		// cache for 10 minutes
		set_transient( 'giar_all_posts', $return, apply_filters( 'giar_posts_ttl', 60 * 10 ) );
	}
	$response = new WP_REST_Response( $return );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'giar_access_control_allow_origin', '*' ) );

	return $response;
}

/**
 * @return bool|\WP_REST_Response
 */
function giar_process_vote() {

	$vote    = $_POST[ 'vote' ];
	$post_id = $_POST[ 'id' ];
	// input validation
	if ( ! is_numeric( $post_id ) || ! in_array( strtolower( $vote ), [ 'up', 'down' ] ) ) {
		return false;
	}
	$meta_name      = 'giar_' . $vote . 'votes';
	$vote_count     = intval( get_post_meta( $post_id, $meta_name, true ) );
	$update_success = update_post_meta( $post_id, $meta_name, ++ $vote_count ) ? true : false;
	// clear transient posts cache
	delete_transient( 'giar_all_posts' );

	$response = new WP_REST_Response( $update_success );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'giar_access_control_allow_origin', '*' ) );

	return $response;
}