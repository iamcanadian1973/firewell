<?php

/**
*  Creates ACF Options Page(s)
*/


if( function_exists('acf_add_options_sub_page') ) {
	
	
	$child_theme_settings = acf_add_options_page(array(
		'page_title' 	=> 'Firewell',
		'menu_title' 	=> 'Firewell',
		'menu_slug' 	=> 'child-theme-settings',
		'capability' 	=> 'edit_posts',
		'position' => 40,
		'redirect' 	=> true
	));
	
	
	
}


/**
 * Hide Advanced Custom Fields to Users
 */
add_filter('acf/settings/show_admin', 'remove_acf_menu');
function remove_acf_menu( $show ){
    // provide a list of usernames who can edit custom field definitions here
    $admins = array( 'admin', 'kyle' );
 
    // get the current user
    $current_user = wp_get_current_user();
	
	return in_array( $current_user->user_login, $admins );
}