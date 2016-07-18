<?php


function kr_body_class( $classes ) {
  if( is_home()|| is_category() || is_post_type_archive( 'research' ) )
  	$classes[] = 'load-more-posts';
  return $classes;
}
add_filter( 'body_class', 'kr_body_class' );


function firewell_load_more_posts() {

	print( '<div class="more-posts"></div>' );
	
}

/**
 * AJAX Load More 
 * @link http://www.billerickson.net/infinite-scroll-in-wordpress
 */
function be_ajax_load_more() {
	
	check_ajax_referer( 'be-load-more-nonce', 'nonce' );
	
	$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	$args['paged'] = esc_attr( $_POST['page'] );
	$args['posts_per_page'] = esc_attr( $_POST['posts_per_page'] );
	$args['post_status'] = 'publish';
	$args['ignore_sticky_posts'] = true;  
    $args['post__not_in'] = get_option('sticky_posts'); 
	$args['post_type'] = esc_attr( $_POST['post_type'] );	    
	
	ob_start();
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
		get_template_part( 'template-parts/content', $args['post_type'] );
	endwhile; endif; wp_reset_postdata();
	$data = ob_get_clean();
 	wp_send_json_success( $data );
	wp_die();
}
add_action( 'wp_ajax_be_ajax_load_more', 'be_ajax_load_more' );
add_action( 'wp_ajax_nopriv_be_ajax_load_more', 'be_ajax_load_more' );

/**
 * Javascript for Load More
 *
 */
function be_load_more_js() {
	 
	 if( is_single() )
	 	return false;
	 
	  global $wp_query;
	  
	  $posts_per_page = get_option( 'posts_per_page' );
	  $found_posts = $wp_query->found_posts;
	  
	  $args = array(
		'nonce' => wp_create_nonce( 'be-load-more-nonce' ),
		'url'   => admin_url( 'admin-ajax.php' ),
		'page' => 2,
		'posts_per_page' => $posts_per_page,
		'show_load_more' => $found_posts > get_option( 'posts_per_page' ) ? TRUE : FALSE,
		'query' => $wp_query->query,
		'post_type' => $wp_query->query_vars['post_type'] ? $wp_query->query_vars['post_type'] : 'post'
	  );


			
	wp_enqueue_script( 'be-load-more', CHILD_THEME_JS . '/load-more.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'be-load-more', 'beloadmore', $args );
	
}
add_action( 'wp_enqueue_scripts', 'be_load_more_js' );