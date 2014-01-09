<?php

/*
 *
 * Template Name: Employee Directory
 *
 */

/*
 *
 * Add Employee Directory Listings to Employee Directory Template
 *
 */
add_action( 'genesis_entry_content', 'tlc_employee_directory_listing' );
function tlc_employee_directory_listing() {

	// Add enclosing div so we can use :nth-child
	echo '<div class="directory-listings">';

	// Loop arguments
	$args=array(
		'orderby' =>'menu_order',
		'order' =>'asc',
		'post_type' =>'employees',
		'posts_per_page' => '-1'
	);
	$my = new WP_Query( $args );

	// Loop
	while ( $my->have_posts() ): $my->the_post();
		
		global $post;
		global $more;
		$more = 0;
		
		get_template_part( 'loop', 'directory' );
	
	endwhile;

	// Reset postdata
	wp_reset_postdata();
	
	// Close enclosing div
	echo '</div><!-- end .directory-listings-->';

}

genesis();

?>