<?php

add_action( 'firewell_before_footer', function() {
	
 	/*
	Featured image/Content - CTA buttons and content visibility.
	
	posts_archive : "News and Events" Archive
	video_archive : "Videos" Post Type Archive
	research_archive : "Research" Post Type Archive
	single_video : Each Individual Video
	single_research : Each Individual Research
	single_post : Each Individual News / Event Post 
	
	*/
	
	// Where are we now?
	$where = firewell_footer_cta_location();
	global $post;
	$post_id = '';
	
	if( is_singular() )
		$post_id = $post->ID;
	
	
	// arguments, adjust as needed
	$args = array(
		'post_type'      => 'footer_cta',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
	);

	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query( $args );

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ( $loop->have_posts() ) : 
 		while ( $loop->have_posts() ) : $loop->the_post(); 
			
			$show = false;
			
			// TEMPLATES
 			$template = get_field( 'template' );			
			if( is_array( $template ) && in_array( $where, $template ) ) {
				$show = true;
			}
			
			// PAGES
			$page = get_field( 'page' );
			
			if( $where == 'page' ) {
				if( is_array( $page ) && in_array( $post_id, $page ) ) {
					$show = true;
				}
			}
			
			/*
			
			TODO: Only show one
			
			
			*/
			$visibility = strtolower( str_replace( ' ', '_', get_field( 'visibility' ) ) );
						
			
			// is this for members only?
			if( ( $visibility == 'members_only' ) && !firewell_is_member() ) {
				$show = false;
			}
			
			
			if( $show ) {
				echo get_footer_cta();
 			}

		endwhile;
 	endif;

	// We only need to reset the $post variable. If we overwrote $wp_query,
	// we'd need to use wp_reset_query() which does both.
	wp_reset_postdata();
	
});

// Where are we?

function firewell_footer_cta_location() {
	
	$where = '';
	
	if( is_home() || is_category() || is_tag() ) {
		$where = 'posts_archive';
	}
	if( is_post_type_archive( 'research' ) || is_tax( 'research_category' ) || is_tax( 'research_tag' ) ) {
		$where = 'research_archive';
	}
	else if( is_post_type_archive( 'video' ) || is_tax( 'video_category' ) || is_tax( 'video_tag' ) ) {
		$where = 'video_archive';
	}
	else if( is_singular( 'research' ) ) {
		$where = 'single_research';
	}
	else if( is_singular( 'video' ) ) {
		$where = 'single_video';
	}
	else if( is_singular( 'post' ) ) {
		$where = 'single_post';
	}
	else if( is_page() ) {
		$where = 'page';
	}
	
	return $where;
	
}


function get_footer_cta() {

	$post_id = get_the_ID();
	$img = get_the_post_thumbnail( $post_id, 'full', '' );
	$title = sprintf( '<h2>%s</h2>', get_the_title() );
	$content = apply_filters( 'the_content', get_the_content() );
	$cta_buttons = get_footer_cta_buttons( $post_id );
	
	return sprintf( '<section class="section section-footer-callout" id="footer-callout-%s"><div class="section-wrapper"><div class="section-container">%s<div class="entry-content">%s%s</div>%s</div></div></section>', $post_id, $img, $title, $content, $cta_buttons  );
	
}

function get_footer_cta_buttons( $post_id ) {
	
	if( have_rows('cta_buttons', $post_id ) ):
	
		$buttons = '';
		
		while( have_rows('cta_buttons', $post_id ) ): the_row();
		   
			$button_text = get_sub_field('button_text');
			
			$link = '';
		   
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
				
		return sprintf('<div class="cta-buttons">%s</div>', $buttons );
		
	endif;
	
	return FALSE;
}
