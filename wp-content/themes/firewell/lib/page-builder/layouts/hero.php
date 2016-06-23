<?php
function layout_hero_block() {
 	
	printf( '<article class="hentry">%s</article>', get_sub_field( 'visual_editor' ) );	
	
 }