<?php

/*
ToDo: wrap sections Genesis style like they do withte wrap class
*/
	
function page_builder_get_content_blocks() {

	global $post, $show_members_only_content_message;
	
	if ( have_rows('content_blocks') ) {
	
		while ( have_rows('content_blocks') ) { 
		
			the_row();
		
			$row_layout = get_row_layout();
			
			$show_members_only_content_message = false;
			
			// TODO: check if layout exists/exclude groups
			if( !function_exists( "layout_{$row_layout}" ) ) {
				_log( "Page Builder Warning: function layout_{$row_layout}() does not exist. Check for included file in \"layouts folder\"" );
				//continue;
			}
			
			do_action( 'page_builder_group_open' );
			
				// Is the page restricted? If so only show content blocks that are set to visible
				if( !members_can_current_user_view_post( get_the_ID() ) ) {
					
					$visibility = get_sub_field( 'visibility' );
					
					if( $visibility == 'Members Only' ) {
						$show_members_only_content_message = true;
						continue;
						
					}
				}
				
				do_action( 'page_builder_before_section' );
				
				printf( '<section %s>', page_builder_attr( 'section' ) );
										
					print( '<div class="section-wrapper">' );
						print( '<div class="section-container">' );	
				
							do_action( 'page_builder_before_layout' );	
					
							call_user_func( "layout_{$row_layout}" );						
					
							do_action( 'page_builder_after_layout' );
							
						print( '</div>' );
					print( '</div>' );				
					
				echo '</section>'; //* end section
				
				do_action( 'page_builder_after_section');	
						
			
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