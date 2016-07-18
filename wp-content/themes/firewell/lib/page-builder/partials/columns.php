<?php

function the_content_columns() {
	echo get_content_columns();
}

function get_content_columns() {
	
	$columns = '';
	
	$column_count =  count( get_sub_field('columns') );
	
	$current_column = 0;
	
	if ( have_rows('columns') ):
						
		while ( have_rows('columns') ):
				
			the_row();
			
			$current_column++;
			
			$column_classes = 'columns';
			
			$content_type = sanitize_title( get_sub_field( 'content_type' ) );
				
			$visual_editor = get_sub_field( 'visual_editor' );
			//$visual_editor = apply_filters( 'pb_the_content', $visual_editor );
			
			
			$image = get_sub_field( 'image' );
			
			if( $content_type == 'image' && $image ) {				
				$content = pb_get_image( $attachment['ID'] );
			}
			elseif( $content_type == 'gallery' ) {
				$content = $gallery;
			}
			else {
				$content = $visual_editor;
			}
							
			$columns .= sprintf( '<div class="%s">%s</div>', $column_classes, $content );
				
		endwhile;
						
		return sprintf( '<div class="entry-content clearfix">%s</div>', $columns );
					
	endif;		
	
	return FALSE;
}


function get_column_classes( $column_count ) {
	$columns = array(
			1 => array( 'small-12', 'columns' ),
			2 => array( 'small-12', 'large-6', 'columns' ), 
			3 => array( 'small-12', 'large-4', 'columns' ), 
	);
	
	
	if( isset( $columns[ $column_count ] ) ) {
		return implode( ' ', $columns[ $column_count ] );
	}
	
}