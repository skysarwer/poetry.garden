<?php
/**
 * The template for displaying the footer.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="fixed bottom half-width">
<?php 
global $site_author;
if (get_current_user_id() == $site_author->ID) {
	echo '<span class="admin_message"><a href="'.site_url().'/wp-admin/admin.php?page=acf-options-general" target="blank">Site Admin</a></span>';
}	
?>
</div>

<!--- Framework --->
</div>

</body>
</html>
