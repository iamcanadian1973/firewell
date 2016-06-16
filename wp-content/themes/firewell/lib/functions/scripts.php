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
	 
	//wp_enqueue_script( 'add-to-any', '//static.addtoany.com/menu/page.js', FALSE, NULL, TRUE );
	
	
	// Load Royal Slider
	global $post;
	
	$slides = get_post_meta( $post->ID, 'slides', TRUE );
	if( !empty( $slides ) ) {
			
	    wp_enqueue_script( 'royalslider' , CHILD_THEME_JS . '/royalslider.js', array('theme-plugins'), NULL, TRUE );
	}
	
	// Load gallery
	$gallery = get_post_meta( $post->ID, 'gallery', TRUE );
	if( !empty( $gallery ) ) {
			
	    wp_enqueue_script( 'gallery' , CHILD_THEME_JS . '/gallery.js', array('theme-plugins'), NULL, TRUE );
	}
	
	
	if( is_page_template( 'templates/register.php' ) ) {
			
	    wp_enqueue_script( 'register' , CHILD_THEME_JS . '/register.js', array(), NULL, TRUE );
	}
	
	// Child Theme JS
	wp_enqueue_script( CHILD_THEME_NAME , CHILD_THEME_JS . '/general.js', array('jquery'), NULL, TRUE );
	
	/*
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	*/
	
}
add_action( 'wp_enqueue_scripts', 'load_scripts' );