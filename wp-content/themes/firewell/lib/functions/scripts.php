<?php

// Load theme stylesheet
function load_theme_stylesheet() {
	
	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
    $version = '1.0';
	wp_enqueue_style( $handle, trailingslashit( CHILD_THEME_CSS ) . 'style.css', false, $version );
	
}
add_action( 'wp_enqueue_scripts', 'load_theme_stylesheet' );


// Load Scripts
function load_scripts() {
    	
	// Modernizr
	wp_enqueue_script( 'modernizr', CHILD_THEME_JS . '/modernizr.custom.js', FALSE, NULL );
	 	
	
	// Child Theme JS
	wp_enqueue_script( CHILD_THEME_NAME , CHILD_THEME_JS . '/general.js', array('jquery'), NULL, TRUE );
	
	/*
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	*/
	
}
add_action( 'wp_enqueue_scripts', 'load_scripts' );