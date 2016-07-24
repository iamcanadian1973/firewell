<?php

// Out put firewell video based on video type selected
function firewell_video( $post_id ) {

	$video_type = get_field( 'video_type', $post_id );
	
	if( 'Dartfish' == $video_type ) {
		// Dartfish
		$video = firewell_dartfish_video( $post_id );
	}
	else {
		// YouTube/Vimeo
		$video = firewell_default_video_embed( $post_id );
	}
	
	return $video;
	
}

// Dartfish custom video embed
function firewell_dartfish_video( $post_id ) {
	
	$video_embed_code = get_post_meta( $post_id, 'video_embed_code', true );
					
	if( $video_embed_code ) {
		
		$video_args = array(
				'CR' => $video_embed_code,
				'VW' => '100%',
				'VH' => '100%'
		); 
		
		$video_url = add_query_arg( $video_args, '//www.dartfish.tv/Embed.aspx?' );
		
		return sprintf( '<div class="embed-container">
				<iframe src="%s" frameborder="0" allowfullscreen="allowfullscreen">
				</iframe></div>',$video_url );
	}
}

// Default Video embed for YouTube/Vimeo
function firewell_default_video_embed( $post_id ) {
	$video_embed = get_field( 'video_url', $post_id );
	if( $video_embed ) {
		return acf_oembed( $video_embed );
	}
}
					