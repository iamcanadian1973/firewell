<?php

function the_cta_buttons() {
	echo get_cta_buttons();	
}

function get_cta_buttons( $raw = FALSE ) {
	
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
				
		return sprintf('<div class="cta-buttons">%s</div></div>', $buttons );
		
	endif;
	
	return FALSE;
}
