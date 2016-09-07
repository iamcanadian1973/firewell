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
		'post_status'    => 'publish',
 	);
	
	if( $post_type == 'post' ) {
		$args['orderby'] = 'meta_value date';
		$args['meta_key'] = 'event_start_date';
		$args['meta_type'] = 'DATE date';
		$args['cat'] = '-20 date';
	}
	
	
	$sticky_posts = get_option( 'sticky_posts' );
	
	
	
	if (is_array($sticky_posts) ) {

        // counnt the number of sticky posts
        $sticky_count = count($sticky_posts);
		
        // and if the number of sticky posts is less than
        // the number we want to set:
        if ($sticky_count < $number_of_posts ) {
            $args['posts_per_page'] = $number_of_posts - $sticky_count;
		}
		else {
			$args['post__in'] = get_option('sticky_posts');
		}
	}
	
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