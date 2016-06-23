<?php

/**
* Page Builder Class
* @version 1.0.0
* @author  Kyle Rumble
*
*/
class KR_Page_Builder {
		
	/**
	 * Plugin directory path.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_path = '';
	
	/**
	 * Plugin directory URI.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_uri = '';
	
	/**
	 * Plugin includes directory path.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $inc_dir = '';
	
	/**
	 * Plugin layouts directory path.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $layouts_dir = '';
	
	/**
	 * Plugin partials directory path.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $partials_dir = '';
	
	/*
	 * Group counter - used for opening and auto closing groups
	 */
	public $group_counter = 0;
	
	/*
	 * Section counter - used for determining even/odd
	 */
	public $section_counter = 0;
	
	/*
	 * Section ID
	 */
	public $section_id = '';
	
	/*
	 * Section Attributes
	 */
	public $section_attributes = array();
	
	
	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
	
		static $instance = null;
	
		if ( is_null( $instance ) ) {
			$instance = new KR_Page_Builder;
			$instance->setup();
			$instance->includes();
		}
	
		return $instance;
	}
		
		/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	public function __construct() {}

	/**
	 * Magic method to output a string if trying to use the object as a string.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __toString() {
		return 'kr_page_builder';
	}

	/**
	 * Magic method to keep the object from being cloned.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Whoah, partner!', 'kr_page_builder' ), '1.0.0' );
	}

	/**
	 * Magic method to keep the object from being unserialized.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Whoah, partner!', 'kr_page_builder' ), '1.0.0' );
	}

	/**
	 * Magic method to prevent a fatal error when calling a method that doesn't exist.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return null
	 */
	public function __call( $method = '', $args = array() ) {
		_doing_it_wrong( "KR_Page_Builder::{$method}", esc_html__( 'Method does not exist.', 'kr_page_builder' ), '1.0.0' );
		unset( $method, $args );
		return null;
	}

	/**
	 * Sets up globals.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function setup() {

		// Main plugin directory path and URI.
		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );

		// Plugin directory paths.
		$this->inc_dir       = trailingslashit( $this->dir_path . 'inc' );
		$this->layouts_dir       = trailingslashit( $this->dir_path . 'layouts' );
		$this->partials_dir       = trailingslashit( $this->dir_path . 'partials' );
	}

	/**
	 * Loads files needed by the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function includes() {

		if( !is_admin() ) {
			// Load includes files.
			require_once( $this->inc_dir . 'functions.php'  );
			require_once( $this->inc_dir . 'structure.php'  );
			// these files need to be loaded last
			require_once( $this->inc_dir . 'actions.php'    );
			require_once( $this->inc_dir . 'filters.php'    );

			
			// Load partials directory. Must get loaded before layouts
			require_once( $this->partials_dir . 'index.php'    );
			
			// Load layout directory.
			require_once( $this->layouts_dir . 'index.php'    );
		}
				
	}
	
	/**
	 * Sets global attributes for section targeting
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function set_attributes( $attributes ) {
		
		$this->section_id = $id = $attributes['id'];
		$this->section_classes = $classes = explode( ' ', $attributes['class'] );
		$this->section_attributes = array( 'id' => $id, 'classes' => $classes );
	}
	

}



/**
 * Gets the instance of the `Members_Plugin` class.  This function is useful for quickly grabbing data
 * used throughout the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function kr_page_builder_plugin() {
	return KR_Page_Builder::get_instance();
}

// Let's roll!
kr_page_builder_plugin();
