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
<?php if ( ! bbp_is_forum_category() ) : ?>
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
<?php endif; ?>
<!--- Single Forum Template-->
	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
		    <div class="flex gap-1 mr-1">
		        
            <?php community_nav();?>
		    
			<div class="full-width">
			   
		    <div id="bbpress-forums" class="bbpress-wrapper"> <!--- styles for forum grid --->


<?php forum_header(); ?>
    
     <div class="flex gap-2 mr-1">
         <div class="high-width">

	



	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php // bbp_single_forum_description(); ?>

		<?php if ( bbp_has_forums() ) : ?>
      	<?php bbp_get_template_part( 'loop',       'forums'    ); ?>
    
		<?php endif; ?>

		<?php if ( ! bbp_is_forum_category() && bbp_has_topics() ) : ?>

			<?php //bbp_get_template_part( 'pagination', 'topics'    ); ?>

			<?php bbp_get_template_part( 'loop',       'topics'    ); ?>

			<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

			

		<?php 
		// if no topics on non category topic
		elseif ( ! bbp_is_forum_category() ) : ?>

			<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

		<?php endif; ?>

	<?php endif; ?>
</div>
<div class="forum-col">
        <a href="<?php the_permalink(); ?>"><?php svg_render(get_field('svg'), 'full-width height-10r');?></a>
	    <h3><?php the_title();?></h3>
	    <p><?php the_content();?></p>
	    <?php if ( ! bbp_is_forum_category()) :
	        if(is_user_logged_in()): ?>
	        <label class="modal-trigger" for ="forum-form"><div class="button">New Post</div></label>
	        <div class="button secondary"><?php bbp_forum_subscription_link(); ?></div>
	        <?php else : ?>
	        <p>You need to be <label class="modal-trigger base" for="header-login">logged in</label> to post in the forums.</p>
	        <?php endif;?>
	        
	    <?php else: 
	       echo '<ul>';
	       $child_forums = new wp_query(array('post_type' => 'forum', 'post_parent' => get_the_ID(), 'order' => 'asc'));
	        $parent_name = $post->post_name;
	        while ($child_forums->have_posts()) {
            $child_forums->the_post();
            echo '<li class="list-title forum-archive full-width"><a class="flex gap-3 align-center" href="'.site_url().'/community/forum/'.$parent_name.'/'.$post->post_name.'">'; svg_render(get_field('svg')); echo get_the_title() . '</a></li>';
        }
        wp_reset_query();
         echo '</ul>';
        endif;?>
        
	</div>

</div>


</div>

	</div> <!--- inside-article --->
	
	</div>
		</main>
</div> <?php
	get_footer();
