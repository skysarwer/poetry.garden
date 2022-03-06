<?php

/**
 * Archive Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

$site_wide_forums =  new wp_query(array('post_type' => 'topic', 'order' => 'asc'));


?>

<div id="bbpress-forums" class="bbpress-wrapper">
<!--- content-archive-forum--->
	<?php // bbp_get_template_part( 'form', 'search' ); ?>

	<?php forum_header(); ?>
	
	<h3>Recent Posts</h3>
	
	<div>
	    <?php 
	 
	        
	    echo do_shortcode('[bbp-topic-index]');
	      
	    ?>
	</div>

	<?php// bbp_forum_subscription_link(); ?>

	<?php //do_action( 'bbp_template_before_forums_index' ); ?>

	<?php // if ( bbp_has_forums() ) : ?>

		<?php //bbp_get_template_part( 'loop',     'forums'    ); ?>

	<?php // else : ?>

		<?php// bbp_get_template_part( 'feedback', 'no-forums' ); ?>

	<?php // endif; ?>

	<?php //do_action( 'bbp_template_after_forums_index' ); ?>

</div>
