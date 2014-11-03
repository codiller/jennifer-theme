<?php

/*
 *
 * Add Disclosure Information Custom Meta Box
 *
 */
add_filter( 'cmb_meta_boxes', 'tlc_cmb_metaboxes_disclosures' );
function tlc_cmb_metaboxes_disclosures( array $meta_boxes ) {

	// Define a prefix
	$prefix = '_tlc_';

	// Define first metabox and fields
	$meta_boxes['disclosure_information'] = array(
		'id'         => 'disclosure_information',
		'title'      => __( 'Disclosure Information', 'tlc' ),
		'pages'      => array( 'page', 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Disclosure Information', 'tlc' ),
				'desc' => __( 'Enter any disclosures for this page/post.', 'tlc' ),
				'id'   => $prefix . 'disclosure_information',
				'type' => 'textarea',
			),
		)
	);

	// Return the metaboxes
	return $meta_boxes;

}

?>