<?php 

function default_colors_admin_footer() { ?>
<script type="text/javascript">
(function($) {
acf.add_filter('color_picker_args', function( args, $field ){
// add the hexadecimal codes here for the colors you want to appear as swatches
args.palettes = ['#000000', '#FFFFFF', '#FFFDF2', '#FCCFCF', '#F5F3C4', '#DEF0D3', '#D1D7FC', '#EAD1FC',]
// return colors
return args;
});
})(jQuery);
</script>
<?php }
add_action('acf/input/admin_footer', 'default_colors_admin_footer');


function options_tabs_admin_footer() {?>
<script>
	(function($){
  // run when ACF is ready
  acf.add_action('ready', function(){
    // check if there is a hash
    if (location.hash.length>1){
      // get everything after the #
      var hash = location.hash.substring(1);
      // loop through the tab buttons and try to find a match
      $('.acf-tab-wrap .acf-tab-button').each(function(i, button){ 
        if (hash==$(button).text().toLowerCase().replace(' ', '-')){
          // if we found a match, click it then exit the each() loop
          $(button).trigger('click');
          return false;
        }
      });
    }
    // when a tab is clicked, update the hash in the URL
    $('.acf-tab-wrap .acf-tab-button').on('click', function($el){
      location.hash='#'+$(this).text().toLowerCase().replace(' ', '-');
    });
  });
})(jQuery);	
</script>
<?php }
add_action('acf/input/admin_footer', 'options_tabs_admin_footer');

function typography_preview($data) {
	
		echo '<div id="typography_preview"><strong><em>Preview:</em></strong> The quick brown fox jumps over the lazy dog</div>';?>
		<script>
			
			function typePreview() {
				var selectedFont = document.getElementById('acf-font_family').value;
				document.getElementById('typography_preview').style.fontFamily = selectedFont;
			}
			
			window.onload = function() { 
				typePreview();
			};
			
			document.getElementById('acf-font_family').onchange = function() { 
				typePreview();
			};
		</script>		
<?php
}
add_action('acf/render_field/key=field_60b197c7e84b7', 'typography_preview');


add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
	// Uncomment to view format of $toolbars
	/*
	echo '< pre >';
		print_r($toolbars);
	echo '< /pre >';
	die;
	*/

	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Very Simple' ] = array();
	$toolbars['Very Simple' ][1] = array('formatselect', 'bold' , 'italic' , 'underline', 'outdent', 'indent', 'blockquote', 'strikethrough', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'undo', 'redo', 'link', 'fullscreen');

	
	// remove the 'Basic' toolbar completely
	//unset( $toolbars['Basic' ] );

	// return $toolbars - IMPORTANT!
	return $toolbars;
}

add_filter('generate_logo', function($logo) {
	if (get_field('site_image', 'options')) {
		$logo = get_field('site_image', 'options');
	} else {
		$logo = $logo;
	}
	return $logo;
});

function site_meta_update() {
	$screen = get_current_screen();
    if (strpos($screen->id, "details") == true) {
		update_option('blogname', get_field('field_604521f2c57a1', 'options'));
		update_option('site_icon', get_field('site_icon', 'options'));
		//update_option ('site_image', get_field('site_image', 'options'));
	}
}
						
add_action( 'acf/save_post', 'site_meta_update' ); 
