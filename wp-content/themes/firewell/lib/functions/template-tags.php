<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package firewell
 */

if ( ! function_exists( 'firewell_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function firewell_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'firewell' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'firewell' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'firewell_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function firewell_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'firewell' ) );
		if ( $categories_list && firewell_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'firewell' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'firewell' ) );
		if ( $tags_list ) {
						printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'firewell' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'firewell' ), esc_html__( '1 Comment', 'firewell' ), esc_html__( '% Comments', 'firewell' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'firewell' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function firewell_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'firewell_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'firewell_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so firewell_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so firewell_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in firewell_categorized_blog.
 */
function firewell_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'firewell_categories' );
}
add_action( 'edit_category', 'firewell_category_transient_flusher' );
add_action( 'save_post',     'firewell_category_transient_flusher' );

/**
 * Return SVG markup.
 *
 * @param  string   $icon_name   Use the icon name, such as "facebook-square"
 */
function firewell_get_svg( $icon_name ) {

	$svg = '<svg class="icon icon-' . esc_html( $icon_name ) . '">';
	$svg .= '	<use xlink:href="#icon-' . esc_html( $icon_name ) . '"></use>';
	$svg .= '</svg>';

	return $svg;
}

/**
 * Echo SVG markup.
 *
 * @param  string   $icon_name   Use the icon name, such as "facebook-square"
 */
function firewell_do_svg( $icon_name ) {
	echo firewell_get_svg( $icon_name );
}

/**
 * Echo social icons with SVG.
 */
function firewell_do_social_icons() { ?>

	<ul class="social-icons">
		<li class="social-icon">
			<a href="https://www.facebook.com/#" title="Facebook"><?php firewell_do_svg( 'facebook-square' ); ?></a>
		</li>
		<li class="social-icon">
			<a href="https://twitter.com/#" title="Twitter"><?php firewell_do_svg( 'twitter-square' ); ?></a>
		</li>
		<li class="social-icon">
			<a href="https://instagram.com/#" title="LinkedIn"><?php firewell_do_svg( 'instagram' ); ?></a>
		</li>
		<li class="social-icon">
			<a href="https://www.youtube.com/channel/#" title="YouTube"><?php firewell_do_svg( 'youtube-square' ); ?></a>
		</li>
		<li class="social-icon">
			<a href="/feed" title="RSS Feed"><?php firewell_do_svg( 'rss-square' ); ?></a>
		</li>
	</ul>

<?php }

/**
 * Limit the excerpt.
 *
 * @param  int     $num_words  The word limit.
 * @param  string  $more       The "read more" text.
 *
 * @return string              The shortened excerpt.
 */
function firewell_get_the_excerpt( $num_words = 20, $more = '...' ) {
	return wp_trim_words( get_the_excerpt(), $num_words, $more );
}

/**
 * Echo an image, no matter what.
 *
 * @param string  $size  The image size you want to display.
 */
function firewell_do_post_image( $size = 'thumbnail' ) {

	// If featured image is present, use that
	if ( has_post_thumbnail() ) {
		return the_post_thumbnail( $size );
	}

	// Check for any attached image
	$media = get_attached_media( 'image', get_the_ID() );
	$media = current( $media );

	// Set up default image path
	$media_url = get_stylesheet_directory_uri() . '/images/placeholder.png';

	// If an image is present, then use it
	if ( is_array( $media ) && 0 < count( $media ) ) {
		$media_url = ( 'thumbnail' === $size ) ? wp_get_attachment_thumb_url( $media->ID ) : wp_get_attachment_url( $media->ID );
	}

	echo '<img src="' . esc_url( $media_url ) . '" class="attachment-thumbnail wp-post-image" alt="' . esc_html( get_the_title() )  . '" />';
}

/**
 * Return an image URI, no matter what.
 *
 * @param  string  $size  The image size you want to return.
 * @return string         The image URI.
 */
function firewell_get_post_image_uri( $size = 'thumbnail' ) {

	// If featured image is present, use that
	if ( has_post_thumbnail() ) {

		$featured_image_id = get_post_thumbnail_id( get_the_ID() );
		$media = wp_get_attachment_image_src( $featured_image_id, $size );

		if ( is_array( $media ) ) {
			return current( $media );
		}
	}

	// Check for any attached image
	$media = get_attached_media( 'image', get_the_ID() );
	$media = current( $media );

	// Set up default image path
	$media_url = get_stylesheet_directory_uri() . '/images/placeholder.png';

	// If an image is present, then use it
	if ( is_array( $media ) && 0 < count( $media ) ) {
		$media_url = ( 'thumbnail' === $size ) ? wp_get_attachment_thumb_url( $media->ID ) : wp_get_attachment_url( $media->ID );
	}

	return $media_url;
}
