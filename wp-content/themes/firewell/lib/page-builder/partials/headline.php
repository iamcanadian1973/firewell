<?php
add_filter( 'page_builder_attr_section-header', function( $attr ) {
	$attr['class'] .= '';
	return $attr;
});

function the_headline() {
	echo get_headline();
}

function get_headline() {
	
	$headline    = get_sub_field( 'headline' );
	$heading_size  = get_sub_field( 'heading_size' );
	$subheadline   = get_sub_field( 'subheadline' );
	$intro_text    = get_sub_field( 'intro_text' );
	
	
	if( $headline || $subheadline ) {
		
		$heading_size = pb_set_default_value( $heading_size, 'h2' );
				
		$headline = sprintf( '<%1$s class="section-title" itemprop="headline"><span>%2$s</span></%1$s>', $heading_size, $headline );
		
		if( $subheadline ) {
			$subheadline = sprintf( '<h3>%s</h3>', $subheadline );
		}
		
		if( $intro_text ) {
			$intro_text = sprintf( '<div class="intro-text">%s</div>', $intro_text );
		}
		
		return sprintf( '<header %s>%s%s%s</header>', page_builder_attr( 'entry-header' ), $headline, $subheadline, $intro_text );		
	}
	
}
