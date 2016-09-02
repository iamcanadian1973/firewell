<?php
// Add columns to Blog
add_filter('manage_post_posts_columns' , 'add_post_columns');
 
function add_post_columns($columns) {
     return array_merge($columns,
          array('event_start' => 'Event Start', 'event_end' => 'Event End' ));
}
 
add_action('manage_posts_custom_column' , 'post_custom_columns', 10, 2 );
 
function post_custom_columns( $column, $post_id ) {
    switch ( $column ) {
		case 'event_start' :
			echo get_field( 'event_start_date' );
			break;
		case 'event_end' :
			echo get_field( 'event_end_date' );
			break;
    }
}

function set_expiry_date( $post_id ) {

  // See if an event_end_date or event_date has been entered and if not then end the function
  if( get_post_meta( $post_id, $key = 'event_end_date', $single = true ) ) {

    // Get the end date of the event in unix grenwich mean time
    $acf_end_date = get_post_meta( $post_id, $key = 'event_end_date', $single = true );

  } elseif ( get_post_meta( $post_id, $key = 'event_start_date', $single = true ) ) {

    // Get the start date of the event in unix grenwich mean time
    $acf_end_date = get_post_meta( $post_id, $key = 'event_start_date', $single = true );

  } else {

    // No start or end date. Lets delete any CRON jobs related to this post and end the function.
    wp_clear_scheduled_hook( 'make_past_event', array( $post_id ) );
    return;

  }
  
  // Current time taking into consideration the WP timezone settings.
  $current_time =  current_time( 'timestamp' );

  // Convert our date to the correct format  
  // get datetime object from site timezone
  $datetime = new DateTime( $acf_end_date, new DateTimeZone( wp_get_timezone_string() ) );
 
  // get the unix timestamp (adjusted for the site's timezone already)
  $timestamp = $datetime->format( 'U' );
  
  // Fixing old events. Really only works while testing
  /*
  if( $current_time >= $timestamp ) {
	  set_past_event_category( $post_id );
	  return;
  }
  */
 

  // Get the number of seconds in a day
  $delay = 24 * 60 * 60; //24 hours * 60 minutes * 60 seconds

  // Add 1 day to the end date to get the day after the event
  $day_after_event = $timestamp + $delay;
  
  // Set to beginning of next day
  $day_after_event =  strtotime('0:00', $day_after_event );

  // Temporarily remove from 'Past Event' category
  wp_remove_object_terms( $post_id, 'past-events', 'category' );

  // If a CRON job exists with this post_id them remove it
  wp_clear_scheduled_hook( 'make_past_event', array( $post_id ) );
  // Add the new CRON job to run the day after the event with the post_id as an argument
  wp_schedule_single_event( $day_after_event , 'make_past_event', array( $post_id ) );

}


// Hook into the save_post_{post-type} function to create/update the cron job everytime an event is saved.
add_action( 'acf/save_post', 'set_expiry_date', 20 );


// Create a function that adds the post to the past-events category
function set_past_event_category( $post_id ){

  // Set the post category to 'Past Event'
  return wp_set_post_categories( $post_id, array( 20 ) );

}

// Hook into the make_past_event CRON job so that the set_past_event_category function runs when the CRON job is fired.
add_action( 'make_past_event', 'set_past_event_category' );


/**
 * Returns the timezone string for a site, even if it's set to a UTC offset
 *
 * Adapted from http://www.php.net/manual/en/function.timezone-name-from-abbr.php#89155
 *
 * @return string valid PHP timezone string
 */
function wp_get_timezone_string() {
 
    // if site timezone string exists, return it
    if ( $timezone = get_option( 'timezone_string' ) )
        return $timezone;
 
    // get UTC offset, if it isn't set then return UTC
    if ( 0 === ( $utc_offset = get_option( 'gmt_offset', 0 ) ) )
        return 'UTC';
 
    // adjust UTC offset from hours to seconds
    $utc_offset *= 3600;
 
    // attempt to guess the timezone string from the UTC offset
    if ( $timezone = timezone_name_from_abbr( '', $utc_offset, 0 ) ) {
        return $timezone;
    }
 
    // last try, guess timezone string manually
    $is_dst = date( 'I' );
 
    foreach ( timezone_abbreviations_list() as $abbr ) {
        foreach ( $abbr as $city ) {
            if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset )
                return $city['timezone_id'];
        }
    }
     
    // fallback to UTC
    return 'UTC';
}

