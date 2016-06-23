<?php

// Custom content filters

add_filter( 'pb_the_content', 'wptexturize'        );
add_filter( 'pb_the_content', 'convert_chars'      );
add_filter( 'pb_the_content', 'wpautop'            );
add_filter( 'pb_the_content', 'shortcode_unautop'  );
add_filter( 'pb_the_content', 'do_shortcode'       );

// Add section attributes
add_filter( 'page_builder_attr_section', 'set_page_builder_section_attr', 10 );
function set_page_builder_section_attr( $attributes ) {
	
	global $post, $PB;	
	
	$is_device = FALSE;
	// use mobile detect plugin
	if( function_exists( 'wpmd_is_device' ) ) {
		$is_device = wpmd_is_device();
	}
	
	$styles = $classes = array();			
	
	// unique id's
	static $ids_array = array();
	
	$row_layout = pb_sanitize_class( get_row_layout() );
			
	// add layout type to ids array
	array_push( $ids_array, $row_layout );
	
	// count number of current layouts
	$counts = array_count_values( $ids_array );	
	
	// Add Section Layout class
	$classes[] = 'section-' . $row_layout;
	// Add Section Layout count class
	$classes[] = sprintf( 'section-%s-%s', $row_layout, $counts[$row_layout] );
	
	// Additional Classes
	$additional_classes = get_sub_field( 'additional_classes' );
	if( $additional_classes ) {
		$classes[] = $additional_classes;
	}
	
	// override row ID
	$row_id = get_sub_field( 'row_id' );
	if( $row_id ) {
		$row_id = sprintf( '%s-%s', 'section', $row_id );
	}
	else {
		$row_id = sprintf( '%s-%s', $row_layout, $counts[$row_layout] );
	}
				
	$attributes['style']  =      pb_parse_attributes_array( $styles );
	$attributes['class'] .= ' '. pb_sanitize_html_classes( $classes, 'string' );
	$attributes['id']     = 	     $row_id;
	
	
	// Load all attributes into Page Builder Class - this allows us to later target sections by attributes
	kr_page_builder_plugin()->set_attributes( $attributes );
	
	return $attributes;

	
}


// Set Page Buolder Group Attrributes
add_filter( 'page_builder_attr_group', 'set_page_builder_group_attr', 10 );
function set_page_builder_group_attr( $attributes ) {
	
	global $post, $PB;	
	
	$is_device = FALSE;
	// use mobile detect plugin
	if( function_exists( 'wpmd_is_device' ) ) {
		$is_device = wpmd_is_device();
	}
	
	$styles = $classes = array();
	
	// unique id's
	static $ids_array = array();
	
	$row_layout = pb_sanitize_class( get_row_layout() );
	
	// add laoyut to ids array
	array_push( $ids_array, $row_layout );
	
	// count number of current layouts
	$counts = array_count_values( $ids_array );

	$classes[] = $row_layout;
	
	$classes[] = sprintf( '%s-%s', $row_layout, $counts[$row_layout] );
	
	// Additional Classes
	$additional_classes = get_sub_field( 'additional_classes' );
	if( $additional_classes ) {
		$classes[] = $additional_classes;
	}
	
	// override row ID
	$row_id = get_sub_field( 'row_id' );
	if( !$row_id ) {
		$row_id = sprintf( '%s-%s', $row_layout, $counts[$row_layout] );
	}
			
	$attributes['style']  =      pb_parse_attributes_array( $styles );
	$attributes['class'] .= ' '. pb_sanitize_html_classes( $classes, 'string' );
	$attributes['id']     = 	     $row_id;
	
	
	// return attributes
	return $attributes;
	
}