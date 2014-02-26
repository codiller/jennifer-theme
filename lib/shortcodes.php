<?php

function tlc_online_application_url() {
	$tlc_application_url = '<a class="btn-lg" href="' . genesis_get_option( 'application_url', 'tlc_options' ) . '" target="_blank">APPLY NOW!</a>';
	return $tlc_application_url;
}
add_shortcode( 'application_url', 'tlc_online_application_url' );

?>