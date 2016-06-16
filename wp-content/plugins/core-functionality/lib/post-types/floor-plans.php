<?php

/**
 * Post Types
 *
 * This file registers any custom post types
 */



/**
 * Create new CPT - Floor Plans
 */

register_via_cpt_core( array(
	    __( 'Floor Plan', 'salisburywalk' ), // Singular
	    __( 'Floor Plans', 'salisburywalk' ), // Plural
	    'floor_plan' // Registered name/slug
	),
	array( 
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => false,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'show_ui' 			 => true,
        'show_in_menu' 		 => true,
        'show_in_nav_menus'  => true,
		'exclude_from_search' => true,
		'rewrite' => array('slug'=> 'homes/floor-plans' ),
		//'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' , 'genesis-cpt-archives-settings' )
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		)
 );