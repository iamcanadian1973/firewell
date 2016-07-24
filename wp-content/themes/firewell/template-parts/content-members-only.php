<?php
/**
 * Template part for displaying members only content message
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Firewell
 */

?>

<section>
	<?php
	$firewell_members_only_message = firewell_members_only_message();
	
	if( $firewell_members_only_message ) {
		echo $firewell_members_only_message;
	}
	?>
</section><!-- .content-members-only -->
