<?php
// Firewell Member functions

function firewell_members_protected() {
	if ( !current_user_can( 'read' ) ) {
		// redirect to login page	
	}
}

add_action( 'firewell_after_content', 'members_only_message' );
function members_only_message() {
	if ( !current_user_can( 'read' ) ) {
		$content = 'Member only content with sign up/login goes here';
		printf( '<div class="members-only-message">%s</div>', $content );	
	}
	
}