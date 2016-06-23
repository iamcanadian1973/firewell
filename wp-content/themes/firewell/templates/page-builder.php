<?php
/**
 * Template Name: Page Builder
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Firewell
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content-page-builder', 'page' );

			endwhile; // End of the loop.
			?>
			
			<?php
			do_action( 'firewell_after_content' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
