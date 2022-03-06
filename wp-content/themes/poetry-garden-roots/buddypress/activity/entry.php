<?php
/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @since 3.0.0
 * @version 3.0.0
 */

bp_nouveau_activity_hook( 'before', 'entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>" data-bp-activity-id="<?php bp_activity_id(); ?>" data-bp-timestamp="<?php bp_nouveau_activity_timestamp(); ?>">
	<div class="activity-avatar item-avatar">

		<a href="<?php bp_activity_user_link(); ?>">

			<?php bp_activity_avatar( array( 'type' => 'full' ) ); ?>

		</a>

	</div>

	<div class="activity-content">

		<div class="activity-header">

			<?php bp_activity_action(); ?>

		</div>

		<?php if ( bp_nouveau_activity_has_content() ) : 
		
		?>
           <a class="activity-title very-subtle" target="_blank" href="<?php echo bp_activity_get_permalink(bp_get_activity_id());?>">
               <?php 
               $activity_publication = false;
               if(bp_get_activity_type() == 'new_poetry' || bp_get_activity_type() == 'new_fiction' || bp_get_activity_type() == 'new_non-fiction' ): 
               
               $activity_publication = true; ?>
                    
                    <h4><?php echo bp_activity_get_meta( bp_get_activity_id(), 'post_title' ); ?></h4>
            
                  <?php elseif(bp_get_activity_type() == 'bbp_topic_create') : ?>
                  <h4>
                   <?php echo get_the_title(bp_get_activity_item_id()); ?>
                </h4>
                <?php elseif(bp_get_activity_type() == 'bbp_reply_create'): ?>
                <h4><em>
                    <?php echo get_the_title(bp_get_activity_secondary_item_id()); 
                    
                    ?>
                </em></h4>
               <?php endif; ?>
              
			<div class="activity-inner <?php echo bp_get_activity_type(); ?>">
               
                    
				<?php bp_nouveau_activity_content(); ?>
			
			</div>
 </a>
		<?php endif; ?>

		<?php bp_nouveau_activity_entry_buttons(); ?>

	</div>

	<?php bp_nouveau_activity_hook( 'before', 'entry_comments' ); ?>

	<?php if ( bp_activity_get_comment_count() || ( is_user_logged_in() && ( bp_activity_can_comment() || bp_is_single_activity() ) ) ) : ?>

		<div class="activity-comments">

			<?php bp_activity_comments(); ?>

			<?php bp_nouveau_activity_comment_form(); ?>

		</div>

	<?php endif; ?>

	<?php bp_nouveau_activity_hook( 'after', 'entry_comments' ); ?>

</li>

<?php
bp_nouveau_activity_hook( 'after', 'entry' );
