<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Firewell
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php firewell_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		global $post;
		$post_excerpt = $post->post_excerpt;
                    
   		if( $post_excerpt ) {
			$excerpt = wp_trim_words( $post_excerpt, 40, '<span class="meta-nav">&#8230;</span>');
			echo wpautop( sprintf( '%s <a href="%s">Read More</a>', $excerpt, get_permalink() ) );
		}
                        
		else {
			the_content( '<span class="meta-nav">&#8230;</span> Read More' );
		}
		
		// add event details
		if( is_single() ) {
			$event_link = get_post_meta( get_the_ID(), 'event_link', true );
			if( $event_link ) {
				printf( '<p><a href="%s">Event Details</a></p>', $event_link );
			}
		}
			

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'firewell' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
	
	<?php
	// view all and social share
	$posts_page_id = get_option( 'page_for_posts');
	$archive_link = get_permalink( $posts_page_id );
	$share = addtoany_share_icons();
	
	if( is_single() )
		printf( '<div class="posts-footer"><a href="%s">View All News & Upcoming Events</a>%s</div>', $archive_link, $share );
	?>

	<footer class="entry-footer">
		<?php //firewell_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
