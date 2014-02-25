<?php

/*
 *
 * Register custom post type - testimonials
 *
 */
add_action( 'init', 'register_cpt_testimonials' );

function register_cpt_testimonials() {

	$labels = array( 
		'name' => _x( 'Testimonials', 'tlc_testimonials' ),
		'singular_name' => _x( 'Testimonial', 'tlc_testimonials' ),
		'add_new' => _x( 'Add New', 'tlc_testimonials' ),
		'add_new_item' => _x( 'Add New Testimonial', 'tlc_testimonials' ),
		'edit_item' => _x( 'Edit Testimonial', 'tlc_testimonials' ),
		'new_item' => _x( 'New Testimonial', 'tlc_testimonials' ),
		'view_item' => _x( 'View Testimonial', 'tlc_testimonials' ),
		'search_items' => _x( 'Search Testimonials', 'tlc_testimonials' ),
		'not_found' => _x( 'No testimonials found', 'tlc_testimonials' ),
		'not_found_in_trash' => _x( 'No testimonials found in Trash', 'tlc_testimonials' ),
		'parent_item_colon' => _x( 'Parent Testimonial:', 'tlc_testimonials' ),
		'menu_name' => _x( 'Testimonials', 'tlc_testimonials' ),
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'genesis-cpt-archives-settings' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array( 
			'slug' => 'testimonials',
			'with_front' => true,
			'feeds' => true,
			'pages' => true
		),
		'capability_type' => 'post'
	);

	register_post_type( 'tlc_testimonials', $args );

}

?>