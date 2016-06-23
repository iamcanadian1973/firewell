<?php

function the_cta_buttons() {
	echo get_cta_buttons();	
}

function get_cta_buttons( $raw = FALSE ) {
	
	// return markup without grid	
	$grid = ' column row';
	
	if( $raw ) {
		$grid = '';
	}
	
	if( have_rows('cta_buttons') ):
	
		$buttons = '';
		
		while( have_rows('cta_buttons') ): the_row();
		   
			$button_text = get_sub_field('button_text');
		   
			if ( get_sub_field('button_link') == 'Page' ) { 
				$link = get_sub_field('choose_page');
			} elseif ( get_sub_field('button_link') == 'Absolute URL' ) {
				$link = get_sub_field('url');
			} 
	
			if ( get_sub_field('button_link') == 'Absolute URL' && get_sub_field('link_target') == 'New Tab') {
				$target= ' target="_blank"';
			} else {
				$target = '';
			};
	
			$buttons .= sprintf('<a class="cta button" href="%s" %s>%s</a>', $link, $target, $button_text );
	
		endwhile;
		
		$button_color = strtolower( get_sub_field( 'button_color' ) ); 
		$reverse_button_color = get_sub_field( 'reverse_button_color' ) ? ' reversed' : ''; 
		
		return sprintf('<div class="column row"><div class="cta-buttons%s %s%s">%s</div></div>', $grid, $button_color, $reverse_button_color, $buttons );
		
	endif;
	
	return FALSE;
}
