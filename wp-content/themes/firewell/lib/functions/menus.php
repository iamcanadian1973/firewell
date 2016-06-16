<?php

// Single Page nav remove active classes
//add_filter('nav_menu_css_class', 'set_current_menu_class',1,2); 
function set_current_menu_class($classes) {
	return array_filter($classes, "remove_parent_classes");
}

function remove_parent_classes($class) {
  // check for current page classes, return false if they exist.
	return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item') ? FALSE : TRUE;
}