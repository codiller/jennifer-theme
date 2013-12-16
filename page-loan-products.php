<?php

/*
 *
 * Template Name: Display Loan Products
 *
 */

/*
 *
 * Add Easier to Use Body Class
 *
 */
add_filter( 'body_class' , 'tlc_body_class' );
function tlc_body_class( $classes ) {
	$classes[] = 'loan-products-overview';
	return $classes;
}

/*
 *
 * Add Loan Products Loop to Display Loan Products Template
 *
 */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'tlc_loan_products_loop' );
function tlc_loan_products_loop() {
	
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	// Add enclosing div so we can use :nth-child
	echo '<div class="loop-entries">';

	// Loop Arguments
	$args = array(
		'post_type' =>'loan-products',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	genesis_custom_loop( $args );

	// Close enclosing div
	echo '</div><!-- end .loop-entries-->';

}

genesis();

?>