<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Firewell
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<header class="page-header">
		<?php
			//the_archive_title( '<h1 class="page-title">', '</h1>' );
			$posts_page_id = get_option( 'page_for_posts');
			printf( '<h1 class="page-title">%s</h1>', get_the_title( $posts_page_id ) );
			echo get_post_field( 'post_content', $posts_page_id );
			
		?>
		</header><!-- .page-header -->
		
		<?php
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
	   
		$args = array(
		'post_type' => 'post',
		//'posts_per_page' => 1,
		'orderby' => 'meta_value_num',
		'order'  => 'DESC',
		'cat'    => 19,
		'meta_query'  => $meta_query,
		'meta_key'  => 'event_start_date',
		'paged'          => get_query_var( 'paged' )
		
		);
		
		global $wp_query;
		$wp_query = new WP_Query( $args );
	
		if ( have_posts() ) : ?>

			<?php
			
			$archive_link = get_permalink( $posts_page_id );
				$slug = '';
				$term = is_tax() ? 
						get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : 
						FALSE;
				
				if ( ! is_wp_error( $term ) && !empty( $term ) ) {
					$slug = $term->slug;
				}
	
				$current_term = $term ? $slug : '';
				// menu
				$tax = 'category';
				$args = array( 'hide_empty' => false );
				$terms = get_terms($tax, $args);
				
				if ( count( $terms ) ) {
					$out = sprintf( '<li><a href="%s">All News & Upcoming Events</a></li>', $archive_link );
					
					foreach( $terms as $term ) {
						$current = $term->slug == $current_term ? ' class="current-menu-item"' : '';
						$out .= sprintf( '<li%s><a href="%s">%s</a></li>', $current, get_term_link( $term, $tax ), $term->name );
					}
				  	
					printf( '<div class="filter-by"><span>Filter By:</span><ul>%s</ul></div>', $out );
				}
			?>
			
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; 
		
		
		wp_reset_query();
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
