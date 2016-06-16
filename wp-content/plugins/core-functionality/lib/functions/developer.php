<?php


// Backend Notice
add_action( 'admin_notices', 'admin_notice' );

/**
* Notice displayed at top of all admin pages
* @link http://wptheming.com/2011/08/admin-notices-in-wordpress/
*/
function admin_notice() {
	echo '<div class="error">Website is currently in Developer Mode.</div>';
}


//* Put website in developer mode and hide from everyone based on IP
add_action('get_header', 'redirect_user_not_logged_in');

function is_allowed_ip( $ip = '184.65.61.136' ) {
				
		if( !is_array( $ip ) ) {
			$ip = array($ip);
		}
		
		return ( in_array($_SERVER['REMOTE_ADDR'], $ip) );
}

function redirect_user_not_logged_in()
{
	if( !is_allowed_ip() ):
	
		wp_redirect( 'http://www.google.ca' );
		exit;
		
	endif;
}
