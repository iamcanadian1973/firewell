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
		
		echo '<div class="column-wrap">';
		
		echo '<div class="column">';
		$link = get_category_link(1);
		$news_args = wp_parse_args( array( 'cat' => 1 ), $args );
		_firewell_recent_posts( $news_args, $number_of_posts, 'News', $link );
		echo '</div>';
		
		echo '<div class="column">';
		$link = get_category_link(19);
		
		$meta_query = array(				
				array(
				'key' => 'event_end_date',
				'value' => (int) date( 'Ymd' ),
				'compare' => '>='
				)
			);
		
		$event_args = array( 'cat' => 19,
							 'orderby' => 'meta_value_num',
							 'order' => 'ASC',
							 'meta_query' => $meta_query,
							 'meta_key' => 'event_start_date' );
		
		$events_args = wp_parse_args( $event_args, $args );
		_firewell_recent_posts( $events_args, $number_of_posts, 'Events', $link );
		echo '</div>';
		
		echo '</div>';
		
	}
	else {
		_firewell_recent_posts( $args, $number_of_posts );
	}
	 
 }
 
 
 function _firewell_recent_posts( $args, $number_of_posts, $subtitle = '', $link = '' ) {
		
	
	$post_type = $args['post_type'];
	
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
 		
		if( $subtitle ) {
			
			$link_before = '';
			$link_after = '';
			
			if( $link ) {
				$link_before = sprintf( '<a href="%s">', $link );
				$link_after = '</a>';
			}
			
			printf( '<h3>%s%s%s</h3>', $link_before, $subtitle, $link_after );
			
		}
		
		while ( $loop->have_posts() ) : $loop->the_post(); 

			get_template_part( 'template-parts/content', $post_type );

		endwhile;
 	endif;

	// We only need to reset the $post variable. If we overwrote $wp_query,
	// we'd need to use wp_reset_query() which does both.
	wp_reset_postdata();		 
 }