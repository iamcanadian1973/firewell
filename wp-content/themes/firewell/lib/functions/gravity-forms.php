<?php

// Validate the access code field - form #1 - field #6
add_filter( 'gform_field_validation_1_6', function ( $result, $value, $form, $field ) {
    $access_code = strtolower( get_option( 'options_access_code' ) );
	$value = strtolower( $value );
    if ( $result['is_valid'] && $value != $access_code ) {
        $result['is_valid'] = false;
        $result['message']  = 'Please enter a valid access code.';
    }

    return $result;
}, 10, 4 );

// Add the user to a specific private group
add_action( 'gform_user_registered', 'add_custom_user_meta', 10, 4 );
function add_custom_user_meta( $user_id, $feed, $entry, $user_pass ) {    
    $groups = rgar( $entry, '5' ); // form field #5
	update_user_meta( $user_id, 'private_group', $groups );
}

// Add additional role for forum participant
add_action( 'gform_user_registered', 'set_user_role', 10, 3 );
function set_user_role( $user_id, $feed, $entry ) {
    // get role from field 5 of the entry.
    $selected_role = 'bbp_participant';
    $user          = new WP_User( $user_id );
    $user->add_role( $selected_role );
}