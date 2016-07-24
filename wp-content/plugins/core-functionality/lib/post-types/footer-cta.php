<?php

/**
 * Create new CPT - Footer CTA
 */
class Footer_CTA_CPT extends CPT_Core {

    var $post_type;
	var $taxonomies;
	var $domain;
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

        $this->post_type = 'footer_cta';
		$this->domain = 'firewell';
		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Footer CTA', $this->domain ), // Singular
				__( 'Footer CTA', $this->domain ), // Plural
				$this->post_type // Registered name/slug
			),
			array( 
				'public'             => false,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => false,
				'hierarchical'       => false,
				'show_ui' 			 => true,
				'show_in_menu' 		 => true,
				'show_in_nav_menus'  => false,
				'exclude_from_search' => true,
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
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

new Footer_CTA_CPT();