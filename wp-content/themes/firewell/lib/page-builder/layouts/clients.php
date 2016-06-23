<?php

function layout_clients() {
	
	add_action( 'pb_content_block', 'the_headline' );
	add_action( 'pb_content_block', 'the_grid' );
	add_action( 'pb_content_block', 'the_cta_buttons' );
	
	print( '<article class="entry"><div class="entry-content">' );
	
	do_action( 'pb_content_block' );
	
	print( '</div></article>' );
	
 }
 
 function the_grid() {
	 echo get_grid();
 }
 
 
 function get_grid() {

	if( have_rows('grid') ):
			
		$logos = '';
		
		while( have_rows('grid') ): the_row();
		   
			$url = get_sub_field('url');
			
			$image = get_sub_field( 'image' );
		
			if( $image ) {
				$size = 'medium';
				$attachment_id = $image['ID'];
				$image = wp_get_attachment_image( $attachment_id, $size, '' );
			}
			
			if( $image ) {
				
				$anchor_open = $url ? sprintf( '<a href="%s" target="_blank">', $url) : '';
				$anchor_close = $url ? '</a>' : '';
				
				$logos .= sprintf('<div class="column"><div data-equalizer-watch data-equalizer-mq="medium-up"><span>%s%s%s</span></div></a></div>', $anchor_open, $image, $anchor_close );
			}
			
	
		endwhile;
		
		
		return sprintf('<div class="row small-up-1 medium-up-2 large-up-4" data-equalizer>%s</div>', $logos );
		
	endif;
	 
 }