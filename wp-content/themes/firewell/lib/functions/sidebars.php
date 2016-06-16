<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function firewell_widgets_init() {

	// Define sidebars
	$sidebars = array(
	'before-header'  => esc_html__( 'Before Header', 'firewell' ),
	//	'sidebar-2'  => esc_html__( 'Sidebar 2', 'firewell' ),
	//	'sidebar-3'  => esc_html__( 'Sidebar 3', 'firewell' ),
	);

	// Loop through each sidebar and register
	foreach ( $sidebars as $sidebar_id => $sidebar_name ) {
		register_sidebar( array(
			'name'          => $sidebar_name,
			'id'            => $sidebar_id,
			'description'   => esc_html__( 'Widget area for ' . $sidebar_name . '', 'firewell' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

}
add_action( 'widgets_init', 'firewell_widgets_init' );