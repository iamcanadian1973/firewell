<?php
// We need to manually set certain parent menu items.
add_filter('nav_menu_css_class', 'firewell_set_current_menu_class',1,2); 
//add_filter('jcs/populated_elements', 'firewell_set_current_submenu_class',1,2); 

function firewell_set_current_menu_class($classes) {
	
	// Video Library
	if( is_post_type_archive( 'video' ) || is_tax( 'video_category' ) || is_tax( 'video_tag' ) ) {
		$classes = array_filter($classes, "firewell_remove_parent_classes");
		
		if ( in_array( sprintf('menu-item-%s', 26 ), $classes ) ) {
			$classes[] = 'current-menu-parent';		
		}
	}
	
	// Single Video
	else if( is_singular( 'video' ) ) {
		$classes = array_filter($classes, "firewell_remove_parent_classes");
	
		if ( in_array( sprintf('menu-item-%s', 26 ), $classes ) ) {
			$classes[] = 'current-menu-parent';		
		}
	}
	
	// Findings
	if( is_post_type_archive( 'research' ) || is_tax( 'research_category' ) || is_tax( 'research_tag' ) ) {
		$classes = array_filter($classes, "firewell_remove_parent_classes");
		
		if ( in_array( sprintf('menu-item-%s', 27 ), $classes ) ) {
			$classes[] = 'current-menu-parent';		
		}
	}
	
	// Single Research
	else if( is_singular( 'research' ) ) {
		$classes = array_filter($classes, "firewell_remove_parent_classes");
	
		if ( in_array( sprintf('menu-item-%s', 27 ), $classes ) ) {
			$classes[] = 'current-menu-parent';		
		}
	}
	
	return $classes;
}


function firewell_set_current_submenu_class($elements) {
	
	// Video Library
	if( is_post_type_archive( 'video' ) ) {
	    //print_r($elements);
		//if ( in_array( sprintf('menu-item-%s', 247 ), $classes ) ) {
			$elements['classes'][] = 'current-menu-item';		
		//}
	}
	
	// Single Video
	else if( is_singular( 'video' ) ) {
		$classes = array_filter($classes, "firewell_remove_parent_classes");
	
		if ( in_array( sprintf('menu-item-%s', 26 ), $classes ) ) {
			$classes[] = 'current-menu-parent';		
		}
	}
	
	return $elements;
}



//add_filter( 'jcs/item_classes', 'jc_edit_item_classes', 10, 3 );
function jc_edit_item_classes($classes, $item_id, $item_type){
 	print_r($classes);
	exit('test');
	if( is_post_type_archive( 'video' ) ) {
		
		if ( in_array( sprintf('menu-item-%s', 247 ), $classes ) ) {
			$classes[] = 'current-menu-item';		
		}
	}
    return $classes;
}


// Helper function for setting active menu class
function firewell_set_menu_item( $classes, $menu_item_id, $class ) {
	$classes = array_filter($classes, "firewell_remove_parent_classes");
	
	if ( in_array( sprintf('menu-item-%s', $menu_item_id ), $classes ) ) {
		$classes[] = $class;		
	}
	
	return $classes;
}

function firewell_remove_parent_classes($class) {
	return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item' || $class == 'current-menu-parent') ? FALSE : TRUE;
}