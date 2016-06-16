<?php

add_filter( 'be_events_manager_metabox_override', '__return_true' );

add_post_type_support('events', 'thumbnail');
add_post_type_support('events', 'excerpt');
add_post_type_support('events', 'genesis-cpt-archives-settings');
//add_theme_support( 'be-events-calendar', array('event-category') );


function event_date() {
	
	global $post;
	
	$start = get_post_meta( get_the_ID(), 'be_event_start', true );
    $end = get_post_meta( get_the_ID(), 'be_event_end', true );

    // Only a start date
    if( empty( $end ) )
        $date = date( 'F j, Y', $start );

    // Same day
    elseif( date( 'F j', $start ) == date( 'F j', $end ) )
        $date = date( 'F j, Y', $start );

    // Same Month
    elseif( date( 'F', $start ) == date( 'F', $end ) )
        $date = date( 'F j', $start ) . '-' . date( 'j, Y', $end );

    // Same Year
    elseif( date( 'Y', $start ) == date( 'Y', $end ) )
        $date = date( 'F j', $start ) . '-' . date( 'F j, Y', $end );

    // Any other dates
    else
        $date = date( 'F j, Y', $start ) . '-' . date( 'F j, Y', $end );	
		
	return $date;
}

function event_time() {
	
	$start = get_post_meta( get_the_ID(), 'be_event_start', true );
    
	$end = get_post_meta( get_the_ID(), 'be_event_end', true );
	
	// Only a start date and no time
    if( date( 'g:i a', $start ) == '12:00 am'  )
        $time = '';

    // Same date, same am/pm
    elseif( date( 'F j', $start ) == date( 'F j', $end ) && date( 'a', $start ) == date( 'a', $end ) )
        $time = date( 'g:i', $start ) . '&mdash;' . date( 'g:i a', $end );

    // Same date, different am/pm
    elseif( date( 'F j', $start ) == date( 'F j', $end ) )
        $time = date( 'g:i a', $start ) . '&mdash;' . date( 'g:i a', $end );

    // different date
    else
        $time = date( 'g:i a', $start ) . '&mdash;' . date( 'F j, g:i a', $end );

    return $time;
}
