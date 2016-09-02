<?php

/**
 * Change default login url
 *
 * @since 	1.0
 */
function firewell_login_url( $login_url, $redirect, $force_reauth ) {
    $login_page = get_permalink(4);
    $login_url = add_query_arg( 'redirect_to', $redirect, $login_page );
    return $login_url;
}

//add_filter( 'login_url', 'firewell_login_url', 10, 3 );


function cubiq_login_init () {
    
	$login_page = get_permalink(4);
	
	$lost_password_page = get_permalink(607);
    $lp_url = add_query_arg( 'redirect_to', $redirect, $lost_password_page );
	
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';

    if ( isset( $_POST['wp-submit'] ) ) {
        $action = 'post-data';
    } else if ( isset( $_GET['reauth'] ) ) {
        $action = 'reauth';
    } else if ( isset($_GET['key']) ) {
        $action = 'resetpass-key';
    }

    // redirect to change password form
    if ( $action == 'rp' || $action == 'resetpass' ) {
        wp_redirect( home_url('/login/?action=resetpass') );
        exit;
    }

    // redirect from wrong key when resetting password
    if ( $action == 'lostpassword' && isset($_GET['error']) && ( $_GET['error'] == 'expiredkey' || $_GET['error'] == 'invalidkey' ) ) {
        wp_redirect( home_url( '/login/?action=forgot&failed=wrongkey' ) );
        exit;
    }

    if (
        $action == 'post-data'        ||            // don't mess with POST requests
        $action == 'reauth'           ||            // need to reauthorize
        $action == 'resetpass-key'    ||            // password recovery
        $action == 'logout'                         // user is logging out
    ) {
        return;
    }

    wp_redirect( $login_page );
    exit;
}
//add_action('login_init', 'cubiq_login_init');



function redirect_login($redirect_to, $url, $user) {
    
	if (is_wp_error($user)) {
        //Login failed, find out why...
        $error_types = array_keys($user->errors);
        //Error type seems to be empty if none of the fields are filled out
        $error_type = 'both_empty';
        //Otherwise just get the first error (as far as I know there
        //will only ever be one)
        if (is_array($error_types) && !empty($error_types)) {
            $error_type = $error_types[0];
        }
		
        $args = array(
		'login' => 'failed',
		'reason' => $error_type);
		wp_redirect( add_query_arg( $args, get_permalink(4) ) );
		exit;
    }

    
}

//add_action('login_redirect', 'redirect_login', 10, 3);