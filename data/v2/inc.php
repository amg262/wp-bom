<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/2/18
 * Time: 8:36 PM
 */
add_action( 'init', function () {
	$labels = [
		"name"               => "Cartoon Series",
		"singular_name"      => "Cartoon Series",
		"menu_name"          => "Cartoon Series",
		"all_items"          => "All Cartoon Series",
		"add_new"            => "Add New",
		"add_new_item"       => "Add New Cartoon Series",
		"edit"               => "Edit",
		"edit_item"          => "Edit Cartoon Series",
		"new_item"           => "New Cartoon Series",
		"view"               => "View",
		"view_item"          => "View Cartoon Series",
		"search_items"       => "Search Cartoon Series",
		"not_found"          => "No Cartoon Series Found",
		"not_found_in_trash" => "No Cartoon Series Found in Trash",
		"parent"             => "Parent Cartoon Series",
	];

	$args = [
		"labels"              => $labels,
		"description"         => "",
		"public"              => true,
		"show_ui"             => true,
		"has_archive"         => true,
		"show_in_menu"        => true,
		"exclude_from_search" => false,
		"capability_type"     => "post",
		"map_meta_cap"        => true,
		"hierarchical"        => true,
		"rewrite"             => [ "slug" => "cartoon-series", "with_front" => true ],
		"query_var"           => true,
		"supports"            => [ "title", "revisions", "thumbnail" ],
	];

	register_post_type( "cartoon-series", $args );

	$labels = [
		"name"          => "Episodes",
		"singular_name" => "Episode",
	];

	$args = [
		"labels"              => $labels,
		"description"         => "",
		"public"              => true,
		"show_ui"             => true,
		"has_archive"         => true,
		"show_in_menu"        => true,
		"exclude_from_search" => false,
		"capability_type"     => "post",
		"map_meta_cap"        => true,
		"hierarchical"        => false,
		"rewrite"             => [ "slug" => "cartoon-series/%series_name%", "with_front" => true ],
		"query_var"           => true,
		"supports"            => [ "title", "revisions", "thumbnail" ],
	];

	register_post_type( "episodes", $args );

} );

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'episodes-parent', 'Cartoon Series', 'episodes_attributes_meta_box', 'episodes', 'side', 'default' );
} );

function episodes_attributes_meta_box( $post ) {
	$pages = wp_dropdown_pages( [ 'post_type'        => 'cartoon-series',
	                              'selected'         => $post->post_parent,
	                              'name'             => 'parent_id',
	                              'show_option_none' => __( '(no parent)' ),
	                              'sort_column'      => 'menu_order, post_title',
	                              'echo'             => 0,
	] );
	if ( ! empty( $pages ) ) {
		echo $pages;
	} // end empty pages check
}

add_action( 'init', function () {

	add_rewrite_rule( '^cartoon-series/(.*)/([^/]+)/?$', 'index.php?episodes=$matches[2]', 'top' );

} );

add_filter( 'post_type_link', function ( $link, $post ) {
	if ( 'episodes' === get_post_type( $post ) ) {
		//Lets go to get the parent cartoon-series name
		if ( $post->post_parent ) {
			$parent = get_post( $post->post_parent );
			if ( ! empty( $parent->post_name ) ) {
				return str_replace( '%series_name%', $parent->post_name, $link );
			}
		} else {
			//This seems to not work. It is intented to build pretty permalinks
			//when episodes has not parent, but it seems that it would need
			//additional rewrite rules
			//return str_replace( '/%series_name%', '', $link );
		}

	}

	return $link;
}, 10, 2 );

