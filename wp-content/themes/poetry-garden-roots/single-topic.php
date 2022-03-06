<?php
/**
 * The Template for displaying all single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<span>
    <input type="checkbox" class="modal-input" id="forum-form">
	<div class="modal flex align-center justify-center"> 
	    <label class="modal-trigger" for ="forum-form">
        <div class="background">
        </div>
        </label>
        <div class="login-modal forum full-width" onclick="event.stopPropagation();">
            <div class="flex align-center justify-space-between">
                <h1>Create a New Post </h1>
                <label class="modal-trigger" for ="forum-form"><div class="x">+</div></label>
            </div>
			<?php bbp_get_template_part( 'form',       'topic'     ); ?>
		</div>
    </div>
</span>

<!--- Single Topic Template-->
	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
		    <div class="flex gap-1 mr-1">
		        
            <?php community_nav();?>
		    
			<div class="full-width">

<div id="bbpress-forums" class="bbpress-wrapper">

	<?php forum_header();?>
	
	  <div class="flex gap-2 mr-1">
         <div class="high-width">
             
    <div class="float-right">
	<?php //bbp_topic_subscription_link(); ?>

	<?php //bbp_topic_favorite_link(); ?>
    </div>
	<?php // do_action( 'bbp_template_before_single_topic' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php bbp_topic_tag_list(); ?>

		<?php //bbp_single_topic_description(); ?>

		<?php if ( bbp_show_lead_topic() ) : ?>

			<?php bbp_get_template_part( 'content', 'single-topic-lead' ); ?>

		<?php endif; ?>

		<?php if ( bbp_has_replies() ) : ?>

			<?php // bbp_get_template_part( 'pagination', 'replies' ); ?>
            <h3>Replies</h3>
			<?php bbp_get_template_part( 'loop',       'replies' ); ?>

			<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

		<?php endif; ?>

		<?php bbp_get_template_part( 'form', 'reply' ); ?>

	<?php endif; ?>

	<?php bbp_get_template_part( 'alert', 'topic-lock' ); ?>

	<?php do_action( 'bbp_template_after_single_topic' ); ?>
</div>
<div class="forum-col">
        <?php
        $parent_id = bbp_get_topic_forum_id(get_the_id()) ;
        ?>
        <a href="<?php the_permalink($parent_id); ?>"><?php svg_render(get_field('svg', $parent_id), 'full-width height-10r');?></a>
	    <h3><?php echo get_the_title($parent_id);?></h3>
	    <p><?php echo get_the_content(null, false, $parent_id);?></p>
<!---
	    <label class="modal-trigger" for ="forum-form"><div class="button">New Post</div></label>
	    <div class="button secondary"><?php bbp_forum_subscription_link($parent_id); ?></div>--->
	</div>

</div>

</div>
</div>
</div>
</main>
</div>
<?php get_footer();