<?php
/**
 * Plugin Name: Core Functionality
 * Description: This contains all your site's core functionality so that it is theme independent.
 * Version: 1.0
 *
 */

// Plugin Directory 
define( 'KR_DIR', dirname( __FILE__ ) );


// Post Types
include_once( KR_DIR . '/lib/post-types/videos.php' );
include_once( KR_DIR . '/lib/post-types/research.php' );
include_once( KR_DIR . '/lib/post-types/footer-cta.php' );

// functions

//include_once( KR_DIR . '/lib/functions/be-calendar.php' );

// Widgets

//include_once( KR_DIR . '/lib/widgets/widget-social.php' );
//include_once( KR_DIR . '/lib/widgets/widget-acf-featured-content.php' );