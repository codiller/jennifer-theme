<?php

/*
 *
 * Add Conversion Information Custom Meta Box
 *
 */
add_filter( 'cmb_meta_boxes', 'tlc_cmb_metaboxes_conversions' );
function tlc_cmb_metaboxes_conversions( array $meta_boxes ) {

	// Define a prefix
	$prefix = '_tlc_';

	// Define first metabox and fields
	$meta_boxes['conversion_information'] = array(
		'id'         => 'conversion_information',
		'title'      => __( 'Conversion Information', 'tlc' ),
		'pages'      => array( 'page', ), // Post type
		'show_on'    => array( 'key' => 'page-template', 'value' => 'page-conversions.php' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Conversion Code', 'tlc' ),
				'desc' => __( 'Enter your page\'s conversion code.', 'tlc' ),
				'id'   => $prefix . 'conversion_code',
				'type' => 'textarea_code',
			),
		)
	);

	// Return the metaboxes
	return $meta_boxes;

}

?>