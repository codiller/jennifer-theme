<?php
/*
 *
 * Template Name: Page with Entries
 *
 */

/*
 *
 * Add custom body class
 *
 */
add_filter( 'body_class', 'tlc_custom_body_class' );
function tlc_custom_body_class( $classes ) {
	$classes[] = 'page-with-entries';
	return $classes;
}

add_action( 'genesis_entry_content', 'tlc_page_with_entries' );
function tlc_page_with_entries() {
	
	// Add variables for use in the query below
	$tlc_post_type = get_post_meta( get_the_ID(), 'wpcf-custom-post-type', true );
	$tlc_custom_taxonomy_name = get_post_meta( get_the_ID(), 'wpcf-custom-taxonomy-name', true );
	$tlc_custom_taxonomy_value = get_post_meta( get_the_ID(), 'wpcf-custom-taxonomy-value', true );
	$tlc_post_parent = get_post_meta( get_the_ID(), 'wpcf-custom-post-parent', true );

	// Add div container for :nth-child
	echo '<div class="loop">';

	// Query args
	$args=array(
		'orderby' =>'title',
		'order' =>'asc',
		'post_type' => $tlc_post_type,
		$tlc_custom_taxonomy_name => $tlc_custom_taxonomy_value,
		'post_parent' => $tlc_post_parent
	);

	// New WP_Query
	$my = new WP_Query( $args );

	// The Loop
	while ( $my->have_posts() ): $my->the_post();
		global $post;
		global $more;
		$more = 0;

		// Theme loop template
		get_template_part( 'loop', 'jennifer' );
	
	endwhile;
	wp_reset_postdata();
	
	echo '</div><!-- end .loop-->';
}

 genesis();

 ?>