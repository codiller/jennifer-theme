<?php

/*
 *
 * Template Name: Conversion Page
 *
 */

/*
 *
 * Remove theme areas
 *
 */
remove_action( 'genesis_before_header', 'tlc_pre_header' );

/*
 *
 * Add conversion script, if present
 *
 */
add_action( 'genesis_before', 'tlc_conversion_code' );
function tlc_conversion_code() {
	if( get_post_meta( get_the_ID(), '_tlc_conversion_code', true ) ) {
		$conversion_code = get_post_meta( get_the_ID(), '_tlc_conversion_code', true );
		echo $conversion_code;
	}
}

genesis();

?>