<?php

add_action( 'firewell_before_footer', function() {
	
	/*
	Featured image/Content - CTA buttons and content visibility.
	
	pages
	posts
	Video Archive
	Research Archive
	videos
	research
	
	*/
	
	
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

			//echo get_footer_cta();

		endwhile;
 	endif;

	// We only need to reset the $post variable. If we overwrote $wp_query,
	// we'd need to use wp_reset_query() which does both.
	wp_reset_postdata();
	
});


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
