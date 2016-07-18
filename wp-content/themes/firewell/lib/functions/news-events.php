<?php
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
		
			$query->set( 'meta_query', $meta_query );
			
			
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
	
	}
}