<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package thegardens
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php global $is_IE; if ( $is_IE ) : ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php endif; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="Shortcut Icon" href="<?php echo CHILD_THEME_IMG;?>/favicon.png" type="image/x-icon" />
<link rel="apple-touch-icon" href="<?php echo CHILD_THEME_IMG;?>/apple-icon.png">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
// offcanvas menu
firewell_off_canvas_menu();
firewell_site_overlay();
?>
<div id="page" class="site-container">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'thegardens' ); ?></a>
	
	<div class="before-header">
		<?php
		if ( is_active_sidebar( 'before-header' ) ) {
			dynamic_sidebar( 'before-header' );
		} 
		?>
	</div>
	<header id="masthead" class="site-header" role="banner">

			<div class="site-branding">

				<?php		
				$logo = sprintf('<img src="%s" alt="%s"/>', CHILD_THEME_IMG .'/logo.svg', get_bloginfo( 'name' ) );
				$site_url = site_url();
				printf('<div class="site-title"><a href="%s" title="%s">%s</a></div>', $site_url, get_bloginfo( 'name' ), $logo );
				// mobile menu button
				firewell_menu_button();
				?>

			</div><!-- .site-branding -->
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="wrap">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'menu dropdown',
							'link_before'	 => '<span>',
							'link_after'	 => '</span>'
						) );
						
					?>
				</div>
			</nav><!-- #site-navigation -->

	</header><!-- #masthead -->
	
	<div class="after-header">
		<?php
		if ( is_active_sidebar( 'after-header' ) ) {
			dynamic_sidebar( 'after-header' );
		}
		?>
	</div>

	<div id="content" class="site-content">