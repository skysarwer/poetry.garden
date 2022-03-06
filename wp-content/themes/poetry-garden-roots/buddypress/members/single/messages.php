<?php
/**
 * BuddyPress - Users Messages
 *
 * @version 3.0.0
 */
?>


<?php
if ( ! in_array( bp_current_action(), array( 'inbox', 'sentbox', 'starred', 'view', 'compose', 'notices' ), true ) ) :

	bp_get_template_part( 'members/single/plugins' );

else :

	bp_nouveau_messages_member_interface();

endif;
?>
