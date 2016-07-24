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
	
	$video_library_settings = acf_add_options_sub_page(array(
		'page_title' 	=> 'Video Archive Settings',
		'menu_title' 	=> 'Video Archive Settings',
		'menu_slug' 	=> 'video-archive-settings',
		'capability' 	=> 'edit_posts',
		'parent_slug'   => 'edit.php?post_type=video'
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


function acf_oembed( $iframe ) {
	
	// use preg_match to find iframe src
	preg_match('/src="(.+?)"/', $iframe, $matches);
	$src = $matches[1];
	
	
	// add extra params to iframe src
	$params = array(
		'controls'    => 1,
		'hd'        => 1,
		'autohide'    => 1,
		'rel' => 0
	);
	
	$new_src = add_query_arg($params, $src);
	
	$iframe = str_replace($src, $new_src, $iframe);
	
	
	// add extra attributes to iframe html
	$attributes = 'frameborder="0"';
	
	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
	
	$iframe = sprintf( '<div class="embed-container">%s</div>', $iframe );
	
	
	// echo $iframe
	return $iframe;	
}