<?php

function layout_recent_posts() {
	
	print( '<article class="hentry">' );
	
	the_headline();
	
	// posts or research?
	
	$post_type = strtolower( get_sub_field( 'post_type' ) );
	$number_of_posts = get_sub_field( 'number_of_posts' );
	
	firewell_recent_posts( $post_type, $number_of_posts );
	
 }
 
 
 
 function firewell_recent_posts( $post_type, $number_of_posts ) {
		
		// arguments, adjust as needed
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => $number_of_posts,
		'post_status'    => 'publish',
 	);
	
	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query( $args );

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ( $loop->have_posts() ) : 
 		while ( $loop->have_posts() ) : $loop->the_post(); 

			get_template_part( 'template-parts/content', $post_type );

		endwhile;
 	endif;

	// We only need to reset the $post variable. If we overwrote $wp_query,
	// we'd need to use wp_reset_query() which does both.
	wp_reset_postdata();	 
 }