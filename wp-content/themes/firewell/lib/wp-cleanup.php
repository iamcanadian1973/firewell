<?php
/**
 * WordPress Core tweaks
 *
 * These should be removed and adjusted as necessary.
 *
 * @since    1.0.0
 */
 


// Clean up Head
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Execute shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

// unregister all widgets
 add_action('widgets_init', 'remove_default_widgets', 11);

 function remove_default_widgets() {
     unregister_widget('WP_Widget_Pages');
     unregister_widget('WP_Widget_Calendar');
     //unregister_widget('WP_Widget_Archives');
     unregister_widget('WP_Widget_Links');
     unregister_widget('WP_Widget_Meta');
     //unregister_widget('WP_Widget_Search');
     //unregister_widget('WP_Widget_Text');
     //unregister_widget('WP_Widget_Categories');
     unregister_widget('WP_Widget_Recent_Posts');
     unregister_widget('WP_Widget_Recent_Comments');
     unregister_widget('WP_Widget_RSS');
     unregister_widget('WP_Widget_Tag_Cloud');
    // unregister_widget('WP_Nav_Menu_Widget');
 }

// Remove Dashboard Meta Boxes
add_action( 'wp_dashboard_setup', 'mb_remove_dashboard_widgets' );
function mb_remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}


// Remove default link for images
add_action( 'admin_init', 'mb_imagelink_setup', 10 );
function mb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option( 'image_default_link_type', 'none' );
	}
}

// Remove paragrapgh tags around images
add_filter('the_content', 'filter_ptags_on_images');
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// Show Kitchen Sink in WYSIWYG Editor
add_filter( 'tiny_mce_before_init', 'mb_unhide_kitchensink' );
function mb_unhide_kitchensink( $args ) {
	$args['wordpress_adv_hidden'] = false;
	return $args;
}

// Editor Styles
add_editor_style( 'editor-style.css' );

// Don't update theme
add_filter( 'http_request_args', 'mb_dont_update_theme', 5, 2 );
function mb_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}

// Prevent File Modifications
define ( 'DISALLOW_FILE_EDIT', true );


// Remove Query Strings From Static Resources
add_filter( 'script_loader_src', 'mb_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'mb_remove_script_version', 15, 1 );
function mb_remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}

// Remove Read More Jump
add_filter( 'the_content_more_link', 'mb_remove_more_jump_link' );
function mb_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ($offset) {
		$end = strpos( $link, '"',$offset );
	}
	if ($end) {
		$link = substr_replace( $link, '', $offset, $end-$offset );
	}
	return $link;
}

// fix menu always showing blog as parent
function dtbaker_wp_nav_menu_objects($sorted_menu_items, $args){
    // check if the current page is really a blog post.
    global $wp_query;
    global $post;
    $current_page = $post;
    if(!empty($wp_query->queried_object_id)){
        if($current_page && $current_page->post_type=='post'){
            //yes!
        }else{
            $current_page = false;
        }
    }else{
        $current_page = false;
    }
 
    $home_page_id = (int) get_option( 'page_for_posts' );
    foreach($sorted_menu_items as $id => $menu_item){
        if ( ! empty( $home_page_id ) && 'post_type' == $menu_item->type && empty( $wp_query->is_page ) && $home_page_id == $menu_item->object_id ){
            if(!$current_page){
                foreach($sorted_menu_items[$id]->classes as $classid=>$classname){
                    if($classname=='current_page_parent'){
                        unset($sorted_menu_items[$id]->classes[$classid]);
                    }
                }
            }
        }
    }
    return $sorted_menu_items;
}
add_filter('wp_nav_menu_objects','dtbaker_wp_nav_menu_objects',10,2);


// Filter Yoast SEO Metabox Priority
add_filter( 'wpseo_metabox_prio', 'mb_filter_yoast_seo_metabox' );
function mb_filter_yoast_seo_metabox() {
	return 'low';
}

