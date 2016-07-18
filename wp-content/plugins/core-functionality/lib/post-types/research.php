<?php
// Query filters and template includes at bottom of page

/**
 * Create new CPT - Researchs
 */
class Research_CPT extends CPT_Core {

   
   var $post_type;
   var $taxonomies;
   var $parent_menu_item;
   var $featured = '_featured';
   
    /**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

        $this->post_type = 'research';
		$this->taxonomies = array( 'research_categories' );
		$this->domain = 'firewell';
		$this->parent_menu_item = '216';
		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Research', $this->domain ), // Singular
				__( 'Research', $this->domain ), // Plural
				$this->post_type // Registered name/slug
			),
			array( 
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'show_ui' 			 => true,
				'show_in_menu' 		 => true,
				'show_in_nav_menus'  => false,
				'exclude_from_search' => false,
				'rewrite' => array('slug'=> 'research/findings' ), 
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt', 'revisions' ),
				'menu_icon' => 'dashicons-format-aside' )

        );

        // Menu highlighting
		//add_filter( 'nav_menu_css_class', array( $this, 'post_type_set_current_parent' ) ); 
		
				
		// Set featured research
        //add_action( sprintf( 'wp_ajax_featured_%s', $this->post_type ), array( $this, 'set_featured' ) );
	   
	    //add_action('pre_get_posts', array( $this, 'filter_cpt_order' ));
		
		add_filter( 'default_content', array( $this, 'set_default_content' ), 10, 2 );
		
		
    }
	
	function filter_cpt_order( $query ){
		if( !is_admin() && $query->is_main_query() && is_post_type_archive( $this->post_type ) ) {
				//$query->set( 'posts_per_page', '12' );
				$query->set( 'orderby', 'menu_order' );
				$query->set( 'order', 'ASC' );
		}
	}
    
	
	function redirect_single_research() {
		if ( is_singular( $this->post_type ) ) {
			wp_redirect( get_post_type_archive_link( $this->post_type ) , 302 );
			exit;
		}
	}
	
	
	function set_default_content( $content, $post ) {
	
		$current_screen = get_current_screen();
	   
	    if( $this->post_type != $current_screen->post_type )
			return;
		
		$content = "<h2>What is the problem?</h2>
		[Add content here or delete all of this for 'Presentations']
		<h2>How did the team study the problem?</h2>
		[Add content here]
		<h2>What did the team find?</h2>
		[Add content here]
		<h2>How can this research be used?</h2>
		[Add content here]
		<h2>Cautions</h2>
		[Add content here]";
	
		return $content;
	
	}

	
		
	function post_type_set_current_parent( $classes ) {
				
		if ( is_singular( $this->post_type ) || is_post_type_archive( $this->post_type ) ) {
	
			//* Remove parent class
			$classes = array_filter($classes, array( $this, 'remove_parent_classes' ));
			
			// set parent page to resources
			if ( in_array( $this->parent_menu_item , $classes ) )
				$classes[] = 'current-menu-item';
					
		}
	
		return $classes;
	}
	
	
	function remove_parent_classes($class) {
		// check for current page classes, return false if they exist.
		return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item') ? FALSE : TRUE;
	}	
	
}

$research_cpt = new Research_CPT();

$research_cpt_categories = array(
    __( 'Research Category', $research_cpt->domain ), // Singular
    __( 'Research Categories', $research_cpt->domain ), // Plural
    'research_category' // Registered name
);

$research_cpt_tags = array(
    __( 'Research Tag', $research_cpt->domain ), // Singular
    __( 'Research Tags', $research_cpt->domain ), // Plural
    'research_tag' // Registered name
);

$research_cats = register_via_taxonomy_core( 
	$research_cpt_categories, 
	array(
		'rewrite' => array('slug'=> 'research/category' )
	), 
	array( 'research' ) );

$research_tags = register_via_taxonomy_core( 
	$research_cpt_tags, 
	array( 'hierarchical' => false,
		   'rewrite' => array('slug'=> 'research/tag' ) ), 
	array( 'research' ) );