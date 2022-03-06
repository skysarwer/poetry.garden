<?php
/**
 * BuddyPress - Blogs Loop
 *
 * @since 3.0.0
 * @version 3.0.0
 * @version 4.3.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_has_blogs( bp_ajax_querystring( 'blogs' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="blogs-list" class="<?php bp_nouveau_loop_classes(); ?>">

	<?php
	while ( bp_blogs() ) :
		bp_the_blog();
		$site_author = get_user_by('ID', get_blog_option(bp_get_blog_id(), 'site_author'));
		
	?>
    
		<li <?php bp_blog_class( array( 'item-entry' ) ); ?>>
			<div class="list-wrap">

				<div class="item-avatar">
				    <?php if (get_blog_option(bp_get_blog_id(), 'options_site_image')) {
				        switch_to_blog(bp_get_blog_id());
				        $picture_object = get_field ('site_image', 'options');
				        echo '<a href="'.site_url().'">'.wp_get_attachment_image( $picture_object, 'medium', false, array('alt' => 'Site image for '.get_bloginfo( 'name' ))).'</a>';
				        restore_current_blog();
				    } else { ?>
					<a class="siteavatar" href="<?php bp_blog_permalink(); ?>"><?php  echo custom_bp_get_blog_avatar( bp_nouveau_avatar_args() ); ?>
				<!---<img src="https://poetry.garden/img/site-avatar.png">--></a> <?php } ?>
				</div>

				<div class="item">

					<div class="item-block">

						<h2 class="list-title blogs-title"><a class="very-subtle" href="<?php bp_blog_permalink(); ?>"><?php bp_blog_name(); ?></a></h2>
						<?php if ($site_author->id != '') { ?>
						<p>by <a href="<?php echo site_url();?>/community/members/<?php echo $site_author->user_login;?>"><?php echo $site_author->nickname;?></a></p>
						<?php } ?>

						<p class="last-activity item-meta"><?php bp_blog_last_active(); ?></p>

						<?php if ( bp_nouveau_blog_has_latest_post() ) : ?>
							<p class="meta last-post">

								<?php // bp_blog_latest_post(); ?>

							</p>
						<?php endif; ?>
                        <ul class="flex blogs-meta action">
                            <li class="generic-button"><a href="<?php bp_blog_permalink();?>" class="blog-button visit button">Visit Site</a></li>
                            <?php if (is_user_logged_in() && get_current_user_id() == $site_author->id): ?>
                             <li class="generic-button"><a href="<?php bp_blog_permalink();?>wp-admin/admin.php?page=site_details" class="blog-button admin button secondary">Edit Site</a></li>
                             <?php endif; ?>
                            </ul>
						<?php //bp_nouveau_blogs_loop_buttons( array( 'container' => 'ul' ) ); ?>

					</div>

					<?php bp_nouveau_blogs_loop_item(); ?>

				</div>



			</div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php else : ?>

	<?php bp_nouveau_user_feedback( 'blogs-loop-none' ); ?>

<?php endif; ?>

<?php
bp_nouveau_after_loop();
