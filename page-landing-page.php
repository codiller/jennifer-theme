<?php

/*
 *
 * Template Name: Landing Page
 *
 */

/*
 *
 * Force Genesis full-width layout
 *
 */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/*
 *
 * Add custom body class
 *
 */
add_filter( 'body_class', 'tlc_custom_body_class' );
function tlc_custom_body_class( $classes ) {
	$classes[] = 'landing-page';
	return $classes;
}

/*
 *
 * Remove theme areas
 *
 */
remove_action( 'genesis_before_header', 'tlc_pre_header' );
unregister_sidebar( 'header-right' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

add_action( 'genesis_header_right', 'tlc_landing_page_header_right_widget' );
function tlc_landing_page_header_right_widget() {

	dynamic_sidebar( 'landing-page-header-right' );

}

genesis();

?>