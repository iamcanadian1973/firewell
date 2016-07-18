<?php

/**
 * Create new CPT - FAQ
 */
class FAQ_CPT extends CPT_Core {

    var $post_type;
	var $taxonomies;
	var $domain;
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

        $this->post_type = 'faq';
		$this->taxonomies = array( 'faq_category' );
		$this->domain = 'firewell';
		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'FAQ', $this->domain ), // Singular
				__( 'FAQ', $this->domain ), // Plural
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
				'show_in_nav_menus'  => true,
				'exclude_from_search' => false,
				'rewrite' => array('slug'=> 'faqs' ), 
				'supports' => array( 'title', 'editor', 'page-attributes' ),
				//'menu_icon' => 'dashicons-images-alt2' 
				)

        );
				
		add_action('pre_get_posts', array( $this, 'filter_cpt_archive' ) );
				
    }
	


	public function filter_cpt_archive( $query ){
		if( !is_admin() && $query->is_main_query() && ( is_post_type_archive( $this->post_type ) || is_tax( $this->taxonomies ) ) ) {
			
			$query->set( 'orderby', 'menu_order' );
			$query->set( 'order', 'ASC' );
			$query->set( 'posts_per_page', -1 );
		}
	}
	
	
	
	
}

new FAQ_CPT();