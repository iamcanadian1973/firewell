<?php

add_action( 'page_builder_group_open', 'group_open' );
add_action( 'page_builder_group_close', 'group_close' );

function group_open() {
	
	if( 'group_open' != get_row_layout() )
		return;
	
	printf( '<div %s>', page_builder_attr( 'group' ) );
	
	print( '<div class="group-wrapper">' );
	
	print( '<div class="group-container">' );
	
	$parallax = get_sub_field( 'parallax_background' );
	
	$background_image = get_sub_field( 'background_image' );
	
	if( $parallax && $background_image ) {
			
		
		
		$size = 'background-image';
			
		if( $background_image ) {
			$attachment_id = $background_image['ID'];
			$background = wp_get_attachment_image_src( $attachment_id, $size );
			$style = sprintf( ' style="background-image:url(%s);"', $background[0] );
			printf('<div class="full-bg-image full-bg-image-fixed"%s></div>', $style );

		}
		
	}
	if( $background_image && !$parallax ) {
		$image = wp_prepare_attachment_for_js( $background_image['ID'] );
		$caption = $image['caption'];
		
		if( $caption ) {
			printf( '<div class="caption">%s</div>', $caption );
		}
	}
		

	
}


function group_close() {

	global $post;
	
	if( 'group_close' != get_row_layout() )
		return;
		
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
}
