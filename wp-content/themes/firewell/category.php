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
			
			$archive_link = get_permalink( $posts_page_id );
			$slug = '';
			$term = is_category() ? 
					get_category( get_query_var( 'cat' ) ) : 
					FALSE;
							
			if ( ! is_wp_error( $term ) && !empty( $term ) ) {
				$slug = $term->slug;
			}
	
			$current_term = $term ? $slug : '';
			// menu
			$tax = 'category';
			$args = array( 'hide_empty' => false );
			$terms = get_terms($tax, $args);
			$out = '';
			
			if ( count( $terms ) ) {
				
				//$out = sprintf( '<li><a href="%s">All News & Upcoming Events</a></li>', $archive_link );
				
				foreach( $terms as $term ) {
					$current = $term->slug == $current_term ? ' class="current-menu-item"' : '';
					$out .= sprintf( '<li%s><a href="%s">%s</a></li>', $current, get_term_link( $term, $tax ), $term->name );
				}
				
				printf( '<div class="filter-by"><span>Filter By:</span><ul>%s</ul></div>', $out );
			}
		?>
		
		<?php
		if ( have_posts() ) : ?>

			
			
			<?php /* Start the Loop */ ?>
			<div class="load-more-wrapper">
         		<div class="load-more-container">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php						
						get_template_part( 'template-parts/content', get_post_format() );
					?>

				<?php endwhile; ?>
				
				</div>
				 <div class="clear"></div>
				 <?php
					the_posts_navigation();
					
					firewell_load_more();
				?>
			  	</div>
		<?php
		else :

			get_template_part( 'template-parts/content', 'no-posts' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
