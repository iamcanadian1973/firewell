<?php
/**
 * Template part for displaying page content in page.php.
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
		
		?>
		
		<?php
		// Summary
		$categories = get_the_term_list( get_the_ID(), 'research_category' );
		
		if ( $categories ) {
			$categories = sprintf( '<span class="category-links">' . esc_html__( '%s' ) . '</span>', $categories );
		}
		
		$summary = get_post_meta( get_the_ID(), 'summary', true );
		
		printf( '<div class="entry-meta">%s%s</div>', $categories, $summary );
				
		?>
	</header><!-- .entry-header -->
	
	<?php
		$thumbnail = sprintf( '<a href="%s">%s</a>', get_permalink(), get_the_post_thumbnail( get_the_ID(), 'medium', '' ) );
		$excerpt = firewell_excerpt( false, false );
		$more_link = sprintf( '<a href="%s" class="btn">read more</a>', get_permalink() );
			
		$pdf = get_post_meta( get_the_ID(), 'pdf', true );
			
		$related_links = related_links();
			
		$tags = get_the_term_list( get_the_ID(), 'research_tag' );
	?>
	
	<?php
	if( is_single() )
		printf( '<div class="excerpt">%s</div>',  $excerpt );
	?>


	<div class="entry-content">
		<?php
		if( is_single() ):
						
			$classes = !($pdf && $related_links && $tags ) ? ' full-width' : '';
			printf( '<div class="columns%s"><!-- full-width class is used when there is no sidebar content-->', $classes );
				
			the_post_thumbnail( 'large' );
				
			the_content();
			
			// footnotes
			$foot_notes = get_field( 'foot_notes' );
			if( $foot_notes )
				printf( '<div class="foot-notes">%s</div>', $foot_notes );
				
			print( '</div>' );
				
			// Show content sidebar if needed
			if( $pdf || $related_links || $tags ) :
					
				if( $pdf ) {
					$pdf = wp_get_attachment_url( $pdf );
					$pdf = sprintf( '<a href="%s" class="btn" target="_blank">Download PDF</a>', $pdf );
				}
					
				if ( $tags ) {
					$tags = sprintf( '<h4>Tags</h4><span class="tag-links">' . esc_html__( '%s' ) . '</span>', $tags );
				}
					
				printf( '<div class="columns"><div class="content-sidebar">%s%s%s</div></div>', $pdf, $related_links, $tags );
					
			endif;
		else:
			printf( '%s<div class="excerpt">%s%s</div>', $thumbnail, $excerpt, $more_link );
 		endif;
		?>
	</div><!-- .entry-content -->
	

	
	<?php
	// view all and social share
	$archive_link = get_post_type_archive_link( 'research' );
	$share = addtoany_share_icons();
	
	if( is_single() )
		printf( '<div class="research-footer"><a href="%s">View All Findings</a>%s</div>', $archive_link, $share );
	?>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'firewell' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
