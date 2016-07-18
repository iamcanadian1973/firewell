<?php

function layout_faq() {
	
	print( '<article class="hentry">' );
	
	the_headline();
	
	faq_block();
	
	print( '</article>' );
	
 }
 
 function faq_block() {
	
	// check if the repeater field has rows of data
if( have_rows('faq') ):

 	print( '<div class="accordion" data-collapse>' );
	
	// loop through the rows of data
    while ( have_rows('faq') ) : the_row();

        // display a sub field value
        $question = get_sub_field('question');
		
		if( $question ) {
			printf( '<h3>%s</h3>', $question );
			the_sub_field( 'answer' );
		}
		
		

    endwhile;
	
	print( '</div>' );

else :

    // no rows found

endif;
}