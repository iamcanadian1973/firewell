<?php
// Creating the widget 
class ACF_WIDGET extends WP_Widget {

	const WIDGET_DOMAIN = 'acf-widget';
	const WIDGET_ID = 'acf_widget';
	const WIDGET_NAME = 'ACF Widget';
	const WIDGET_DESCRIPTION = 'Custom widget for showing ACF data';
	const WIDGET_TITLE = '';
	
	function __construct() {
		
		parent::__construct(
			// Base ID of your widget
			self::WIDGET_ID, 
		
			// Widget name will appear in UI
			__( self::WIDGET_NAME, self::WIDGET_DOMAIN), 
		
			// Widget description
			array( 'description' => __( self::WIDGET_DESCRIPTION, self::WIDGET_DOMAIN ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		// Custom fields output here
		
		
		
		
		// After Widget
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
		}
		else {
			$title = __( self::WIDGET_TITLE, self::WIDGET_DOMAIN );
		}
		
		printf('<p>%s</p>', __('Save widget first if you do not see any fields.', self::WIDGET_DOMAIN ) );
	
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	
} // Class wpb_widget ends here

// Register and load the widget
function acf_load_widget() {
	register_widget( 'ACF_WIDGET' );
}
add_action( 'widgets_init', 'acf_load_widget' );