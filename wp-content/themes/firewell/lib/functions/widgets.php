<?php

// Flexible Posts Widget - Add class

function kr_widget_display_callback($instance, $widget, $args) {
 if ( strpos( $args['widget_id'], 'dpe_fp_widget' ) === FALSE && !isset($instance['template'])) {
    return $instance;
  }
		
  $widget_classname = $widget->widget_options['classname'];
  $my_classnames = basename( $instance['template'], '.php' ) . '_widget';

  $args['before_widget'] = str_replace($widget_classname, "{$widget_classname} {$my_classnames}", $args['before_widget']);

  $widget->widget($args, $instance);

  return false;
}
add_filter( 'widget_display_callback', 'kr_widget_display_callback', 10, 3 );