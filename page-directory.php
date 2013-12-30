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
	
	/*
	 *
	 * Add Management to Directory
	 *
	 */

	// Add category heading
	echo '<h2 class="directory-category-heading">Management</h2>';

	// Add enclosing div so we can use :nth-child
	echo '<div class="directory-listings">';

	// Loop arguments
	$args=array(
		'orderby' =>'menu_order',
		'order' =>'asc',
		'post_type' =>'employees',
		'title' => 'division-manager,branch-manager,operations-manager,sales-manager'
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

	/*
	 *
	 * Add Office Staff to Directory
	 *
	 */

	// Add category heading
	echo '<h2 class="directory-category-heading">Office Staff</h2>';

	// Add enclosing div so we can use :nth-child
	echo '<div class="directory-listings">';

	// Loop arguments
	$args=array(
		'orderby' =>'title',
		'order' =>'asc',
		'post_type' =>'employees',
		'title' => 'underwriting-manager,compliance-manager,marketing-manager,office-manager,front-desk,underwriter,junior-underwriter,processor,junior-processor,closer,funder,loan-coordinator,processing-manager,processing-assistant'
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

	/*
	 *
	 * Add Loan Officers to Directory
	 *
	 */

	// Add category heading
	echo '<h2 class="directory-category-heading">Loan Officers</h2>';

	// Add enclosing div so we can use :nth-child
	echo '<div class="directory-listings">';

	// Loop arguments
	$args=array(
		'orderby' =>'title',
		'order' =>'asc',
		'post_type' =>'employees',
		'title' => 'loan-officer,senior-loan-officer,reverse-mortgage-loan-officer'
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