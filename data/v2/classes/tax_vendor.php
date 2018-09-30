<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/4/18
 * Time: 7:45 PM
 */

add_action( 'init', 'register_part' );
add_action( 'init', 'register_assembly' );
//add_action( 'init', [ $this, 'register_part_cat' ] );
//add_action( 'init', [ $this, 'register_part_tags' ] );

add_action( 'init', 'register_inventory' );


function cptui_register_my_taxes_vendor() {

	/**
	 * Taxonomy: Vendors.
	 */

	$labels = [
		"name"          => __( "Vendors", "wasserman-store" ),
		"singular_name" => __( "Vendor", "wasserman-store" ),
	];

	$args = [
		"label"              => __( "Vendors", "wasserman-store" ),
		"labels"             => $labels,
		"public"             => true,
		"hierarchical"       => true,
		"label"              => "Vendors",
		"show_ui"            => true,
		"show_in_menu"       => true,
		"show_in_nav_menus"  => true,
		"query_var"          => true,
		"rewrite"            => [ 'slug' => 'vendor', 'with_front' => true, 'hierarchical' => true, ],
		"show_admin_column"  => true,
		"show_in_rest"       => true,
		"rest_base"          => "vendor",
		"show_in_quick_edit" => true,
	];
	register_taxonomy( "vendor", [ "part", "assembly", "inventory" ], $args );
}

add_action( 'init', 'cptui_register_my_taxes_vendor' );

function cptui_register_my_taxes_material() {

	/**
	 * Taxonomy: Materials.
	 */

	$labels = [
		"name"          => __( "Materials", "wasserman-store" ),
		"singular_name" => __( "Material", "wasserman-store" ),
	];

	$args = [
		"label"              => __( "Materials", "wasserman-store" ),
		"labels"             => $labels,
		"public"             => true,
		"hierarchical"       => true,
		"label"              => "Materials",
		"show_ui"            => true,
		"show_in_menu"       => true,
		"show_in_nav_menus"  => true,
		"query_var"          => true,
		"rewrite"            => [ 'slug' => 'material', 'with_front' => true, 'hierarchical' => true, ],
		"show_admin_column"  => true,
		"show_in_rest"       => true,
		"rest_base"          => "material",
		"show_in_quick_edit" => true,
	];
	register_taxonomy( "material", [ "part", "assembly", "inventory" ], $args );
}

add_action( 'init', 'cptui_register_my_taxes_material' );

function cptui_register_my_cpts_bill_materials() {

	/**
	 * Post Type: BOMs.
	 */

	$labels = [
		"name"          => __( "BOM", "wasserman-store" ),
		"singular_name" => __( "BOM", "wasserman-store" ),
	];

	$args = [
		"label"               => __( "BOM", "wasserman-store" ),
		"labels"              => $labels,
		"description"         => "",
		"public"              => true,
		"publicly_queryable"  => true,
		"show_ui"             => true,
		"show_in_rest"        => true,
		"rest_base"           => "",
		"has_archive"         => true,
		"show_in_menu"        => true,
		"show_in_nav_menus"   => true,
		"exclude_from_search" => false,
		"capability_type"     => "product",
		"map_meta_cap"        => true,
		"hierarchical"        => true,
		"rewrite"             => [ "slug" => "bill_materials", "with_front" => true ],
		"query_var"           => true,
		"supports"            => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "bill_materials", $args );
}

add_action( 'init', 'cptui_register_my_cpts_bill_materials' );


function register_inventory() {

	/**
	 * Post Type: Inventory Items.
	 */

	$labels = [
		"name"          => __( "Inventory", "wc-bill-materials" ),
		"singular_name" => __( "Inventory", "wc-bill-materials" ),
		'menu_name'     => __( 'Inventory', 'wc-bom' ),
		'all_items'     => __( 'All Inventory', 'wc-bom' ),

	];

	$args = [
		'label'               => __( 'Inventory', 'wc-bom' ),
		'labels'              => $labels,
		//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'show_in_menu'        => true,
		//'show_in_menu_string' => 'wc-bom-admin',
		'exclude_from_search' => false,
		'capability_type'     => 'product',
		'map_meta_cap'        => true,
		'hierarchical'        => true,
		'query_var'           => true,
		'menu_icon'           => 'dashicons-admin-tools',
		'supports'            => [
			'title',
			//'editor',
			'thumbnail',
			//'excerpt',
			//'comments',
			'revisions',
			'author',
			'page-attributes',
		],
	];

	register_post_type( "inventory", $args );
}

