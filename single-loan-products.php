<?php
/*
 *
 * Template for Single Loan Products
 *
 */

/*
 *
 * Remove Post and Meta Info
 *
 */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/*
 *
 * Add Previous & Next Post Links
 *
 */
add_action( 'genesis_entry_header', 'tlc_post_links' );
function tlc_post_links() {
	
	// Add nav block
	echo '<nav class="entry-links">';

	// Add previous post link
	if( get_previous_post() ) :
    	echo previous_post_link('<div class="link-prev">%link : Previous</div>');
	endif;

	// Add next post link
	if( get_next_post() ) :
    	echo next_post_link('<div class="link-next">Next : %link</div>');
	endif;

	// End nav block
	echo '</nav><!-- end .entry-links-->';
	
}

genesis();

?>