<?php
/**
 * BuddyPress - Users Activity
 *
 * @since 3.0.0
 * @version 3.0.0
 */

?>
<div class="flex gap-2 mp-column">
<div>
    <?php 
    $bio = xprofile_get_field( 6,  bp_displayed_user_id());
    $stamp = xprofile_get_field(23, bp_displayed_user_id());
    if ($bio->data->value != '' || $stamp->data->value != ''):
    echo '<div class="member-column">';
    if ($bio->data->value != ''):
        echo '<div class="member-bio">'.$bio->data->value.'</div><br/>';
    endif;
    if ($stamp->data->value != ''):
        echo '<br/><div class="member-stamp flex"><a class="no-bg" href="'.xprofile_get_field(9, bp_displayed_user_id())->data->value.'" target="_blank" title="'.xprofile_get_field(9, bp_displayed_user_id())->data->value.'"><img src="'.site_url().'/wp-content'.$stamp->data->value.'"></a></div>';
    endif;
    echo '</div>';
    endif;
    ?>
    
</div><div class="flex-grow">
<h3 class="ml-1">
	<?php esc_html_e( 'Recent Activities', 'buddypress' ); ?>
</h3>

<?php //bp_get_template_part( 'common/search-and-filters-bar' ); ?>

<?php bp_nouveau_member_hook( 'before', 'activity_content' ); ?>

<div id="activity-stream" class="activity single-user" data-bp-list="activity">

	<div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'member-activity-loading' ); ?></div>

	<ul  class="<?php bp_nouveau_loop_classes(); ?>" >

	</ul>

</div><!-- .activity -->

<?php
bp_nouveau_member_hook( 'after', 'activity_content' ); ?>
</div>
</div>
<?php
