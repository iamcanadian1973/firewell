<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Firewell
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		
		<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'menu_id'        => 'footer-menu',
				'container'       => 'span',
				'menu_class'     => 'menu',
				'items_wrap'      => '%3$s',
				'link_before'     => '<span>',
				'link_after'      => '</span>',
				'depth'           => 0,
			) );
			
		?>
		
		<div class="site-info">

			<span class="copyright-text"><?php printf( esc_html__( '&copy; %1$s Firewell. All rights reserved.', 'firewell' ), date( 'Y' ) ); ?></span>
			
			<?php	
			wp_nav_menu( array(
				'theme_location' => 'copyright',
				'menu_id'        => 'copyright-menu',
				'container'       => 'span',
				'menu_class'     => 'menu',
				'items_wrap'      => '%3$s',
				'link_before'     => '<span>',
				'link_after'      => '</span>',
				'depth'           => 0,
			) );

			?>
			
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
