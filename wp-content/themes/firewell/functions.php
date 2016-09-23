<?php
/**
 * Firewell functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Firewell
 */

if ( ! function_exists( 'firewell_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function firewell_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Firewell, use a find and replace
	 * to change 'firewell' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'firewell', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'firewell' ),
		'footer' => esc_html__( 'Footer', 'firewell' ),
		'copyright' => esc_html__( 'Copyright', 'firewell' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'firewell_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'firewell_setup' );


function firewell_load_custom_settings() {
	
	define( 'CHILD_DIR', get_stylesheet_directory() );
	define( 'CHILD_URL', get_stylesheet_directory_uri() );
	define( 'CHILD_THEME_CSS', CHILD_URL . '/assets/styles' );
	define( 'CHILD_THEME_IMG', CHILD_URL . '/assets/images' );
	define( 'CHILD_THEME_JS', CHILD_URL . '/assets/scripts' );
	define( 'CHILD_THEME_LANG', CHILD_URL . '/languages' );
	
	define( 'CHILD_THEME_NAME', sanitize_title( wp_get_theme() ) );
	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );	
	
	// Include WordPress Cleanup functions
	include_once( CHILD_DIR . '/lib/wp-cleanup.php' );
	
	// Child Theme Functions
	include_once( CHILD_DIR . '/lib/functions/init.php' );
	
	// Page Buiklder
	include_once( CHILD_DIR . '/lib/page-builder/init.php' );
}
add_action( 'after_setup_theme', 'firewell_load_custom_settings' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function firewell_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'firewell_content_width', 640 );
}
add_action( 'after_setup_theme', 'firewell_content_width', 0 );


function admin_style() {
  wp_enqueue_style('firwell-admin-css', trailingslashit( CHILD_THEME_CSS ) . 'admin.css' );
}
add_action('admin_enqueue_scripts', 'admin_style');


// Login Styles
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', trailingslashit( CHILD_THEME_CSS ) . '/login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );


// Admin SVG fix to remove width & height
function wg_fix_svg_size_attributes( $out, $id )
{
	$image_url  = wp_get_attachment_url( $id );
	$file_ext   = pathinfo( $image_url, PATHINFO_EXTENSION );

	if ( ! is_admin() || 'svg' !== $file_ext ){
		return false;
	}

	return array( $image_url, null, null, false );
}
add_filter( 'image_downsize', 'wg_fix_svg_size_attributes', 10, 2 );
