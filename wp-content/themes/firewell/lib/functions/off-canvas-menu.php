<?php
//* Do NOT include the opening PHP tag

function firewell_off_canvas_menu() {
	
	$args = array( 
		'theme_location'  => 'primary', 
		'container' => 'nav',
		'container_class'  => 'nav-mobile',
		'echo' => FALSE
		); 
			
	printf( '<div class="pushy pushy-left"><a href="#" class="close-btn"><em>' . __( 'Close Navigation', 'firewell' ) . '</em> X</a>%s</div>', wp_nav_menu( $args ) );
}

/**
  * Add the menu to the .site-header, but hooking right before the genesis_header_markup_close action.
  * @author Calvin Makes (@calvin_makes)
  * @link http://www.calvinmakes.com/add-a-mobile-friendly-off-canvas-menu-in-genesis
*/
//add_action( 'genesis_header', 'firewell_menu_button', 14 );
function firewell_menu_button() {
	
	//* Only add the Menu button if a primary navigation is set. You can switch this for whatever menu you are dealing with
	if ( has_nav_menu( "primary" ) ) {
		printf('<a alt="Toggle Menu" href="#" class="menu-btn right small"><span class="screen-reader-text">%s</span><span class="line"></span><span class="line"></span><span class="line"></span></a>', __( 'Menu', 'firewell' ) );
	}
}



/** 
  * Add the overlay div that will be used for clicking out of the active menu.
  * @author Calvin Makes (@calvin_makes)
  * @link http://www.calvinmakes.com/add-a-mobile-friendly-off-canvas-menu-in-genesis
*/
//add_action( 'genesis_before', 'firewell_site_overlay', 2 );
function firewell_site_overlay() {
	echo '<div class="site-overlay"></div>';
}

/** 
  * Include the JavaScript
  * @author Calvin Makes (@calvin_makes)
  * @link http://www.calvinmakes.com/add-a-mobile-friendly-off-canvas-menu-in-genesis
*/
add_action( 'wp_enqueue_scripts', 'firewell_load_menu' );
function firewell_load_menu() {
  wp_enqueue_script( 'firewell-menu', CHILD_THEME_JS . '/off-canvas-menu.js', array( 'jquery' ), 1.0, TRUE );
}
