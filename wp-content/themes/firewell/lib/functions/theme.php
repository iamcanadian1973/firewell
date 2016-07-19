<?php
// Theme Functions

// Add excerpts to pages
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
//add_action( 'init', 'my_add_excerpts_to_pages' );

// Add additional image sizes
//add_image_size( 'full-width-photo', 1900, 99999 );
//add_image_size( 'design-size', 720, 432, true ); 


// allow svg uploads
//Allow SVG files to be uploaded

function custom_mtypes( $m ){
    $m['svg'] = 'image/svg+xml';
    $m['svgz'] = 'image/svg+xml';
    return $m;
}
add_filter( 'upload_mimes', 'custom_mtypes' );