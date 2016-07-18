<?php
/**
 * Video Archive
 * 
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Firewell
 */

// check if user is loggedin

if( function_exists( 'firewell_members_protected' ) ) {
	firewell_members_protected();
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			// add teaser from the videos page
			$videos_page_id = 101;
			
			$args = array(
					'post_type'      => 'page',
					'posts_per_page' => 1,
					'post_status'    => 'publish',
					'p'          	 => $videos_page_id
			);

			// Use $loop, a custom variable we made up, so it doesn't overwrite anything
			$loop = new WP_Query( $args );
	
			if( $loop->have_posts() ): 
				while ( $loop->have_posts() ) : $loop->the_post();
	
					get_template_part( 'template-parts/content-page-builder', 'page' );
	
				endwhile; // End of the loop.
				
			endif;
			
			wp_reset_postdata();
			?>
			
			<?php if ( have_posts() ) : ?>
				
				<?php
				$archive_link = get_post_type_archive_link( 'video' );
				$slug = '';
				$term = is_tax() ? 
						get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : 
						FALSE;
				
				if ( ! is_wp_error( $term ) && !empty( $term ) ) {
					$slug = $term->slug;
				}
	
				$current_term = $term ? $slug : '';
				// menu
				$tax = 'video_category';
				$args = array();
				$terms = get_terms($tax, $args);
				
				if ( count( $terms ) ) {
					$current = is_post_type_archive( 'video' ) ? ' class="current-menu-item"' : '';
					$out = sprintf( '<li%s><a href="%s">All Videos</a></li>', $current, $archive_link );
					
					foreach( $terms as $term ) {
						$current = $term->slug == $current_term ? ' class="current-menu-item"' : '';
						$out .= sprintf( '<li%s><a href="%s">%s</a></li>', $current, get_term_link( $term, $tax ), $term->name );
					}
				  	
					printf( '<div class="filter-by"><span>Filter By:</span><ul>%s</ul></div>', $out );
				}
								
				?>
				
				<?php /* Start the Loop */ ?>
 				<?php
				printf( '<ul %s>', 'class="video-grid"' );
				?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php						
						$thumbnail = get_the_post_thumbnail( get_the_ID(), 'video-thumbnail' );
						$title = the_title( '<h3>', '</h3>', FALSE );
						$content = apply_filters( 'the_content', get_the_content() );
						printf( '<li><a href="%s">%s<div>%s%s</div></a></li>',get_permalink(),$thumbnail,  $title, $content );
					?>

				<?php endwhile; ?>

				<?php
				echo '</ul>';
				?>
 			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
