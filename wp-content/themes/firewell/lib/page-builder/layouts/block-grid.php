<?php

function layout_block_grid() {
	
	printf( '<article class="column row entry">%s%s</article>', 
			get_headline(), 
			get_block_grid()
		);
	
 }
 
 
 
 
 function get_block_grid() {

	
	$show_buttons = get_sub_field( 'show_buttons' );
	
	if( have_rows('grid') ):
			
		$out = '';
		
		while( have_rows('grid') ): the_row();
		   			
			$attachment_id = get_sub_field( 'image' );
			$size = 'large';
			$image = '';
			
			$heading = sprintf( '<h4>%s</h4>', get_sub_field( 'heading' ) );			
			
			$content =  get_sub_field( 'content' );
			
			$button_text = get_sub_field('button_text');
			
			$page = get_sub_field('choose_page');
			
			$url = get_sub_field('url');
			
			if( $url ) {
				$page = $url;
			}
			
		
			if( $attachment_id ) {
				$image = wp_get_attachment_image( $attachment_id, $size, '' );				
			}
			
			$anchor_open = $page ? sprintf( '<a href="%s">', $page) : '';
			$anchor_close = $page ? '</a>' : '';
			$cta = '';
									
			if( $show_buttons ) {
				$anchor_open = $anchor_close = '';	
				if( $page && $button_text ) {
					$cta = sprintf( '<p><a href="%s">%s</a></p>', $page, $button_text );	
				}
			}
			
				
			$out .= sprintf('<li><div>%s%s%s%s%s%s</div></li>', 
				$anchor_open, 
				$image, 
				$heading, 
				$content,
				$cta,
				$anchor_close
				);
			
	
		endwhile;
		
		
		return sprintf('<div class="grid"><ul>%s</ul></div>', $out );
		
	endif;
	 
 }