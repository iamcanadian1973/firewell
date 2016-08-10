<?php
// Theme Functions

// Add excerpts to pages
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
//add_action( 'init', 'my_add_excerpts_to_pages' );

// Add additional image sizes
//add_image_size( 'video-thumbnail', 480, 250, true );
//add_image_size( 'design-size', 720, 432, true ); 


// allow svg uploads
//Allow SVG files to be uploaded

function custom_mtypes( $m ){
    $m['svg'] = 'image/svg+xml';
    $m['svgz'] = 'image/svg+xml';
    return $m;
}
add_filter( 'upload_mimes', 'custom_mtypes' );



// remove unwanted archive details before title
add_filter( 'get_the_archive_title', function ($title) {
	// remove anyhting before the :, then remove the : then remove any left whitespace.
    return ltrim( str_replace( ':', '', strstr($title, ':') ) );
});


// TablePress
add_filter( 'tablepress_table_output', 'tablepress_add_div_wrapper', 10, 3 ); 
function tablepress_add_div_wrapper( $output, $table, $options ) { 
	$output = '<div class="table-responsive">' . $output . '</div>'; return $output; 
}