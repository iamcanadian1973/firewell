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
			$heading = get_field( 'video_heading', 'option' );
			$heading = $heading ? $heading : 'Videos';
			$content = get_field( 'video_intro_text', 'option' );
			
			$featured_video_id = get_field( 'featured_video', 'option' );
			$featured_video = firewell_video( $featured_video_id );
			
			// Show featured video to users not logged in
			if( $featured_video && !firewell_is_member() ) {
				$excerpt = firewell_excerpt( false, false );
				$content .= sprintf( '<div class="featured-video"><div class="video-box">%s</div><div class="excerpt">%s</div></div>', $featured_video, $excerpt );
			}
			
			printf( '<section class="section section-archive-description"><div class="section-wrapper"><div class="section-container"><header class="entry-header"><h2 class="section-title" itemprop="headline"><span>%s</span></h2></header><div class="entry-content">%s</div></div></div></section>', $heading, $content );
			?>
			
			<?php
			// let's make sure they're allowd to see the videos
			if( !firewell_is_member() ) {
				echo firewell_members_only_message();
			}
			
			if ( have_posts() && firewell_is_member() ) : ?>
				
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
						$thumbnail = get_the_post_thumbnail( get_the_ID(), 'medium' );
						$title = the_title( '<h3>', '</h3>', FALSE );
						// get excerpt
						$content = firewell_excerpt( false, false );
						printf( '<li><a href="%s">%s<div>%s%s</div></a></li>',get_permalink(),$thumbnail,  $title, $content );
					?>

				<?php endwhile; ?>

				<?php
				echo '</ul>';
				?>
 			<?php 
			endif; 
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
