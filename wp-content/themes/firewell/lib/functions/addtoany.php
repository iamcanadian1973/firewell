<?php

add_action( 'wp_enqueue_scripts', 'load_addtoany_scripts' );
function load_addtoany_scripts() {
		wp_enqueue_script( 'addtoany', '//static.addtoany.com/menu/page.js', FALSE, NULL, TRUE );
		
		wp_enqueue_script( 'addtoany-config', CHILD_THEME_JS . '/addtoany-config.js', array('addtoany'), NULL, TRUE );
}

function addtoany_share( $label = 'Share' ) {
	return sprintf( '<span class="social-share">
					<a class="a2a_dd" href="https://www.addtoany.com/share">%s &nbsp;&nbsp;<i class="ion-icons ion-android-share-alt"></i></a></span>', $label );
	
}

// Social icons used in header/footer
function addtoany_share_icons() {
	
	return share_icons();
	
	global $post;
	
	$socials = array(
			//'googleplus'  => 'google_plus',
			//'instagram'   => 'instagram',
			//'pinterest'   => 'pinterest',
			'email'       => 'Email Link',
			'twitter'     => 'Tweet This',
			'facebook'    => 'Post to Facebook',
			//'rss'         => 'feed'
	);
	
	
	$anchor_class = 'a2a_button_'; // a2a_button_
	
	$list = '';
	
	foreach( $socials as $network => $text ) {
		
		
		$list .= sprintf('<li class="%1$s"><a class="%2$s%1$s">%3$s</a></li>', $network, $anchor_class, $text );	
	}
	
		
	return sprintf( '<ul class="share-icons a2a_kit clearfix">%s</ul>', $list );
}


function share_icons() {

 	ob_start();

	?>
	<div class="sharebar"><ul><li class="mail" ><a href="mailto:?subject=Firewell:%20<?php the_title(); ?>&body=I%20thought%20you%20might%20be%20interested%20in%20this%3A%0A%0A<?php the_permalink(); ?>">Email</a></li> <li class="twitter" ><a href="http://twitter.com/share?text=Firewell:%20<?php the_title(); ?>&url=<?php echo get_permalink(get_the_ID()); ?>" target="_blank" >Tweet</a></li> <li class="facebook" ><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" target="_blank">Share</a></li></ul></div>
	<?php
	/* PERFORM COMLEX QUERY, ECHO RESULTS, ETC. */
   $share = ob_get_contents();
   ob_end_clean();
   
   return $share;
	
}