<?php
/**
 * The template for displaying the footer.
 *
 * @package Poetry Garden
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div>
</div>


<div id="footer">
	
</div>

<?php
/**
 * generate_after_footer hook.
 *
 * @since 2.1
 */
do_action( 'generate_after_footer' );

wp_footer();
?>
<script>
   
window.onload = function() {
    setTimeout(function(){
  var siteAvatars = document.getElementsByClassName("siteavatar");
  var numSiteAvatars = siteAvatars.length;
  for (var i = 0; i < numSiteAvatars; i++) {
    var sa = siteAvatars[i];
    var a = sa.querySelector(".avatar");
    console.log(a);
  }
}, 3000); }
    
</script>
</body>
</html>