// Disable WPSEO Nag on Dev Server 
//add_filter( 'option_wpseo', 'be_disable_wpseo_nag' );
function be_disable_wpseo_nag( $options ) {
	if( strpos( site_url(), 'localhost' ) || strpos( site_url() ,'master-wp' ) )
		$options['ignore_blog_public_warning'] = 'ignore';
	return $options;
}

//Page Slug Body Class
add_filter( 'body_class', 'add_slug_body_class' );
function add_slug_body_class( $classes ) {
	global $post;
	
	if( !is_singular() )
		return $classes;
		
	//$page_template_slug = sanitize_html_class( str_replace( '.', '-', get_page_template_slug( $post->ID ) ) );
	// if ( isset( $post ) && !is_page_template() ) {
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	
		
	if ($post->post_parent) {
		//$parent  = end(get_post_ancestors( $post-ID ));
		//$parent = get_post( $id );
		//$classes[] = 'parent-' . $parent->post_type . '-' . $parent->post_name;
		$parents  = get_post_ancestors( $post->ID );
		foreach( $parents as $parent ) {
			$p = get_post( $parent );
			$classes[] = 'parent-' . $p->post_type . '-' . $p->post_name;
		}
		
	}
		
	
	return $classes;
}

/**
 * Don't Update Theme
 * @since 1.0.0
 *
 * If there is a theme in the repo with the same name,
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */

add_filter( 'http_request_args', 'ssm_dont_update_theme', 5, 2 );
function ssm_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}


/**
 * Remove default link for images
 */
add_action('admin_init', 'ssm_imagelink_setup', 10);
function ssm_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}

/**
 * Show Kitchen Sink in WYSIWYG Editor
 */
add_filter( 'tiny_mce_before_init', 'ssm_unhide_kitchensink' );
function ssm_unhide_kitchensink($args) {
	$args['wordpress_adv_hidden'] = false;
	return $args;
}

/**
 * Modifies the TinyMCE settings array
 */
add_filter( 'tiny_mce_before_init', 'ssm_tiny_mce_before_init' );
function ssm_tiny_mce_before_init( $init ) {

	// Restrict the Formats available in TinyMCE. Currently excluded: h1,h5,h6,address,pre
	$init['block_formats'] = 'Paragraph=p;Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Blockquote=blockquote';
	return $init;

}

/**
 * Remove the injected styles for the [gallery] shortcode
 *
 */
add_filter( 'gallery_style', 'ssm_gallery_style' );
function ssm_gallery_style( $css ) {

	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );

}

/**
*  Set Home Page Programmatically if a Page Called "Home" Exists
*/

// Should this be wrapped in a function for better organization?

$homepage = get_page_by_title( 'Home' );

if ( $homepage ) {
    update_option( 'page_on_front', $homepage->ID );
    update_option( 'show_on_front', 'page' );
}


/**
 * Remove Read More Jump
 */
add_filter('the_content_more_link', 'ssm_remove_more_jump_link');
function ssm_remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}


/**
 * Fix Gravity Form Tabindex Conflicts
 * http://gravitywiz.com/fix-gravity-form-tabindex-conflicts/
 */
add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
function gform_tabindexer( $tab_index, $form = false ) {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    if( $form )
        add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}


/**
*  Removes unnecessary menu items from add new dropdown
*/
//add_action( 'admin_bar_menu', 'remove_wp_nodes', 999 );
function remove_wp_nodes() {
    global $wp_admin_bar;   
    $wp_admin_bar->remove_node( 'new-link' );
    $wp_admin_bar->remove_node( 'new-media' );
    // $wp_admin_bar->remove_node( 'new-shop_coupon' );
    // $wp_admin_bar->remove_node( 'new-shop_order' );
    $wp_admin_bar->remove_node( 'new-user' );
}



// Disable WPSEO columns on edit screen 
//add_filter( 'wpseo_use_page_analysis', '__return_false' );
