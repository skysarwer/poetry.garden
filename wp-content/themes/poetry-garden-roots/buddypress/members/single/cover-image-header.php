<?php
/**
 * BuddyPress - Users Cover Image Header
 *
 * @since 3.0.0
 * @version 3.0.0
 */
?>

<div id="cover-image-container">
	<div id="header-cover-image"></div>
	<div id="item-header-cover-image">
		<div id="item-header-avatar">
			<a class="no-bg" href="<?php bp_displayed_user_link(); ?>">

				<?php bp_displayed_user_avatar( 'type=full' ); ?>

			</a>
		</div><!-- #item-header-avatar -->

		<div id="item-header-content">

			<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
			    <h2 class="user-nicename"><?php echo get_user_by('ID', bp_displayed_user_id())->nickname; ?></h2>
				<h3 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h3>
			<?php endif; ?>
				</div><!-- #item-header-content -->
		     <div class="absolute member-meta full-width">
	    <div class="member-bar flex justify-space-between align-center relative">
	         <div class="bar-cont flex m-column">
			<?php
			
				global $uri_segments;
		    if($uri_segments[4] == 'profile' || $uri_segments[4] == 'settings') {
		         echo '<a class="wt" href="'.site_url().'/community/members/me">&larr; Return to Profile</a>';
		    } else { 
		       
if ( function_exists( 'bp_follow_total_follow_counts' ) ) :
	$follow_count = bp_follow_total_follow_counts( array('user_id' => bp_displayed_user_id()));
    echo '<p class="wt full-width d-mb-0 pt-05">'.$follow_count['followers'].' Followers | '.$follow_count['following'].' Following</p>';
	// uncomment the next line to output the following count for user ID 5
	// echo $count['following'];

	// uncomment the next line to output the followers count for user ID 5
	// echo $count['followers'];
endif;

		    ?>
		    <div class="actions flex justify-end full-width">
		    <?php if (is_user_logged_in() && get_current_user_id() != bp_displayed_user_id()) {
			bp_nouveau_member_header_buttons(
				array(
					'container'         => 'ul',
					'button_element'    => 'button',
					'container_classes' => array( 'member-header-actions' ),
				)
			);
			
			$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
            echo '<ul class="member-header-actions action"><li class="generic-button msg"><a class="button secondary" href="' . $escaped_url . '/?new-message&fast=1&to='.bp_get_displayed_user_mentionname().'">Message</a></li></ul>';
		} else if (is_user_logged_in()) {
		    echo '<a class="button secondary" href="'.site_url().'/community/members/me/profile/edit">Edit Profile</a>';
		}
?> </div> <?php } ?>
</div>
</div>
<div class="relative justify-space-between flex wrap bar-cont m">
     <?php
    $member_website = xprofile_get_field( 7,  bp_displayed_user_id())->data->value;
    echo '<a href="'.$member_website.'" title="'.$member_website.'" target="_blank">'.$member_website.'</a>';
    ?>
    
    <?php if (  bp_has_profile('profile_group_id=3') ) : ?>
  <?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
    
   
    <?php if ( bp_profile_group_has_fields() ) : ?>
 
 
        <ul class="flex gap-1 justify-end wrap flex-grow" id="profile-group-fields">
        <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
 
          <?php if ( bp_field_has_data() ) : ?>
          <li>
              <?php 
               $mp_value = xprofile_get_field( bp_get_the_profile_field_id(),  bp_displayed_user_id())->data->value;
               if (bp_get_the_profile_field_id() == '26') {
              echo '<a class="no-bg" href="mailto:'.$mp_value.'" title="'.$mp_value.'" target="blank">';
               } else {
                echo '<a class="no-bg" href="'.$mp_value.'" title="'.$mp_value.'" target="blank">';      
               }
              mp_svg_render(call_user_func('mp_' . bp_get_the_profile_field_id())); 
              echo '</a>';
              
              ?>
            
            <?php //bp_the_profile_field_name() ?>
            <?php //bp_the_profile_field_value() ?>
          </li>
          <?php endif; ?>
 
        <?php endwhile; ?>
        </ul>
 
    <?php endif; ?>
 
  <?php endwhile; ?>
     <?php endif; ?>
    
</div></div>
			<?php bp_nouveau_member_hook( 'before', 'header_meta' ); ?>

			<?php if ( bp_nouveau_member_has_meta() ) : ?>
			<!---	<div class="item-meta">

					<?php // bp_nouveau_member_meta(); ?>

				</div><!-- #item-meta -->
			<?php endif; ?>

	

	</div><!-- #item-header-cover-image -->
</div><!-- #cover-image-container -->
