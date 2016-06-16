<?php
/**
 * Social Widget
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/billerickson/Core-Functionality
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class BE_Social_Widget extends WP_Widget {
	
    /**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $defaults;
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	function __construct() {
		
		// widget defaults
		$this->defaults = array(
			'title'     => '',
			'twitter'   => '',
			'facebook'  => '',
			'google-plus'     => '',
			'email'		=> '',
			'linkedin'  => '',
			'youtube'   => '',
			'pinterest' => '',
			'rss'       => '',
		);
		
		// Socials
		$this->socials = apply_filters( 'be_social_widget_order', array(
			'youtube'   => 'Youtube URL',
			'facebook'  => 'Facebook URL',
			'twitter'   => 'Twitter URL',
			'instagram' => 'Instagram URL',
			//'google-plus' => 'Google Plus URL',
			//'email' 	  => 'Email Adress',
			//'linkedin'  => 'LinkedIn URL',
			
			//'pinterest' => 'Pinterest URL',
			//'rss'       => 'RSS URL',
		) );
		
		
		// Widget Slug
		$widget_slug = 'be-social-widget';
		
		// widget basics
		$widget_ops = array(
			'classname'   => 'be-social-widget',
			'description' => 'Links to social sites.'
		);
		
		// widget controls
		$control_ops = array(
			'id_base' => 'be-social-widget',
			//'width'   => '400',
		);
		
		// load widget
		parent::__construct( $widget_slug, 'Social Widget', $widget_ops, $control_ops );	
	}

    
	/**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme 
     * @param array  An array of settings for this widget instance 
     * @return void Echoes it's output
     **/
	function widget( $args, $instance ) {
		extract( $args );
		
		// Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		
		echo $before_widget;
		
		if ( !empty( $instance['title'] ) ) { 
			echo $before_title . $instance['title'] . $after_title;
		}
				
		$socials = $this->socials;
		
		if( empty( $socials ) )
			return;
					
		$items = '';
		
				
		
		foreach( $socials as $key => $title ) {
			
			if( !empty( $instance[$key] ) ) {
				
				// emails isn't escaped
				$val  = ( $key == 'email' ) ? 'mailto:' . antispambot( $instance[$key] ) : esc_url( $instance[$key] );
				$icon = ( $key == 'email' ) ? 'envelope' : $key;
				
				$items .= sprintf('<li><a target="_blank" class="%1$s" href="%2$s"><i class="fa fa-%1$s"></i><span class="screen-reader-text">%3$s</span></a></li>', $icon, $val, $title );
			}
		}
		
		$items = apply_filters( 'be_social_widget_items', $items );
		
		printf( '<div class="social-icons"><ul>%s</ul></div>', $items );
		

		echo $after_widget;
	}

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings 
     * @return array The validated and (if necessary) amended settings
     **/
	function update( $new_instance, $old_instance ) {
		
		$new_instance['title'] = strip_tags( $new_instance['title'] );
		
		foreach( $this->socials as $social => $title ) {
			// don't escape email field
			$new_instance[$social] = ( $social == 'email' ) ? $new_instance[$social] : esc_url( $new_instance[$social] );
		}
		
		return $new_instance;
	}
	
    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
	function form( $instance ) {
	
		// Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		
		echo '<p>
			<label for="' . $this->get_field_id( 'title' ) . '">Title:</label>
			<input type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . esc_attr( $instance['title'] ) . '" class="widefat" />
			</p>';
			
		
			
		foreach( $this->socials as $social => $title ) {
			
			$val = ( $social == 'email' ) ? $instance[$social] : esc_attr( $instance[$social] );
						
			echo '<p>
				<label for="' . $this->get_field_id( $social ) . '">' . $title . ':</label>
				<input type="text" id="' . $this->get_field_id( $social ) . '" name="' . $this->get_field_name( $social ) . '" value="' . $val. '" class="widefat" />
				</p>';
		}
	}
}


add_action( 'widgets_init', create_function( '', "register_widget('BE_Social_Widget');" ) );