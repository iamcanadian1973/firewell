<?php

function get_slideshow( $slides ) {
	
	if( empty( $slides )  ) {
		return FALSE;		
	}
	
	$size = 'slide';
	
	if( function_exists( 'wpmd_is_device' ) ) {
				
		if( wpmd_is_phone() ) {
			$size = 'medium';
		}
		
	}
						
	$items = '';
	   
	foreach( $slides as $slide ): 
												
		$img_attr = wp_get_attachment_image_src( $slide['ID'], $size ); // returns an array
		$caption = '';
								
		// 1500px x 500px
		$items .= sprintf('<a data-rsw="%s" data-rsh="%s" class="rsImg" href="%s">%s</a>', $img_attr[1], $img_attr[2], $img_attr[0], $caption );
	
	endforeach;
		
	return sprintf( '<div class="slideshow"><div id="slider" class="royalSlider rsCustom">%s</div></div>', $items );
  	
}
