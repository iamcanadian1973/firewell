<?php
/**
 * The template for displaying search forms in _s
 *
 * @package _s
 * @since _s 1.0
 */
 
 static $search_form_id;
 $search_form_id++;
?>
	<div id="search-form-<?php echo $search_form_id;?>" class="searchbox">
	<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="screen-reader-text"><?php _ex( 'Search', 'assistive text', '_s' ); ?></label>
		<input type="search" class="searchbox-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', '_s' ); ?>" />
		<input type="submit" class="searchbox-submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Go', 'submit button', '_s' ); ?>" />
		<span class="searchbox-icon">Go</span>
	</form>
	</div>