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
				
				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<?php
					echo firewell_video( get_the_ID() );
					?>
					
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<?php
						$categories = get_the_term_list( get_the_ID(), 'video_category' );
						if ( $categories ) {
							$categories = sprintf( '<span class="category-links">' . esc_html__( '%s' ) . '</span>', $categories );
						}
						printf( '<div class="entry-meta">%s%s</div>', firewell_posted_on(), $categories );
						?>
					</header><!-- .entry-header -->
				
					<div class="entry-content">
					
					<?php						
						the_content();
						
						// PDF
						$pdf = get_post_meta( get_the_ID(), 'pdf', true );
						
						if( $pdf ) {
							$pdf = wp_get_attachment_url( $pdf );
							printf( '<p><a href="%s" class="btn" target="_blank">%s</a></p>', $pdf, 'Download TEAM Feedback' );
						}
						
						// Tags
						$tags_list = get_the_term_list( get_the_ID(), 'video_tag' );
						if ( $tags_list ) {
							printf( '<div class="tags-links">' . esc_html__( '%s' ) . '</div>', $tags_list );
						}
		
						// View all
						printf( '<div class="view-all"><a href="%s">View all</a></div>', get_post_type_archive_link( 'video' ) );
					?>
										
					</div><!-- .entry-content -->

					<?php if ( get_edit_post_link() ) : ?>
						<footer class="entry-footer">
							<?php
								edit_post_link(
									sprintf(
										/* translators: %s: Name of current post */
										esc_html__( 'Edit %s', 'firewell' ),
										the_title( '<span class="screen-reader-text">"', '"</span>', false )
									),
									'<span class="edit-link">',
									'</span>'
								);
							?>
						</footer><!-- .entry-footer -->
					<?php endif; ?>
				</article><!-- #post-## -->

				<?php endwhile; ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
