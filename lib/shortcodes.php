<?php

function tlc_online_application_url() {
	$application_url = '<a class="btn-lg" href="' . genesis_get_option( 'application-url', 'tlc-options' ) . '" target="_blank">APPLY NOW!</a>';
	return $application_url;
}
add_shortcode( 'application_url', 'tlc_online_application_url' );

?>