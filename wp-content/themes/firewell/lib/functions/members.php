<?php
// Firewell Member functions

function firewell_members_protected() {
	if ( !current_user_can( 'read' ) ) {
		// redirect to login page	
	}
}

add_action( 'firewell_after_content', 'check_content_permission' );
function check_content_permission() {
	global $post;
	$post_id = $post->ID;
	$roles = members_get_post_roles( $post_id );
	if ( !empty( $roles ) && !current_user_can( 'read' ) ) {
		echo members_only_message();
	}
	
}


function members_only_message() {
	
	$login_link = get_permalink();
	$signup_link = get_permalink();
	printf('<section class="section members-only-message"><div class="section-wrapper"><div class="section-container"><article class="hentry"><h2>%s</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Log In or Sign Up</p></article></div></div></section>', 'Members Only', $login_link, $signup_link);
}