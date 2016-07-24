<?php
// Firewell Member functions

/*
 show the membersonly message
 get_template_part( 'template-parts/content-members-only', 'none' );
*/

function firewell_get_user_role( $user = null ) {
	$user = $user ? new WP_User( $user ) : wp_get_current_user();
	return $user->roles ? array_values( $user->roles )[0] : false;
}

function firewell_is_member() {
	return current_user_can( 'read' ) ? true : false;
}


function firewell_members_only_message() {
	
	$message = get_field( 'members_only_message', 'options' );
	
	if( $message ) {
		return sprintf( '<div class="members-access-error">%s</div>', $message );
	}
	
	return false;
}

add_action( 'firewell_after_content', 'check_content_permission' );
function check_content_permission() {
	global $post;
	$post_id = $post->ID;
	$roles = members_get_post_roles( $post_id );
	if ( !empty( $roles ) && !current_user_can( 'read' ) ) {
		
	}
	
}





// Set page builder error message for users that are not logged in
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


