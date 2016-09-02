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
			
			<?php if ( have_posts() ) : ?>
				
				<?php
 				
				$archive_link = get_post_type_archive_link( 'research' );
				$slug = '';
				$term = is_tax() ? 
						get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : 
						FALSE;
				
				if ( ! is_wp_error( $term ) && !empty( $term ) ) {
					$slug = $term->slug;
				}
	
				$current_term = $term ? $slug : '';
				// menu
				$tax = 'research_category';
				$args = array();
				$terms = get_terms($tax, $args);
				
				if ( count( $terms ) ) {
					$current = is_post_type_archive( 'research' ) ? ' class="current-menu-item"' : '';
					$out = sprintf( '<li%s><a href="%s">All Research</a></li>', $current, $archive_link );
					
					foreach( $terms as $term ) {
						$current = $term->slug == $current_term ? ' class="current-menu-item"' : '';
						$out .= sprintf( '<li%s><a href="%s">%s</a></li>', $current, get_term_link( $term, $tax ), $term->name );
					}
				  	
					printf( '<div class="filter-by"><span>Filter By:</span><ul>%s</ul></div>', $out );
				}
								
				?>
				
				<?php /* Start the Loop */ ?>
				
				<div class="load-more-wrapper">
         		<div class="load-more-container">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php						
						get_template_part( 'template-parts/content', 'research' );
					?>

				<?php endwhile; ?>
				
				</div>
				 <div class="clear"></div>
				 <?php
					the_posts_navigation();
					
					firewell_load_more();
				?>
			  	</div>
				
				

 			<?php endif; ?>
			
			

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
