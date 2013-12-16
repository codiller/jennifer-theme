<?php

function tlc_online_application_url () {
	echo genesis_get_option( 'application-url', 'tlc-options' );
}
add_shortcode( 'application_url', 'tlc_online_application_url' );

?>