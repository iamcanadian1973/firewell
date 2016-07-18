<?php

function layout_callout() {
	
	
	print( '<article class="hentry">' );
			
	$attachment_id = get_sub_field( 'image' );
	echo pb_get_image( $attachment_id );
		
	$visual_editor = get_sub_field( 'visual_editor' );
	printf( '<div class="entry-content">%s</div>', $visual_editor );
	
	the_cta_buttons();
	
	print( '</article>' );
	
 }
 
 
