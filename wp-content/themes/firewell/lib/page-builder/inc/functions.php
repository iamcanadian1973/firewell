<?php

// helper functions

function pb_sanitize_html_classes( $classes, $return_format = 'input' ) {

	if ( 'input' === $return_format ) {
		$return_format = is_array( $classes ) ? 'array' : 'string';
	}

	$classes = is_array( $classes ) ? $classes : explode( ' ', $classes );

	$sanitized_classes = array_map( 'sanitize_html_class', $classes );

	if ( 'array' === $return_format )
		return $sanitized_classes;
	else
		return implode( ' ', $sanitized_classes );

}

function pb_sanitize_class( $class ) {
	$class = sanitize_title_with_dashes( $class );
	return str_replace( '_', '-', $class );
}



function pb_parse_attributes_array( $attr ) {
	// Parse all classes
	if( !empty( $attr ) ) {
		$attr = array_filter( $attr );
		$attr = implode(' ', (array) $attr );
		return $attr;
	}
}

function kr_term_list( $tax, $args = array() ) {

	
	$orderby      = 'name'; 
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no
	$title        = '';

	$defaults = array(
	  'echo'		 => FALSE,
	  'hide_empty'   => FALSE, 
	  'taxonomy'     => $tax,
	  'orderby'      => $orderby,
	  'show_count'   => $show_count,
	  'pad_counts'   => $pad_counts,
	  'hierarchical' => $hierarchical,
	  'title_li'     => $title
	);
	
	$args = wp_parse_args( $args, $defaults );
		
	$terms = get_terms( $tax, $args );
	
	/*
	term_id
	name
	description
	*/
	
	return $terms;
	
}

// get the page builder image
function pb_get_image( $attachment_id, $size = 'large' ) {
	$image = '';
	if( $attachment_id ) {
		$image = wp_get_attachment_image( $attachment_id, $size, '' );				
	}
	return $image;
 }


function pb_set_default_value( $value, $default ) {
	if( is_array( $value ) ) {
		$value = array_shift($value);
	}
	
	$ret = $value  ? $value : $default;
	
	return strtolower( $ret );

}


if(!function_exists('_log')){
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}
