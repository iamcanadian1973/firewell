<?php
/**
 * Research Single
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

					<?php
						get_template_part( 'template-parts/content', 'research' );
					?>

				<?php endwhile; ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
