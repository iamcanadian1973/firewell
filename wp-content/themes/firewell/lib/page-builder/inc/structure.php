<?php

/*
ToDo: wrap sections Genesis style like they do withte wrap class
*/
	
function page_builder_get_content_blocks() {

	global $post;
	
	if ( have_rows('content_blocks') ) {
	
		while ( have_rows('content_blocks') ) { 
		
			the_row();
		
			$row_layout = get_row_layout();
			
			// TODO: check if layout exists/exclude groups
			if( !function_exists( "layout_{$row_layout}" ) ) {
				_log( "Page Builder Warning: function layout_{$row_layout}() does not exist. Check for included file in \"layouts folder\"" );
				//continue;
			}
			
			do_action( 'page_builder_group_open' );
			
			// skip group open
			if (strpos( $row_layout, 'group' ) === false ):
			
			printf( '<section %s>', page_builder_attr( 'section' ) );
				
				do_action( 'page_builder_before_section' );
				
				print( '<div class="section-wrapper">' );
					print( '<div class="section-container">' );	
			
						do_action( 'page_builder_before_layout' );	
				
						call_user_func( "layout_{$row_layout}" );						
				
						do_action( 'page_builder_after_layout' );
						
					print( '</div>' );
				print( '</div>' );	
				
				do_action( 'page_builder_after_section');				
				
			echo '</section>'; //* end section
			
			// skip group_close
			endif;
				
			do_action( 'page_builder_group_close' );
			
			
		} // endwhile have_rows('page_builder')
		
		do_action( 'page_builder_after_while' );
	
	} // endif have_rows('page_builder')


}





// add section classes
add_filter( 'page_builder_attr_section', 'default_section_attr' );
	
function default_section_attr( $attributes ) {

	// static counter variblae
	static $section_counter;
	$section_counter++;
	
	// set section ID
	$attributes['id'] = sanitize_title_with_dashes( 'section-' . $section_counter );
		 
	$classes[] = 'section';
	
	// Section #'s
	$classes[] = 'section-' . $section_counter;
	
	// odd/even
	$classes[] = $section_counter % 2 == 0 ? 'section-even' : 'section-odd';
	
	// Clean up and remove empty array items
	$classes = array_filter( $classes );
	
	$attributes['class'] = implode(' ', (array) $classes );
															 
	// return the attributes
	return $attributes;
 
}			


function page_builder_attr( $context, $attributes = array() ) {
	
	$attributes = page_builder_parse_attr( $context, $attributes );
	
	$output = '';
	
	//* Cycle through attributes, build tag attribute string
	foreach ( $attributes as $key => $value ) {
	
		if ( ! $value ) {
			continue;
		}
	
		if ( true === $value ) {
			$output .= esc_html( $key ) . ' ';
		} else {
			$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
		}
	
	}
	
	$output = apply_filters( "page_builder_attr_{$context}_output", $output, $attributes, $context );
	
	return trim( $output );

}

function page_builder_parse_attr( $context, $attributes = array() ) {

	$defaults = array(
		'class' => sanitize_html_class( $context ),
	);
	
	$attributes = wp_parse_args( $attributes, $defaults );
	
	//* Contextual filter
	return apply_filters( "page_builder_attr_{$context}", $attributes, $context );

}