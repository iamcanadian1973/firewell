<?php
// Firewell Member functions

/**
 * Redirect non-admins to the homepage after logging into the site.
 *
 * @since 	1.0
 */
function firewell_login_redirect( $redirect_to, $request, $user  ) {
	return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
}

add_filter( 'login_redirect', 'firewell_login_redirect', 10, 3 );

/**
 * Get current user role
 *
 * @since 	1.0
 */
function firewell_get_user_role( $user = null ) {
	$user = $user ? new WP_User( $user ) : wp_get_current_user();
	return $user->roles ? array_values( $user->roles )[0] : false;
}

/**
 * Find out if they are a user. We do it this way so that anyone that can read can see content.
 *
 * @since 	1.0
 */
function firewell_is_member() {
	return current_user_can( 'read' ) ? true : false;
}

/**
 * Format he Members message
 *
 * @since 	1.0
 */
function firewell_members_only_message() {
	
	$message = get_field( 'members_only_message', 'options' );
	
	if( $message ) {
		return sprintf( '<div class="members-access-error">%s</div>', $message );
	}
	
	return false;
}

/*
// Can't remember what this was supposed to do, but keeping it anyway for now.
add_action( 'firewell_after_content', 'check_content_permission' );
function check_content_permission() {
	global $post;
	$post_id = $post->ID;
	$roles = members_get_post_roles( $post_id );
	if ( !empty( $roles ) && !current_user_can( 'read' ) ) {
		
	}
	
}
*/



/**
 * Set page builder error message for users that are not logged in
 *
 * @since 	1.0
 */
 add_action( 'page_builder_after_while', function() {
		
	// Is the page restricted? If so only show content blocks that are set to visible
	if( !members_can_current_user_view_post( get_the_ID() ) ) {
		
		$visibility = get_sub_field( 'visibility' );
		
		if( $visibility == 'Members Only' ){
			$message = members_get_setting( 'content_permissions_error' );	
			printf( '<div class="section">%s</div>', $message );
		}
			
	}
	
});


function firewell_user_info( $atts = '' ) {
	
	$a = shortcode_atts( array(
        'value' => 'user_firstname',
    ), $atts );
	
	if( is_user_logged_in() ) {
		// Hello [username]! My Account (link to profile) 
		$user = wp_get_current_user();
		$detail = $a['value'];
		return 	( isset( $user->{$detail} ) ) ? $user->{$detail} : 'User';
	}
	
	return 'User';	
}

add_shortcode( 'firewell_user_info', 'firewell_user_info' );


function firewell_logout_url_shortcode() {
	return sprintf('<a href="%s">Logout</a>', wp_logout_url( site_url() ) );
}
add_shortcode( 'bbp-logout', 'firewell_logout_url_shortcode' );