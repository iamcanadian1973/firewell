<?php

function firewell_video_template_redirect( $template ) {
	if ( is_tax( 'video_category' ) || is_tag( 'video_tag' ) ) 
		$template = get_query_template( 'archive-video' );	
	return $template;
}
add_filter( 'template_include', 'firewell_video_template_redirect' );	



function firewell_research_template_redirect( $template ) {
	if ( is_tax( 'research_category' ) || is_tag( 'research_tag' ) ) 
		$template = get_query_template( 'archive-research' );	
	return $template;
}
add_filter( 'template_include', 'firewell_research_template_redirect' );	