// https://multiplestates.wordpress.com/2016/01/06/scheduling-a-category-change-based-on-an-advanced-custom-field-value-when-a-post-is-saved-using-a-wordpress-cron-job/

if( ! function_exists( 'fix_no_editor_on_posts_page' ) ) {

    /**
     * Add the wp-editor back into WordPress after it was removed in 4.2.2.
     *
     * @param Object $post
     * @return void
     */
    function fix_no_editor_on_posts_page( $post ) {
        if( isset( $post ) && $post->ID != get_option('page_for_posts') ) {
            return;
        }

        remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
        add_post_type_support( 'page', 'editor' );
    }
    add_action( 'edit_form_after_title', 'fix_no_editor_on_posts_page', 0 );
 }

add_action( 'pre_get_posts', 'firewell_event_query' );
function firewell_event_query( $query ) {
	
	if ( $query->is_main_query() && !is_admin() ) {	
		
		if( is_home() ) {
			
			$meta_query = array(
				'relation' => 'OR',
				
				array(
				'key' => 'event_end_date',
				'value' => (int) date( 'Ymd' ),
				'compare' => '>='
				),
				array(
					'key' => 'event_start_date',
					'compare' => 'EXISTS',
					'value' => ''
				)
			);
		
			//$query->set( 'meta_query', $meta_query );
			$query->set( 'orderby', 'meta_value date' );
			$query->set( 'meta_key', 'event_start_date' );
			$query->set( 'meta_type', 'DATE' );
			$query->set( 'cat', '-20' );
			
		}
		elseif( is_category( 'news' ) ) {
			$meta_query = array(
				array(
					'key' => 'event_start_date',
					'compare' => 'EXISTS',
					'value' => ''
				)
			);
		
			$query->set( 'meta_query', $meta_query );
			//$query->set( 'cat', '1,19,20' );
		}
		elseif( is_category( 'upcoming-events' ) ) {
			$meta_query = array(				
				array(
				'key' => 'event_end_date',
				'value' => (int) date( 'Ymd' ),
				'compare' => '>='
				)
			);
		
			$query->set( 'meta_query', $meta_query );
			
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'ASC' );
			$query->set( 'meta_query', $meta_query );
			$query->set( 'meta_key', 'event_start_date' );
			
			//$query->set( 'cat', '1,19,20' );
		}
		elseif( is_category( 'past-events' ) ) {
			$meta_query = array(
				'relation' => 'AND',
				array(
					'key' => 'event_end_date',
					'value' => (int) date( 'Ymd' ),
					'compare' => '<'
				),
				array(
					'key' => 'event_start_date',
					'compare' => '!=',
					'value' => ''
				)
			);
					
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'DESC' );
			$query->set( 'meta_query', $meta_query );
			$query->set( 'meta_key', 'event_start_date' );
		}
	
	}
}

/*
add_filter( 'request', function( $query_vars ) {

  // triggered also in admin pages
  if ( is_admin() )
    return $query_vars;

  if ( $query_vars['category_name'] == 'past-events'  && ! isset($query_vars['error']) ) {
     $query_vars = array('category_name' => 'upcoming-events');
  }

  return $query_vars;

});
*/


function firewell_excerpt( $more = '<span class="meta-nav">&#8230;</span>', $show_read_more = true ) {
	
	global $post;
	$post_content = $post->post_content;
    $post_excerpt = $post->post_excerpt;
	
	$out = '';
                    
    if( strstr( $post_content,'<!--more-->') ) {
        $content_arr = get_extended ( $post_content );
		$excerpt = sprintf( '%s%s', $content_arr['main'], $more );
    }
    elseif( $post_excerpt ) {
        $excerpt = sprintf( '%s%s', $post_excerpt, $more );
    }
    else {
        $excerpt = wp_trim_words( $post_content, 40, $more );
    }
	
	                    
   	if( $show_read_more ) {
		$out =  wpautop( sprintf( '%s <a href="%s">Read More</a>', $excerpt, get_permalink() ) );
	}	
	else {
		$out =  wpautop( $excerpt );
	}
	
	
	return $out;
}