function register_part_tags() {

	$labels = [
		'name'          => __( 'Part Tags', 'wc-bom' ),
		'singular_name' => __( 'Part Tag', 'wc-bom' ),
		'menu_name'     => __( 'Tags', 'wc-bom' ),
	];

	$args = [
		'label'              => __( 'Part Tags', 'wc-bom' ),
		'labels'             => $labels,
		'public'             => true,
		'hierarchical'       => false,
		//'label' => 'Inventory Types',
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'show_admin_column'  => true,
		'show_in_rest'       => true,
		'show_in_quick_edit' => true,
	];
	register_taxonomy( 'part-tags', [ 'part', 'assembly' ], $args );
}


function register_part_cat() {

	$labels = [
		'name'          => __( 'Part Categories', 'wc-bom' ),
		'singular_name' => __( 'Part Category', 'wc-bom' ),
		'menu_name'     => __( 'Categories', 'wc-bom' ),
	];

	$args = [
		'label'              => __( 'Part Categories', 'wc-bom' ),
		'labels'             => $labels,
		'public'             => true,
		'hierarchical'       => true,
		//'label' => 'Inventory Types',
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'show_admin_column'  => true,
		'show_in_rest'       => true,
		'show_in_quick_edit' => true,
	];
	register_taxonomy( 'part-category', [ 'part', 'assembly' ], $args );


}

function register_assembly() {

	$labels = [
		'name'          => __( 'Assembly', 'wc-bom' ),
		'singular_name' => __( 'Assembly', 'wc-bom' ),
		'menu_name'     => __( 'Assembly', 'wc-bom' ),
		'all_items'     => __( 'All Assemblies', 'wc-bom' ),
	];
	$args   = [
		'label'               => __( 'Assemblies', 'wc-bom' ),
		'labels'              => $labels,
		//'description'         => 'Post type for assemblies build by combining materials with parts.',
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'rest_base'           => 'assembly',
		'has_archive'         => 'assemblies',
		'show_in_menu'        => true,
		//'show_in_menu_string' => 'wc-bom-admin',
		'exclude_from_search' => false,
		'capability_type'     => 'product',
		'map_meta_cap'        => true,
		'hierarchical'        => true,
		'query_var'           => true,
		'menu_icon'           => 'dashicons-hammer',
		'supports'            => [
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'author',
			'page-attributes',
		],
	];
	register_post_type( 'assembly', $args );
}


/**
 *
 */
function register_part() {

	$labels = [
		'name'          => __( 'Parts', 'wc-bom' ),
		'singular_name' => __( 'Part', 'wc-bom' ),
		'menu_name'     => __( 'Parts', 'wc-bom' ),
		'all_items'     => __( 'All Parts', 'wc-bom' ),

	];

	$args = [
		'label'               => __( 'Parts', 'wc-bom' ),
		'labels'              => $labels,
		//'description'         => 'Materials post type that will be combined to make subassemblies and assemblies portion of BOM.',
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'show_in_menu'        => true,
		//'show_in_menu_string' => 'wc-bom-admin',
		'exclude_from_search' => false,
		'capability_type'     => 'product',
		'map_meta_cap'        => true,
		'hierarchical'        => true,
		'query_var'           => true,
		'menu_icon'           => 'dashicons-admin-tools',
		'supports'            => [
			'title',
			//'editor',
			'thumbnail',
			//'excerpt',
			//'comments',
			'revisions',
			'author',
			'page-attributes',
		],
	];

	register_post_type( 'part', $args );
}