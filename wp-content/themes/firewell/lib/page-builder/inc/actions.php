<?php
// Adds all the necessary funcitonaility to a page template

function page_builder_meta() {
	
	// load scripts
	add_action( 'wp_enqueue_scripts', 'page_builder_scripts' );		
	
	add_filter( 'body_class', 'page_builder_class' );
}


/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */
function page_builder_class( $classes ) {
  $classes[] = 'page-builder';
  return $classes;
}



function page_builder_scripts() {
	//wp_enqueue_script( 'royal-slider', CHILD_THEME_JS . '/jquery.royalslider.custom.min.js', '', '', true );
	//wp_enqueue_script( 'lazysizes', CHILD_THEME_JS . '/jquery.lazyload-any.min.js', array('jquery'), NULL, TRUE );
	wp_enqueue_script( 'page-builder', CHILD_THEME_JS . '/page-builder.js', array(
	'wp-util'
	//'lazysizes', 'royal-slider'
	), '', true );
}
