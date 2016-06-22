<?php
// Query filters and template includes at bottom of page

/**
 * Create new CPT - Videos
 */
class Videos_CPT extends CPT_Core {

   
   var $post_type;
   var $taxonomies;
   var $parent_menu_item;
   var $featured = '_featured';
   
    /**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

        $this->post_type = 'arktos_video';
		$this->taxonomies = array( 'portfolio_categories' );
		$this->domain = 'firewell';
		$this->parent_menu_item = '216';
		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Video', $this->domain ), // Singular
				__( 'Videos', $this->domain ), // Plural
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
				'rewrite' => array('slug'=> 'media/videos' ), 
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt', 'revisions' ),
				'menu_icon' => 'dashicons-format-video' )

        );

        // Menu highlighting
		add_filter( 'nav_menu_css_class', array( $this, 'post_type_set_current_parent' ) ); 
		
		// We don't want anyone to find the single video page
		add_action( 'template_redirect', array( $this, 'redirect_single_video' ) );
				
		// Set featured video
        add_action( sprintf( 'wp_ajax_featured_%s', $this->post_type ), array( $this, 'set_featured' ) );
	   
	    add_action('pre_get_posts', array( $this, 'filter_cpt_order' ));
		
    }
	
	function filter_cpt_order( $query ){
		if( !is_admin() && $query->is_main_query() && is_post_type_archive( $this->post_type ) ) {
				//$query->set( 'posts_per_page', '12' );
				$query->set( 'orderby', 'menu_order' );
				$query->set( 'order', 'ASC' );
		}
	}
    
	
	function redirect_single_video() {
		if ( is_singular( $this->post_type ) ) {
			wp_redirect( get_post_type_archive_link( $this->post_type ) , 302 );
			exit;
		}
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
	
	
	/**
     * Registers admin columns to display. Hooked in via CPT_Core.
     * @since  0.1.0
     * @param  array  $columns Array of registered column names/labels
     * @return array           Modified array
     */
    public function columns( $columns ) {
        
		$current_screen = get_current_screen();
	   
	    if( $this->post_type != $current_screen->post_type )
			return;
		
		$new_column = array(
            //'feature' => sprintf( __( 'Featured %s', $this->domain ), $this->post_type( 'singular' ) ),
			'portfolio_category' => __( 'Categories', $this->domain ),
        );
        //return array_merge( $new_column, $columns );
        return array_slice( $columns, 0, 2, true ) + $new_column + array_slice( $columns, 1, null, true );
    }

    /**
     * Handles admin column display. Hooked in via CPT_Core.
     * @since  0.1.0
     * @param  array  $column Array of registered column names
     */
    public function columns_display( $column, $post_id ) {
        
		$current_screen = get_current_screen();
	   
	   if( $this->post_type != $current_screen->post_type )
			return;
		
		switch ( $column ) {
            case 'feature':
			$url = wp_nonce_url( admin_url( sprintf( 'admin-ajax.php?action=featured_%s&post_id=%s', $this->post_type, $post_id ) ), sprintf( 'featured-%s', $this->post_type ), 'set_featured' );
			echo '<a href="' . $url . '" title="'. 'Toggle feature' . '">';
			if ( $this->is_featured( $post_id ) ) {
				printf('<img src="%s" alt="%s" height="14" width="14" />', plugins_url( 'images/featured.png', dirname( dirname(__FILE__) ) ), __( 'yes', '' ) );
			} else {
				printf('<img src="%s" alt="%s" height="14" width="14" />', plugins_url( 'images/featured-off.png', dirname( dirname(__FILE__) ) ), __( 'no', '' ) );
			}
			echo '</a>';
			break;
			case 'portfolio_category':
				$this->taxonomy_column( $post, 'portfolio-categories', 'Categories' );
			break;
        }
    }
	
	
	private function taxonomy_column( $post = '', $tax = '', $name = '' ) {
		if ( empty( $post ) ) return;
		$id = $post->ID;
		$categories = get_the_terms( $id, $tax );
		if ( !empty( $categories ) ) {
			$out = array();
			foreach ( $categories as $c ) {
				$out[] = sprintf( '<a href="%s">%s</a>',
				esc_url( add_query_arg( array( 'post_type' => $post->post_type, $tax => $c->slug ), 'edit.php' ) ),
				esc_html( sanitize_term_field( 'name', $c->name, $c->term_id, 'category', 'display' ) )
				);
			}
			echo join( ', ', $out );
		} else {
			_e( 'No '. $name .' Specified' );
		}

	}

	
	private function set_featured() {
				
		if ( current_user_can( 'edit_posts' ) && isset($_GET['set_featured']) && wp_verify_nonce($_GET['set_featured'], sprintf( 'featured-%s', $this->post_type ) ) ) {
			
			$post_id = absint( $_GET['post_id'] );
			
			if ( $this->post_type === get_post_type( $post_id ) ) {
				
				$ids = $this->get_post_ids();
		
				if( !empty( $ids ) ) {
					foreach( $ids as $id ) { 
						
						//if( $id !== $post_id ) // comment out to allow for multiple
							update_post_meta( $id, $this->featured, 0);
					}
				}
	
				update_post_meta( $post_id, $this->featured, get_post_meta( $post_id, $this->featured, true ) == true ? false : true );
			}
		}

		wp_safe_redirect( wp_get_referer() ? remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'ids' ), wp_get_referer() ) : admin_url( sprintf('edit.php?post_type=', $this->post_type ) ) );
		die();
	}

	
	private function get_post_ids() {
		
		$ret = array();
		
		$posts = new WP_Query(
			array( 
				'post_type' => $this->post_type,
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			) 
		);	
		
		if ( $posts->have_posts() ) : 
			while ( $posts->have_posts() ) : $posts->the_post(); 
	
				$ret[] = get_the_ID();
	
			endwhile;
		endif;
		
		wp_reset_postdata();
		
		return $ret;
	}


	private function is_featured( $post_id ) {
		return get_post_meta( $post_id, $this->featured, true );
	}
	
}
new Videos_CPT();

$video_cpt_categories = array(
    __( 'Video Category', $portfolio_cpt->domain ), // Singular
    __( 'Video Categories', $portfolio_cpt->domain ), // Plural
    'video_category' // Registered name
);

$video_cpt_tags = array(
    __( 'Video Tag', $portfolio_cpt->domain ), // Singular
    __( 'Video Tags', $portfolio_cpt->domain ), // Plural
    'video_tag' // Registered name
);

$video_cats = register_via_taxonomy_core( $video_cpt_categories, array(), array( 'video-category' ) );

$video_tags = register_via_taxonomy_core( $video_cpt_tags, array( 'hierarchical' => false ), array( 'video-tag' ) );