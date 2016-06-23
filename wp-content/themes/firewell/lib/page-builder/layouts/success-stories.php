<?php
/*
Layout function: must be prefixed with layout and named anfter row layout
*/

function layout_stories() {
	printf( '<article class="row entry">%s<div class="small-12 columns entry-content">%s</div></article>', 
			get_headline(), 
			get_success_stories()
		);
}
 
 
 function get_success_stories() {
	
	// use helper function to get post types
	$filter_by = get_sub_field( 'filter_by' ); 
	$posts_per_page = get_sub_field( 'posts_per_page' ); 
	
	$args = array(
	
		'post_type'      => 'story',
		'posts_per_page' => $posts_per_page,
		'post_status'    => 'publish'
	
	);
	
	
	if( $filter_by == 'Featured' ) {
		$args['meta_query'] = array(
				array(
					'key' => '_featured',
					'value' => 1,
					'compare' => '=='
				)
			);
	}
	
	$out = '';	
				
	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query( $args );

	if( $loop->have_posts() ) :
		
		
		
		$out .= sprintf( '<div %s>', 'class="row small-up-1  large-up-3"' );
						
		while ( $loop->have_posts() ) : $loop->the_post(); 
				
			global $post;
			
			$out .= '<div class="column">';
			
			$out .= story_get_thumbnail();
			
			$out .= sprintf( '<div %s>', 'class="entry"' );
			
			$out .= sprintf( '<div class="entry-header"><h2 class="entry-title"><a href="%s">%s</a></h2></div>', get_permalink(), get_the_title() );
			$out .= sprintf( '<div %s>', genesis_attr( 'entry-content' ) );
			$out .= story_get_excerpt();
			$out .= '</div>'; //* end .entry-content
			
			$out .= '</div>';
			
			$out .= '</div>';
							
		endwhile;
					
		$out .= '</div>';
						
	endif;
		
	wp_reset_postdata();
	
	return $out;
		
 }


function story_get_thumbnail() {
	$thumbnail = get_the_post_thumbnail( get_the_ID(), 'post-thumbnail' );
	if( $thumbnail )
		return sprintf('<a href="%s">%s</a>', get_permalink(), $thumbnail );		
}

function story_get_excerpt() {
	
	global $post;
	
	$post_content = $post->post_content;
    $post_excerpt = $post->post_excerpt;
                    
    if( strstr( $post_content,'<!--more-->') ) {
        $content_arr = get_extended ( $post_content );
        $excerpt =  $content_arr['main'];
    }
    elseif( $post_excerpt) {
        $excerpt = $post_excerpt;
    }
    else {
        $excerpt = wp_trim_words( $post_content, 20, '');
    }
	
	$read_more = sprintf( ' <strong><a href="%s">%s</a></strong>', get_permalink(), 'read more...' );
                        
    return 	wpautop( sprintf( '%s%s', $excerpt, $read_more ) );
}