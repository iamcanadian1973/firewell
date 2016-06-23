<?php

function get_accordions() {

	print( '<div class="row"><div class="small-12 columns">' );
			
	do_action( 'genesis_before_entry' );

	printf( '<article %s>', genesis_attr( 'entry' ) );
	
	do_action( 'genesis_entry_header' );
											
	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		
		do_action( 'genesis_entry_content' );
		
		$accordions = get_post_meta( get_the_ID(), 'accordions', true );
			
		if( $accordions ) {
					
			print( '<div class="accordions">' );
			
			foreach( range(0, --$accordions ) as $key ) {
				
				$title = esc_html( get_post_meta( get_the_ID(), 'accordions_' . $key . '_accordion_heading', true ) );
				
				printf('<h2>%s</h2>', $title );
				
				$accordion = esc_html( get_post_meta( get_the_ID(), 'accordions_' . $key . '_accordion', true ) );
				
				$this->get_accordion( $key, $accordion );
			}
		}
		
		print( '</div>' );
	
	echo '</div>'; //* end .entry-content
	do_action( 'genesis_after_entry_content' );
	
	
	do_action( 'genesis_entry_footer' );
	
	echo '</article>';

	do_action( 'genesis_after_entry' );
			
	echo '</div></div>';
	
}


function get_accordion( $parent,  $accordion ) {
			
	if( $accordion ) {
								
		print( '<div class="accordion">' );
		
		foreach( range(0, --$accordion ) as $key ) {

			$heading = esc_html( get_post_meta( get_the_ID(), 'accordions_' . $parent . '_accordion_' . $key . '_question', true ) );
			$content = get_post_meta( get_the_ID(), 'accordions_' . $parent . '_accordion_' . $key . '_answer', true );
			printf( '<div class="accordion-item"><h4>%s<span></span></h4><div>%s</div></div>', $heading, apply_filters( 'the_content', $content ) );
		}
		
		print( '</div>' );
	}
	
}


function kr_accordion( $title, $content ) {
	
	$out = '';
	$out .= '<div class="accordion" data-collapse>';
  	$out .=  sprintf( '<h4>%s</h4>', $title );
	$out .= '<div>';
	$out .=  $content;
	$out .= '</div>';
	$out .= '</div>';
	
	return $out;
}