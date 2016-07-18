<?php
function admin_style() {
  
  wp_enqueue_style('firwell-admin-css', trailingslashit( CHILD_THEME_CSS ) . 'admin.css' );
}
add_action('admin_enqueue_scripts', 'admin_style');