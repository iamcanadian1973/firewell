<?php

function related_links() {
	
	$out = '';
	
	if( have_rows('related_links') ):

		// loop through the rows of data
		while ( have_rows('related_links') ) : the_row();
	
			$text = get_sub_field('link_title');
			$link = get_sub_field('url');
			$out .= sprintf( '<li><a href="%s">%s</a></li></li>', $link, $text );
	
		endwhile;
		
		return sprintf( '<h4>Related Links</h4><ul>%s</ul>', $out );
		
	
	else :
	
		return FALSE;
	
	endif;
	
}