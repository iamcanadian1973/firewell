<?php

function layout_services() {
	
	printf( '<article class="row entry">%s<div class="small-12 columns entry-content">%s%s</div></article>', 
			get_headline(), 
			get_services(),
			get_cta_buttons()
		);
	
 }
 
 
 
 
 function get_services() {

	if( have_rows('grid') ):
			
		$logos = '';
		
		while( have_rows('grid') ): the_row();
		   
			$url = get_sub_field('url');
			
			$anchor = get_sub_field( 'anchor' );
			
			$image = get_sub_field( 'image' );
			
			$heading = get_sub_field( 'heading' );
			
			$heading = sprintf( '<h4 data-equalizer-watch="bar">%s</h4>', $heading );
			
			$text = get_sub_field( 'content' );
		
			if( $image ) {
				$size = 'medium';
				$attachment_id = $image['ID'];
				$image = wp_get_attachment_image( $attachment_id, $size, '' );
			}
			
			if( $image ) {
				
				$anchor_open = $url ? sprintf( '<a href="%s" target="_blank">', $url) : '';
				$anchor_close = $url ? '</a>' : '';
				$button = '';
				
				if( $url ) {
					
					$url = trailingslashit( $url );
					$url = sprintf( '%s%s', $url, $anchor );
					
					$button = sprintf( '<a href="%s">%s</a>', $url, 'Learn more' );	
				}
				
				$logos .= sprintf('<div class="column"><div data-equalizer-watch data-equalizer-mq="medium-up"><span data-equalizer="bar">%s%s%s%s</span></div></a></div>', $image, $heading, $text, $button );
			}
			
	
		endwhile;
		
		
		return sprintf('<div class="row small-up-1 medium-up-2 large-up-4" data-equalizer>%s</div>', $logos );
		
	endif;
	 
 }