<?php

//* Enqueue Google fonts


//add_action( 'wp_enqueue_scripts', 'kr_load_google_fonts' );

function kr_load_google_fonts() {
	
	// change array as needed
	$font_families = array(
			'Work+Sans:200,400,300,500,600,700'
		);
	
	$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext',
		);

	$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	
	if( !empty( $font_families ) ) {
		wp_enqueue_style( 'google-fonts', $fonts_url, array(), CHILD_THEME_VERSION );
	}
	
	
}



// * Enqueue TypeKit

//add_action( 'wp_enqueue_scripts', 'load_typekit_scripts' );

// Load TykeKit
function load_typekit_scripts() {
    wp_enqueue_script( 'typekit', '//use.typekit.net/uma8hzd.js' );
	
	// dev: gus4xuk
}

//add_action( 'wp_head', 'load_typekit_inline', 99 );

function load_typekit_inline() {
    //if ( wp_script_is( 'typekit', 'done' ) ) {
        echo '<script>try{Typekit.load();}catch(e){}</script>';
		// { async: true }
    //}
}

add_filter( 'stf_exclude_scripts', 'stf_custom_header_scripts', 10, 1 );

function stf_custom_header_scripts( $scripts ) {
    $scripts[] = 'typekit'; // replace 'backbone' with the script slug
    return $scripts;
}



//add_action( 'wp_enqueue_scripts', 'kr_load_local_fonts' );

function kr_load_local_fonts() {
	
	wp_enqueue_style( 'dashicons' );
	
	$fonts = array( 
			'font-awesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'
			//'ionicons' => 'http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'
			);
	
	foreach( $fonts as $name => $src ) {
		wp_enqueue_style( $name, $src, array(), CHILD_THEME_VERSION );
	}
		
}
