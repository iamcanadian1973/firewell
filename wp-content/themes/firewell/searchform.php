<?php
/**
 * The template for displaying search forms in _s
 *
 * @package _s
 * @since _s 1.0
 */
 
?>
	<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s">
		<input type="search" class="searchbox-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', '_s' ); ?>" />
		</label>
		<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', '_s' ); ?>" />
	</form>