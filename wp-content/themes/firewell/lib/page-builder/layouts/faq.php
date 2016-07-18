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
	
	$count = 1;
	
	// loop through the rows of data
    while ( have_rows('faq') ) : the_row();

        // display a sub field value
        $question = get_sub_field('question');
		
		if( $question ) {
			printf( '<h3 id="faq-%s">%s</h3>', $count, $question );
			print( '<div>' );
			the_sub_field( 'answer' );
			printf('<p><a class="faq-link" href="%s/#faq-%s">#</a></p>', get_permalink(), $count );
			print( '</div>' );
			$count++;
		}
		
		

    endwhile;
	
	print( '</div>' );

else :

    // no rows found

endif;
}