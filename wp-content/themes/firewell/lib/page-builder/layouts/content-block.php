<?php

function layout_content_block() {
	
	
	print( '<article class="hentry">' );
	
	the_headline();
	
	the_content_columns();
	
	the_cta_buttons();
	
	print( '</article>' );
	
 }