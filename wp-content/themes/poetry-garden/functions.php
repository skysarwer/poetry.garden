<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

//remove auto paragraph tags
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

function site_meta_update() {
	$screen = get_current_screen();
    if (strpos($screen->id, "details") == true) {
		update_option('blogname', get_field('field_604521f2c57a1', 'options'));
		update_option('site_icon', get_field('site_icon', 'options'));
		//update_option ('site_image', get_field('site_image', 'options'));
	}
}
						
add_action( 'acf/save_post', 'site_meta_update' ); 

// Remove Feed Links
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);

// Remove Smilies
add_filter( 'emoji_svg_url', '__return_false');
remove_filter('comment_text', 'convert_smilies', 20);
remove_filter('the_excerpt', 'convert_smilies');
remove_filter('the_content', 'convert_smilies');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('init', 'smilies_init', 5);

// Remove Unneccessary Header Code
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links');

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_separate', trailingslashit( get_stylesheet_directory_uri() ) . 'ctc-style.css', array( 'generate-style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
//if (
	//!current_user_can('administrator') && 
//	!is_admin()) {
  show_admin_bar(false);
//}
}

add_action('admin_menu','remove_menu_items');
function remove_menu_items() {
	remove_menu_page('edit.php');
	remove_menu_page('plugins.php');
	remove_menu_page('users.php');
	remove_menu_page('themes.php');
	remove_menu_page('user-registration');
	remove_menu_page('upload.php');
	remove_menu_page('index.php');
	remove_submenu_page( 'tools.php', 'site-health.php' );
	remove_submenu_page( 'tools.php', 'tools.php' );
	if (get_current_user_id() != '1') {
		remove_menu_page('edit.php?post_type=acf-field-group');
		remove_menu_page('options-general.php');
	}
}

add_action('admin_menu', 'add_menu_items', 100);
function add_menu_items(){
     // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( 'Profile', 'Profile', 'manage_options', 'profile.php?page=bp-profile-edit', '', 'dashicons-admin-users', 7 );
	add_submenu_page( 'tools.php', 'Discussion Settings', 'Discussion Settings', 'manage_options', 'options-discussion.php', '', 2);
}

function add_acf_menu_pages()
{
	acf_add_options_page(array(
        'page_title' => 'Site Details',
        'menu_title' => 'Site Details',
        'menu_slug' => 'site_details',
        'capability' => 'manage_options',
        'position' => 6,
        'redirect' => true,
        'icon_url' => 'dashicons-admin-home',
        'update_button' => 'Update Site',
        'updated_message' => 'Options saved <a href="'.site_url().'" target="blank">View Site</a>',
		'autoload' => true,
		
    ));
	
    acf_add_options_page(array(
        'page_title' => 'Customize',
        'menu_title' => 'Customize',
        'menu_slug' => 'customize',
        'capability' => 'manage_options',
        'position' => 7,
        'redirect' => true,
        'icon_url' => 'dashicons-admin-appearance',
        'update_button' => 'Save options',
        'updated_message' => 'Options saved <a href="'.site_url().'" target="blank">View Site</a>',
		'autoload' => true,
		
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'General',
        'menu_title' => 'General',
        'parent_slug' => 'customize',
		 'updated_message' => 'Options saved <a href="'.site_url().'" target="blank">View Site</a>',
    ));

	    acf_add_options_sub_page(array(
        'page_title' => 'Page Flaps',
        'menu_title' => 'Page Flaps',
        'parent_slug' => 'customize',
		'updated_message' => 'Options saved <a href="'.site_url().'" target="blank">View Site</a>',
    ));

		    acf_add_options_sub_page(array(
        'page_title' => 'Site Templates',
        'menu_title' => 'Site Templates',
        'parent_slug' => 'customize',
		 'updated_message' => 'Options saved <a href="'.site_url().'" target="blank">View Site</a>',
    ));
	
		  acf_add_options_sub_page(array(
        'page_title' => 'Menus',
        'menu_title' => 'Menus',
        'parent_slug' => 'customize',
			  	'autoload' => true,
		 'updated_message' => 'Menu updated <a href="'.site_url().'" target="blank">View Site</a>',
    ));
	
    acf_add_options_sub_page(array(
        'page_title' => 'Header',
        'menu_title' => 'Header',
        'parent_slug' => 'customize',
		 'updated_message' => 'Options saved <a href="'.site_url().'" target="blank">View Site</a>',
    ));
	
	   acf_add_options_sub_page(array(
        'page_title' => 'Footer',
        'menu_title' => 'Footer',
        'parent_slug' => 'customize',
		    'updated_message' => 'Options saved <a href="'.site_url().'" target="blank">View Site</a>',
    ));
	
}
add_action('acf/init', 'add_acf_menu_pages');



//add_action('init', function() {remove_post_type_support( 'page', 'editor' );});

function remove_personal_options(){
    echo '<script type="text/javascript">jQuery(document).ready(function($) {
  
$(\'form#your-profile > h2:first\').remove(); // remove the "Personal Options" title
  
$(\'form#your-profile tr.user-rich-editing-wrap\').remove(); // remove the "Visual Editor" field
 
$(\'form#your-profile tr.user-admin-color-wrap\').remove(); // remove the "Admin Color Scheme" field
  
$(\'form#your-profile tr.user-comment-shortcuts-wrap\').remove(); // remove the "Keyboard Shortcuts" field
 
 
$(\'form#your-profile tr.user-syntax-highlighting-wrap\').remove(); // remove the "Syntax Highlighting" field

 
$(\'form#your-profile tr.user-admin-bar-front-wrap\').remove(); // remove the "Toolbar" field
  
$(\'form#your-profile tr.user-language-wrap\').remove(); // remove the "Language" field
  
$(\'form#your-profile tr.user-first-name-wrap\').remove(); // remove the "First Name" field
  
$(\'form#your-profile tr.user-last-name-wrap\').remove(); // remove the "Last Name" field

//$(\'form#your-profile tr.user-nickname-wrap\').remove(); // remove the "Nickname" field

$(\'form#your-profile div#application-passwords-section\').remove();
  
$(\'form#your-profile tr.user-nickname-wrap\').hide(); // Hide the "nickname" field
  
$(\'table.form-table tr.user-display-name-wrap\').hide(); // hide the “Display name publicly as” field

$(\'table.form-table tr.user-tsf_facebook_page-wrap\').hide(); 

$(\'table.form-table tr.user-tsf_twitter_page-wrap\').hide(); 

$(\'table.form-table tr.user-url-wrap\').remove();// remove the "Website" field in the "Contact Info" section
  
$(\'h2:contains("About Yourself"), h2:contains("About the user"), h2:contains("Authorial Info")\').remove(); // remove the "About Yourself" and "About the user" titles
  
$(\'form#your-profile tr.user-description-wrap\').remove(); // remove the "Biographical Info" field
  
$(\'form#your-profile tr.user-profile-picture\').remove(); // remove the "Profile Picture" field
  
$(\'table.form-table tr.user-aim-wrap\').remove();// remove the "AIM" field in the "Contact Info" section
 
$(\'table.form-table tr.user-yim-wrap\').remove();// remove the "Yahoo IM" field in the "Contact Info" section
 
$(\'table.form-table tr.user-jabber-wrap\').remove();// remove the "Jabber / Google Talk" field in the "Contact Info" section
 
$(\'h2:contains("Name")\').remove(); // remove the "Name" heading

$(\'#generate_layout_options_meta_box\').remove();
 
$(\'h2:contains("Contact Info")\').remove(); // remove the "Contact Info" heading

$(\'div.bp-profile-field.field_2\').remove();

$(\'div.bp-profile-field.field_3\').remove();
 
});</script>';
}
add_action('admin_head','remove_personal_options');

//add_action('admin_head-user-edit.php', 'setup_user_edit');
//add_action('admin_head-profile.php', 'setup_user_edit');
add_action('admin_head', 'setup_user_edit');
function setup_user_edit() {
    add_filter('gettext', 'change_extended_profile');
	add_filter('gettext', 'profile_label');
}
function change_extended_profile($input) {
    if ('Extended Profile' == $input)
        return 'Profile Information';
    return $input;
}
function profile_label($input) {
	 if ('Profile' == $input)
		 return 'Account Settings';
	return $input;
}


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

function generate_comment( $comment, $args, $depth ) {
		$args['avatar_size'] = apply_filters( 'generate_comment_avatar_size', 65 );

		if ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'generatepress' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'generatepress' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" <?php generate_do_element_classes( 'comment-body', 'comment-body' ); ?>>
				<footer class="comment-meta">
					<?php
					if ( 0 != $args['avatar_size'] ) { // phpcs:ignore
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<div class="comment-author-info">
						<div <?php generate_do_element_classes( 'comment-author' ); ?>>
							<?php printf( '<cite itemprop="name" class="fn">%s</cite>', get_comment_author_link() ); ?>
						</div>

						<div class="entry-meta comment-metadata">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
									<?php
										printf(
											/* translators: 1: date, 2: time */
											_x( '%1$s at %2$s', '1: date, 2: time', 'generatepress' ), // phpcs:ignore
											get_comment_date(), // phpcs:ignore
											get_comment_time() // phpcs:ignore
										);
									?>
								</time>
							</a>
							<?php edit_comment_link( __( 'Edit', 'generatepress' ), '<span class="edit-link">| ', '</span>' ); ?>
						</div>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : // phpcs:ignore ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'generatepress' ); ?></p>
					<?php endif; ?>
				</footer>

				<div class="comment-content" itemprop="text">
					<?php
					/**
					 * generate_before_comment_content hook.
					 *
					 * @since 2.4
					 */
					do_action( 'generate_before_comment_text', $comment, $args, $depth );

					comment_text();

					/**
					 * generate_after_comment_content hook.
					 *
					 * @since 2.4
					 */
					do_action( 'generate_after_comment_text', $comment, $args, $depth );
					?>
				</div>
			</article>
			<?php
		endif;
	}

add_filter( 'avatar_defaults', 'wpb_new_gravatar' );
function wpb_new_gravatar ($avatar_defaults) {
$myavatar = '404';
$avatar_defaults[$myavatar] = "No Default Gravatar";
return $avatar_defaults;
}

function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = get_field( 'writing', $post_id ); //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 30; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

   // $the_excerpt = '<p>' . $the_excerpt . '</p>';

    return $the_excerpt;
}

//SEO

add_filter( 'the_seo_framework_fetched_description_excerpt', function( $excerpt, $post_id ) {
	$field = function_exists( 'get_field' ) ? preg_replace( "/\r|\n/", " ", get_excerpt_by_id($post_id) ) : '';
	return $field ?: $excerpt;
}, 10, 2 );

add_filter('generate_logo', function($logo) {
	if (get_field('site_image', 'options')) {
		$logo = get_field(site_image, 'options');
	} else {
		$logo = $logo;
	}
	return $logo;
});

require_once get_stylesheet_directory().'/template-functions.php';
require_once get_stylesheet_directory().'/custom-post-types.php';

add_filter('acf/format_value/type=text', 'do_shortcode');


/*function get_post_by_name($post_name, $output = OBJECT) {
    global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type='post'", $post_name ));
        if ( $post ) {
            return get_post($post, $output);
		} else {
    return null;
		}
}*/



/*function syndicate_comment( $comment_ID, $comment_approved, $commentdata) {
    
    $site_id = get_current_blog_id();
    
    $post_name = '0'.$site_id.'0'.$commentdata['comment_post_ID'].'0';
    
    $comment_args =  array ( 
        'meta_query' => array (
            
            array (
                
                'key' => 'syndicated_id',
                'value' => $comment_ID,
                
            ),
            
            array (
                
                'key' => 'syndicated_site',
                'value' => $site_id,
                
            ),
            
        ),
    );
    
    switch_to_blog(1);
    
    $post_id = get_post_by_name($post_name)->ID;
    
    $comment_query = new WP_Comment_Query;
    
    $comment_results = $comment_query->query($comment_args);
    
    if (empty($comment_results)) {
        
        if ($commentdata['comment_parent'] != '') {
        
            $parent_args =  array ( 
                'meta_query' => array (
                    
                    array (
                        
                        'key' => 'syndicated_id',
                        'value' => $commentdata['comment_parent'],
                        
                        ),
                    
                    array (
                        
                        'key' => 'syndicated_site',
                        'value' => $site_id,
                        
                        ),
                    
                    ),
            );
        
            $parent_query = new WP_Comment_Query;
            
            $parent_results = $parent_query->query($parent_args);
            
            $synced_comment_parent = $parent_results[0]->comment_ID;
        
        } else {
        
           $synced_comment_parent = 0;
        }
        
        $new_commentdata = array (
        
            'comment_author' => $commentdata['comment_author'],
            'comment_author_email' =>  $commentdata['comment_author_email'],
            'comment_author_url' =>  $commentdata['comment_author_url'],
            'comment_content' =>  $commentdata['comment_content'],
            'comment_date' => $commentdata['comment_date'],
            'comment_date_gmt' => $commentdata['comment_date_gmt'],
            //'comment_type' => $commentdata['comment_content'],
            'comment_parent' => $synced_comment_parent,
            'comment_post_ID' => $post_id, 
            'user_id' => $commentdata['user_id'],
            'comment_agent' =>  $commentdata['comment_agent'],
            'comment_author_IP' =>  $commentdata['comment_author_IP'],
            'comment_meta' => array (
                
                        'syndicated_id' => $comment_ID,
                        'syndicated_site' => $site_id,
    
                ),
        
        );
        
        remove_action ('comment_post', 'syndicate_comment', 11, 3); 
        
        wp_new_comment ($new_commentdata);
        
        add_action('comment_post', 'syndicate_comment', 11, 3); 
    }
    
    restore_current_blog();
    
}*/
//add_action('comment_post', 'syndicate_comment', 11, 3); 

function poetry_garden_svg($is_post = false) {
	if(get_field('field_60b1e0c228d43', 'options')):?> 
	 
	<a class="ml-2 pg-sig" href="
	<?php
	if ($is_post == true) {
	    global $post;
	    echo 'https://poetry.garden/p/0'.get_current_blog_id().'0'.$post->ID.'0';
	} else {
        echo 'https://poetry.garden/community/publications';
    }
	 ?>" target="blank"><svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="21.1666mm" height="18.6266mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 2117 1863"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <defs>
  <style type="text/css">
   <![CDATA[
    .str0 {stroke:#C4BE9A;stroke-width:13.92}
    .fil23 {fill:none}
    .fil15 {fill:#324B2D}
    .fil7 {fill:#415C36}
    .fil0 {fill:#496739}
    .fil8 {fill:#5C701D}
    .fil1 {fill:#5D701C}
    .fil18 {fill:#5D7D33}
    .fil9 {fill:#658549}
    .fil16 {fill:#7EA149}
    .fil19 {fill:#89960C}
    .fil13 {fill:#B84565}
    .fil12 {fill:#C93C54}
    .fil21 {fill:#CBDB65}
    .fil10 {fill:#D54B65}
    .fil6 {fill:#E87787}
    .fil5 {fill:#EC637D}
    .fil14 {fill:#F97C93}
    .fil11 {fill:#FD92A3}
    .fil2 {fill:#FFA6B2}
    .fil3 {fill:#FFBDC6}
    .fil4 {fill:#FFDCE2}
    .fil24 {fill:var(--site-text)}
    .fil22 {fill:url(#id0)}
    .fil17 {fill:url(#id1)}
    .fil20 {fill:url(#id2)}
   ]]>
  </style>
  <linearGradient id="id0" gradientUnits="userSpaceOnUse" x1="436.91" y1="1694.9" x2="1206.28" y2="1694.9">
   <stop offset="0" style="stop-opacity:1; stop-color:#F0ECD4"/>
   <stop offset="0.501961" style="stop-opacity:1; stop-color:#FFFDF2"/>
   <stop offset="1" style="stop-opacity:1; stop-color:#F0EBD3"/>
  </linearGradient>
  <linearGradient id="id1" gradientUnits="userSpaceOnUse" x1="1529.15" y1="760.6" x2="1796.94" y2="760.6">
   <stop offset="0" style="stop-opacity:1; stop-color:#EBE3B7"/>
   <stop offset="1" style="stop-opacity:1; stop-color:white"/>
  </linearGradient>
  <linearGradient id="id2" gradientUnits="userSpaceOnUse" x1="1413.54" y1="704.17" x2="951.56" y2="1721.85">
   <stop offset="0" style="stop-opacity:1; stop-color:#EDE8CE"/>
   <stop offset="0.258824" style="stop-opacity:1; stop-color:#F6F2E0"/>
   <stop offset="1" style="stop-opacity:1; stop-color:#FFFDF2"/>
  </linearGradient>
 </defs>
 <g id="Layer_x0020_1">
  <path class="fil0" d="M900 929c-1,-34 -7,-90 1,-120 11,-45 35,-33 51,-70 -15,-6 -16,5 -26,-16 -5,-11 -7,-24 -12,-33 -11,-21 -21,-6 -52,-36 -11,32 -7,42 1,74 -19,-12 -51,-78 -82,-94 -13,-6 -22,-3 -34,-8 -7,-3 -44,-41 -80,-55l32 86c41,120 70,64 105,135 18,37 38,39 68,52 15,6 14,23 15,43 1,18 5,46 -1,60 0,0 14,-18 14,-18z"/>
  <path class="fil1" d="M845 990c1,14 4,5 -3,11 4,1 2,5 16,-8 7,-6 13,-11 19,-18 15,-17 27,-27 26,-46 0,0 -1,-2 -1,-2 0,1 -1,-1 -1,-2 -1,-2 -1,-2 -1,-6 -1,-3 -1,-9 -1,-12 -1,-37 -10,-107 19,-130 17,-13 16,-16 30,-29l4 -9c-15,-6 -17,4 -27,-18 -5,-12 -6,-25 -14,-33 -1,24 -28,143 -26,149 -15,-44 -45,-76 -77,-111l-37 -35c-7,-6 -9,-8 -16,-14 -30,-22 -68,-67 -78,-100l-10 -6 46 125c11,21 21,34 39,45 23,16 33,16 46,40 15,27 15,32 37,47 22,15 46,11 50,36 2,13 5,70 1,81 -3,9 -24,26 -31,33 -2,2 -5,4 -6,6 -4,5 -2,2 -4,6z"/>
  <path class="fil2" d="M813 693c2,3 2,8 3,12 15,4 9,9 19,4 2,-1 6,-2 7,-3 14,-1 12,7 10,19 -2,13 -8,16 -7,23 5,-3 7,-16 17,-28 8,-9 10,2 16,-3 2,-1 4,-4 6,-6 1,-1 1,-1 3,-2 2,-2 1,-2 2,-3l0 1c5,-1 7,0 9,2 -2,2 -8,-3 -11,4 -3,6 -1,9 -1,16l2 0c3,-3 -1,-3 1,1 0,1 0,3 1,3 0,0 2,0 2,0 3,-1 2,-1 3,-2l2 -3c2,-2 2,-3 3,-6l1 -4c0,-1 0,-3 0,-4l-1 -2c5,1 13,13 12,25 -2,12 -4,17 -8,26 9,2 29,6 29,18 0,4 1,10 1,15 -1,11 -4,25 -7,36 -1,4 -1,9 -2,12 -2,4 -3,6 -9,6 -11,1 -8,3 -13,5 -6,2 -7,-3 -13,0 0,5 3,10 5,13 8,9 19,10 13,17 -2,3 -6,5 -10,8 -13,7 -10,9 -13,20 -2,7 -4,15 -11,13 -1,0 -2,-1 -3,-1 -1,0 -2,-1 -2,-1 -1,0 0,0 0,0 1,2 6,2 8,2 3,0 5,-2 5,-5 0,-5 -5,-14 -7,-17l-10 -6c-2,-1 -2,-1 -5,-1 1,2 0,1 1,2 1,2 0,0 1,0 -1,0 -2,-1 -3,-2 -4,-3 -4,-2 -6,-1 -3,1 -1,-1 -2,1 -2,4 0,9 1,13l1 -1c1,2 2,6 4,7 -1,-2 -8,-5 -12,-3 -4,4 0,14 2,19 3,11 6,10 4,19 1,3 -1,7 -2,9 -1,2 -4,6 -5,8 -2,1 -2,2 -4,4 -1,1 -2,1 -4,3 -2,2 -6,4 -8,6 -1,1 -1,0 -1,1 2,2 4,5 6,8l-14 4c-4,1 -13,1 -16,2 -3,2 -6,5 -12,5 -3,0 -7,-5 -9,-7 -1,1 -1,-1 0,2 -2,-3 -1,-2 -4,-3 -12,-3 -8,-8 -12,-11 -5,1 -7,16 -4,24l0 1c0,0 0,0 0,0l0 3c0,1 -1,2 -1,3 -4,5 -16,0 -21,-1 -14,-4 -17,6 -27,9l0 7c-1,2 0,1 -1,3l-4 -7c-2,-2 0,-1 -2,-2 -4,-1 -6,-3 -7,-7 -3,-8 -2,-19 -6,-26 -11,2 -16,29 -22,29 -3,0 -4,-5 -10,-9 -4,-2 -10,-3 -16,-1 -6,2 -9,13 -26,1 -6,-5 -13,-12 -18,-20 -3,-5 -3,-10 -1,-15 1,-3 5,-10 7,-11 1,-2 0,-1 2,-2 10,-5 16,-11 23,-19 3,-3 2,-3 2,-4l8 1c3,1 5,2 4,-2 -8,0 -20,-4 -28,-7 -3,-2 -6,-3 -8,-4 -2,-7 2,-4 -7,-10 -2,-2 -4,-3 -5,-4 -4,-4 -3,-3 -4,-5 3,0 0,0 3,1 3,1 2,-1 6,0 -1,-4 -1,-2 -1,-6 0,-5 1,-4 0,-6 0,0 0,0 0,0 3,-2 2,-2 3,-5 2,0 5,1 7,3l5 5c-3,0 -1,-1 -3,-2 -2,0 -2,0 -3,0 -1,1 -1,1 -1,2l-1 2c2,4 2,2 5,7 1,1 2,3 3,4 4,4 8,5 13,8 2,1 3,1 4,2 -1,0 -2,0 -2,0 0,0 0,0 -1,0 1,1 1,1 1,1 5,2 11,5 17,7 -4,0 -8,-1 -11,-2 1,2 0,1 2,2 2,1 5,1 8,2 10,2 8,5 23,5 3,0 5,-1 7,0l2 1c1,1 1,0 0,2 2,0 3,1 4,1 2,0 3,-1 5,-1 6,1 9,2 15,2 8,0 6,-1 8,1 2,-1 0,-1 6,-1 2,-1 4,-1 6,-2 3,0 7,0 12,0l1 -2c2,-1 4,-1 7,-2 2,-1 3,-1 4,-3 2,0 1,0 2,1 7,-8 3,-6 12,-11 1,-1 3,-3 3,-3 2,0 3,1 4,1 4,2 4,-3 4,-3l7 -1c0,-1 1,-2 2,-2 0,0 0,0 0,0 7,-4 6,-3 12,0 1,1 4,2 5,2l6 -3c0,-4 0,-3 -1,-8 0,-1 0,-2 1,-3 0,0 0,0 0,0 4,0 -3,0 1,0 2,0 14,7 16,8 3,2 5,3 8,6 3,2 5,5 8,6 -1,-4 -2,-3 -3,-7 -1,-2 0,-1 -1,-3l-4 -4c-2,-2 -2,-4 -5,-4 -3,-1 -6,-6 -9,-8 -1,0 -1,-1 -2,-1l-2 -2c-3,-2 -4,-5 -5,-9 -1,1 -1,1 -1,2l-2 1c0,-3 0,-2 1,-4 8,-13 6,-21 8,-24l0 3c2,-1 5,-4 6,-5 1,-3 0,0 1,-1l3 -6c0,-1 0,0 1,-1 3,-3 -1,1 1,-1 0,-1 0,0 1,-1 1,-3 1,-2 3,-4l3 -4c1,-2 0,-1 1,-2l1 -3c1,-2 -1,1 2,-1 0,0 0,0 0,0 3,-3 1,-3 3,-5 0,0 0,0 0,0l-1 -1c-1,-2 0,0 0,-1 0,-3 1,-3 -1,-2 2,-1 1,-2 2,-5 1,-2 0,0 2,-2 0,0 17,-8 31,-20 2,-2 3,-3 5,-5 4,-4 6,-4 1,-10 4,-4 8,-8 9,-14 -3,1 -4,3 -5,5 -1,-2 -2,-3 -4,-3l-11 11c-1,1 -2,2 -4,1 1,-1 2,-2 3,-4 0,-2 -2,-4 -2,-5 3,-4 10,-15 13,-20 1,-3 3,-4 3,-8 -1,1 -1,0 -2,1l-11 17c-3,-2 -2,-1 -2,-3 -4,1 -4,3 -6,5l-11 15c-1,-8 2,-9 4,-13l-2 -2c-2,-2 -1,-3 -1,-6 0,-4 0,-8 -1,-12 -2,0 -1,0 -2,1 0,0 0,0 -1,0 -3,0 0,-6 1,-7 -1,-1 -1,-1 -1,-1l-3 -2c-3,-1 -2,-1 -4,-2 -1,1 -1,1 -1,2 0,1 0,1 -1,1 0,-4 0,-3 -2,-6l-1 -1c-2,-2 0,-2 -4,-2l1 5c-2,-3 -4,-9 -8,-14 -2,-2 -2,-3 -6,-3 -6,0 -5,5 -4,12 0,3 0,10 -1,12 -1,-2 1,-1 -1,-2 0,1 0,1 -1,2 0,0 -1,1 -1,1 -3,1 3,-2 -1,0l-1 1c-3,1 0,3 -3,8 -1,2 -2,6 -3,7 0,2 -1,0 -1,0 -1,0 -3,3 -3,4 0,1 -1,2 -1,2l-1 6c-1,2 -1,-1 -1,2 -1,4 -1,2 1,2l-8 6c-1,1 -1,1 -2,2 0,-1 -1,-1 0,-2l2 -6c0,0 0,0 0,0 2,1 1,1 1,1 0,0 0,0 0,-1 0,0 0,0 1,0 0,-1 0,-1 0,-1 0,0 0,0 0,0 1,-1 0,-1 1,-4l2 -5c3,-9 0,-11 1,-15 0,0 0,0 1,1l1 2c2,-6 -4,-30 -6,-36 -2,-5 -4,-8 -6,-12l3 0c2,4 5,5 9,20 1,3 1,3 3,4 2,2 0,-2 1,1 1,1 1,3 1,5l2 4c-2,-12 -4,-26 -10,-38l3 0c0,-5 -1,-3 -2,-8 2,0 2,0 3,2l5 12c1,1 1,3 2,5l3 3c0,-1 0,0 1,0l2 8c-1,-14 -6,-29 -11,-41 -1,-1 -1,-3 -2,-3 0,-2 1,-2 1,-3 1,-1 0,-2 0,-3 0,-3 0,0 1,-3l2 4c1,-1 1,-1 2,-2 1,-2 0,-3 3,-3 2,2 5,22 6,27 5,-1 3,0 3,-4z"/>
  <path class="fil3" d="M769 722c2,2 8,7 10,10l10 12c0,2 3,4 3,7 -1,4 2,6 -1,15l-2 5c-1,3 0,3 -1,4 0,0 0,0 0,0 0,0 0,0 0,1 -1,0 -1,0 -1,0 0,1 0,1 0,1 0,0 1,0 -1,-1 0,0 0,0 0,0l-2 6c-1,1 0,1 0,2 1,-1 1,-1 2,-2l8 -6c2,-2 4,-3 6,-6 1,-1 1,-1 2,-2 0,-1 1,-1 1,-2 6,-8 6,-10 8,-23 1,-2 1,-9 1,-12 -1,-7 -2,-12 4,-12 4,0 4,1 6,3 4,5 6,11 8,14 3,6 7,17 7,24 2,11 3,3 1,15 -1,8 2,7 -1,24 -3,0 -3,0 -5,-1 -1,-2 -1,-5 -2,-7 -3,-10 0,-6 -2,-11 0,-2 -1,-5 -1,-8 0,1 0,4 0,7 0,-1 0,-1 -1,-1l0 -1c-2,-2 -2,-5 -4,-6 0,6 1,10 1,15 -1,6 0,11 -5,13 -1,-7 1,-9 -1,-23 -4,6 1,15 -5,23l-7 9c0,0 0,1 0,1 -2,-1 -1,-1 -3,-2 1,7 0,15 -2,21 0,3 0,2 -2,4 -4,3 -6,5 -8,10 0,-2 0,-1 -1,-1 -1,2 -2,3 -3,5 -1,-2 0,-3 0,-5 -1,-1 0,0 -1,-1 -2,1 -1,1 -1,4 -2,11 -4,10 -6,13l-1 1 -1 -3c-3,0 -5,1 -7,1l-4 0c-1,0 0,0 -1,0 -3,0 -2,1 -5,2 -1,1 -4,1 -5,2 7,0 7,12 13,14 4,2 8,0 11,-3l2 -2c4,-4 5,-5 7,-9 1,-2 1,0 2,-4 3,-4 4,-6 7,-12l3 -4c4,-4 2,-5 6,-6 1,0 1,0 3,0 2,3 6,11 5,15l0 11c-2,3 0,11 -8,24 -1,2 -1,1 -1,4 -1,3 -11,12 -14,14 -9,7 -13,-1 -23,5 0,-1 -3,-2 -5,-3 -9,-3 -11,-6 -16,-8 -4,-1 -8,3 -13,1 -3,-1 -8,-3 -12,-3 0,2 0,1 3,3 3,1 9,4 13,5 -1,0 -3,0 -3,0 0,0 -2,1 -3,1 1,1 3,3 4,2 -4,0 -8,-2 -12,0 0,0 0,0 0,0 -3,1 -5,1 -8,2 -6,2 -13,-4 -20,-4 2,3 1,2 4,4 1,0 5,3 4,2 -1,1 -2,1 -4,1 0,0 0,0 0,1 -10,5 -19,-6 -26,-1 0,0 0,0 0,0l3 2c1,0 2,0 3,1 2,0 4,1 6,1 6,2 37,7 39,5 -11,2 -31,0 -42,-2 -4,-1 -4,-1 -7,0 -5,1 -3,0 -8,0 1,3 1,3 4,4l4 1c3,2 1,2 4,4 0,0 1,0 1,0 1,3 1,4 2,5 -4,2 -22,-4 -25,-5 -7,-3 -14,-6 -20,-10 -1,-1 -1,-1 -3,-1 -4,-3 -14,-12 -17,-16l-5 -5c-2,-2 -5,-3 -7,-3 -1,3 0,3 -3,5 0,0 0,0 0,0 1,2 0,1 0,6 0,4 0,2 1,6 -4,-1 -3,1 -6,0 -3,-1 0,-1 -3,-1 1,2 0,1 4,5 1,1 3,2 5,4 9,6 5,3 7,10 2,1 5,2 8,4 8,3 20,7 28,7 1,4 -1,3 -4,2l-8 -1c-3,0 -14,-4 -18,-6 -2,-1 -5,-2 -8,-4 -2,-1 -6,-4 -7,-4 -3,-4 -25,-16 -19,-37l1 -2c0,0 0,0 0,0 0,0 0,0 0,-1 2,8 -2,5 5,12 1,1 7,6 8,6 -1,0 0,0 -1,-2 5,-1 4,-3 5,-5 0,-2 1,-2 1,-3 0,-3 -1,-7 -3,-10l4 1c3,-5 0,-4 11,-4 4,0 8,3 10,4 7,3 18,7 27,6 10,0 18,-4 27,-10l-5 -5c2,-1 1,0 1,-1 -1,-2 -2,-4 -3,-5 -2,-2 -3,-3 -4,-6 3,2 4,1 7,1 2,1 2,2 7,2 1,1 6,4 8,4 4,3 3,3 9,1 8,-2 14,-2 21,-6 11,-6 16,-14 25,-5 4,4 3,7 6,7 1,-3 1,-3 0,-6l1 0c-1,-6 -8,-10 -7,-14 2,-3 8,1 7,-4 0,-2 0,-1 0,-2l1 -4c1,1 0,1 1,1 2,2 0,1 2,1 6,2 6,0 8,-2 0,-3 0,-5 -1,-7 0,0 -1,0 -1,0 0,0 0,-1 0,-1 -1,-1 -1,-3 -1,-5l-8 -2c8,-2 17,-16 21,-22 -1,4 -4,8 1,10l0 1c3,1 2,2 5,3 2,1 1,1 4,1l0 -5 2 2c3,-2 4,-8 3,-12 0,-7 -8,-12 -16,-1 -1,1 -2,3 -3,4 -3,5 -6,10 -11,13 -3,2 -6,4 -10,6 -11,8 0,16 2,22 -9,1 -5,1 -10,-2l-8 -8c-10,-9 -22,-24 -27,-36l3 -2c2,0 1,1 4,1 1,0 1,0 2,0l2 1c0,-2 0,-2 0,-4l2 4c4,-2 7,-5 7,-9 1,-5 -5,-14 -6,-20l8 12 5 -4c0,-1 0,0 1,-1l-2 -3c3,1 2,1 3,-1 2,-3 1,-1 3,-4l4 -3c-1,-3 -3,-4 -5,-6 -1,-1 -4,-4 -5,-5 4,2 12,8 16,11 2,2 1,2 4,3 3,1 3,2 5,3 2,1 7,1 9,0 -1,-6 -7,-10 -10,-14 1,0 1,1 3,1 4,0 2,-4 4,-6l3 -3c2,-2 3,-4 6,-5 2,3 7,10 9,11l3 3c2,1 3,2 5,2 1,-1 0,-2 1,-3 2,-5 2,-5 -1,-10 -2,-3 -4,-7 -7,-10 -2,-2 -4,-4 -6,-6l-3 -2c-2,-2 -6,-6 -7,-9 2,0 1,0 3,1 1,1 1,1 2,2z"/>
  <path class="fil4" d="M764 719c1,3 5,7 7,9l3 2c2,2 4,4 6,6 3,3 5,7 7,10 3,5 3,5 1,10 -1,1 0,2 -1,3 -2,0 -3,-1 -5,-2l-3 -3c-2,-1 -7,-8 -9,-11 -3,1 -4,3 -6,5l-3 3c-2,2 0,6 -4,6 -2,0 -2,-1 -3,-1 3,4 9,8 10,14 -2,1 -7,1 -9,0 -2,-1 -2,-2 -5,-3 -3,-1 -2,-1 -4,-3 -4,-3 -12,-9 -16,-11 1,1 4,4 5,5 2,2 4,3 5,6l-4 3c-2,3 -1,1 -3,4 -1,2 0,2 -3,1l2 3c-1,1 -1,0 -1,1l-5 4 -8 -12c1,6 7,15 6,20 0,4 -3,7 -7,9l-2 -4c0,2 0,2 0,4l-2 -1c-1,0 -1,0 -2,0 -3,0 -2,-1 -4,-1l-3 2c5,12 17,27 27,36l8 8c5,3 1,3 10,2 -2,-6 -13,-14 -2,-22 4,-2 7,-4 10,-6 5,-3 8,-8 11,-13 1,-1 2,-3 3,-4 8,-11 16,-6 16,1 1,4 0,10 -3,12l-2 -2 0 5c-3,0 -2,0 -4,-1 -3,-1 -2,-2 -5,-3l0 -1c-5,-2 -2,-6 -1,-10 -4,6 -13,20 -21,22l8 2c0,2 0,4 1,5 0,0 0,1 0,1 0,0 1,0 1,0 1,2 1,4 1,7 -2,2 -2,4 -8,2 -2,0 0,1 -2,-1 -1,0 0,0 -1,-1l-1 4c0,1 0,0 0,2 1,5 -5,1 -7,4 -1,4 6,8 7,14l-1 0c-9,-14 -7,-7 -8,-16 -8,-3 -21,-21 -26,-27 -2,-3 -6,-8 -9,-14l-2 -2c-4,-10 -7,-12 -5,-25 2,-3 3,-7 7,-9 1,-1 1,1 1,-2 5,-1 5,-7 10,-12 3,-4 12,-17 20,-11 3,1 5,2 7,4 2,2 11,8 14,8 -1,-4 -9,-10 -13,-13 -1,-1 -5,-5 -6,-7 -4,-5 2,-10 -6,-20 -6,-8 -17,-8 -24,-5 -5,3 -3,3 -4,2 1,-2 3,-3 5,-5 2,-1 4,-2 6,-3 10,-3 20,-1 28,3 5,2 18,9 20,13z"/>
  <path class="fil3" d="M692 723c-12,2 -36,23 -37,35l2 -3c3,-4 12,-14 16,-16 -1,4 0,3 0,6 2,-1 10,-13 12,-2 5,-1 8,-2 12,-3 0,1 0,1 0,2 4,0 2,-1 5,1 1,8 -5,11 -4,19 -1,0 -4,1 -7,2 6,1 8,2 16,1 0,3 0,1 -1,2l-4 0c-12,0 -19,-6 -23,-7 -10,7 -11,21 -13,30l0 5c-3,2 -19,5 -22,7l-2 1 14 0c3,2 6,6 7,11 1,7 0,10 -3,14 -1,0 0,0 -1,0 -7,-3 -4,1 -11,-3 -1,0 -1,0 -2,-1l1 -2c0,-1 1,1 0,-1 0,-1 -1,-1 -1,-1 0,0 0,0 0,-1l-1 0c-3,-5 -2,-2 -3,-4 0,-1 0,-2 0,-3l6 -1c1,-2 0,-1 2,-2 4,-2 9,-1 9,1 0,-2 -2,-4 -3,-5 -3,0 -6,1 -9,1 -10,0 -9,-5 -1,-7 0,-1 0,-2 0,-4l10 -3 -5 -1c-1,-4 0,-4 -4,-3 0,-2 0,-3 -1,-4 3,-1 12,-5 13,-5l-8 1 -1 -8c1,0 2,0 3,-1 2,-1 1,0 1,-1 0,-3 1,-1 -1,-2l-2 0 19 -6c-1,-3 -2,-2 -5,-1l-18 6c-8,2 -18,7 -25,5 -1,-3 -2,-3 -2,-7 1,-6 9,-14 10,-16 1,-1 6,-7 7,-8 3,-2 6,-5 9,-7 4,-4 13,-10 19,-12 5,-3 9,-4 14,-6 5,-2 11,-2 17,-4l0 2c2,0 2,0 4,1 0,4 0,2 -1,3l0 0c0,0 0,1 0,1 -2,0 -3,0 -5,1 -2,2 0,1 -2,3z"/>
  <path class="fil5" d="M561 859c2,3 7,7 10,9 2,2 4,3 7,5 3,1 6,3 9,4 -1,3 -2,2 -3,5l-1 2c0,1 0,1 0,1 0,0 0,0 0,0l-1 2c-6,21 16,33 19,37 -4,-1 -5,1 -9,2 -2,1 -4,1 -5,1l-8 5c-3,2 0,1 -4,1 -3,1 0,0 -1,1l-1 0c-1,2 -3,2 -6,2 3,-1 2,1 3,1l-6 1c-1,3 2,1 -5,5 -2,1 -5,2 -7,3l3 0c1,2 1,5 0,6l7 3c0,0 1,-1 1,-1 4,-1 1,1 6,0l4 -1c1,0 2,0 3,-1l2 0c1,0 0,0 1,0l-11 6c1,0 6,-2 8,-2 0,6 -2,13 -2,15l0 1 -3 -1c-1,-2 -3,-2 -4,-5 -1,-2 -2,-4 -4,-5 -2,-2 -6,-4 -11,-5 -15,-6 -7,-9 -7,-22 -1,-6 -4,-8 -3,-15 1,-6 3,-9 4,-13 1,-6 0,-8 8,-9 4,-1 12,0 14,-3 0,-2 -2,-2 -4,-2 -12,-2 -22,2 -23,-8 -1,-5 -2,-6 -4,-10l1 -1 4 3c3,-1 3,-1 6,-5 6,-8 2,-5 4,-9l1 -2 -5 1c2,-2 -2,-4 -1,-9l5 -1c3,2 6,5 9,8z"/>
  <path class="fil2" d="M595 767l1 2c-2,1 -2,0 -3,1 0,2 6,25 1,16l-2 1c0,0 -1,0 -2,0 -2,0 -5,-1 -7,-3 0,6 2,9 4,13 1,1 1,1 1,2l2 2c1,2 4,4 2,8 -2,1 -4,-2 -5,-4 -1,-2 -13,-17 -15,-19 -2,-2 -3,-4 -8,-4l1 1c3,3 10,7 12,11 3,7 4,15 3,22 -2,1 -1,1 -3,1l0 2 -3 -1c-5,-2 -3,-2 -8,-8l-3 -2c0,-1 0,-1 0,-1l-1 -1c-1,-1 -1,-2 -2,-3 -3,2 -2,4 -3,6 -1,-4 -3,-3 -3,-3 -1,1 0,3 -4,6 -5,2 -2,0 -2,4 0,1 0,0 0,1 -2,-1 0,0 -2,-1 -1,0 1,0 -1,0 -2,-1 -4,-1 -5,0l-4 -6c2,11 22,32 23,33 2,3 -2,3 1,5 0,3 -1,2 0,5 0,2 1,4 1,6 -3,-3 -6,-6 -9,-8l-14 -17c-2,-2 -3,-5 -5,-7l-2 3c0,1 -1,3 -1,4 -1,1 -5,-2 -7,7 -3,16 3,19 10,29 2,1 2,3 4,4 2,4 3,5 4,10 1,10 11,6 23,8 2,0 4,0 4,2 -2,3 -10,2 -14,3 -8,1 -7,3 -8,9 -1,4 -3,7 -4,13 -1,7 2,9 3,15 0,13 -8,16 7,22 5,1 9,3 11,5 2,1 3,3 4,5 1,3 3,3 4,5 -8,-4 -3,-9 -16,-13 -9,-3 -15,-3 -13,-15 3,-19 -4,-14 -1,-26 0,-5 2,-7 3,-11 1,-6 0,-6 4,-9 0,0 0,0 0,0l0 -5c-15,-6 1,-1 -17,-24 -2,-3 -7,-8 -8,-11 -3,-6 -2,-19 2,-24 4,-3 2,2 5,-5 2,-3 2,-2 0,-6 -6,-11 -10,-25 -3,-36 1,-2 1,-2 2,-3 0,1 0,3 1,6 2,4 6,13 9,16 0,0 0,0 0,0 2,-3 1,-1 6,-2l4 -2 -1 -5 2 -3 -2 -14c-1,1 1,1 1,1 2,-3 0,0 0,-2 -2,0 -3,-2 -6,-3 -6,-1 -7,1 -8,1 1,-3 6,-5 9,-3 4,2 5,4 8,6 2,-3 3,-13 3,-18 -1,-6 -7,-9 -4,-15l2 -1c-1,3 -3,5 0,9 2,3 3,3 3,8 1,6 -1,13 -2,18 8,8 9,-10 22,7 4,5 8,11 11,16 2,3 2,4 5,5 -1,-7 -7,-10 -12,-26 -1,-6 -3,-11 1,-14 5,-3 11,-1 14,-1z"/>
  <path class="fil2" d="M891 689c-3,-3 -1,-3 -7,-7 -7,-4 -7,-11 -9,-17 -1,-4 -2,-7 -7,-7 -11,-1 -9,3 -21,-2 -8,-3 -14,1 -22,2 3,4 5,8 8,14 1,5 4,13 5,18 0,3 1,6 0,8l-2 0c-2,-3 1,-4 -3,-4 -2,-1 -3,-1 -5,0 -1,-7 -5,-25 -9,-29 0,4 0,1 -1,4 -2,0 -2,0 -3,-1 0,0 0,1 0,2l0 1c0,0 0,1 0,1l-1 -1c0,-1 0,0 -1,-1 0,-1 0,-1 -1,-1 -3,1 -1,1 -4,0l1 2c-2,-1 -4,-11 -6,-15 -1,-2 -4,-8 -6,-9 -4,-2 -3,1 -4,-2 0,-3 0,0 -4,-4 -3,-4 -8,-9 -12,-10 -4,-1 -8,-1 -13,0 -7,1 -7,2 -8,6l-9 3c2,4 6,3 15,19 0,1 0,0 -1,1 -1,-1 -1,-1 -3,-3 -2,1 -1,2 -3,4l-1 2c0,0 0,0 0,0 0,0 0,0 -1,-1 0,0 -1,-1 -1,-1l-5 -7c1,3 4,5 2,10 -2,5 0,2 0,5 -1,4 -3,2 -3,2 -1,0 0,0 -1,0 -3,1 -2,1 -7,2 -1,-2 -1,-3 -3,-4l0 2c0,0 1,1 1,2 -5,1 1,-1 -5,0 1,7 2,10 1,13 -2,-1 -2,-1 -3,-3 -1,1 0,0 -1,1l-1 2c-2,1 -4,1 -7,-1l-4 -3c0,0 -1,0 -1,0 -4,-4 -6,-5 -6,-16 -2,5 1,10 1,12 0,2 1,-1 -1,2 -1,-1 0,0 -1,-1 -1,-4 -5,-10 -2,-14 3,-5 8,-1 6,-11 -9,2 -18,5 -27,4 -6,0 -7,-1 -10,-4 -5,-4 -8,-1 -12,1 2,-3 9,-5 12,-5 6,0 14,8 23,6 5,-1 10,-2 14,-3 0,-4 -1,-6 -1,-10 0,-3 2,-5 5,-5l2 -1 -3 3c-3,6 -1,11 0,16 1,-3 -1,-2 1,-3 3,3 3,4 7,6 1,0 3,3 6,2 1,-1 0,-1 1,-3l4 0c1,-2 3,-2 1,-10 -1,-5 -4,-8 -7,-11 -1,-1 -1,-1 -2,-2 16,-1 16,4 20,3 11,-2 6,-5 11,-7 6,-3 17,-2 22,0 4,1 10,9 14,12 8,7 16,-3 30,13 9,-1 15,-5 23,-2 4,1 5,3 10,3 4,0 8,-1 12,-1 9,1 8,9 11,17 3,10 10,8 12,16z"/>
  <path class="fil6" d="M813 860l0 -11c4,-4 3,-2 7,-7 1,-2 2,-3 3,-5l8 -14c2,-3 2,-7 4,-11 4,-7 5,-16 5,-24 1,-5 0,-24 -3,-28 0,-7 -4,-18 -7,-24l-1 -5c4,0 2,0 4,2l1 1c2,3 2,2 2,6 1,0 1,0 1,-1 0,-1 0,-1 1,-2 2,1 1,1 4,2l3 2c0,0 0,0 1,1 -1,1 -4,7 -1,7 1,0 1,0 1,0 1,-1 0,-1 2,-1 1,4 1,8 1,12 0,3 -1,4 1,6l2 2c-2,4 -5,5 -4,13l11 -15c2,-2 2,-4 6,-5 0,2 -1,1 2,3l11 -17c1,-1 1,0 2,-1 0,4 -2,5 -3,8 -3,5 -10,16 -13,20 0,1 2,3 2,5 -1,2 -2,3 -3,4 2,1 3,0 4,-1l11 -11c2,0 3,1 4,3 1,-2 2,-4 5,-5 -1,6 -5,10 -9,14 5,6 3,6 -1,10 -2,2 -3,3 -5,5 -14,12 -31,20 -31,20 -2,2 -1,0 -2,2 -1,3 0,4 -2,5 2,-1 1,-1 1,2 0,1 -1,-1 0,1l1 1c0,0 0,0 0,0 -2,2 0,2 -3,5 0,0 0,0 0,0 -3,2 -1,-1 -2,1l-1 3c-1,1 0,0 -1,2l-3 4c-2,2 -2,1 -3,4 -1,1 -1,0 -1,1 -2,2 2,-2 -1,1 -1,1 -1,0 -1,1l-3 6c-1,1 0,-2 -1,1 -1,1 -4,4 -6,5l0 -3z"/>
  <path class="fil7" d="M560 960c2,8 0,5 0,11 3,-2 2,-1 4,-4 2,-4 4,-7 8,-11 1,6 0,6 -3,13 -2,8 -2,4 -2,10 0,3 0,2 0,3 -6,14 -1,8 -6,15l-8 19c-4,7 1,2 -4,8 -3,4 -17,23 -16,26 1,-8 2,-15 5,-24 1,-5 4,-19 7,-23 -17,31 -24,52 -49,83 -12,14 -20,20 -22,43 -1,11 1,46 7,57 3,4 2,4 3,8 -4,-7 -8,-42 -6,-49l3 1c0,0 0,0 0,0 3,3 4,4 6,7 3,5 4,7 6,14 5,14 6,16 8,29 1,10 4,11 2,26 -1,6 -2,6 0,13 1,6 1,10 2,14 -6,-4 -15,-32 -18,-42 -1,2 -1,0 0,3l13 42c-4,-3 -19,-15 -23,-16 -2,-2 -5,-3 -6,-5l-19 -14c-1,0 -2,-1 -3,-2l-96 -61c-26,-19 -32,-25 -56,-45l-24 -22c2,5 12,19 15,24 5,8 10,16 15,24 10,18 18,33 28,49l4 -1c1,3 4,6 6,7l8 2c7,1 10,4 16,8 0,0 0,0 1,0 5,4 12,12 18,13 4,1 6,1 9,3l-8 -1c1,4 2,4 4,7 1,3 2,6 3,9 5,15 9,5 7,13 5,4 25,12 34,16 11,4 24,7 39,6 16,-1 26,5 37,10 4,2 5,3 8,5 4,2 5,2 9,5 2,1 14,10 14,12 0,-2 -1,-2 1,-1 -5,-11 -1,-3 -4,-11 -3,-6 -5,-11 -7,-18 -3,-10 -5,-22 -7,-31 -5,-29 0,-81 9,-110 4,-13 2,-11 7,-24l36 -117c1,-3 1,-4 2,-7 1,-3 1,-4 2,-6 3,-8 3,-4 6,-18 3,-9 5,-17 7,-26 2,-8 11,-48 13,-51l1 -7c-3,3 -30,62 -33,70 -3,7 -8,17 -10,24l-3 -5z"/>
  <path class="fil8" d="M541 1297c7,-3 2,-2 10,-13 1,28 47,51 66,64 2,1 3,1 5,2l16 10c2,1 5,2 8,4l8 4c3,2 5,3 8,5 2,1 5,4 7,3 -3,-4 -29,-19 -35,-23 -25,-15 -75,-40 -83,-67 -2,-10 2,-15 5,-22 6,-15 -9,-12 18,-37 13,-13 20,-22 24,-35 10,-25 -5,-61 5,-90 1,-2 1,-2 1,-3l6 16c2,-3 1,-5 2,-9l2 0c-5,-20 -9,-13 -7,-31 2,-9 2,-18 1,-28 -1,-11 -4,-21 -6,-31 -3,-23 -2,-62 -1,-84l4 -54c-2,3 -11,43 -13,51 -2,9 -4,17 -7,26 -3,14 -3,10 -6,18 -1,2 -1,3 -2,6 -1,3 -1,4 -2,7l-36 117c-5,13 -3,11 -7,24 -9,29 -14,81 -9,110 2,9 4,21 7,31 2,7 4,12 7,18 3,8 -1,0 4,11z"/>
  <path class="fil8" d="M724 1405l-4 -1c-2,0 -5,-2 -7,-4 -3,-2 -56,-30 -59,-32l-8 -4c-3,-2 -6,-3 -8,-4l-16 -10c-2,-1 -3,-1 -5,-2 -19,-13 -65,-36 -66,-64 -8,11 -3,10 -10,13 -2,-1 -1,-1 -1,1 5,1 6,4 7,9 2,4 4,5 5,8 -13,-3 -44,5 -58,7 -10,1 -21,2 -30,3 -39,4 -69,0 -105,-13 -6,-3 -17,-10 -23,-10 11,14 35,24 49,30 27,13 36,35 60,36 54,3 72,-47 112,-45 10,1 9,3 22,12 18,13 117,70 138,80 2,1 9,5 11,6 2,2 2,0 -4,-16z"/>
  <path class="fil9" d="M273 1087l24 22c24,20 30,26 56,45l96 61c1,1 2,2 3,2l19 14c1,2 4,3 6,5 1,-2 2,1 0,-5 -1,0 -3,-2 -4,-3l-19 -13c-50,-32 -27,-10 -48,-46 -9,-16 -18,-23 -21,-28 10,0 47,12 58,19 12,9 25,21 35,32 6,6 6,5 9,15 3,10 12,38 18,42 -1,-4 -1,-8 -2,-14 -2,-7 -1,-7 0,-13 2,-15 -1,-16 -2,-26 -2,-13 -3,-15 -8,-29 -2,-7 -3,-9 -6,-14 -2,-3 -3,-4 -6,-7 0,0 0,0 0,0l-3 -1c-2,7 2,42 6,49 -1,-4 0,-4 -3,-8 0,3 1,6 1,10 -25,-36 -37,-48 -73,-58 -39,-10 -67,-15 -103,-34l-27 -17c-3,-2 -10,-8 -13,-8 2,3 4,7 7,8z"/>
  <path class="fil8" d="M477 1236c4,1 19,13 23,16l-13 -42c-1,-3 -1,-1 0,-3 -3,-10 -3,-9 -9,-15 -10,-11 -23,-23 -35,-32 -11,-7 -48,-19 -58,-19 3,5 12,12 21,28 21,36 -2,14 48,46l19 13c1,1 3,3 4,3 2,6 1,3 0,5z"/>
  <path class="fil7" d="M336 1302c6,0 17,7 23,10 36,13 66,17 105,13 9,-1 20,-2 30,-3 14,-2 45,-10 58,-7 -1,-3 -3,-4 -5,-8 -14,-1 -29,-5 -50,-7 -51,-3 -64,13 -113,9l-48 -7z"/>
  <path class="fil8" d="M546 1002c-3,3 -6,17 -8,22 -2,9 -3,16 -4,24 -1,-3 13,-22 16,-26 5,-5 0,-1 4,-8l8 -18c5,-8 0,-2 5,-16 1,-1 1,0 1,-2 0,-7 0,-3 2,-11 3,-7 4,-7 2,-13 -3,4 -5,7 -7,11 -5,8 -5,19 -19,37z"/>
  <path class="fil6" d="M617 899c3,4 13,13 17,16l7 4c2,2 5,3 7,5 5,2 9,4 15,6 25,9 52,6 76,-5 15,-7 19,-12 28,-18 10,-6 14,2 23,-5 3,-2 13,-11 14,-14l2 -1c0,-1 0,-1 1,-2 1,4 2,7 5,9l2 2c1,0 1,1 2,1 3,2 6,7 9,8 3,0 3,2 5,4l4 4c1,2 0,1 1,3 1,4 2,3 3,7 -3,-1 -5,-4 -8,-6 -3,-3 -5,-4 -8,-6 -2,-1 -14,-8 -16,-8 -4,0 3,0 -1,0 0,0 0,0 0,0 -1,1 -1,2 -1,3 1,5 1,4 1,8l-6 3c-1,0 -4,-1 -5,-2 -6,-3 -5,-4 -12,0 0,0 0,0 0,0 -1,0 -2,1 -2,2l-7 1c0,0 0,5 -4,3 -1,0 -2,-1 -4,-1 0,0 -2,2 -3,3 -9,5 -5,3 -12,11 -1,-1 0,-1 -2,-1 -1,2 -2,2 -4,3 -3,1 -5,1 -7,2l-1 2c-5,0 -9,0 -12,0 -2,1 -4,1 -6,2 -6,0 -4,0 -6,1 -2,-2 0,-1 -8,-1 -6,0 -9,-1 -15,-2 -2,0 -3,1 -5,1 -1,0 -2,-1 -4,-1 1,-2 1,-1 0,-2l-2 -1c-2,-1 -4,0 -7,0 -15,0 -13,-3 -23,-5 -3,-1 -6,-1 -8,-2 -2,-1 -1,0 -2,-2 3,1 7,2 11,2 -6,-2 -12,-5 -17,-7 0,0 0,0 -1,-1 1,0 1,0 1,0 0,0 1,0 2,0 -1,-1 -2,-1 -4,-2 -5,-3 -9,-4 -13,-8 -1,-1 -2,-3 -3,-4 -3,-5 -3,-3 -5,-7l1 -2c0,-1 0,-1 1,-2 1,0 1,0 3,0 2,1 0,2 3,2z"/>
  <path class="fil10" d="M634 938c0,1 1,1 -2,4 -7,8 -13,14 -23,19 -2,1 -1,0 -2,2 -4,1 -10,5 -15,7 -4,2 -14,5 -18,2l0 -1c0,-2 2,-9 2,-15 -2,0 -7,2 -8,2l11 -6c-1,0 0,0 -1,0l-2 0c-1,1 -2,1 -3,1l-4 1c-5,1 -2,-1 -6,0 0,0 -1,1 -1,1l-7 -3c1,-1 1,-4 0,-6l-3 0c2,-1 5,-2 7,-3 7,-4 4,-2 5,-5l6 -1c-1,0 0,-2 -3,-1 3,0 5,0 6,-2l1 0c1,-1 -2,0 1,-1 4,0 1,1 4,-1l8 -5c1,0 3,0 5,-1 4,-1 5,-3 9,-2 1,0 5,3 7,4 3,2 6,3 8,4 4,2 15,6 18,6z"/>
  <path class="fil2" d="M767 907c-9,6 -13,11 -28,18 -24,11 -51,14 -76,5 -6,-2 -10,-4 -15,-6 -2,-2 -5,-3 -7,-5l-7 -4c2,0 2,0 3,1 6,4 13,7 20,10 3,1 21,7 25,5 -1,-1 -1,-2 -2,-5 0,0 -1,0 -1,0 -3,-2 -1,-2 -4,-4l-4 -1c-3,-1 -3,-1 -4,-4 5,0 3,1 8,0 3,-1 3,-1 7,0 11,2 31,4 42,2 -2,2 -33,-3 -39,-5 -2,0 -4,-1 -6,-1 -1,-1 -2,-1 -3,-1l-3 -2c0,0 0,0 0,0 7,-5 16,6 26,1 0,-1 0,-1 0,-1 2,0 3,0 4,-1 1,1 -3,-2 -4,-2 -3,-2 -2,-1 -4,-4 7,0 14,6 20,4 3,-1 5,-1 8,-2 0,0 0,0 0,0 4,-2 8,0 12,0 -1,1 -3,-1 -4,-2 1,0 3,-1 3,-1 0,0 2,0 3,0 -4,-1 -10,-4 -13,-5 -3,-2 -3,-1 -3,-3 4,0 9,2 12,3 5,2 9,-2 13,-1 5,2 7,5 16,8 2,1 5,2 5,3z"/>
  <path class="fil2" d="M715 817c-2,3 -3,3 -4,4 -1,-1 -3,-3 -3,-3 1,2 1,3 1,5 1,4 1,3 2,5 1,3 0,4 0,5 -2,3 -1,2 -2,5 -2,0 -1,0 -2,0 -3,0 2,-1 -8,0l2 3c-2,0 -2,0 -3,1 3,4 10,10 12,12 -1,1 -1,1 -2,2 -7,-3 -10,-9 -14,-9 -3,0 -1,-1 -4,-2 1,3 3,5 1,9 -3,1 -7,0 -9,-1l0 0c-3,3 -4,3 -5,4 4,2 5,2 9,5 0,0 1,0 1,0l3 4c-5,0 -18,-10 -20,-13 1,3 5,7 7,9 3,2 3,1 3,3 -5,0 -5,-1 -7,-2 -3,0 -4,1 -7,-1 1,3 2,4 4,6 1,1 2,3 3,5 0,1 1,0 -1,1 -2,-2 -7,-11 -9,-13 -2,-4 -4,-12 -8,-13 2,12 2,4 4,11 2,7 1,11 2,15l-2 1 2 5c-1,0 -10,-1 -11,-1 0,-3 1,-3 -1,-6 -3,-5 -7,-9 -8,-12l-5 -8c-3,-2 -5,-5 -8,-7l-1 -2 -3 -8 2 -1c1,-1 2,-1 3,-1 2,0 2,-1 4,-1 1,2 -2,1 2,1l8 -1c0,0 -1,0 -3,2 -6,6 1,10 2,12 3,0 5,-1 8,-1 2,0 3,1 6,1 2,-5 3,-5 2,-12l5 6c2,2 3,6 5,9 1,-2 1,-3 1,-3 0,-1 0,-2 0,-2 0,-7 1,-7 1,-12 1,3 1,3 3,4l0 1c3,4 0,-1 1,1l5 5c2,1 -1,1 2,1 4,0 3,-4 2,-7 -3,-4 -2,-6 -6,-8 -4,-2 -4,0 -4,0 4,-3 4,-1 6,-8 1,-2 2,-3 2,-3l-1 0c1,1 0,0 1,2l3 2c2,2 0,2 4,4l3 2c2,-3 0,-2 1,-3 0,0 0,-2 0,0l0 1c0,0 1,0 1,0l1 0c5,1 1,1 5,2l1 -1c0,0 0,-1 0,-1 3,-3 1,-13 0,-14 -1,-3 -1,-2 -2,-3 -1,-1 -2,-4 -6,-4 -1,-1 -1,-1 -1,0 2,-1 3,-1 5,-1 3,-1 5,-1 6,-3 3,0 3,1 2,-1l2 2c3,6 7,11 9,14z"/>
  <path class="fil11" d="M813 849c1,-4 -3,-12 -5,-15 -2,0 -2,0 -3,0 -4,1 -2,2 -6,6l-3 4c-3,6 -4,8 -7,12 -1,4 -1,2 -2,4 -2,4 -3,5 -7,9l-2 2c-3,3 -7,5 -11,3 -6,-2 -6,-14 -13,-14 1,-1 4,-1 5,-2 3,-1 2,-2 5,-2 1,0 0,0 1,0l4 0c2,0 4,-1 7,-1l1 3 1 -1c2,-3 4,-2 6,-13 0,-3 -1,-3 1,-4 1,1 0,0 1,1 0,2 -1,3 0,5 1,-2 2,-3 3,-5 1,0 1,-1 1,1 2,-5 4,-7 8,-10 2,-2 2,-1 2,-4 2,-6 3,-14 2,-21 2,1 1,1 3,2 0,0 0,-1 0,-1l7 -9c6,-8 1,-17 5,-23 2,14 0,16 1,23 5,-2 4,-7 5,-13 0,-5 -1,-9 -1,-15 2,1 2,4 4,6l0 1c1,0 1,0 1,1 0,-3 0,-6 0,-7 0,3 1,6 1,8 2,5 -1,1 2,11 1,2 1,5 2,7 2,1 2,1 5,1 3,-17 0,-16 1,-24 2,-12 1,-4 -1,-15 3,4 4,23 3,28 0,8 -1,17 -5,24 -2,4 -2,8 -4,11l-8 14c-1,2 -2,3 -3,5 -4,5 -3,3 -7,7z"/>
  <path class="fil11" d="M660 828c0,2 1,0 0,2 -1,1 0,-1 -1,0 -1,2 -1,0 -1,3 -6,-4 -17,0 -25,0 -2,0 -2,1 -4,1 -1,0 -2,0 -3,1 -4,-5 -6,-9 -9,-16 -3,-8 -2,-13 -3,-21 1,-2 2,-9 3,-12 1,-3 3,-10 5,-12 0,-2 1,1 0,-2 7,2 17,-3 25,-5l18 -6c3,-1 4,-2 5,1l-19 6 2 0c2,1 1,-1 1,2 0,1 1,0 -1,1 -1,1 -2,1 -3,1l1 8 8 -1c-1,0 -10,4 -13,5 1,1 1,2 1,4 4,-1 3,-1 4,3l5 1 -10 3c0,2 0,3 0,4 -8,2 -9,7 1,7 3,0 6,-1 9,-1 1,1 3,3 3,5 0,-2 -5,-3 -9,-1 -2,1 -1,0 -2,2l-6 1c0,1 0,2 0,3 1,2 0,-1 3,4l1 0c0,1 0,1 0,1 0,0 1,0 1,1 1,2 0,0 0,1l-1 2c1,1 1,1 2,1 7,4 4,0 11,3 1,0 0,0 1,0z"/>
  <path class="fil5" d="M891 689c1,4 1,10 -1,14l0 1c-1,1 -1,1 -1,1 -1,-4 -5,1 -6,1l-7 -1c-4,-1 -5,0 -8,-1 1,-2 2,-4 2,-7 -2,1 -2,1 -3,2 -1,-1 -1,0 -3,-2l-1 -2c0,0 0,0 -1,-1 1,-1 1,-2 2,-3 1,-3 0,-1 0,-4 0,-1 1,-3 -1,-4 -2,-1 -3,1 -4,1l0 -2c-1,0 -1,0 -1,0 -2,2 -7,14 -11,16 -3,2 -5,1 -8,3l-1 -11c-1,-5 -4,-13 -5,-18 -3,-6 -5,-10 -8,-14 8,-1 14,-5 22,-2 12,5 10,1 21,2 5,0 6,3 7,7 2,6 2,13 9,17 6,4 4,4 7,7z"/>
  <path class="fil5" d="M635 699c-2,1 -2,1 -3,2l-2 3c0,0 0,0 0,0 -2,2 -4,3 -4,4 1,4 1,-2 1,1 -1,2 -1,2 -3,2 2,3 2,7 -3,8 -4,-3 -10,1 -12,4 -1,0 -1,0 -2,-1 -1,0 -1,-1 -2,-1 -2,-1 -3,-1 -5,-2 -8,-2 -14,2 -14,11 0,4 2,8 3,11 -2,1 -1,1 -4,1 -1,0 -1,0 -3,0l2 10c-3,0 -8,-2 -12,-2 -2,0 -2,-1 -5,0 -2,0 -4,0 -5,0 4,-1 16,3 20,5 2,0 3,1 5,2 1,0 1,0 2,1 2,1 1,0 2,2 1,4 0,2 3,4l1 1c1,2 0,-1 2,2l-2 0c-3,0 -9,-2 -14,1 -4,3 -2,8 -1,14 5,16 11,19 12,26 -3,-1 -3,-2 -5,-5 -3,-5 -7,-11 -11,-16 -13,-17 -14,1 -22,-7 1,-5 3,-12 2,-18 0,-5 -1,-5 -3,-8 -3,-4 -1,-6 0,-9 2,-3 6,-7 12,-7 5,0 10,1 15,1l2 0c1,-2 1,-6 3,-9 -1,-1 -2,-1 -2,-3 0,-4 3,-9 5,-11 10,-13 15,-6 33,-13 5,-1 9,-9 14,-4z"/>
  <path class="fil6" d="M762 659c3,1 1,0 2,2 1,2 2,2 3,6 -12,0 -11,10 -12,11 -1,2 -2,2 -3,6 2,-1 3,-2 4,-4 3,6 5,7 10,10 2,1 3,1 5,3 1,1 3,2 4,4 -1,1 0,0 0,2 0,1 0,1 -1,3 -4,0 -8,1 -11,2 -2,1 -2,1 -4,1 1,8 0,6 4,10 2,2 5,4 6,7 -1,-1 -1,-1 -2,-2 -2,-1 -1,-1 -3,-1 -2,-4 -15,-11 -20,-13 -8,-4 -18,-6 -28,-3 0,0 0,0 1,-1 2,-1 2,0 -1,-6 -3,-7 -5,-9 -8,-17 1,1 0,0 1,1 2,-3 1,0 1,-2 0,-2 -3,-7 -1,-12 0,11 2,12 6,16 0,0 1,0 1,0l4 3c3,2 5,2 7,1l1 -2c1,-1 0,0 1,-1 1,2 1,2 3,3 1,-3 0,-6 -1,-13 6,-1 0,1 5,0 0,-1 -1,-2 -1,-2l0 -2c2,1 2,2 3,4 5,-1 4,-1 7,-2 1,0 0,0 1,0 0,0 2,2 3,-2 0,-3 -2,0 0,-5 2,-5 -1,-7 -2,-10l5 7c0,0 1,1 1,1 1,1 1,1 1,1 0,0 0,0 0,0l1 -2c2,-2 1,-3 3,-4 2,2 2,2 3,3 1,-1 1,0 1,-1z"/>
  <path class="fil11" d="M707 765c-8,1 -10,0 -16,-1 3,-1 6,-2 7,-2 2,-1 2,-1 3,-2 2,-1 1,-1 2,-2 2,-3 2,-2 2,-6 0,-13 3,-9 1,-15l-4 0c1,-1 3,-3 -1,-3 0,-4 0,-6 -1,-10 -6,1 -9,4 -12,5 -2,0 -1,0 -2,0 1,-1 2,-2 3,-3 0,0 0,0 0,0 1,0 1,0 1,0 1,-2 1,-1 2,-3 2,-2 0,-1 2,-3 2,-1 3,-1 5,-1 0,0 0,-1 0,-1l0 0c1,-1 1,1 1,-3 -2,-1 -2,-1 -4,-1l0 -2c3,-1 6,0 9,-1 1,1 -1,1 4,-2 7,-3 18,-3 24,5 8,10 2,15 6,20 1,2 5,6 6,7 4,3 12,9 13,13 -3,0 -12,-6 -14,-8 -2,-2 -4,-3 -7,-4 -8,-6 -17,7 -20,11 -5,5 -5,11 -10,12z"/>
  <path class="fil11" d="M715 817c5,6 18,24 26,27 1,9 -1,2 8,16 1,3 1,3 0,6 -3,0 -2,-3 -6,-7 -9,-9 -14,-1 -25,5 -7,4 -13,4 -21,6 -6,2 -5,2 -9,-1 -2,0 -7,-3 -8,-4 0,-2 0,-1 -3,-3 -2,-2 -6,-6 -7,-9 2,3 15,13 20,13l-3 -4c0,0 -1,0 -1,0 -4,-3 -5,-3 -9,-5 1,-1 2,-1 5,-4l0 0c2,1 6,2 9,1 2,-4 0,-6 -1,-9 3,1 1,2 4,2 4,0 7,6 14,9 1,-1 1,-1 2,-2 -2,-2 -9,-8 -12,-12 1,-1 1,-1 3,-1l-2 -3c10,-1 5,0 8,0 1,0 0,0 2,0 1,-3 0,-2 2,-5 0,-1 1,-2 0,-5 -1,-2 -1,-1 -2,-5 0,-2 0,-3 -1,-5 0,0 2,2 3,3 1,-1 2,-1 4,-4z"/>
  <path class="fil3" d="M658 666c0,2 0,1 -1,2 0,0 0,1 0,1l0 1c3,4 13,16 15,22l0 1c-3,0 -4,-2 -6,-6 -5,1 0,1 -5,0 -1,0 -1,0 -1,0 0,3 2,6 3,8 -2,0 -2,-1 -3,-2 -4,-4 -1,1 -7,-3 -2,-1 -1,-1 -4,-1 1,2 2,2 3,4 -1,1 -3,0 -1,3 1,1 3,2 4,4 -3,0 -4,-3 -7,-4 -3,-1 -1,1 -9,2l9 5 5 7c-4,-1 -6,-4 -9,-5 -1,-1 -3,-2 -4,-3 -1,-1 -1,-1 -2,-2 -2,-2 -1,-1 -3,-1 -5,-5 -9,3 -14,4 -18,7 -23,0 -33,13 -2,2 -5,7 -5,11 0,2 1,2 2,3 -2,3 -2,7 -3,9l-2 0c0,-1 2,-7 2,-8 0,0 -5,-9 10,-22 7,-5 21,-3 30,-7 4,-2 4,-4 8,-5 -3,-2 -7,-3 -7,-8 1,-4 4,-7 7,-8 -1,-5 -6,-18 4,-22 10,-3 16,5 21,9l3 -2z"/>
  <path class="fil5" d="M708 679c3,8 5,10 8,17 3,6 3,5 1,6 -3,-2 -5,-10 -7,-11 -2,-4 -13,-17 -17,-18 -9,-3 -13,12 -13,20l-6 2 -2 -3c-2,-6 -12,-18 -15,-22l0 -1c0,0 0,-1 0,-1 1,-1 1,0 1,-2 1,-5 1,-8 5,-11 4,-2 7,-5 12,-1 3,3 4,4 10,4 9,1 18,-2 27,-4 2,10 -3,6 -6,11 -3,4 1,10 2,14z"/>
  <path class="fil3" d="M904 858c-2,-1 -4,0 -7,-1 -1,-1 -2,-1 -3,-1 -6,-2 1,10 5,14 1,1 2,1 3,2 2,1 7,4 8,7l2 3 -1 3c-3,6 -18,11 -21,16 -6,11 0,29 -18,27l2 3c-2,0 -3,1 -4,1l-3 3c0,2 0,5 0,6 -1,-4 -1,-7 -2,-11 -1,-4 -1,-6 -4,-8 -2,-1 -4,-3 -7,-4 -2,-2 -10,-8 -8,4 1,5 8,5 12,12l-2 0c-1,0 -1,1 -1,1l-2 3c-1,1 0,0 -1,1 0,1 1,2 1,3 1,4 3,6 -2,9 2,-9 -1,-8 -4,-19 -2,-5 -6,-15 -2,-19 4,-2 11,1 12,3 -2,-1 -3,-5 -4,-7l-1 1c-1,-4 -3,-9 -1,-13 1,-2 -1,0 2,-1 2,-1 2,-2 6,1 1,1 2,2 3,2 -1,0 0,2 -1,0 -1,-1 0,0 -1,-2 3,0 3,0 5,1l10 6c2,3 7,12 7,17 0,3 -2,5 -5,5 -2,0 -7,0 -8,-2 0,0 -1,0 0,0 0,0 1,1 2,1 1,0 2,1 3,1 7,2 9,-6 11,-13 3,-11 0,-13 13,-20 4,-3 8,-5 10,-8 6,-7 -5,-8 -13,-17 -2,-3 -5,-8 -5,-13 6,-3 7,2 13,0 5,-2 2,-4 13,-5 6,0 7,-2 9,-6 1,-3 1,-8 2,-12 3,-11 6,-25 7,-36 0,-5 -1,-11 -1,-15 2,1 2,4 2,6 2,13 -2,29 -5,41 -1,7 -2,17 -5,21 -3,4 -6,3 -11,4 -3,0 -9,3 -10,5z"/>
  <path class="fil3" d="M793 645c1,3 0,0 4,2 2,1 5,7 6,9 2,4 4,14 6,15 1,6 5,16 4,22 0,4 2,3 -3,4 -1,-5 -4,-25 -6,-27 -3,0 -2,1 -3,3 -1,1 -1,1 -2,2l-2 -4c-1,3 -1,0 -1,3 0,1 1,2 0,3 0,1 -1,1 -1,3 1,0 1,2 2,3 5,12 10,27 11,41l-2 -8c-3,-10 -8,-22 -12,-32 -2,-3 -4,-5 -5,-8 -5,0 -3,0 -6,-1 -2,-1 -1,1 -5,-2 -3,-3 -5,0 -6,-8 0,1 -1,3 -1,5 -3,-1 -3,-3 -8,-1 -12,7 4,18 4,20 0,0 0,0 0,0 0,0 0,1 0,1 0,0 0,0 -1,0 -5,-3 -7,-4 -10,-10 -1,2 -2,3 -4,4 1,-4 2,-4 3,-6 1,-1 0,-11 12,-11l3 0c-2,-13 6,-32 23,-22z"/>
  <path class="fil2" d="M600 841c1,1 1,2 2,4 2,6 10,14 15,17l3 -1c6,-1 11,4 14,8l2 1c2,2 2,1 4,3l3 3c2,1 2,1 3,3 -1,2 -3,2 -6,5 -3,0 -12,0 -14,-1 -2,-1 -2,-2 -3,0 -2,-1 -6,-4 -10,-4 -11,0 -8,-1 -11,4l-4 -1c-6,-1 -7,-6 -14,0 1,-3 2,-2 3,-5 2,0 5,0 8,1 3,1 5,2 8,2 -3,-2 -9,-3 -12,-5 -4,-1 -8,-3 -11,-5 1,-4 0,-1 4,-3 -2,-3 -2,-1 -3,-4 3,0 3,2 5,2 3,0 -1,-2 3,0 5,3 15,11 21,11 -1,-1 -2,-1 -3,-2 -3,-2 -1,-1 -3,-4 -2,-2 -13,-9 -15,-16 2,0 0,0 2,1l8 7c-2,-3 -3,-4 -4,-9 3,2 5,6 11,10l10 7c-2,-1 1,0 -1,-2 -1,0 -2,0 -3,-1 -1,-1 -3,-2 -4,-4 -9,-8 -17,-16 -18,-29 5,0 8,4 10,8l0 -1z"/>
  <path class="fil6" d="M622 774c-2,2 -4,9 -5,12 -1,3 -2,10 -3,12 0,-3 0,-3 -1,-5l-1 2c-1,3 0,6 -4,14 -2,3 0,2 -1,5 -3,0 -1,-1 -3,-3 -1,0 -4,-2 -6,0 0,0 0,0 0,1 -1,1 -1,0 -2,2 -2,-1 0,-1 -2,-1 3,5 -3,7 1,14 1,2 0,-1 2,2 -1,1 -2,2 -1,4 -3,0 -5,-2 -9,-1 -2,1 -4,4 -4,7l-2 2c-4,0 -8,-1 -13,0 -4,1 -7,4 -8,7 -3,-2 1,-2 -1,-5 -1,-1 -21,-22 -23,-33l4 6c2,7 18,22 23,26 2,-2 0,-3 3,-4 1,0 1,0 2,-1 1,-3 -2,0 0,-3 1,-1 2,-1 3,-3 -2,-4 -15,-17 -14,-21 2,1 7,8 9,10 3,4 5,6 8,9 4,-2 5,-2 8,1 3,1 4,-2 6,-4l-2 -19c0,-2 -1,-1 1,-2 1,2 3,5 5,4 2,-4 -1,-6 -2,-8 1,-2 -2,-1 1,-1 1,2 -1,-1 1,0 0,1 -2,0 0,1 2,1 7,0 8,1 1,1 1,3 3,4 0,0 -1,-3 -1,-4 -1,-4 0,-3 1,-6l1 -4c0,0 0,0 0,0l0 -1c1,-1 2,-9 1,-11l-10 -10 8 2c1,0 1,-1 2,-2 2,-2 3,-4 7,-4 2,2 4,3 6,5l1 1c2,1 2,1 3,2z"/>
  <path class="fil6" d="M710 691c2,1 4,9 7,11 -1,1 -1,1 -1,1 -2,1 -4,2 -6,3 -2,2 -4,3 -5,5 -3,1 -6,0 -9,1 -6,2 -12,2 -17,4 -5,2 -9,3 -14,6 0,-3 -5,-9 -7,-10l0 6c-1,-2 -1,-7 -1,-8 0,0 -4,-3 -5,-4 1,2 2,3 2,5 -3,0 -5,-1 -6,-2 -1,-3 0,0 -1,-2 0,0 -1,-1 -1,-1 -1,0 -1,0 -2,-1 3,1 5,4 9,5l-5 -7c1,-2 2,0 4,0 2,0 2,-1 4,0 2,1 6,6 8,6 0,-2 -3,-6 -5,-7 1,-1 1,0 1,-1 1,-1 0,-2 1,-3 2,0 3,1 4,2 2,1 1,2 4,2 -1,-2 -2,-5 -3,-7 2,-1 1,0 3,1l1 1c4,2 0,3 6,3l-1 -5 6 -1c1,-4 1,-7 3,-9 1,6 0,7 3,9l2 1c1,1 0,0 1,1 2,1 2,1 3,1l9 2c-1,-2 -1,-2 -2,-4 1,0 2,-1 2,-1 0,-1 1,-1 1,-1l0 -1c1,-2 0,-4 1,-6 0,-2 0,0 1,-2 1,3 3,4 5,7l0 0z"/>
  <path class="fil2" d="M806 716c-1,0 -1,-1 -1,0l-3 -3c-1,-2 -1,-4 -2,-5l-5 -12c-1,-2 -1,-2 -3,-2 1,5 2,3 2,8l-3 0c6,12 8,26 10,38l-2 -4c0,-2 0,-4 -1,-5 -1,-3 1,1 -1,-1 -2,-1 -2,-1 -3,-4 -4,-15 -7,-16 -9,-20l-3 0c-1,-2 -1,-3 -3,-5 -2,-2 -2,-2 -4,-4 -1,-2 -3,-3 -4,-4 -2,-2 -3,-2 -5,-3 1,0 1,0 1,0 0,0 0,-1 0,-1 0,0 0,0 0,0 0,-2 -16,-13 -4,-20 5,-2 5,0 8,1 0,-2 1,-4 1,-5 1,8 3,5 6,8 4,3 3,1 5,2 3,1 1,1 6,1 1,3 3,5 5,8 4,10 9,22 12,32z"/>
  <path class="fil10" d="M614 798c1,8 0,13 3,21 3,7 5,11 9,16l-2 1 3 8c-1,-1 -4,-6 -7,-7 -1,-1 0,-1 -1,-1 -9,-3 -5,0 -8,-2 -2,-2 -1,-2 -4,-2 1,5 3,5 4,8 1,3 -1,3 2,6 5,4 1,3 6,8 1,1 2,2 3,4 1,3 1,1 0,1 3,0 3,0 6,1 -3,0 -6,-1 -8,1l-3 1c-5,-3 -13,-11 -15,-17 -1,-2 -1,-3 -2,-4 0,-4 -3,-6 -4,-8 -1,-2 0,-3 1,-4 -2,-3 -1,0 -2,-2 -4,-7 2,-9 -1,-14 2,0 0,0 2,1 1,-2 1,-1 2,-2 0,-1 0,-1 0,-1 2,-2 5,0 6,0 2,2 0,3 3,3 1,-3 -1,-2 1,-5 4,-8 3,-11 4,-14l1 -2c1,2 1,2 1,5z"/>
  <path class="fil11" d="M587 805c-2,1 -1,0 -1,2l2 19c-2,2 -3,5 -6,4 -3,-3 -4,-3 -8,-1 -3,-3 -5,-5 -8,-9 -2,-2 -7,-9 -9,-10 -1,4 12,17 14,21 -1,2 -2,2 -3,3 -2,3 1,0 0,3 -1,1 -1,1 -2,1 -3,1 -1,2 -3,4 -5,-4 -21,-19 -23,-26 1,-1 3,-1 5,0 2,0 0,0 1,0 2,1 0,0 2,1 0,-1 0,0 0,-1 0,-4 -3,-2 2,-4 4,-3 3,-5 4,-6 0,0 2,-1 3,3 1,-2 0,-4 3,-6 1,1 1,2 2,3l1 1c0,0 0,0 0,1l3 2c5,6 3,6 8,8l3 1 0 -2c2,0 1,0 3,-1 1,-7 0,-15 -3,-22 -2,-4 -9,-8 -12,-11l-1 -1c5,0 6,2 8,4 2,2 14,17 15,19z"/>
  <path class="fil3" d="M633 833c8,0 19,-4 25,0 8,6 5,5 8,8 3,-20 8,-9 11,-21 4,-11 2,-13 16,-16l9 -2c-1,2 -3,2 -6,3 -2,0 -3,0 -5,1 0,-1 0,-1 1,0 4,0 5,3 6,4 1,1 1,0 2,3 1,1 3,11 0,14 0,0 0,1 0,1l-1 1c-4,-1 0,-1 -5,-2l-1 0c0,0 -1,0 -1,0l0 -1c0,-2 0,0 0,0 -1,1 1,0 -1,3l-3 -2c-4,-2 -2,-2 -4,-4l-3 -2c-1,-2 0,-1 -1,-2l1 0c0,0 -1,1 -2,3 -2,7 -2,5 -6,8 0,0 0,-2 4,0 4,2 3,4 6,8 1,3 2,7 -2,7 -3,0 0,0 -2,-1l-5 -5c-1,-2 2,3 -1,-1l0 -1c-2,-1 -2,-1 -3,-4 0,5 -1,5 -1,12 0,0 0,1 0,2 0,0 0,1 -1,3 -2,-3 -3,-7 -5,-9l-5 -6c1,7 0,7 -2,12 -3,0 -4,-1 -6,-1 -3,0 -5,1 -8,1 -1,-2 -8,-6 -2,-12 2,-2 3,-2 3,-2l-8 1c-4,0 -1,1 -2,-1z"/>
  <path class="fil12" d="M889 705l0 1c-1,1 0,1 -2,3 -2,1 -2,1 -3,2 -2,2 -4,5 -6,6 -6,5 -8,-6 -16,3 -10,12 -12,25 -17,28 -1,-7 5,-10 7,-23 2,-12 4,-20 -10,-19 0,0 -1,0 -1,0 0,0 0,1 -1,0 0,0 0,0 0,0l-1 -5c3,-2 5,-1 8,-3 4,-2 9,-14 11,-16 0,0 0,0 1,0l0 2c1,0 2,-2 4,-1 2,1 1,3 1,4 0,3 1,1 0,4 -1,1 -1,2 -2,3 1,1 1,1 1,1l1 2c2,2 2,1 3,2 1,-1 1,-1 3,-2 0,3 -1,5 -2,7 3,1 4,0 8,1l7 1c1,0 5,-5 6,-1z"/>
  <path class="fil13" d="M693 804c-14,3 -12,5 -16,16 -3,12 -8,1 -11,21 -3,-3 0,-2 -8,-8 0,-3 0,-1 1,-3 1,-1 0,1 1,0 1,-2 0,0 0,-2 3,-4 4,-7 3,-14 -1,-5 -4,-9 -7,-11l-14 0 2 -1c3,-2 19,-5 22,-7l0 -5c4,-2 12,-8 17,-9l1 1c-2,1 -3,2 -5,3 -2,1 -4,1 -5,2 1,2 2,3 3,4 3,4 1,1 2,1 1,2 2,2 3,5 4,8 2,4 17,5l-6 2z"/>
  <path class="fil14" d="M552 851l-5 1c-1,5 3,7 1,9l5 -1 -1 2c-2,4 2,1 -4,9 -3,4 -3,4 -6,5l-4 -3 -1 1c-2,-1 -2,-3 -4,-4 -7,-10 -13,-13 -10,-29 2,-9 6,-6 7,-7 0,-1 1,-3 1,-4l2 -3c2,2 3,5 5,7l14 17z"/>
  <path class="fil14" d="M625 732c0,5 1,15 5,17 -1,2 -9,10 -10,16 0,4 1,4 2,7 1,3 0,0 0,2 -1,-1 -1,-1 -3,-2l-1 -1c-2,-2 -4,-3 -6,-5 -4,0 -5,2 -7,4 -1,1 -1,2 -2,2l-8 -2 10 10c1,2 0,10 -1,11l0 1c0,0 0,0 0,0l-1 4c-1,3 -2,2 -1,6 0,1 1,4 1,4 -2,-1 -2,-3 -3,-4 -1,-1 -6,0 -8,-1 -2,-1 0,0 0,-1 -2,-1 0,2 -1,0 -3,0 0,-1 -1,1l-2 -2c0,-1 0,-1 -1,-2 -2,-4 -4,-7 -4,-13 2,2 5,3 7,3 1,0 2,0 2,0l2 -1c5,9 -1,-14 -1,-16 1,-1 1,0 3,-1l-1 -2 2 0 5 2c3,-1 4,-2 7,-4 -1,-2 -1,-2 -3,-3l1 -1c0,0 0,0 0,0 3,-3 0,2 1,-2 0,-1 0,0 0,-1l0 -1c0,-3 1,0 0,-3 0,-1 0,-1 -1,-3 3,0 1,1 3,2 3,1 4,4 7,6 1,-2 -2,-5 -3,-7 -2,-4 1,0 0,-8 2,0 2,0 4,-1 2,3 1,4 3,4 2,-3 -3,-6 0,-10l1 -2c1,-1 2,-2 2,-3 0,1 0,0 1,0z"/>
  <path class="fil14" d="M672 874l5 5c-9,6 -17,10 -27,10 -9,1 -20,-3 -27,-6 1,-2 1,-1 3,0 2,1 11,1 14,1 3,-3 5,-3 6,-5 -1,-2 -1,-2 -3,-3l-3 -3c-2,-2 -2,-1 -4,-3l-2 -1c-3,-4 -8,-9 -14,-8 2,-2 5,-1 8,-1l5 0c1,-5 3,-3 -1,-8 -1,-2 -2,-4 -4,-6 3,2 5,5 8,7l5 8c1,3 5,7 8,12 2,3 1,3 1,6 1,0 10,1 11,1l-2 -5 2 -1c-1,-4 0,-8 -2,-15 -2,-7 -2,1 -4,-11 4,1 6,9 8,13 2,2 7,11 9,13z"/>
  <path class="fil3" d="M780 953c2,5 5,8 7,13 -3,-1 -1,-1 -4,-3 -2,-2 -2,-1 -4,-4l-9 -13c-1,-2 -2,-2 -4,-4 -3,-5 -4,-4 -5,-11l8 -8 13 10 10 12c2,2 13,18 13,20 0,2 0,1 0,2 -2,2 -1,0 -4,-2 -1,-2 -8,-2 -8,-2 -4,-1 2,0 -5,-3 0,-1 0,0 -1,-1l-3 -2c-2,-1 -2,-2 -4,-4z"/>
  <path class="fil11" d="M710 691l0 0c-2,-3 -4,-4 -5,-7 -1,2 -1,0 -1,2 -1,2 0,4 -1,6l0 1c0,0 -1,0 -1,1 0,0 -1,1 -2,1 1,2 1,2 2,4l-9 -2c-1,0 -1,0 -3,-1 -1,-1 0,0 -1,-1l-2 -1c-3,-2 -2,-3 -3,-9 -2,2 -2,5 -3,9l-6 1 1 5c-6,0 -2,-1 -6,-3l-1 -1c-2,-1 -1,-2 -3,-1 1,2 2,5 3,7 -3,0 -2,-1 -4,-2 -1,-1 -2,-2 -4,-2 -1,1 0,2 -1,3 0,1 0,0 -1,1 2,1 5,5 5,7 -2,0 -6,-5 -8,-6 -2,-1 -2,0 -4,0 -2,0 -3,-2 -4,0l-9 -5c8,-1 6,-3 9,-2 3,1 4,4 7,4 -1,-2 -3,-3 -4,-4 -2,-3 0,-2 1,-3 -1,-2 -2,-2 -3,-4 3,0 2,0 4,1 6,4 3,-1 7,3 1,1 1,2 3,2 -1,-2 -3,-5 -3,-8 0,0 0,0 1,0 5,1 0,1 5,0 2,4 3,6 6,6l0 -1 2 3 6 -2c0,-8 4,-23 13,-20 4,1 15,14 17,18z"/>
  <path class="fil12" d="M665 722c-6,2 -15,8 -19,12 -3,2 -6,5 -9,7 -1,1 -6,7 -7,8 -4,-2 -5,-12 -5,-17l0 -1 0 -5c1,0 2,0 3,0 1,1 1,1 1,1 8,2 3,-2 2,-6 1,0 2,2 3,3l6 -4c1,-1 1,-2 1,-2 -1,-5 -3,-4 -1,-7 3,0 1,0 4,1 0,0 0,0 0,0l1 -1c2,-2 -1,0 1,-2 1,0 2,0 2,0 1,1 3,2 6,2 0,-2 -1,-3 -2,-5 1,1 5,4 5,4 0,1 0,6 1,8l0 -6c2,1 7,7 7,10z"/>
  <path class="fil14" d="M838 690l1 11 1 5c0,0 0,0 0,0 1,1 1,0 1,0 0,0 1,0 1,0 -1,1 -5,2 -7,3 -10,5 -4,0 -19,-4 -1,-4 -1,-9 -3,-12 1,-6 -3,-16 -4,-22l-1 -2c3,1 1,1 4,0 1,0 1,0 1,1 1,1 1,0 1,1l1 1c0,0 0,-1 0,-1l0 -1c0,-1 0,-2 0,-2 1,1 1,1 3,1 1,-3 1,0 1,-4 4,4 8,22 9,29 2,-1 3,-1 5,0 4,0 1,1 3,4l2 0c1,-2 0,-5 0,-8z"/>
  <path class="fil14" d="M793 645c-17,-10 -25,9 -23,22l-3 0c-1,-4 -2,-4 -3,-6 -1,-2 1,-1 -2,-2 -9,-16 -13,-15 -15,-19l9 -3c1,-4 1,-5 8,-6 5,-1 9,-1 13,0 4,1 9,6 12,10 4,4 4,1 4,4z"/>
  <path class="fil3" d="M621 719c3,3 3,3 4,7l0 5c-1,-3 -1,-10 -7,-11 0,0 0,0 -1,1l-6 7c-1,2 0,2 0,4 -3,1 2,-2 -2,0 1,11 -2,3 -1,11 0,0 0,0 0,0l0 1c-3,0 -1,0 -3,-2l-4 1c0,0 0,1 0,1 0,1 0,1 0,1l-3 1c0,3 -1,1 1,4 3,4 -1,3 -1,3 -1,-1 -3,-4 -4,-6 -2,-1 -3,-4 -5,-6 -1,-3 -3,-7 -3,-11 0,-9 6,-13 14,-11 2,1 3,1 5,2 1,0 1,1 2,1 1,1 1,1 2,1 2,-3 8,-7 12,-4z"/>
  <path class="fil2" d="M698 762c-1,-8 5,-11 4,-19 -3,-2 -1,-1 -5,-1 0,-1 0,-1 0,-2 -4,1 -7,2 -12,3 -2,-11 -10,1 -12,2 0,-3 -1,-2 0,-6 -4,2 -13,12 -16,16l-2 3c1,-12 25,-33 37,-35 -1,2 -1,1 -2,3 0,0 0,0 -1,0 0,0 0,0 0,0 -1,1 -2,2 -3,3 1,0 0,0 2,0 3,-1 6,-4 12,-5 1,4 1,6 1,10 4,0 2,2 1,3l4 0c2,6 -1,2 -1,15 0,4 0,3 -2,6 -1,1 0,1 -2,2 -1,1 -1,1 -3,2z"/>
  <path class="fil3" d="M596 833c1,2 4,4 4,8l0 1c-2,-4 -5,-8 -10,-8 1,13 9,21 18,29 1,2 3,3 4,4 1,1 2,1 3,1 2,2 -1,1 1,2l-10 -7c-6,-4 -8,-8 -11,-10 1,5 2,6 4,9l-8 -7c-2,-1 0,-1 -2,-1 2,7 13,14 15,16 2,3 0,2 3,4 1,1 2,1 3,2 -6,0 -16,-8 -21,-11 -4,-2 0,0 -3,0 -2,0 -2,-2 -5,-2 1,3 1,1 3,4 -4,2 -3,-1 -4,3 3,2 7,4 11,5 3,2 9,3 12,5 -3,0 -5,-1 -8,-2 -3,-1 -6,-1 -8,-1 -3,-1 -6,-3 -9,-4 -3,-2 -5,-3 -7,-5 0,0 1,2 0,-1 -2,-1 -2,0 -3,-3 2,0 4,0 5,0 0,0 3,-1 4,-1 -1,-3 -2,-1 -3,-4 4,1 2,2 7,3 0,-3 -1,-1 1,-2 1,2 2,2 5,2 -1,-3 -2,0 -2,-5 0,-3 -1,-7 -2,-10 -1,-3 -2,-3 -3,-3l3 -1c-1,-3 0,-2 0,-4 0,-3 2,-6 4,-7 4,-1 6,1 9,1z"/>
  <path class="fil14" d="M706 767c-4,2 -5,6 -7,9 -4,1 -13,2 -16,5 -5,1 -13,7 -17,9 2,-9 3,-23 13,-30 4,1 11,7 23,7l4 0z"/>
  <path class="fil3" d="M571 868c-3,-2 -8,-6 -10,-9 0,-2 -1,-4 -1,-6 -1,-3 0,-2 0,-5 1,-3 4,-6 8,-7 5,-1 9,0 13,0l2 -2c0,2 -1,1 0,4l-3 1c1,0 2,0 3,3 1,3 2,7 2,10 0,5 1,2 2,5 -3,0 -4,0 -5,-2 -2,1 -1,-1 -1,2 -5,-1 -3,-2 -7,-3 1,3 2,1 3,4 -1,0 -4,1 -4,1 -1,0 -3,0 -5,0 1,3 1,2 3,3 1,3 0,1 0,1z"/>
  <path class="fil10" d="M704 801c1,2 1,1 -2,1l-9 2 6 -2c-15,-1 -13,3 -17,-5 -1,-3 -2,-3 -3,-5 -1,0 1,3 -2,-1 -1,-1 -2,-2 -3,-4 1,-1 3,-1 5,-2 2,-1 3,-2 5,-3l-1 -1c3,-3 12,-4 16,-5 -2,13 1,15 5,25z"/>
  <path class="fil11" d="M625 731l0 1c-1,0 -1,1 -1,0 0,1 -1,2 -2,3l-1 2c-3,4 2,7 0,10 -2,0 -1,-1 -3,-4 -2,1 -2,1 -4,1 1,8 -2,4 0,8 1,2 4,5 3,7 -3,-2 -4,-5 -7,-6 -2,-1 0,-2 -3,-2 1,2 1,2 1,3 1,3 0,0 0,3l0 1c0,1 0,0 0,1 -1,4 2,-1 -1,2 0,0 0,0 0,0l-1 1c-1,-2 -1,-1 -2,-2 -1,-1 -1,-2 -2,-3 -2,-1 -3,-2 -4,-4 0,0 4,1 1,-3 -2,-3 -1,-1 -1,-4l3 -1c0,0 0,0 0,-1 0,0 0,-1 0,-1l4 -1c2,2 0,2 3,2l0 -1c0,0 0,0 0,0 -1,-8 2,0 1,-11 4,-2 -1,1 2,0 0,-2 -1,-2 0,-4l6 -7c1,-1 1,-1 1,-1 6,1 6,8 7,11z"/>
  <path class="fil3" d="M529 783c1,-3 3,-5 6,-7 1,0 2,-2 8,-1 3,1 4,3 6,3 0,2 2,-1 0,2 0,0 -2,0 -1,-1l2 14 -2 3 1 5 -4 2c-5,1 -4,-1 -6,2 0,0 0,0 0,0 -3,-3 -7,-12 -9,-16 -1,-3 -1,-5 -1,-6z"/>
  <path class="fil10" d="M782 706c2,4 4,7 6,12 -3,0 -3,0 -4,-2l-2 1c0,0 0,0 -1,0 0,0 1,1 0,-1 -2,-2 -1,-1 -4,-2 -2,0 -1,0 -4,0 2,15 15,24 16,30l-10 -12c-2,-3 -8,-8 -10,-10 -1,-3 -4,-5 -6,-7 -4,-4 -3,-2 -4,-10 2,0 2,0 4,-1 3,-1 7,-2 11,-2 1,-2 1,-2 1,-3 0,-2 -1,-1 0,-2 2,2 2,2 4,4 2,2 2,3 3,5z"/>
  <path class="fil3" d="M716 638c1,-2 2,-2 4,-2 2,0 4,-1 6,-1 1,1 1,1 2,2 3,3 6,6 7,11 2,8 0,8 -1,10l-4 0c-1,2 0,2 -1,3 -3,1 -5,-2 -6,-2 -4,-2 -4,-3 -7,-6 -2,1 0,0 -1,3 -1,-5 -3,-10 0,-16l3 -3 -2 1z"/>
  <path class="fil3" d="M894 817c2,-1 0,0 2,0 -2,2 -2,1 -2,3 -1,0 0,0 1,0 3,5 -17,4 -19,5 -3,0 0,0 -4,0 -6,0 -3,-3 -7,-5 0,0 0,0 1,0l0 -2c0,1 0,2 -2,-1 -1,0 -1,1 -1,-2 -1,-5 5,-3 7,-3 11,-1 17,0 28,2 2,0 7,1 3,3 -1,0 -4,0 -7,0z"/>
  <path class="fil3" d="M630 962c1,5 1,4 -3,10 -2,2 -9,13 -11,14 -5,3 -16,5 -11,-9 2,-5 3,-4 6,-7 4,-3 8,-6 13,-7 4,-1 3,-1 6,-1z"/>
  <path class="fil5" d="M644 705c1,1 1,1 2,1 0,0 1,1 1,1 1,2 0,-1 1,2 0,0 -1,0 -2,0 -2,2 1,0 -1,2l-1 1c0,0 0,0 0,0 -3,-1 -1,-1 -4,-1 -2,3 0,2 1,7 0,0 0,1 -1,2l-6 4c-1,-1 -2,-3 -3,-3 1,4 6,8 -2,6 0,0 0,0 -1,-1 -1,0 -2,0 -3,0 -1,-4 -1,-4 -4,-7 5,-1 5,-5 3,-8 2,0 2,0 3,-2 0,-3 0,3 -1,-1 0,-1 2,-2 4,-4 0,0 0,0 0,0l2 -3c1,-1 1,-1 3,-2 2,0 1,-1 3,1 1,1 1,1 2,2 1,1 3,2 4,3z"/>
  <path class="fil10" d="M589 741c2,2 3,5 5,6 1,2 3,5 4,6 1,2 2,3 4,4 1,1 1,2 2,3 1,1 1,0 2,2 2,1 2,1 3,3 -3,2 -4,3 -7,4l-5 -2c-2,-3 -1,0 -2,-2l-1 -1c-3,-2 -2,0 -3,-4 -1,-2 0,-1 -2,-2 -1,-1 -1,-1 -2,-1 -2,-1 -3,-2 -5,-2 -4,-2 -16,-6 -20,-5 1,0 3,0 5,0 3,-1 3,0 5,0 4,0 9,2 12,2l-2 -10c2,0 2,0 3,0 3,0 2,0 4,-1z"/>
  <path class="fil12" d="M627 844l1 2c2,2 3,4 4,6 4,5 2,3 1,8l-5 0c-3,-1 -3,-1 -6,-1 1,0 1,2 0,-1 -1,-2 -2,-3 -3,-4 -5,-5 -1,-4 -6,-8 -3,-3 -1,-3 -2,-6 -1,-3 -3,-3 -4,-8 3,0 2,0 4,2 3,2 -1,-1 8,2 1,0 0,0 1,1 3,1 6,6 7,7z"/>
  <path class="fil12" d="M788 718c2,6 8,30 6,36l-1 -2c-1,-1 -1,-1 -1,-1 0,-3 -3,-5 -3,-7 -1,-6 -14,-15 -16,-30 3,0 2,0 4,0 3,1 2,0 4,2 1,2 0,1 0,1 1,0 1,0 1,0l2 -1c1,2 1,2 4,2z"/>
  <path class="fil3" d="M898 709c1,1 0,0 1,1 1,1 1,0 1,2l1 2c0,1 0,3 0,4l-1 4c-1,3 -1,4 -3,6l-2 3c-1,1 0,1 -3,2 0,0 -2,0 -2,0 -1,0 -1,-2 -1,-3 -2,-4 2,-4 -1,-1l-2 0c0,-7 -2,-10 1,-16 3,-7 9,-2 11,-4z"/>
  <path class="fil4" d="M598 882c2,3 3,7 3,10 0,1 -1,1 -1,3 -1,2 0,4 -5,5 1,2 0,2 1,2 -1,0 -7,-5 -8,-6 -7,-7 -3,-4 -5,-12l1 -2c7,-6 8,-1 14,0z"/>
  <path class="fil15" d="M867 941l0 6c-3,-3 -5,-11 -9,-13 -4,-7 -11,-7 -12,-12 -2,-12 6,-6 8,-4 3,1 5,3 7,4 3,2 3,4 4,8 1,4 1,7 2,11z"/>
  <path class="fil3" d="M639 879c-1,1 -1,1 -2,2l-7 0c-4,-2 -4,0 -9,-6 -4,-6 -6,-17 2,-12 2,1 1,0 2,1l10 11c3,3 2,0 4,4z"/>
  <path class="fil6" d="M811 743c-2,13 -2,15 -8,23 0,1 -1,1 -1,2 -1,1 -1,1 -2,2 -2,3 -4,4 -6,6 -2,0 -2,2 -1,-2 0,-3 0,0 1,-2l1 -6c0,0 1,-1 1,-2 0,-1 2,-4 3,-4 0,0 1,2 1,0 1,-1 2,-5 3,-7 3,-5 0,-7 3,-8l1 -1c4,-2 -2,1 1,0 0,0 1,-1 1,-1 1,-1 1,-1 1,-2 2,1 0,0 1,2z"/>
  <path class="fil7" d="M904 858c0,5 5,15 6,21 -1,-3 -6,-6 -8,-7 -1,-1 -2,-1 -3,-2 -4,-4 -11,-16 -5,-14 1,0 2,0 3,1 3,1 5,0 7,1z"/>
  <path class="fil4" d="M703 881c-3,4 -1,0 -1,1l0 1c0,0 0,0 0,0l0 1c-6,1 -8,0 -12,-2 -1,-3 -1,-4 0,-7 1,-1 3,-3 6,-3 2,1 0,0 5,4 1,1 0,0 1,2 1,1 1,1 1,3z"/>
  <path class="fil4" d="M736 871c-2,0 -2,0 -5,-2l-3 -3c-2,-10 5,-10 8,-9 3,1 3,3 3,7 0,1 0,3 0,4 -1,1 -1,1 -1,1 -1,1 -1,1 -2,2z"/>
  <path class="fil4" d="M836 929c-2,0 -2,0 -3,0 -1,0 -3,-1 -3,-1l-3 -2c-8,-7 -8,-14 -6,-14 2,0 8,6 10,7 1,2 9,10 5,10z"/>
  <path class="fil7" d="M1504 724c-13,2 -45,36 -54,38 -6,2 -2,0 -8,4 -9,6 -15,7 -18,9l-27 11c-2,1 -4,1 -7,2 -4,2 -1,2 -7,4 -11,4 -18,10 -22,11 -3,1 -1,0 -4,2 -1,0 -2,1 -3,2 -4,3 -3,1 -7,4 -8,6 -1,-1 -11,6l-30 20c-4,3 -8,7 -13,12l-12 13c1,-16 5,-22 10,-34 -2,2 -6,4 -5,7 0,-5 2,-18 3,-23 3,-14 8,-61 11,-66 7,-5 32,-3 39,-8l5 -4c-1,5 -1,10 -1,15 -2,12 -7,22 -13,32 -3,4 -7,9 -9,13 5,-3 15,-12 19,-14 0,1 -14,12 -17,16 7,2 6,2 11,-1 8,-5 18,-10 25,-16 -2,2 -2,2 -1,4 7,-12 10,-6 12,-17l0 -3c-2,-1 -5,2 -8,3 -2,1 -1,1 -2,1 5,-6 35,-25 49,-27 9,-1 15,4 23,3 6,0 20,-8 36,-13 6,-1 33,-9 38,-8l-2 2z"/>
  <path class="fil8" d="M1330 870c1,-30 24,-59 27,-92 2,-15 1,-23 -7,-32 -5,-7 -11,-21 -13,-30l0 -5c23,14 27,-15 43,-27 -3,5 -9,53 -11,66 -1,6 -4,18 -4,23 0,-2 3,-5 5,-6 -5,12 -8,18 -9,34l12 -14c4,-4 8,-8 12,-11l30 -20c10,-7 4,-1 11,-7 4,-2 4,0 7,-3 2,-1 2,-2 4,-3 3,-2 1,0 4,-1 3,-1 11,-7 21,-11 7,-3 4,-2 7,-4 3,-1 5,-1 8,-3l26 -11c4,-2 9,-2 19,-8 6,-4 2,-2 7,-4 10,-2 41,-37 55,-39 -11,12 -21,23 -31,36 -18,22 -37,55 -64,63 -32,10 -33,3 -58,27 -10,10 -23,17 -37,20 -32,7 -29,-17 -51,43 -20,57 -14,18 -13,19z"/>
  <path class="fil16" d="M1293 801c2,-3 12,-9 15,-11 1,1 0,1 2,0 2,-1 5,-3 6,-2l0 2c-1,8 -4,4 -9,13 -1,-1 0,-1 0,-3 -5,5 -12,8 -18,12 -4,2 -4,3 -9,1 2,-3 13,-12 13,-12z"/>
  <path class="fil7" d="M1584 662c-14,2 -45,37 -55,39 -5,2 -1,0 -7,4 -10,6 -15,6 -19,9l-26 10c-3,2 -5,2 -8,3 -3,2 0,1 -7,4 -10,4 -18,10 -21,11 -3,1 -1,-1 -4,1 -2,1 -2,2 -4,3 -3,3 -3,1 -7,3 -7,6 -1,0 -11,7l-30 20c-4,3 -8,7 -12,11l-12 14c1,-16 4,-22 9,-34 -2,1 -5,4 -5,6 0,-5 3,-17 4,-23 2,-13 8,-61 11,-66 6,-4 31,-2 39,-7l5 -4c-2,4 -1,10 -2,15 -1,12 -6,22 -13,32 -2,4 -6,9 -8,12 4,-3 15,-12 18,-13 0,1 -14,11 -16,16 6,2 6,1 11,-2 7,-4 17,-9 24,-15 -1,2 -1,2 -1,4 7,-12 10,-6 12,-17l1 -3c-3,-2 -6,2 -9,3 -2,1 -1,1 -2,0 5,-6 35,-24 50,-26 9,-1 15,3 23,3 6,0 20,-9 35,-13 6,-2 34,-9 38,-8l-1 1z"/>
  <path class="fil17 str0" d="M1529 855c84,0 167,0 251,1 6,-23 13,-45 15,-67 3,-22 2,-43 -5,-61 -7,-17 -20,-31 -34,-42 -15,-11 -32,-20 -52,-20 -21,-1 -45,7 -64,19 -19,13 -33,30 -44,44 -12,13 -21,23 -29,35 -8,13 -15,28 -22,43 -6,16 -11,32 -16,48z"/>
  <path class="fil7" d="M1246 989c10,2 37,31 44,32 5,2 1,0 7,4 7,5 12,5 15,7l22 9c2,1 3,1 6,2 3,1 0,1 6,3 8,3 15,8 18,9 2,1 0,0 3,1 1,1 2,2 3,2 3,3 2,1 5,3 7,5 1,0 9,6l25 16c4,3 7,6 11,10l10 11c-1,-13 -4,-18 -8,-29 1,2 4,4 4,6 0,-4 -2,-14 -3,-19 -2,-11 -7,-50 -9,-54 -6,-4 -26,-2 -32,-7l-4 -3c1,4 0,8 1,13 1,9 5,18 10,26 3,3 6,7 7,10 -3,-2 -12,-10 -15,-11 0,1 12,10 14,13 -6,2 -5,2 -9,-1 -7,-4 -15,-8 -20,-13 1,2 1,2 0,4 -6,-10 -8,-5 -10,-14l0 -3c2,-1 5,1 7,3 2,0 1,1 2,0 -5,-5 -29,-20 -41,-22 -8,-1 -13,3 -19,3 -5,-1 -17,-8 -30,-11 -4,-1 -27,-8 -31,-7l2 1z"/>
  <path class="fil8" d="M1389 1110c0,-24 -19,-48 -22,-75 -1,-13 -1,-19 6,-27 4,-6 9,-18 10,-25l1 -4c-19,12 -23,-12 -36,-22 3,4 7,43 9,55 1,4 3,14 3,18 0,-2 -2,-4 -4,-5 4,10 7,15 8,28l-10 -11c-4,-4 -7,-7 -10,-9l-25 -17c-8,-6 -3,-1 -9,-5 -3,-3 -3,-1 -6,-3 -1,-1 -2,-2 -3,-2 -2,-2 -1,-1 -3,-2 -3,-1 -9,-5 -18,-9 -5,-2 -3,-2 -6,-3 -2,-1 -4,-1 -6,-2l-22 -9c-3,-2 -7,-2 -15,-7 -5,-3 -2,-2 -6,-3 -8,-2 -34,-31 -45,-32 8,10 16,19 25,29 15,18 31,45 53,52 26,9 27,3 48,22 8,9 19,14 31,17 26,6 23,-14 41,35 17,48 12,16 11,16z"/>
  <path class="fil16" d="M1420 1053c-2,-2 -10,-7 -13,-9 -1,1 0,1 -1,0 -2,-1 -4,-3 -6,-2l1 2c1,7 3,3 7,11 1,-1 1,-1 0,-3 4,4 11,7 16,11 3,1 2,2 6,0 -1,-2 -10,-9 -10,-10z"/>
  <path class="fil2" d="M1425 813c0,3 2,8 3,11 -12,10 -4,12 -15,12 -2,0 -6,1 -8,1 -13,5 -8,11 -1,21 7,11 14,11 17,17 -7,0 -14,-11 -28,-17 -11,-5 -7,6 -15,4 -3,-1 -5,-2 -8,-3 -1,-1 -2,-1 -4,-1 -2,-1 -2,-1 -3,-2l0 1c-4,2 -6,4 -6,6 2,1 5,-5 10,-1 6,4 6,8 8,14l-1 0c-4,0 -1,-2 0,2 0,1 0,2 0,3 -1,0 -2,1 -3,1 -3,1 -1,0 -2,0l-4 -2c-2,-1 -3,-2 -5,-4l-2 -4c-1,-1 -2,-2 -2,-3l-1 -2c-3,3 -5,17 1,27 6,10 11,14 18,20 -8,5 -23,17 -18,28 2,4 3,10 5,14 5,10 15,21 22,30 2,3 5,7 7,9 4,3 5,4 11,2 10,-4 8,-1 13,-1 6,-1 5,-6 11,-6 3,5 3,11 2,14 -3,11 -13,17 -5,21 4,2 8,2 13,2 15,2 13,4 21,13 4,5 9,12 15,7 1,-1 1,-2 2,-3 0,0 1,-1 1,-1 1,0 0,0 1,0 -1,2 -5,5 -7,5 -3,1 -5,1 -7,-3 -2,-4 -2,-13 -1,-17l6 -10c2,-2 2,-2 5,-3 0,2 0,1 0,2 -1,2 0,0 -1,1 0,-1 1,-2 2,-3 2,-5 2,-4 4,-4 3,0 1,-1 3,0 3,3 3,8 4,12l-1 0c0,2 1,6 0,8 0,-3 4,-8 9,-8 5,2 5,13 6,18 2,11 -1,11 4,18 1,3 4,6 6,8 2,1 7,3 8,5 3,0 3,0 5,1 2,1 3,1 5,1 3,1 8,1 10,2 1,1 1,0 1,1 -1,3 -1,6 -1,9l14 -2c4,-1 12,-5 14,-5 4,0 9,2 13,-1 4,-1 5,-7 6,-10 1,1 0,-1 1,2 0,-4 -1,-2 2,-5 9,-7 4,-9 6,-14 5,-1 13,11 14,20l0 0c0,0 0,1 0,1l2 2c0,1 1,2 2,2 5,3 14,-6 18,-10 11,-9 17,-2 28,-3l3 6c1,2 0,1 2,2l1 -8c0,-2 -1,0 1,-2 3,-3 3,-5 3,-10 -1,-8 -6,-17 -6,-25 10,-3 27,19 32,16 2,-1 1,-6 5,-12 3,-3 8,-7 14,-8 7,0 14,8 24,-10 3,-7 6,-16 7,-26 1,-5 -1,-10 -5,-14 -3,-2 -9,-6 -11,-6 -1,-1 0,-1 -2,-1 -12,-1 -19,-3 -30,-7 -3,-2 -3,-2 -3,-3l-6 4c-3,2 -4,4 -5,1 7,-5 16,-13 22,-19 2,-3 4,-5 6,-7 -2,-7 -4,-3 1,-12 1,-2 2,-4 3,-6 2,-5 2,-3 2,-6 -3,2 -1,0 -2,2 -3,3 -3,1 -6,3 -1,-4 0,-3 -2,-6 -2,-4 -2,-2 -2,-5 0,0 0,0 0,0 -4,-1 -2,-1 -5,-4 -2,1 -5,4 -5,6l-2 7c2,-2 0,-1 2,-3 1,-1 1,-1 2,-2 1,1 2,1 2,2l2 2c-1,4 -1,2 -2,8 0,1 0,3 -1,4 -2,6 -5,8 -8,14 -1,1 -2,1 -2,3 0,0 1,-1 1,-1 1,0 0,0 1,0 0,0 0,0 0,0 -4,5 -8,10 -13,14 3,-1 7,-4 10,-6 0,2 0,1 -1,2 -2,3 -5,4 -7,6 -8,6 -5,7 -19,14 -2,1 -4,1 -6,3l-1 2c-1,1 0,0 1,2 -2,1 -3,1 -4,2 -1,1 -3,1 -4,2 -5,2 -7,5 -13,8 -7,3 -5,1 -6,4 -3,0 -1,-1 -6,1 -2,1 -5,1 -6,2 -3,1 -7,3 -11,4l-2 -1c-2,0 -4,1 -7,1 -2,0 -3,0 -5,-1 -1,1 0,1 -2,2 -9,-4 -4,-5 -15,-5 0,0 -3,-1 -4,-1 -2,0 -2,2 -3,3 -2,3 -5,-1 -5,-1l-6 1c-1,0 -2,0 -3,-1 0,0 0,0 0,0 -8,0 -7,0 -11,6 -1,1 -3,3 -4,4l-6 0c-2,-4 -2,-3 -3,-8 0,-1 0,-2 -1,-2 0,0 -1,0 -1,0 -3,1 3,-1 0,0 -3,2 -10,12 -12,15 -1,3 -3,4 -4,8 -2,3 -3,7 -5,9 -1,-4 1,-4 0,-7 0,-3 0,-2 0,-4l1 -5c1,-3 1,-5 3,-6 3,-2 3,-7 5,-11 0,-1 0,-1 1,-2l1 -3c2,-3 2,-6 1,-9 1,0 1,0 2,1l2 0c-2,-2 -1,-2 -3,-3 -13,-9 -14,-16 -17,-18l1 3c-2,0 -6,-2 -8,-3 -2,-2 1,1 -1,0l-5 -4c-1,-1 0,0 -1,0 -4,-2 1,0 -2,-1 0,0 0,0 -1,-1 -3,-2 -2,0 -4,-2l-5 -2c-1,-1 0,-1 -2,-2l-2 -1c-2,-2 1,0 -2,-1 0,0 0,0 0,0 -4,-1 -2,-2 -5,-3 0,0 0,0 0,0l0 -2c1,-2 1,1 0,0 -1,-3 -1,-2 0,-3 -2,0 -2,-1 -4,-2 -2,-2 0,-1 -2,-2 -1,0 -18,0 -36,-5 -3,0 -5,-1 -7,-2 -5,-1 -7,-1 -5,-8 -5,-2 -11,-4 -14,-9 3,0 5,1 6,2 1,-2 1,-3 3,-4l14 5c2,0 3,1 4,-1 -1,0 -3,-1 -4,-2 -1,-1 0,-4 0,-5 -5,-2 -16,-9 -21,-13 -2,-1 -4,-2 -6,-6 2,0 1,0 2,1l18 10c1,-2 1,-2 0,-4 4,0 5,1 7,3l17 8c-3,-8 -6,-7 -9,-10l1 -2c0,-3 -1,-4 -2,-7 -2,-2 -3,-7 -5,-11 2,0 2,1 3,1 0,-1 -1,0 1,-1 2,-1 -3,-5 -4,-6 0,0 0,-1 0,-1l3 -3c2,-2 0,-2 2,-4 1,1 1,1 2,2 1,1 0,1 1,1 -1,-4 -2,-4 0,-7l0 -1c1,-3 -1,-2 3,-3l1 4c1,-3 -1,-10 1,-16 0,-2 0,-3 4,-5 5,-2 6,2 9,9 1,3 4,9 5,10 0,-2 0,0 1,-2 0,1 1,1 1,1 0,0 1,1 1,1 4,0 -3,0 2,0l1 0c3,0 1,3 6,6 2,2 4,4 6,5 0,1 0,0 0,0 1,-1 4,1 5,2 0,0 1,1 2,1l3 5c2,2 0,-1 2,1 2,3 1,2 0,3l10 2c1,0 1,0 3,1 -1,-2 -1,-2 -2,-3l-4 -4c0,0 0,0 0,0 -1,2 0,2 0,2 0,-1 0,-1 -1,-1 0,0 0,-1 -1,-1 0,0 0,0 0,0 0,0 0,0 0,0 -1,-1 -1,-1 -3,-3l-4 -4c-6,-6 -5,-9 -7,-13 0,1 0,1 0,2l-1 2c-4,-5 -9,-28 -10,-35 0,-5 0,-8 0,-13l-2 2c0,3 -2,6 0,21 1,3 1,3 0,5 -1,2 -1,-2 -1,1 0,1 1,3 1,5l1 5c-4,-13 -8,-25 -8,-39l-3 1c-2,-5 0,-3 -1,-7 -2,0 -2,0 -2,3l0 12c0,2 0,4 1,6l-2 3c0,0 0,1 0,1l1 8c-4,-13 -7,-28 -7,-41 0,-1 0,-3 -1,-4 0,-2 -1,-1 -2,-2 0,-1 0,-2 -1,-3 -1,-3 1,0 -1,-2l-1 4c-1,0 -1,0 -2,0 -2,-1 -2,-3 -4,-2 -2,2 4,22 6,26 -5,2 -3,2 -5,-1z"/>
  <path class="fil3" d="M1477 820c-1,3 -4,9 -5,13l-3 14c1,3 -1,6 0,8 2,4 1,7 7,13l4 4c2,2 2,2 3,3 0,0 0,0 0,0 0,0 0,0 0,0 1,0 1,1 1,1 1,0 1,0 1,1 0,0 -1,0 0,-2 0,0 0,0 0,0l4 4c1,1 1,1 2,3 -2,-1 -2,-1 -3,-1l-10 -2c-2,-1 -5,-2 -9,-3 -1,-1 0,-1 -2,-1 0,-1 -1,-1 -2,-1 -9,-5 -9,-7 -17,-18 -1,-1 -4,-7 -5,-10 -3,-7 -4,-11 -9,-9 -4,2 -4,3 -4,5 -2,6 0,13 -1,16 0,7 1,19 3,25 4,10 0,4 6,14 4,7 2,6 11,20 3,-1 3,0 4,-2 1,-3 -1,-6 -1,-8 -1,-10 -2,-5 -3,-10 -1,-2 -1,-5 -2,-7 0,0 2,3 3,5 0,0 0,0 0,-1l0 -1c0,-3 -1,-5 1,-6 2,4 3,8 6,13 3,5 4,9 9,10 -2,-7 -4,-8 -8,-21 6,3 5,13 14,18l9 5c1,0 1,1 1,1 1,-1 1,-2 1,-3 3,6 8,13 11,18 2,2 2,2 4,2 5,1 8,2 12,6 -1,-2 -1,-1 0,-2 1,2 3,2 5,4 -1,-3 -1,-3 -2,-5 0,-1 0,0 0,-1 2,1 2,0 3,3 6,9 7,7 10,9l2 1 0 -4c2,0 4,-1 6,-2l4 -2c0,0 0,0 1,0 2,-1 2,1 5,0 1,0 4,0 5,-1 -6,4 0,14 -5,19 -3,3 -8,3 -11,2l-3 -1c-5,-2 -6,-2 -10,-5 -2,-2 -1,0 -4,-2 -4,-4 -6,-4 -11,-8l-4 -3c-5,-2 -4,-4 -8,-3 -2,0 -1,1 -3,1 -1,4 0,12 2,16l5 10c3,2 4,9 17,18 2,1 1,1 3,3 2,2 15,6 18,7 11,1 11,-7 23,-6 0,-1 2,-3 3,-4 7,-8 8,-11 11,-14 3,-4 9,-2 12,-5 3,-3 6,-7 10,-8 0,2 0,1 -2,4 -2,3 -6,8 -9,9 0,0 2,0 2,0 0,0 2,-1 4,-1 -1,1 -2,4 -4,4 5,-2 7,-5 12,-5 0,0 0,0 0,0 3,0 4,-2 7,-2 7,-1 10,-9 16,-12 0,3 1,1 -2,5 0,0 -3,5 -2,3 1,1 2,0 4,0 0,0 0,0 0,0 11,1 15,-13 23,-11 0,0 0,0 1,0l-2 2c-1,1 -2,2 -3,2 -1,2 -3,3 -4,5 -5,3 -30,22 -34,21 11,-3 29,-14 38,-21 2,-1 2,-2 5,-3 5,-1 3,-1 7,-3 1,3 1,3 -1,5l-3 4c-3,3 0,2 -2,4 0,1 -1,1 -1,1 0,3 1,4 1,5 4,0 17,-12 20,-15 4,-5 9,-12 13,-17 1,-2 1,-2 2,-3 2,-4 8,-16 9,-21l2 -7c0,-2 3,-5 5,-6 3,3 1,3 5,4 0,0 0,0 0,0 0,3 0,1 2,5 2,3 1,2 2,6 3,-2 3,0 6,-3 1,-2 -1,0 2,-2 0,3 0,1 -2,6 -1,2 -2,4 -3,6 -5,9 -3,5 -1,12 -2,2 -4,4 -6,7 -6,6 -15,14 -22,19 1,3 2,1 5,-1l6 -4c3,-1 11,-10 13,-13 2,-2 4,-4 6,-7 1,-2 4,-7 5,-7 1,-5 15,-25 1,-41l-1 -1c-1,0 -1,0 -1,0 0,0 0,-1 0,-1 1,8 4,4 0,12 0,2 -3,9 -5,10 2,-1 1,-1 1,-3 -5,2 -6,-1 -7,-2 -1,-2 -1,-1 -2,-2 -2,-3 -2,-7 -2,-11l-3 3c-4,-3 -1,-3 -11,1 -4,2 -6,7 -8,8 -5,6 -12,14 -21,17 -10,4 -18,4 -28,3l1 -7c-1,0 0,1 -1,0 1,-2 1,-4 1,-7 1,-2 2,-3 1,-6 -1,3 -3,2 -6,4 -1,1 -1,2 -5,5 -1,0 -4,5 -5,7 -3,4 -2,3 -8,4 -8,2 -14,4 -22,4 -12,-1 -20,-6 -24,6 -2,5 0,7 -3,9 -2,-3 -1,-3 -2,-6l-1 1c-2,-5 3,-13 0,-16 -3,-1 -6,5 -8,0 0,-2 0,-2 0,-3l-3 -2c0,1 0,1 -1,2 -1,2 1,0 -1,1 -4,4 -5,2 -8,1 -1,-2 -2,-4 -2,-6 0,0 0,-1 0,-1 0,0 0,0 0,0 1,-2 0,-3 -1,-5l7 -5c-8,1 -23,-7 -29,-12 3,4 7,6 4,10l0 1c-2,2 -1,2 -3,5 -2,2 0,1 -3,2l-2 -4 -1 3c-4,-1 -7,-6 -8,-9 -2,-7 2,-15 14,-8 1,0 3,1 4,2 5,3 10,6 16,7 3,0 7,1 11,1 13,2 7,14 8,20 8,-3 5,-1 8,-6l4 -10c4,-13 9,-32 8,-44l-4 -1c-1,1 0,1 -2,3 -1,1 -1,0 -2,1l-2 2c0,-2 0,-3 -1,-4l-1 4c-4,1 -7,-2 -10,-5 -2,-3 -1,-14 -3,-20l-2 14 -5 -1c-1,-1 -1,-1 -2,-1l1 -3c-3,1 -1,1 -4,0 -3,-2 -1,0 -4,-2l-5 -2c0,-2 1,-5 2,-7 1,-2 2,-5 2,-6 -3,3 -7,12 -9,16 -1,3 -1,3 -3,5 -2,1 -2,3 -3,5 -1,2 -6,3 -8,3 -1,-6 2,-12 3,-16 -1,1 -1,1 -2,1 -4,2 -4,-1 -6,-3l-5 -1c-2,-1 -4,-2 -7,-2 0,3 -1,12 -2,14l-2 3c-2,2 -2,3 -4,5 -1,-1 -1,-2 -3,-3 -3,-3 -4,-4 -3,-9 1,-4 1,-8 2,-12 1,-3 2,-6 3,-9l1 -2c2,-3 4,-8 3,-12 -1,2 -1,1 -1,3 -1,2 -1,2 -2,3z"/>
  <path class="fil7" d="M1455 1153c1,6 0,4 0,8 2,-2 1,-1 3,-3 2,-3 3,-6 5,-8 1,4 0,4 -1,9 -2,6 -2,3 -2,8 0,2 0,1 0,2 -5,10 -1,5 -4,11l-6 13c-3,6 0,2 -3,7 -2,2 -13,16 -12,18 1,-6 2,-11 4,-17 1,-4 3,-14 5,-17 -12,22 -17,38 -36,61 -8,10 -14,14 -16,31 0,8 1,33 5,41 2,3 2,3 2,6 -2,-5 -5,-30 -4,-36l2 1c0,0 0,0 0,0 3,2 3,3 5,5 2,4 2,5 4,10 4,10 5,12 6,22 1,7 3,7 1,19 -1,4 -1,4 0,9 1,4 1,7 2,10 -5,-3 -11,-23 -13,-30 -1,1 -1,0 -1,2l10 31c-2,-3 -14,-12 -17,-12 -1,-2 -3,-3 -4,-4l-14 -10c-1,0 -1,-1 -2,-1l-70 -45c-19,-14 -23,-18 -41,-33l-17 -16c1,4 9,14 11,18 4,5 7,11 11,17 7,13 13,24 20,36l3 -1c1,2 3,4 4,5l6 1c5,2 8,3 12,6 0,0 0,0 0,0 5,3 10,9 14,10 2,1 4,1 6,2l-6 -1c1,3 2,3 3,5 1,2 2,5 3,7 3,11 6,3 5,9 3,4 18,9 24,12 8,3 18,5 29,4 11,-1 19,4 27,8 2,1 3,2 6,3 2,2 3,2 6,4 1,1 10,7 10,8 0,-1 0,-1 1,0 -4,-8 -1,-2 -3,-8 -2,-5 -3,-8 -5,-13 -2,-8 -4,-16 -5,-23 -4,-21 0,-59 6,-80 3,-9 2,-8 6,-17l26 -86c1,-2 1,-2 1,-4 1,-3 1,-3 2,-5 1,-5 1,-3 4,-13 2,-6 3,-12 5,-19 1,-5 8,-35 9,-37l1 -5c-2,2 -21,45 -24,51 -2,5 -6,12 -7,17l-2 -3z"/>
  <path class="fil4" d="M1480 814c1,4 -1,9 -3,12l-1 2c-1,3 -2,6 -3,9 -1,4 -1,8 -2,12 -1,5 0,6 3,9 2,1 2,2 3,3 2,-2 2,-3 4,-5l2 -3c1,-2 2,-11 2,-14 3,0 5,1 7,2l5 1c2,2 2,5 6,3 1,0 1,0 2,-1 -1,4 -4,10 -3,16 2,0 7,-1 8,-3 1,-2 1,-4 3,-5 2,-2 2,-2 3,-5 2,-4 6,-13 9,-16 0,1 -1,4 -2,6 -1,2 -2,5 -2,7l5 2c3,2 1,0 4,2 3,1 1,1 4,0l-1 3c1,0 1,0 2,1l5 1 2 -14c2,6 1,17 3,20 3,3 6,6 10,5l1 -4c1,1 1,2 1,4l2 -2c1,-1 1,0 2,-1 2,-2 1,-2 2,-3l4 1c1,12 -4,31 -8,44l-4 10c-3,5 0,3 -8,6 -1,-6 5,-18 -8,-20 -4,0 -8,-1 -11,-1 -6,-1 -11,-4 -16,-7 -1,-1 -3,-2 -4,-2 -12,-7 -16,1 -14,8 1,3 4,8 8,9l1 -3 2 4c3,-1 1,0 3,-2 2,-3 1,-3 3,-5l0 -1c3,-4 -1,-6 -4,-10 6,5 21,13 29,12l-7 5c1,2 2,3 1,5 0,0 0,0 0,0 0,0 0,1 0,1 0,2 1,4 2,6 3,1 4,3 8,-1 2,-1 0,1 1,-1 1,-1 1,-1 1,-2l3 2c0,1 0,1 0,3 2,5 5,-1 8,0 3,3 -2,11 0,16l1 -1c2,-16 3,-9 0,-18 6,-5 10,-27 13,-34 0,-4 1,-10 1,-17l1 -2c-1,-11 1,-15 -6,-24 -3,-3 -6,-6 -10,-6 -2,0 0,1 -2,-1 -5,1 -8,-4 -14,-7 -5,-3 -18,-10 -23,-1 -2,2 -3,4 -4,7 -1,2 -6,12 -9,13 -1,-4 4,-14 6,-18 1,-1 2,-6 2,-9 1,-5 -6,-7 -3,-20 2,-9 12,-14 19,-14 6,0 4,0 5,-1 -2,0 -4,-1 -7,-2 -2,0 -5,0 -6,0 -11,1 -19,8 -24,14 -4,5 -12,16 -13,20z"/>
  <path class="fil3" d="M1547 787c11,-3 41,5 48,16l-4 -2c-4,-2 -17,-7 -20,-7 2,3 0,2 1,5 -2,0 -14,-7 -11,4 -5,1 -8,1 -12,2 1,1 1,1 2,2 -5,1 -3,-1 -5,3 2,7 9,8 12,15 1,-1 4,-1 6,-1 -4,4 -5,5 -13,8 2,2 0,1 2,1l3 -2c11,-5 15,-13 17,-16 12,2 19,14 25,21l3 5c3,0 18,-4 22,-4l2 1 -13 6c-1,3 -2,8 -1,13 2,6 5,8 9,11 1,-1 0,0 1,-1 5,-5 4,-1 9,-7 0,-1 0,-1 1,-1l-2 -2c-1,-1 0,1 -1,-1 0,-1 1,-1 1,-1 0,-1 0,-1 0,-1l0 -1c1,-5 1,-3 1,-5 0,0 0,-2 -1,-2l-6 2c-1,-2 0,-1 -2,-2 -5,0 -9,3 -8,6 0,-2 0,-5 1,-7 3,0 6,-1 8,-3 9,-3 6,-8 -2,-6 -1,-1 -1,-2 -1,-4l-11 1 4 -2c-1,-4 -1,-4 2,-5 0,-2 -1,-3 0,-4 -4,1 -13,1 -15,2l8 -3 -2 -7c-1,0 -2,0 -3,0 -2,0 -1,1 -2,-1 -1,-2 -1,0 0,-1l2 -2 -19 3c0,-3 0,-3 4,-3l19 -3c7,-1 19,-1 23,-6 1,-3 2,-3 -1,-7 -3,-5 -13,-9 -15,-10 -1,0 -8,-3 -10,-4 -3,-1 -7,-2 -11,-3 -5,-1 -16,-3 -22,-2 -5,0 -10,0 -15,1 -6,0 -11,3 -17,4l1 1c-2,1 -2,1 -3,3 1,3 0,1 1,2l1 1c0,0 0,0 0,0 2,-1 4,-1 5,-1 3,1 1,1 4,1z"/>
  <path class="fil5" d="M1721 853c0,4 -3,10 -4,13 -2,2 -3,4 -5,7 -2,2 -4,6 -6,7 2,3 3,1 5,4l2 1c0,0 0,1 0,1 0,0 0,0 1,0l1 1c14,16 0,36 -1,41 3,-2 5,-1 9,-1 1,-1 3,-1 5,-1l8 0c4,1 1,1 5,0 3,-1 0,-1 1,0l1 0c2,0 4,0 6,-1 -3,0 -2,1 -2,2l5 -2c3,2 -1,2 7,2 2,0 5,0 8,0l-3 1c0,2 2,5 3,6l-6 5c0,0 -1,0 -1,0 -3,1 0,1 -5,2l-3 2c-2,0 -3,0 -4,0l-2 1c-1,0 0,0 -1,0l13 0c-2,1 -6,1 -8,2 2,5 7,11 8,12l0 2 3 -2c0,-2 1,-3 1,-7 0,-2 0,-4 1,-6 1,-3 4,-6 8,-9 11,-11 2,-11 -3,-23 -2,-5 0,-9 -4,-15 -3,-4 -6,-6 -9,-9 -3,-5 -3,-8 -11,-5 -4,1 -11,6 -14,3 0,-1 1,-2 3,-3 10,-7 20,-8 17,-17 -2,-5 -1,-6 -1,-10l-1 -1 -2 4c-4,1 -4,1 -7,-1 -9,-5 -4,-4 -8,-7l-2 -1 5 -2c-3,0 0,-3 -3,-8l-5 2c-2,3 -3,7 -5,10z"/>
  <path class="fil2" d="M1652 786l0 2c2,-1 2,-1 3,-1 1,2 6,25 6,15l2 0c0,0 1,0 2,-1 2,-1 4,-3 5,-5 2,5 2,9 2,13 0,1 0,1 0,2l-1 2c0,3 -1,6 1,9 2,0 3,-4 3,-6 0,-2 5,-21 6,-23 1,-3 1,-5 5,-7l-1 1c-1,4 -6,11 -5,15 0,7 2,15 6,21 2,0 1,0 3,0l1 2 3 -3c3,-4 1,-3 4,-10l1 -4c0,0 0,0 0,0l0 -2c0,-2 0,-2 0,-4 4,2 4,4 5,5 0,-4 2,-4 2,-5 1,2 1,4 6,4 6,0 2,0 4,3 0,1 0,0 0,1 2,-1 0,0 2,-2 1,-1 -1,1 0,0 2,-2 4,-2 5,-2l2 -7c2,10 -7,38 -7,39 -1,3 2,2 1,5 1,3 1,1 2,4 1,2 1,4 1,6 2,-3 3,-7 5,-10l6 -22c0,-2 0,-6 1,-8l3 2c1,1 2,2 2,2 2,1 4,-3 10,4 9,13 6,18 3,30 -1,2 -1,4 -2,6 0,4 -1,5 1,10 3,9 -7,10 -17,17 -2,1 -3,2 -3,3 3,3 10,-2 14,-3 8,-3 8,0 11,5 3,3 6,5 9,9 4,6 2,10 4,15 5,12 14,12 3,23 -4,3 -7,6 -8,9 -1,2 -1,4 -1,6 0,4 -1,5 -1,7 5,-7 -2,-10 8,-19 7,-7 12,-9 5,-19 -10,-16 -2,-14 -9,-24 -3,-3 -6,-5 -8,-8 -4,-5 -2,-5 -7,-6 0,0 -1,-1 -1,-1l-2 -4c11,-11 -1,0 5,-28 1,-4 4,-10 3,-14 -1,-6 -7,-18 -12,-20 -5,-2 -2,2 -7,-2 -3,-3 -3,-2 -3,-6 1,-13 -2,-26 -12,-34 -1,-1 -2,-1 -3,-1 0,0 1,2 1,5 1,5 0,15 -1,19 0,0 0,0 0,0 -3,-2 -1,-1 -6,0l-5 0 0 -5 -4 -2 -4 -12c2,0 0,0 0,0 -4,-2 0,1 -1,-1 1,-1 2,-3 4,-5 5,-4 7,-2 7,-3 -2,-2 -7,-2 -9,1 -3,4 -3,6 -5,9 -3,-2 -8,-11 -10,-15 -2,-6 2,-11 -3,-15l-2 -1c2,3 4,4 4,8 -1,4 -1,5 0,10 2,5 7,11 10,15 -4,10 -12,-5 -17,16 -1,6 -2,12 -3,19 0,3 0,4 -2,6 -2,-7 3,-12 -1,-28 -1,-6 -2,-12 -7,-12 -5,-1 -9,3 -12,5z"/>
  <path class="fil2" d="M1354 842c1,-4 -1,-3 3,-9 4,-6 2,-12 1,-19 -1,-5 -1,-7 3,-9 10,-6 10,-2 18,-11 6,-6 13,-5 21,-8 -1,5 -2,10 -1,16 0,5 1,14 3,19 1,2 2,5 3,7l2 -1c0,-3 -3,-3 1,-5 2,-2 3,-2 4,-2 -1,-7 -6,-24 -4,-29 2,3 0,0 3,2 2,-1 1,-1 2,-2 0,0 0,1 0,2l1 1c0,0 1,0 1,0l0 -1c0,-1 0,0 0,-1 0,-1 0,-1 1,-2 3,0 2,1 3,-1l1 2c0,-2 -1,-12 -1,-16 0,-2 0,-9 1,-11 3,-3 3,0 3,-3 -1,-3 0,0 1,-5 2,-5 4,-11 7,-14 3,-3 7,-5 11,-6 7,-2 8,-1 11,2l9 -1c0,4 -5,5 -6,23 1,1 0,1 2,1 1,-2 0,-2 1,-4 2,0 2,1 5,2l1 1c0,0 0,1 0,1 1,-1 1,-1 1,-2 0,0 0,-1 0,-1l1 -9c1,4 0,7 4,10 3,4 0,2 2,5 1,3 3,0 3,0 0,0 0,0 0,0 4,0 3,0 8,-1 0,-2 0,-4 1,-5l0 1c1,1 1,2 1,3 4,-2 -1,-1 4,-3 3,8 2,11 5,13 1,-2 1,-2 2,-5 0,1 0,1 1,2l1 1c3,-1 5,-2 6,-4l3 -5c0,0 0,0 0,0 2,-6 4,-7 -1,-17 4,3 3,9 4,11 1,2 -1,0 1,2 2,-2 1,-1 2,-2 -2,-4 -1,-11 -5,-13 -5,-3 -7,2 -10,-7 9,-2 18,-4 26,-8 5,-3 6,-4 8,-8 2,-6 6,-4 10,-4 -3,-3 -10,-1 -12,0 -6,2 -9,13 -19,15 -4,1 -9,2 -13,3 -2,-3 -2,-6 -4,-9 -1,-2 -4,-4 -6,-3l-3 1 4 2c6,3 6,8 7,13 -1,-1 0,-1 -2,-1 -2,3 -1,4 -4,7 0,1 -1,5 -4,5 -2,-1 -1,-1 -2,-2l-4 2c-2,-2 -4,-1 -5,-9 -1,-5 0,-9 2,-13 0,-2 0,-1 1,-3 -15,6 -13,11 -17,12 -11,2 -8,-2 -13,-2 -6,0 -16,5 -20,10 -3,2 -5,12 -7,17 -5,9 -15,4 -22,24 -7,3 -15,2 -21,8 -3,2 -3,4 -7,6 -4,2 -8,3 -12,5 -7,5 -3,12 -2,20 2,10 -5,11 -4,19z"/>
  <path class="fil6" d="M1497 962l-5 -10c-5,-2 -4,-1 -9,-3 -2,-1 -3,-3 -5,-4l-13 -9c-3,-2 -5,-5 -8,-7 -7,-6 -11,-13 -15,-20 -3,-4 -10,-21 -10,-26 -2,-6 -3,-18 -3,-25l-1 -4c-4,1 -2,0 -3,3l0 1c-2,3 -1,3 0,7 -1,0 0,0 -1,-1 -1,-1 -1,-1 -2,-2 -2,2 0,2 -2,4l-3 3c0,0 0,1 0,1 1,1 6,5 4,6 -2,1 -1,0 -1,1 -1,0 -1,-1 -3,-1 2,4 3,9 5,11 1,3 2,4 2,7l-1 2c3,3 6,2 9,10l-17 -8c-2,-2 -3,-3 -7,-3 1,2 1,2 0,4l-18 -10c-1,-1 0,-1 -2,-1 2,4 4,5 6,6 5,4 16,11 21,13 0,1 -1,4 0,5 1,1 3,2 4,2 -1,2 -2,1 -4,1l-14 -5c-2,1 -2,2 -3,4 -1,-1 -3,-2 -6,-2 3,5 9,7 14,9 -2,7 0,7 5,8 2,1 4,2 7,2 18,5 35,5 36,5 2,1 0,0 2,2 2,1 2,2 4,2 -1,1 -1,0 0,3 1,1 1,-2 0,0l0 2c0,0 0,0 0,0 3,1 1,2 5,3 0,0 0,0 0,0 3,1 0,-1 2,1l2 1c2,1 1,1 2,2l5 2c2,2 1,0 4,2 1,1 1,1 1,1 3,1 -2,-1 2,1 1,0 0,-1 1,0l5 4c2,1 -1,-2 1,0 2,1 6,3 8,3l-1 -3z"/>
  <path class="fil6" d="M1689 913c-1,5 -7,17 -9,21l-4 7c-1,2 -3,5 -5,7 -3,5 -6,8 -10,12 -19,19 -44,28 -70,28 -16,0 -23,-3 -33,-4 -12,-1 -12,7 -23,6 -3,-1 -16,-5 -18,-7l-2 0c-1,-1 -1,-1 -2,-1 1,3 1,6 -1,9l-1 3c-1,1 -1,1 -1,2 -2,4 -2,9 -5,11 -2,1 -2,3 -3,6l-1 5c0,2 0,1 0,4 1,3 -1,3 0,7 2,-2 3,-6 5,-9 1,-4 3,-5 4,-8 2,-3 9,-13 12,-15 3,-1 -3,1 0,0 0,0 1,0 1,0 1,0 1,1 1,2 1,5 1,4 3,8l6 0c1,-1 3,-3 4,-4 4,-6 3,-6 11,-6 0,0 0,0 0,0 1,1 2,1 3,1l6 -1c0,0 3,4 5,1 1,-1 1,-3 3,-3 1,0 4,1 4,1 11,0 6,1 15,5 2,-1 1,-1 2,-2 2,1 3,1 5,1 3,0 5,-1 7,-1l2 1c4,-1 8,-3 11,-4 1,-1 4,-1 6,-2 5,-2 3,-1 6,-1 1,-3 -1,-1 6,-4 6,-3 8,-6 13,-8 1,-1 3,-1 4,-2 1,-1 2,-1 4,-2 -1,-2 -2,-1 -1,-2l1 -2c2,-2 4,-2 6,-3 14,-7 11,-8 19,-14 2,-2 5,-3 7,-6 1,-1 1,0 1,-2 -3,2 -7,5 -10,6 5,-4 9,-9 13,-14 0,0 0,0 0,0 -1,0 0,0 -1,0 0,0 -1,1 -1,1 0,-2 1,-2 2,-3 3,-6 6,-8 8,-14 1,-1 1,-3 1,-4 1,-6 1,-4 2,-8l-2 -2c0,-1 -1,-1 -2,-2 -1,1 -1,1 -2,2 -2,2 0,1 -2,3z"/>
  <path class="fil10" d="M1690 955c0,1 0,1 3,3 11,4 18,6 30,7 2,0 1,0 2,1 4,-1 11,1 16,0 5,0 15,-2 17,-6l0 -2c-1,-1 -6,-7 -8,-12 2,-1 6,-1 8,-2l-13 0c1,0 0,0 1,0l2 -1c1,0 2,0 4,0l3 -2c5,-1 2,-1 5,-2 0,0 1,0 1,0l6 -5c-1,-1 -3,-4 -3,-6l3 -1c-3,0 -6,0 -8,0 -8,0 -4,0 -7,-2l-5 2c0,-1 -1,-2 2,-2 -2,1 -4,1 -6,1l-1 0c-1,-1 2,-1 -1,0 -4,1 -1,1 -5,0l-8 0c-2,0 -4,0 -5,1 -4,0 -6,-1 -9,1 -1,0 -4,5 -5,7 -2,3 -4,5 -6,7 -2,3 -10,12 -13,13z"/>
  <path class="fil2" d="M1558 984c10,1 17,4 33,4 26,0 51,-9 70,-28 4,-4 7,-7 10,-12 2,-2 4,-5 5,-7l4 -7c-1,1 -1,1 -2,3 -4,5 -9,12 -13,17 -3,3 -16,15 -20,15 0,-1 -1,-2 -1,-5 0,0 1,0 1,-1 2,-2 -1,-1 2,-4l3 -4c2,-2 2,-2 1,-5 -4,2 -2,2 -7,3 -3,1 -3,2 -5,3 -9,7 -27,18 -38,21 4,1 29,-18 34,-21 1,-2 3,-3 4,-5 1,0 2,-1 3,-2l2 -2c-1,0 -1,0 -1,0 -8,-2 -12,12 -23,11 0,0 0,0 0,0 -2,0 -3,1 -4,0 -1,2 2,-3 2,-3 3,-4 2,-2 2,-5 -6,3 -9,11 -16,12 -3,0 -4,2 -7,2 0,0 0,0 0,0 -5,0 -7,3 -12,5 2,0 3,-3 4,-4 -2,0 -4,1 -4,1 0,0 -2,0 -2,0 3,-1 7,-6 9,-9 2,-3 2,-2 2,-4 -4,1 -7,5 -10,8 -3,3 -9,1 -12,5 -3,3 -4,6 -11,14 -1,1 -3,3 -3,4z"/>
  <path class="fil2" d="M1567 882c3,1 3,1 4,1 1,-1 2,-3 2,-4 -1,2 0,4 1,6 1,3 0,2 1,5 0,3 0,3 2,4 2,2 1,2 3,3 2,0 1,1 3,0 2,-2 -3,0 6,-3l0 3c2,-1 2,-1 3,-1 -1,5 -5,13 -6,16 2,0 2,1 3,1 5,-5 5,-12 8,-14 3,-1 1,-1 3,-3 1,3 0,5 3,8 3,0 6,-3 7,-5l1 1c4,1 5,1 6,1 -3,3 -4,4 -6,8 0,0 0,0 -1,0l-1 6c5,-3 12,-17 13,-21 0,3 -2,8 -3,11 -2,3 -1,3 -1,5 4,-3 4,-4 5,-5 3,-2 5,-1 6,-4 1,3 0,4 -1,6 0,3 0,5 -1,7 1,1 0,0 1,0 2,-2 3,-13 3,-15 0,-5 -2,-13 2,-16 4,12 0,5 1,13 1,6 3,9 5,13l2 1 1 4c0,0 8,-5 8,-5 0,-3 -1,-2 -1,-6 0,-6 2,-11 2,-14l1 -10c2,-2 2,-6 4,-9l0 -2 0 -9 -3 0c-1,0 -2,1 -3,1 -2,1 -2,0 -3,1 -1,2 1,0 -2,2l-8 2c0,0 1,0 4,1 7,2 3,9 3,11 -3,1 -5,1 -7,2 -3,1 -3,3 -6,4 -3,-3 -4,-3 -6,-10l-2 8c-1,2 -1,6 -1,9 -1,0 -2,-1 -2,-2 0,0 -1,-1 -1,-2 -3,-6 -4,-5 -6,-9 1,2 0,2 0,4l-1 2c0,4 1,-1 0,1l-2 6c-1,2 1,0 -2,2 -4,2 -5,-2 -4,-6 1,-4 -1,-5 2,-9 2,-4 3,-2 3,-2 -5,-1 -4,1 -9,-5 -1,-1 -3,-2 -3,-2l1 1c-1,1 0,0 -1,1l-1 4c0,3 1,1 -1,5l-3 3c-2,-2 0,-2 -2,-2 0,0 0,-2 1,0l0 1c0,0 -1,0 -1,0l-1 1c-4,3 0,1 -4,3l-1 0c0,0 -1,-1 -1,-1 -4,-2 -6,-11 -6,-13 0,-2 1,-1 1,-3 1,-1 0,-5 4,-7 1,0 0,0 1,0 -2,1 -3,1 -5,1 -3,1 -5,2 -7,1 -2,1 -2,2 -2,0l-1 2c0,7 -1,13 -1,17z"/>
  <path class="fil11" d="M1492 952c-2,-4 -3,-12 -2,-16 2,0 1,-1 3,-1 4,-1 3,1 8,3l4 3c5,4 7,4 11,8 3,2 2,0 4,2 4,3 5,3 10,5l3 1c3,1 8,1 11,-2 5,-5 -1,-15 5,-19 -1,1 -4,1 -5,1 -3,1 -3,-1 -5,0 -1,0 -1,0 -1,0l-4 2c-2,1 -4,2 -6,2l0 4 -2 -1c-3,-2 -4,0 -10,-9 -1,-3 -1,-2 -3,-3 0,1 0,0 0,1 1,2 1,2 2,5 -2,-2 -4,-2 -5,-4 -1,1 -1,0 0,2 -4,-4 -7,-5 -12,-6 -2,0 -2,0 -4,-2 -3,-5 -8,-12 -11,-18 0,1 0,2 -1,3 0,0 0,-1 -1,-1l-9 -5c-9,-5 -8,-15 -14,-18 4,13 6,14 8,21 -5,-1 -6,-5 -9,-10 -3,-5 -4,-9 -6,-13 -2,1 -1,3 -1,6l0 1c0,1 0,1 0,1 -1,-2 -3,-5 -3,-5 1,2 1,5 2,7 1,5 2,0 3,10 0,2 2,5 1,8 -1,2 -1,1 -4,2 -9,-14 -7,-13 -11,-20 -6,-10 -2,-4 -6,-14 0,5 7,22 10,26 4,7 8,14 15,20 3,2 5,5 8,7l13 9c2,1 3,3 5,4 5,2 4,1 9,3z"/>
  <path class="fil11" d="M1620 868c1,1 -1,0 1,1 2,1 -1,0 1,1 2,1 0,-2 2,1 4,-6 15,-7 23,-10 1,-1 1,0 3,-1 1,0 2,-1 3,-1 1,-6 2,-10 1,-17 0,-9 -3,-13 -6,-21 -2,-1 -5,-7 -8,-10 -2,-2 -7,-7 -9,-8 -1,-2 -1,2 -2,-2 -4,5 -16,5 -23,6l-19 3c-4,0 -4,0 -4,3l19 -3 -2 2c-1,1 -1,-1 0,1 1,2 0,1 2,1 1,0 2,0 3,0l2 7 -8 3c2,-1 11,-1 15,-2 -1,1 0,2 0,4 -3,1 -3,1 -2,5l-4 2 11 -1c0,2 0,3 1,4 8,-2 11,3 2,6 -2,2 -5,3 -8,3 -1,2 -1,5 -1,7 -1,-3 3,-6 8,-6 2,1 1,0 2,2l6 -2c1,0 1,2 1,2 0,2 0,0 -1,5l0 1c0,0 0,0 0,1 0,0 -1,0 -1,1 1,2 0,0 1,1l2 2c-1,0 -1,0 -1,1 -5,6 -4,2 -9,7 -1,1 0,0 -1,1z"/>
  <path class="fil5" d="M1354 842c1,4 4,10 7,13l1 0c0,1 0,1 1,1 -1,-4 5,-2 5,-2l6 -4c3,-2 5,-2 7,-4 -2,-2 -4,-3 -5,-5 2,0 2,-1 4,0 1,-1 1,-1 1,-3l1 -2c0,-1 0,0 0,-1 -1,-1 -2,-2 -3,-3 -2,-2 -1,0 -2,-3 0,-1 -2,-3 -1,-4 2,-2 4,-1 4,-1l0 -1c0,-1 0,-1 0,-1 3,1 12,9 17,10 4,0 5,-2 8,-1l-3 -10c-2,-5 -3,-14 -3,-19 -1,-6 0,-11 1,-16 -8,3 -15,2 -21,8 -8,9 -8,5 -18,11 -4,2 -4,4 -3,9 1,7 3,13 -1,19 -4,6 -2,5 -3,9z"/>
  <path class="fil5" d="M1587 742c2,0 2,0 4,1l3 1c0,0 0,0 0,0 3,1 4,1 5,2 1,4 -2,-1 0,1 1,2 1,2 3,1 0,3 1,7 6,6 3,-4 9,-3 12,-1 1,-1 1,-2 2,-3 0,0 1,-1 1,-2 1,-1 2,-2 4,-3 6,-5 14,-5 17,4 2,3 2,7 2,11 2,-1 1,0 4,-1 1,-1 1,-1 2,-2l3 10c3,-1 7,-4 10,-6 2,-2 2,-2 5,-3 1,-1 4,-2 4,-2 -4,1 -13,10 -16,13 -1,1 -2,2 -3,4 -1,0 -1,1 -2,2 -1,2 0,0 0,2 0,5 0,2 -1,5l-1 2c0,2 -1,-1 0,2l1 0c3,-2 7,-6 12,-5 5,0 6,6 7,12 4,16 -1,21 1,28 2,-2 2,-3 2,-6 1,-7 2,-13 3,-19 5,-21 13,-6 17,-16 -3,-4 -8,-10 -10,-15 -1,-5 -1,-6 0,-10 0,-4 -2,-5 -4,-8 -3,-1 -8,-2 -13,0 -5,2 -9,5 -13,7l-2 1c-3,-2 -4,-5 -7,-7 0,-1 1,-1 0,-4 -1,-3 -6,-6 -9,-7 -15,-8 -16,1 -35,3 -5,0 -12,-5 -14,2z"/>
  <path class="fil9" d="M1246 1245l17 16c18,15 22,19 41,33l70 45c1,0 1,1 2,1l14 10c1,1 3,2 4,4 1,-2 2,0 0,-4 0,0 -2,-2 -2,-2l-15 -10c-36,-23 -19,-7 -34,-33 -7,-12 -13,-17 -16,-20 8,0 35,8 42,13 9,7 19,15 26,23 4,5 4,4 7,12 2,7 8,27 13,30 -1,-3 -1,-6 -2,-10 -1,-5 -1,-5 0,-9 2,-12 0,-12 -1,-19 -1,-10 -2,-12 -6,-22 -2,-5 -2,-6 -4,-10 -2,-2 -2,-3 -5,-5 0,0 0,0 0,0l-2 -1c-1,6 2,31 4,36 0,-3 0,-3 -2,-6 0,2 1,5 1,7 -18,-25 -27,-34 -53,-41 -28,-8 -49,-11 -75,-26l-19 -12c-2,-1 -8,-5 -10,-6 2,2 3,5 5,6z"/>
  <path class="fil6" d="M1456 760c-2,3 0,1 0,3 -1,2 -1,3 -1,6 11,-4 15,5 16,6 2,1 3,0 5,3 -2,0 -4,0 -5,-2 -1,7 -1,9 -5,14 -1,2 -2,2 -3,4 -1,2 -2,3 -2,6 1,1 0,-1 1,1 1,1 1,2 2,3 3,-1 8,-3 11,-3 2,0 2,0 4,0 3,7 3,5 1,10 -2,2 -4,6 -3,9 1,-1 1,-1 2,-3 0,-2 0,-1 1,-3 1,-4 9,-15 13,-20 5,-6 13,-13 24,-14 -1,0 -1,0 -1,0 -3,-1 -3,0 -3,-6 0,-8 1,-10 1,-19 -1,1 0,0 -2,2 -2,-2 0,0 -1,-2 -1,-2 0,-8 -4,-11 5,10 3,11 1,17 0,0 0,0 0,0l-3 5c-1,2 -3,3 -6,4l-1 -1c-1,-1 -1,-1 -1,-2 -1,3 -1,3 -2,5 -3,-2 -2,-5 -5,-13 -5,2 0,1 -4,3 0,-1 0,-2 -1,-3l0 -1c-1,1 -1,3 -1,5 -5,1 -4,1 -8,1 0,0 0,0 0,0 0,0 -2,3 -3,0 -2,-3 1,-1 -2,-5 -4,-3 -3,-6 -4,-10l-1 9c0,0 0,1 0,1 0,1 0,1 -1,2 0,0 0,-1 0,-1l-1 -1c-3,-1 -3,-2 -5,-2 -1,2 0,2 -1,4 -2,0 -1,0 -2,-1z"/>
  <path class="fil11" d="M1551 832c8,-3 9,-4 13,-8 -2,0 -5,0 -6,1 -2,0 -2,0 -4,0 -2,-1 -1,-1 -3,-2 -3,-1 -3,-1 -4,-4 -6,-11 -6,-7 -7,-13l3 -1c-1,-1 -3,-2 0,-4 -1,-4 -2,-5 -4,-9 7,-1 11,-1 13,-1 2,0 1,0 2,-1 -1,0 -2,0 -4,-1 0,0 0,0 0,0 0,0 0,0 -1,0 -1,0 -1,0 -2,-2 -3,0 -1,0 -4,-1 -1,0 -3,0 -5,1 0,0 0,0 0,0l-1 -1c-1,-1 0,1 -1,-2 1,-2 1,-2 3,-3l-1 -1c-3,0 -5,2 -8,2 -1,1 1,1 -5,1 -7,0 -17,5 -19,14 -3,13 4,15 3,20 0,3 -1,8 -2,9 -2,4 -7,14 -6,18 3,-1 8,-11 9,-13 1,-3 2,-5 4,-7 5,-9 18,-2 23,1 6,3 9,8 14,7z"/>
  <path class="fil11" d="M1567 882c-3,7 -7,29 -13,34 3,9 2,2 0,18 1,3 0,3 2,6 3,-2 1,-4 3,-9 4,-12 12,-7 24,-6 8,0 14,-2 22,-4 6,-1 5,0 8,-4 1,-2 4,-7 5,-7 0,-2 -1,-2 1,-5 1,-3 3,-8 3,-11 -1,4 -8,18 -13,21l1 -6c1,0 1,0 1,0 2,-4 3,-5 6,-8 -1,0 -2,0 -6,-1l-1 -1c-1,2 -4,5 -7,5 -3,-3 -2,-5 -3,-8 -2,2 0,2 -3,3 -3,2 -3,9 -8,14 -1,0 -1,-1 -3,-1 1,-3 5,-11 6,-16 -1,0 -1,0 -3,1l0 -3c-9,3 -4,1 -6,3 -2,1 -1,0 -3,0 -2,-1 -1,-1 -3,-3 -2,-1 -2,-1 -2,-4 -1,-3 0,-2 -1,-5 -1,-2 -2,-4 -1,-6 0,1 -1,3 -2,4 -1,0 -1,0 -4,-1z"/>
  <path class="fil3" d="M1553 722c1,2 0,1 1,2 0,0 0,0 0,0l1 1c-1,5 -5,20 -4,26l1 1c2,-1 2,-3 2,-8 6,-1 0,1 5,-2 0,0 1,0 1,0 1,3 1,6 0,8 2,-1 2,-2 2,-3 2,-5 2,1 5,-5 1,-2 1,-2 3,-3 0,2 0,2 -1,5 2,0 3,-1 2,2 0,2 -1,3 -2,5 3,-1 3,-4 5,-6 2,-2 2,0 9,-2l-6 7 -1 9c3,-2 3,-5 6,-8 0,-2 1,-3 2,-5 0,-1 1,-1 1,-2 1,-2 1,-1 2,-2 2,-7 9,-2 14,-2 19,-2 20,-11 35,-3 3,1 8,4 9,7 1,3 0,3 0,4 3,2 4,5 7,7l2 -1c-1,0 -6,-5 -6,-6 0,0 1,-10 -18,-15 -8,-2 -21,6 -30,6 -4,0 -6,-2 -9,-1 1,-3 5,-6 2,-10 -2,-3 -6,-5 -9,-4 -1,-5 -3,-19 -13,-18 -10,1 -12,11 -15,16l-3 0z"/>
  <path class="fil5" d="M1514 755c0,9 -1,11 -1,19 0,6 0,5 3,6 1,-3 -1,-12 1,-13 -1,-5 4,-21 7,-24 7,-7 17,5 20,12l6 -1 1 -3c-1,-6 3,-21 4,-26l-1 -1c0,0 0,0 0,0 -1,-1 0,0 -1,-2 -3,-4 -5,-7 -10,-7 -4,0 -8,-2 -10,4 -2,4 -3,5 -8,8 -8,4 -17,6 -26,8 3,9 5,4 10,7 4,2 3,9 5,13z"/>
  <path class="fil3" d="M1415 998c1,-1 3,-1 5,-3 1,-1 2,-2 2,-2 6,-4 4,10 2,14 -1,2 -1,3 -2,4 -1,2 -4,7 -4,9l-1 4 3 2c5,4 21,2 25,5 10,8 13,26 28,17l-1 3c2,0 3,0 5,0l4 0c0,2 1,5 2,6 -1,-3 -2,-7 -3,-10 -1,-5 -2,-6 0,-9 2,-3 3,-5 4,-7 2,-2 6,-12 9,0 2,6 -4,8 -5,16l2 -1c1,0 1,1 2,1l2 1c1,1 1,0 1,1 1,1 1,2 1,3 1,5 0,7 5,7 -5,-7 -2,-7 -4,-18 -1,-5 -1,-16 -6,-18 -5,0 -9,5 -9,8 1,-2 0,-6 0,-8l1 0c-1,-4 -1,-9 -4,-12 -2,-1 0,0 -3,0 -2,0 -2,-1 -4,4 -1,1 -2,2 -2,3 1,-1 0,1 1,-1 0,-1 0,0 0,-2 -3,1 -3,1 -5,3l-6 10c-1,4 -1,13 1,17 2,4 4,4 7,3 2,0 6,-3 7,-5 -1,0 0,0 -1,0 0,0 -1,1 -1,1 -1,1 -1,2 -2,3 -6,5 -11,-2 -15,-7 -8,-9 -6,-11 -21,-13 -5,0 -9,0 -13,-2 -8,-4 2,-10 5,-21 1,-3 1,-9 -2,-14 -6,0 -5,5 -11,6 -5,0 -3,-3 -13,1 -6,2 -7,1 -11,-2 -2,-2 -5,-6 -7,-9 -7,-9 -17,-20 -22,-30 -2,-4 -3,-10 -5,-14 -1,2 0,5 0,7 4,12 15,25 22,34 4,6 9,14 14,17 5,2 7,0 11,-2 3,-1 10,-1 12,0z"/>
  <path class="fil8" d="M1394 1354c3,0 15,9 17,12l-10 -31c0,-2 0,-1 1,-2 -3,-8 -3,-7 -7,-12 -7,-8 -17,-16 -26,-23 -7,-5 -34,-13 -42,-13 3,3 9,8 16,20 15,26 -2,10 34,33l15 10c0,0 2,2 2,2 2,4 1,2 0,4z"/>
  <path class="fil3" d="M1423 761c0,3 0,0 -3,3 -1,2 -1,9 -1,11 0,4 1,14 1,16 1,6 2,16 5,22 2,3 0,3 5,1 -2,-4 -8,-24 -6,-26 2,-1 2,1 4,2 1,0 1,0 2,0l1 -4c2,2 0,-1 1,2 1,1 1,2 1,3 1,1 2,0 2,2 1,1 1,3 1,4 0,13 3,28 7,41l-1 -8c-2,-10 -3,-23 -3,-33 0,-4 1,-7 0,-10 5,-2 4,-1 5,-3 2,-3 2,0 4,-4 1,-5 5,-3 3,-10 -1,1 1,3 2,4 2,-2 2,-4 7,-4 14,1 4,17 5,19 0,0 0,0 0,0 0,0 0,1 0,1 0,0 1,0 1,0 4,-5 4,-7 5,-14 1,2 3,2 5,2 -2,-3 -3,-2 -5,-3 -1,-1 -5,-10 -16,-6l-2 2c-4,-12 -19,-26 -30,-10z"/>
  <path class="fil2" d="M1679 854c-1,1 0,2 0,4 1,7 -3,17 -6,22l-3 0c-6,2 -8,8 -9,13l-2 2c-1,3 -1,2 -2,4l-2 4c-1,2 -1,2 -1,4 2,2 4,1 8,3 2,-1 10,-6 11,-8 2,-2 2,-3 3,-1 2,-1 4,-6 8,-8 10,-4 7,-4 11,-1l3 -3c5,-3 4,-8 13,-5 -2,-3 -3,-1 -5,-4 -1,2 -5,3 -7,5 -2,2 -3,4 -6,5 2,-3 7,-7 9,-10 3,-3 5,-6 8,-9 -3,-3 -1,-1 -5,-1 0,-3 1,-2 0,-4 -2,1 -2,2 -3,3 -3,1 -1,-2 -3,1 -3,5 -8,17 -14,19 0,-1 1,-2 2,-3 2,-3 0,-1 1,-4 0,-3 7,-14 6,-22 -1,2 0,1 -1,2l-4 10c1,-3 1,-5 0,-9 -2,2 -3,7 -6,13l-6 11c1,-2 -1,0 1,-3 0,-1 1,-1 1,-2 1,-2 2,-3 2,-5 5,-11 8,-22 4,-34 -4,2 -6,7 -6,11l0 0z"/>
  <path class="fil6" d="M1631 803c2,1 7,6 9,8 3,3 6,9 8,10 -1,-2 -1,-3 -1,-5l2 2c2,2 2,5 9,10 3,2 1,3 3,5 3,-2 1,-1 2,-4 0,-1 3,-4 5,-3 0,0 0,0 1,1 1,0 0,0 2,1 2,-2 0,0 1,-2 0,6 6,5 5,13 0,2 0,0 0,2 1,1 2,2 3,4 1,-2 3,-4 7,-4 2,0 5,2 7,3l2 2c4,-3 6,-5 12,-6 4,-1 8,0 10,3 1,-3 -2,-2 -1,-5 0,-1 9,-29 7,-39l-2 7c1,7 -7,27 -9,33 -4,-1 -2,-2 -5,-2 -1,0 -1,0 -2,-1 -2,-1 2,-1 -2,-2 -1,-1 -1,-1 -3,-2 0,-3 6,-21 3,-24 -1,2 -2,10 -3,12 -1,5 -3,8 -4,13 -4,-1 -5,-1 -6,3 -3,2 -5,0 -8,0l-6 -19c-1,-2 0,-1 -2,-1 0,2 -1,6 -3,6 -2,-3 -1,-6 -1,-9 -1,0 1,-1 -2,0 0,3 1,-1 0,1 0,1 1,-1 0,1 -2,1 -6,3 -6,3 -1,2 0,5 -2,6 1,0 0,-3 0,-4 -1,-4 -2,-3 -4,-5l-2 -3c0,0 -1,0 -1,-1l0 0c-1,-1 -6,-8 -5,-9l4 -14 -6 6c-1,-1 -1,-1 -2,-1 -3,-2 -5,-2 -9,-1 0,3 -1,4 -3,7l0 1c-2,2 -2,2 -2,3z"/>
  <path class="fil6" d="M1517 767c-2,1 0,10 -1,13 0,0 0,0 1,0 1,0 4,0 6,0 3,1 5,2 7,2 3,0 5,-2 8,-2 6,-1 11,-4 17,-4 5,-1 10,-1 15,-1 -1,-3 0,-10 2,-12l3 5c-1,-2 -3,-5 -3,-7 0,-1 3,-5 3,-5 0,2 -1,2 0,5 3,-1 5,-4 5,-5 0,-3 -1,0 0,-2 0,0 0,-1 0,-1 1,-1 1,-1 2,-2 -3,3 -3,6 -6,8l1 -9c-2,0 -2,2 -3,2 -2,2 -3,0 -4,3 -1,1 -3,7 -4,8 -1,-1 0,-6 1,-8 -1,-1 -1,0 -1,-1 -2,0 -1,-1 -2,-2 -2,1 -3,2 -4,3 0,2 0,3 -2,4 0,-2 0,-6 0,-8 -3,1 -2,1 -2,2l-1 1c-3,5 2,4 -4,6l-1 -5 -6 2c-2,-3 -4,-6 -6,-7 1,6 2,7 1,9l-2 3c-1,0 0,0 -1,1 -1,1 -1,1 -2,2l-7 5c0,-2 0,-2 0,-3 -1,-1 -2,-1 -2,-1 -1,0 -1,-1 -1,-1l-1 0c-1,-2 -2,-4 -3,-5 -1,-2 0,-1 -1,-1 -1,2 -2,5 -2,8l0 0z"/>
  <path class="fil2" d="M1442 830c0,0 0,-1 0,-1l2 -3c-1,-2 -1,-4 -1,-6l0 -12c0,-3 0,-3 2,-3 1,4 -1,2 1,7l3 -1c0,14 4,26 8,39l-1 -5c0,-2 -1,-4 -1,-5 0,-3 0,1 1,-1 1,-2 1,-2 0,-5 -2,-15 0,-18 0,-21l2 -2c1,-2 0,-3 1,-6 1,-3 1,-3 2,-5 0,-3 1,-4 2,-6 1,-2 2,-2 3,-4 0,0 -1,0 -1,0 0,0 0,-1 0,-1 0,0 0,0 0,0 -1,-2 9,-18 -5,-19 -5,0 -5,2 -7,4 -1,-1 -3,-3 -2,-4 2,7 -2,5 -3,10 -2,4 -2,1 -4,4 -1,2 0,1 -5,3 1,3 0,6 0,10 0,10 1,23 3,33z"/>
  <path class="fil7" d="M1292 1401c4,1 12,6 17,8 26,9 48,12 76,9 6,0 15,-1 22,-2 10,-2 33,-7 42,-5 -1,-2 -2,-3 -3,-6 -11,-1 -22,-4 -37,-5 -37,-2 -47,9 -82,6l-35 -5z"/>
  <path class="fil10" d="M1648 821c3,8 6,12 6,21 1,7 0,11 -1,17l3 0 0 9c0,-1 1,-7 3,-9 1,-1 0,-1 1,-2 6,-6 5,-2 6,-5 1,-2 1,-2 3,-3 1,5 0,5 0,8 0,4 1,3 0,7 -2,5 1,3 -1,9 -1,2 -2,3 -2,6 1,2 1,1 1,1 -3,1 -3,0 -5,2 3,-1 5,-2 8,-2l3 0c3,-5 7,-15 6,-22 0,-2 -1,-3 0,-4 -1,-3 0,-7 1,-9 -1,-2 -2,-3 -3,-4 0,-2 0,0 0,-2 1,-8 -5,-7 -5,-13 -1,2 1,0 -1,2 -2,-1 -1,-1 -2,-1 -1,-1 -1,-1 -1,-1 -2,-1 -5,2 -5,3 -1,3 1,2 -2,4 -2,-2 0,-3 -3,-5 -7,-5 -7,-8 -9,-10l-2 -2c0,2 0,3 1,5z"/>
  <path class="fil11" d="M1675 816c2,0 1,-1 2,1l6 19c3,0 5,2 8,0 1,-4 2,-4 6,-3 1,-5 3,-8 4,-13 1,-2 2,-10 3,-12 3,3 -3,21 -3,24 2,1 2,1 3,2 4,1 0,1 2,2 1,1 1,1 2,1 3,0 1,1 5,2 2,-6 10,-26 9,-33 -1,0 -3,0 -5,2 -1,1 1,-1 0,0 -2,2 0,1 -2,2 0,-1 0,0 0,-1 -2,-3 2,-3 -4,-3 -5,0 -5,-2 -6,-4 0,1 -2,1 -2,5 -1,-1 -1,-3 -5,-5 0,2 0,2 0,4l0 2c0,0 0,0 0,0l-1 4c-3,7 -1,6 -4,10l-3 3 -1 -2c-2,0 -1,0 -3,0 -4,-6 -6,-14 -6,-21 -1,-4 4,-11 5,-15l1 -1c-4,2 -4,4 -5,7 -1,2 -6,21 -6,23z"/>
  <path class="fil3" d="M1647 861c-8,3 -19,4 -23,10 -5,9 -3,7 -4,11 -11,-16 -11,-5 -19,-14 -8,-8 -7,-11 -21,-8l-9 3c2,1 4,0 7,-1 2,0 3,0 5,-1 -1,0 0,0 -1,0 -4,2 -3,6 -4,7 0,2 -1,1 -1,3 0,2 2,11 6,13 0,0 1,1 1,1l1 0c4,-2 0,0 4,-3l1 -1c0,0 1,0 1,0l0 -1c-1,-2 -1,0 -1,0 2,0 0,0 2,2l3 -3c2,-4 1,-2 1,-5l1 -4c1,-1 0,0 1,-1l-1 -1c0,0 2,1 3,2 5,6 4,4 9,5 0,0 -1,-2 -3,2 -3,4 -1,5 -2,9 -1,4 0,8 4,6 3,-2 1,0 2,-2l2 -6c1,-2 0,3 0,-1l1 -2c0,-2 1,-2 0,-4 2,4 3,3 6,9 0,1 1,2 1,2 0,1 1,2 2,2 0,-3 0,-7 1,-9l2 -8c2,7 3,7 6,10 3,-1 3,-3 6,-4 2,-1 4,-1 7,-2 0,-2 4,-9 -3,-11 -3,-1 -4,-1 -4,-1l8 -2c3,-2 1,0 2,-2z"/>
  <path class="fil12" d="M1363 856l0 0c1,1 1,1 3,2 2,0 3,0 4,1 3,1 5,2 8,3 8,2 4,-9 15,-4 14,6 21,17 28,17 -3,-6 -10,-6 -17,-17 -7,-10 -12,-16 1,-21 0,0 1,-1 1,-1 0,0 1,0 1,0 0,0 0,0 0,0l-2 -5c-3,-1 -4,1 -8,1 -5,-1 -14,-9 -17,-10 0,0 0,0 0,1l0 1c0,0 -2,-1 -4,1 -1,1 1,3 1,4 1,3 0,1 2,3 1,1 2,2 3,3 0,1 0,0 0,1l-1 2c0,2 0,2 -1,3 -2,-1 -2,0 -4,0 1,2 3,3 5,5 -2,2 -4,2 -7,4l-6 4c0,0 -6,-2 -5,2z"/>
  <path class="fil13" d="M1580 860c14,-3 13,0 21,8 8,9 8,-2 19,14 1,-4 -1,-2 4,-11 -2,-3 0,0 -2,-1 -2,-1 1,0 -1,-1 -2,-1 0,0 -1,-1 -4,-3 -7,-5 -9,-11 -1,-5 0,-10 1,-13l13 -6 -2 -1c-4,0 -19,4 -22,4l-3 -5c-5,0 -14,-2 -19,0l-1 1c3,0 4,0 6,0 3,0 4,0 6,0 0,2 0,4 -1,5 -1,5 -1,1 -1,1 -1,3 -1,3 -2,6 0,9 1,5 -12,12l6 -1z"/>
  <path class="fil14" d="M1726 843l5 -2c3,5 0,8 3,8l-5 2 2 1c4,3 -1,2 8,7 3,2 3,2 7,1l2 -4 1 1c1,-2 1,-4 2,-6 3,-12 6,-17 -3,-30 -6,-7 -8,-3 -10,-4 0,0 -1,-1 -2,-2l-3 -2c-1,2 -1,6 -1,8l-6 22z"/>
  <path class="fil14" d="M1610 768c2,3 6,13 3,16 2,1 12,5 15,10 3,4 2,4 1,7 1,4 1,0 2,2 0,-1 0,-1 2,-3l0 -1c2,-3 3,-4 3,-7 4,-1 6,-1 9,1 1,0 1,0 2,1l6 -6 -4 14c-1,1 4,8 5,9l0 0c0,1 1,1 1,1l2 3c2,2 3,1 4,5 0,1 1,4 0,4 2,-1 1,-4 2,-6 0,0 4,-2 6,-3 1,-2 0,0 0,-1 1,-2 0,2 0,-1 3,-1 1,0 2,0l1 -2c0,-1 0,-1 0,-2 0,-4 0,-8 -2,-13 -1,2 -3,4 -5,5 -1,1 -2,1 -2,1l-2 0c0,10 -5,-13 -6,-15 -1,0 -1,0 -3,1l0 -2 -1 0 -5 5c-3,-1 -4,-1 -8,-1 0,-2 0,-3 2,-4l-1 -1c-1,0 -1,0 -1,0 -3,-1 1,2 -1,-1 -1,-1 0,0 -1,-1l0 -1c-1,-2 -1,1 -1,-2 -1,-1 0,-1 -1,-3 -2,1 0,0 -2,2 -2,3 -2,6 -3,9 -2,-2 -1,-6 -1,-8 1,-4 0,0 -3,-7 -2,1 -2,1 -4,1 0,3 1,4 -1,5 -3,-2 0,-6 -4,-9l-2 -1c-2,-1 -2,-1 -3,-3 0,2 0,1 -1,2z"/>
  <path class="fil14" d="M1628 914l-1 7c10,1 18,1 28,-3 9,-3 16,-11 21,-17 -1,-2 -1,-1 -3,1 -1,2 -9,7 -11,8 -4,-2 -6,-1 -8,-3 0,-2 0,-2 1,-4l2 -4c1,-2 1,-1 2,-4l2 -2c1,-5 3,-11 9,-13 -3,0 -5,1 -8,2l-4 2c-3,-3 -4,0 -3,-6 0,-3 0,-5 1,-8 -2,3 -2,7 -4,9l-1 10c0,3 -2,8 -2,14 0,4 1,3 1,6 0,0 -8,5 -8,5l-1 -4 -2 -1c-2,-4 -4,-7 -5,-13 -1,-8 3,-1 -1,-13 -4,3 -2,11 -2,16 0,2 -1,13 -3,15z"/>
  <path class="fil3" d="M1566 1031c0,5 -1,9 0,15 1,-2 0,-2 1,-5 1,-3 2,-2 2,-5l3 -16c0,-2 1,-3 1,-5 1,-5 3,-5 1,-12l-11 -4 -7 15 -4 14c-1,3 -4,22 -3,24 1,2 0,1 1,1 2,2 0,0 2,-3 1,-1 6,-5 6,-5 3,-3 -1,1 3,-5 1,0 1,0 1,-1l2 -3c1,-2 0,-3 2,-5z"/>
  <path class="fil11" d="M1517 767l0 0c0,-3 1,-6 2,-8 1,0 0,-1 1,1 1,1 2,3 3,5l1 0c0,0 0,1 1,1 0,0 1,0 2,1 0,1 0,1 0,3l7 -5c1,-1 1,-1 2,-2 1,-1 0,-1 1,-1l2 -3c1,-2 0,-3 -1,-9 2,1 4,4 6,7l6 -2 1 5c6,-2 1,-1 4,-6l1 -1c0,-1 -1,-1 2,-2 0,2 0,6 0,8 2,-1 2,-2 2,-4 1,-1 2,-2 4,-3 1,1 0,2 2,2 0,1 0,0 1,1 -1,2 -2,7 -1,8 1,-1 3,-7 4,-8 1,-3 2,-1 4,-3 1,0 1,-2 3,-2l6 -7c-7,2 -7,0 -9,2 -2,2 -2,5 -5,6 1,-2 2,-3 2,-5 1,-3 0,-2 -2,-2 1,-3 1,-3 1,-5 -2,1 -2,1 -3,3 -3,6 -3,0 -5,5 0,1 0,2 -2,3 1,-2 1,-5 0,-8 0,0 -1,0 -1,0 -5,3 1,1 -5,2 0,5 0,7 -2,8l-1 -1 -1 3 -6 1c-3,-7 -13,-19 -20,-12 -3,3 -8,19 -7,24z"/>
  <path class="fil12" d="M1570 775c6,-1 17,1 22,2 4,1 8,2 11,3 2,1 9,4 10,4 3,-3 -1,-13 -3,-16l-1 -2 -1 -4c-2,1 -2,1 -3,1 -1,1 -1,1 -1,1 -6,5 -3,-1 -4,-5 -1,2 -1,3 -1,5l-8 -2c-1,0 -1,0 -2,-1 0,-5 1,-5 -1,-7 -3,2 -1,1 -3,3 0,0 0,0 0,0l-1 0c-3,-1 0,-1 -3,-1 0,0 -1,0 -1,0 0,1 -2,4 -5,5 -1,-3 0,-3 0,-5 0,0 -3,4 -3,5 0,2 2,5 3,7l-3 -5c-2,2 -3,9 -2,12z"/>
  <path class="fil14" d="M1402 821l3 10 2 5c0,0 0,0 0,0 0,0 -1,0 -1,0 0,0 -1,1 -1,1 2,0 6,-1 8,-1 11,0 3,-2 15,-12 -1,-3 -3,-8 -3,-11 -3,-6 -4,-16 -5,-22l-1 -2c-1,2 0,1 -3,1 -1,1 -1,1 -1,2 0,1 0,0 0,1l0 1c0,0 -1,0 -1,0l-1 -1c0,-1 0,-2 0,-2 -1,1 0,1 -2,2 -3,-2 -1,1 -3,-2 -2,5 3,22 4,29 -1,0 -2,0 -4,2 -4,2 -1,2 -1,5l-2 1c-1,-2 -2,-5 -3,-7z"/>
  <path class="fil14" d="M1423 761c11,-16 26,-2 30,10l2 -2c0,-3 0,-4 1,-6 0,-2 -2,0 0,-3 1,-18 6,-19 6,-23l-9 1c-3,-3 -4,-4 -11,-2 -4,1 -8,3 -11,6 -3,3 -5,9 -7,14 -1,5 -2,2 -1,5z"/>
  <path class="fil7" d="M1583 1070c3,9 2,22 2,31 5,-3 10,-10 13,-14 3,-5 5,-10 7,-16 -1,-9 -9,-21 -14,-20 -2,5 3,7 -6,14 -3,3 -2,1 -2,5z"/>
  <path class="fil3" d="M1608 754c-2,3 -1,4 0,8l1 4c1,-3 -2,-9 2,-12 0,0 1,0 1,0l8 3c2,2 2,2 3,4 3,0 -3,-1 1,-1 4,11 3,2 6,9 0,1 0,1 0,1l1 0c2,-1 1,0 2,-2l3 -1c0,0 0,1 0,1 1,1 1,0 1,1l3 -1c2,3 1,0 1,4 -1,5 2,2 2,2 1,-2 1,-4 2,-7 0,-2 0,-5 1,-7 0,-4 0,-8 -2,-11 -3,-9 -11,-9 -17,-4 -2,1 -3,2 -4,3 0,1 -1,2 -1,2 -1,1 -1,2 -2,3 -3,-2 -9,-3 -12,1z"/>
  <path class="fil2" d="M1558 825c-3,-7 -10,-8 -12,-15 2,-4 0,-2 5,-3 -1,-1 -1,-1 -2,-2 4,-1 7,-1 12,-2 -3,-11 9,-4 11,-4 -1,-3 1,-2 -1,-5 3,0 16,5 20,7l4 2c-7,-11 -37,-19 -48,-16 1,2 1,2 2,2 1,0 1,0 1,0 0,0 0,0 0,0 2,1 3,1 4,1 -1,1 0,1 -2,1 -2,0 -6,0 -13,1 2,4 3,5 4,9 -3,2 -1,3 0,4l-3 1c1,6 1,2 7,13 1,3 1,3 4,4 2,1 1,1 3,2 2,0 2,0 4,0z"/>
  <path class="fil3" d="M1680 845c-1,2 -2,6 -1,9l0 0c0,-4 2,-9 6,-11 4,12 1,23 -4,34 0,2 -1,3 -2,5 0,1 -1,1 -1,2 -2,3 0,1 -1,3l6 -11c3,-6 4,-11 6,-13 1,4 1,6 0,9l4 -10c1,-1 0,0 1,-2 1,8 -6,19 -6,22 -1,3 1,1 -1,4 -1,1 -2,2 -2,3 6,-2 11,-14 14,-19 2,-3 0,0 3,-1 1,-1 1,-2 3,-3 1,2 0,1 0,4 4,0 2,-2 5,1 -3,3 -5,6 -8,9 -2,3 -7,7 -9,10 3,-1 4,-3 6,-5 2,-2 6,-3 7,-5 2,-1 4,-5 6,-7 2,-3 3,-5 5,-7 -1,-1 0,1 -1,-1 1,-2 1,-1 1,-4 -1,1 -3,1 -4,2 0,0 -3,0 -4,1 -1,-3 1,-2 1,-5 -4,2 -1,3 -5,5 -2,-2 0,-1 -2,-1 0,2 -1,3 -4,4 0,-3 2,-1 0,-5 -1,-3 -2,-7 -2,-10 0,-3 0,-3 1,-4l-3 0c0,-3 -1,-2 -1,-4 -2,-1 -5,-3 -7,-3 -4,0 -6,2 -7,4z"/>
  <path class="fil14" d="M1553 833c4,0 7,3 10,6 3,-2 13,-4 16,-3 5,-2 14,0 19,0 -6,-7 -13,-19 -25,-21 -2,3 -6,11 -17,16l-3 2z"/>
  <path class="fil3" d="M1717 866c1,-3 4,-9 4,-13 0,-2 0,-4 -1,-6 -1,-3 -1,-1 -2,-4 -2,-3 -6,-4 -10,-3 -6,1 -8,3 -12,6l-2 -2c0,2 1,1 1,4l3 0c-1,1 -1,1 -1,4 0,3 1,7 2,10 2,4 0,2 0,5 3,-1 4,-2 4,-4 2,0 0,-1 2,1 4,-2 1,-3 5,-5 0,3 -2,2 -1,5 1,-1 4,-1 4,-1 1,-1 3,-1 4,-2 0,3 0,2 -1,4 1,2 0,0 1,1z"/>
  <path class="fil10" d="M1569 863c0,2 0,1 2,0l9 -3 -6 1c13,-7 12,-3 12,-12 1,-3 1,-3 2,-6 0,0 0,4 1,-1 1,-1 1,-3 1,-5 -2,0 -3,0 -6,0 -2,0 -3,0 -6,0l1 -1c-3,-1 -13,1 -16,3 7,9 5,13 6,24z"/>
  <path class="fil11" d="M1609 766l1 2c1,-1 1,0 1,-2 1,2 1,2 3,3l2 1c4,3 1,7 4,9 2,-1 1,-2 1,-5 2,0 2,0 4,-1 3,7 4,3 3,7 0,2 -1,6 1,8 1,-3 1,-6 3,-9 2,-2 0,-1 2,-2 1,2 0,2 1,3 0,3 0,0 1,2l0 1c1,1 0,0 1,1 2,3 -2,0 1,1 0,0 0,0 1,0l1 1c0,-2 0,-2 1,-3 0,-1 0,-2 0,-3 1,-2 2,-4 2,-6 0,0 -3,3 -2,-2 0,-4 1,-1 -1,-4l-3 1c0,-1 0,0 -1,-1 0,0 0,-1 0,-1l-3 1c-1,2 0,1 -2,2l-1 0c0,0 0,0 0,-1 -3,-7 -2,2 -6,-9 -4,0 2,1 -1,1 -1,-2 -1,-2 -3,-4l-8 -3c0,0 -1,0 -1,0 -4,3 -1,9 -2,12z"/>
  <path class="fil3" d="M1718 772c-2,-2 -6,-4 -9,-4 0,1 -2,-1 -7,3 -2,2 -3,4 -4,5 1,2 -3,-1 1,1 0,0 2,0 0,0l4 12 4 2 0 5 5 0c5,-1 3,-2 6,0 0,0 0,0 0,0 1,-4 2,-14 1,-19 0,-3 -1,-5 -1,-5z"/>
  <path class="fil10" d="M1458 811c0,5 0,8 0,13 3,-1 3,-1 3,-4l2 1c1,0 0,0 1,-1 0,0 0,1 0,0 1,-3 1,-2 3,-4 1,-1 1,-1 3,-1 4,13 -3,28 -1,32l3 -14c1,-4 4,-10 5,-13 -1,-3 1,-7 3,-9 2,-5 2,-3 -1,-10 -2,0 -2,0 -4,0 -3,0 -8,2 -11,3 -1,-1 -1,-2 -2,-3 -1,-2 0,0 -1,-1 -1,2 -1,2 -2,5 -1,3 0,4 -1,6z"/>
  <path class="fil3" d="M1489 721c-2,0 -3,0 -5,1 -2,0 -4,1 -5,1 -1,2 -1,1 -1,3 -2,4 -3,8 -2,13 1,8 3,7 5,9l4 -2c1,1 0,1 2,2 3,0 4,-4 4,-5 3,-3 2,-4 4,-7 2,0 1,0 2,1 -1,-5 -1,-10 -7,-13l-4 -2 3 -1z"/>
  <path class="fil3" d="M1406 958c-2,0 0,0 -1,1 2,1 1,0 2,2 1,-1 0,0 0,0 -1,6 16,-3 19,-4 2,-1 0,1 3,-1 5,-3 1,-4 4,-7 0,0 0,-1 0,-1l-2 -1c1,1 1,1 2,-2 0,0 1,1 0,-2 -1,-5 -6,-1 -8,0 -10,4 -15,7 -24,14 -1,1 -6,4 -1,4 1,0 4,-2 6,-3z"/>
  <path class="fil3" d="M1704 975c1,5 1,4 7,7 2,2 13,8 15,8 7,1 17,-3 6,-12 -3,-4 -4,-3 -8,-4 -4,-1 -9,-2 -14,-1 -4,1 -3,1 -6,2z"/>
  <path class="fil5" d="M1582 751c-1,1 -1,1 -2,2 0,0 0,1 0,1 -1,2 0,-1 0,2 0,0 1,0 1,0 3,0 0,0 3,1l1 0c0,0 0,0 0,0 2,-2 0,-1 3,-3 2,2 1,2 1,7 1,1 1,1 2,1l8 2c0,-2 0,-3 1,-5 1,4 -2,10 4,5 0,0 0,0 1,-1 1,0 1,0 3,-1 -1,-4 -2,-5 0,-8 -5,1 -6,-3 -6,-6 -2,1 -2,1 -3,-1 -2,-2 1,3 0,-1 -1,-1 -2,-1 -5,-2 0,0 0,0 0,0l-3 -1c-2,-1 -2,-1 -4,-1 -1,1 -1,0 -2,2 0,1 -1,1 -1,2 -1,2 -2,3 -2,5z"/>
  <path class="fil10" d="M1646 760c-1,2 -1,5 -1,7 -1,3 -1,5 -2,7 0,2 -1,4 -2,6 0,1 0,2 0,3 -1,1 -1,1 -1,3 -2,1 -2,2 -2,4 4,0 5,0 8,1l5 -5c-1,-3 0,0 0,-2l1 -2c1,-3 1,0 1,-5 0,-2 -1,0 0,-2 1,-1 1,-2 2,-2 1,-2 2,-3 3,-4 3,-3 12,-12 16,-13 0,0 -3,1 -4,2 -3,1 -3,1 -5,3 -3,2 -7,5 -10,6l-3 -10c-1,1 -1,1 -2,2 -3,1 -2,0 -4,1z"/>
  <path class="fil9" d="M1338 1359c1,-6 -2,2 -5,-9 -1,-2 -2,-5 -3,-7 -1,-2 -2,-2 -3,-5l6 1c-2,-1 -4,-1 -6,-2 -4,-1 -9,-7 -14,-10 0,0 0,0 0,0 -4,-3 -7,-4 -12,-6l-6 -1c-1,-1 -3,-3 -4,-5l-3 1c6,9 16,19 23,26 6,6 20,16 27,17z"/>
  <path class="fil12" d="M1656 868l0 2c-1,3 -1,5 -1,8 -1,6 0,3 3,6l4 -2c2,-2 2,-1 5,-2 0,0 0,1 -1,-1 0,-3 1,-4 2,-6 2,-6 -1,-4 1,-9 1,-4 0,-3 0,-7 0,-3 1,-3 0,-8 -2,1 -2,1 -3,3 -1,3 0,-1 -6,5 -1,1 0,1 -1,2 -2,2 -3,8 -3,9z"/>
  <path class="fil12" d="M1458 824c1,7 6,30 10,35l1 -2c0,-1 0,-1 0,-2 -1,-2 1,-5 0,-8 -2,-4 5,-19 1,-32 -2,0 -2,0 -3,1 -2,2 -2,1 -3,4 0,1 0,0 0,0 -1,1 0,1 -1,1l-2 -1c0,3 0,3 -3,4z"/>
  <path class="fil3" d="M1357 863c-1,1 -1,0 -1,2 -1,1 -1,0 -1,2l1 2c0,1 1,2 2,3l2 4c2,2 3,3 5,4l4 2c1,0 -1,1 2,0 1,0 2,-1 3,-1 0,-1 0,-2 0,-3 -1,-4 -4,-2 0,-2l1 0c-2,-6 -2,-10 -8,-14 -5,-4 -8,2 -10,1z"/>
  <path class="fil18" d="M1877 1215c2,2 1,0 2,2 -4,0 -12,1 -15,2 -4,0 0,0 -4,4 -8,6 -3,2 -9,4l-10 3c-6,3 -6,2 -12,3l16 5c-5,1 -20,-3 -26,-3 -8,-1 -16,0 -25,-3 -1,-6 1,-4 -5,-4 -4,0 -3,-1 -3,-1 -2,1 -3,1 -5,1 -3,1 -10,3 -13,5 -1,0 -1,1 -2,1 1,2 2,0 -4,3 -4,2 -11,6 -14,10 7,0 34,5 42,6 2,1 11,3 13,3 -9,-2 -19,-3 -28,-4 -21,-2 -13,0 -21,7l-4 5c-6,9 -3,2 -7,7 -2,1 -2,3 -4,5l-5 3c-5,5 -3,1 -8,7 -3,5 -3,0 -8,8 -2,3 0,0 -3,3 0,0 0,0 -1,0 -8,9 -7,5 -13,9 0,0 0,1 -1,1 -4,3 1,1 -6,5 -3,2 -1,2 -5,4 0,0 0,1 0,1 0,0 0,0 0,0 -1,0 -1,0 -1,0 -5,3 -1,-1 -11,3 -9,4 -7,1 -10,5 -3,3 -5,6 -8,9 -2,3 -6,10 -6,8 -3,2 -2,6 -4,4l0 3c12,0 26,-2 38,-4l37 -8c-2,2 -2,1 -5,3 -34,15 -43,8 -58,17 -6,3 -11,7 -18,11 -34,24 -38,24 -78,35 -28,9 -55,18 -86,22 -20,2 -60,2 -77,14 -17,12 4,1 6,-1 6,0 17,-5 26,-6 18,-2 37,-1 56,-4 29,-4 73,-17 101,-27 26,-8 32,-11 56,-30 8,-6 12,-9 21,-14 9,-5 31,-1 60,-22 21,-14 22,-14 40,-33 15,-16 22,-24 40,-34 6,-3 15,-5 25,-7 9,-1 17,-4 25,-6 4,-2 8,-3 12,-5 2,-1 3,-2 5,-3l33 -19c11,-6 17,-9 29,-14 3,-2 10,-4 12,-6 -10,0 -24,4 -36,5 -6,1 -12,1 -18,2 -6,0 -13,-2 -18,0z"/>
  <path class="fil7" d="M1704 1231c1,0 1,0 1,2 1,2 -1,7 -2,9 -9,15 -18,12 -24,20l-8 -2c-5,7 -16,43 -17,53l3 -9 -8 42c2,2 1,-2 4,-4 4,-9 17,-26 24,-34 9,-11 18,-20 28,-28 10,-9 19,-16 30,-24 5,-4 9,-8 14,-12 5,-4 12,-8 17,-10 1,0 1,-1 2,-1 3,-2 10,-4 13,-5 2,0 3,0 5,-1 3,0 17,-4 22,-5 6,-2 15,-3 22,-4 15,-1 30,-2 47,-3 5,-2 12,0 18,0 6,-1 12,-1 18,-2 12,-1 26,-5 36,-5 2,1 3,0 5,-1 2,0 4,0 6,-1 -1,-2 -4,-1 -8,-1 -3,0 -6,0 -9,0l-55 -3c-11,0 -22,4 -35,1 -14,-4 -21,-13 -33,-18 -33,-12 -46,10 -60,19 -12,8 -55,25 -56,27z"/>
  <path class="fil7" d="M1539 1306c-3,3 -6,9 -8,11 0,3 0,15 0,16 7,-8 18,-31 36,-39 17,-6 30,-11 45,-23 24,-19 19,-31 34,-44 5,-4 9,-6 14,-10 12,-13 11,-45 32,-80 4,-5 21,-29 22,-31 0,-2 0,-1 0,-2 -4,5 -8,9 -12,12 -8,6 -28,29 -34,36 -11,17 -31,42 -44,57 -1,1 -2,1 -3,2l-18 18c-28,27 -41,39 -64,77z"/>
  <path class="fil7" d="M1448 1239c1,3 0,7 2,9l2 -7c1,3 2,6 2,10 2,8 6,19 9,29 13,48 23,34 34,69 4,12 6,27 5,42 1,-1 1,0 2,-4l6 -35c1,-12 2,-24 0,-35 -2,-19 -6,-22 -10,-38 -4,-12 -9,-23 -12,-37 -6,-25 -6,-24 -7,-49 -2,-29 1,-31 10,-57 1,-3 6,-16 6,-18l-16 26c-11,20 -18,40 -24,63 -2,6 -3,10 -4,16 -1,6 -3,10 -5,16z"/>
  <path class="fil18" d="M1497 1118c0,2 -5,15 -6,18 -9,26 -12,28 -10,57 1,25 1,24 7,49 3,14 8,25 12,37 4,16 8,19 10,38 2,11 1,23 0,35l-6 35c-1,4 -1,3 -2,4 0,1 -1,14 -4,13 1,1 1,1 1,2l-2 6c2,-2 7,-9 9,-10 4,-11 9,-22 14,-33 2,-5 4,-11 6,-17 2,-5 3,-15 5,-19 0,-1 0,-13 0,-16 0,0 0,-4 0,-4 -1,-4 0,-2 0,-6 -3,0 -2,-2 -4,-9 -1,-3 -2,-6 -2,-9 -5,-23 -4,-51 -11,-64 -10,-18 -21,-17 -21,-57 0,-14 5,-20 3,-31 1,-4 1,-7 2,-11 0,-2 0,-3 1,-5l0 -4c0,0 0,-1 0,-1 0,0 0,0 0,0 0,-1 0,-1 0,-1l-2 3z"/>
  <path class="fil9" d="M1534 1298c1,-1 0,0 2,-2 1,-1 2,-3 2,-5 2,-4 3,-8 4,-12 5,-24 4,-37 17,-60l0 3c6,1 5,0 8,-1l7 -3c0,0 0,0 0,0l6 -4c4,-2 1,0 4,-2 1,-2 1,-2 3,-3 4,8 2,20 0,29 -2,7 -3,8 -8,12 -13,14 -24,25 -34,42 -1,1 -7,9 -7,11 0,2 0,1 1,3 23,-38 36,-50 64,-77l18 -18c1,-1 2,-1 3,-2 13,-15 33,-40 44,-57 6,-7 26,-30 34,-36 4,-3 8,-7 12,-12 0,1 0,0 0,2 2,-2 3,-4 5,-7 -3,1 -10,8 -13,11 -5,4 -9,6 -14,9 -5,3 -8,5 -14,8l-15 8c-64,28 -44,19 -95,67 -4,4 -8,8 -12,13 -8,11 -11,26 -14,40 -2,15 -3,27 -8,43z"/>
  <path class="fil19" d="M1654 1313c-5,32 -32,60 -61,71l-20 9c-15,5 -29,9 -44,13 -9,2 -15,4 -23,-4 -2,1 -7,8 -9,10l2 -6c0,-1 0,-1 -1,-2 -8,14 -25,16 -43,17 -16,1 -38,-1 -55,-7l-6 33c0,0 0,-1 0,-1l2 -1c2,-3 2,-3 6,-6 17,-12 57,-12 77,-14 31,-4 58,-13 86,-22 40,-11 44,-11 78,-35 7,-4 12,-8 18,-11 15,-9 24,-2 58,-17 3,-2 3,-1 5,-3l-37 8c-12,2 -26,4 -38,4l0 -3 8 -42 -3 9z"/>
  <path class="fil8" d="M1534 1298l-3 9c0,4 -1,2 0,6 0,0 0,4 0,4 2,-2 5,-8 8,-11 -1,-2 -1,-1 -1,-3 0,-2 6,-10 7,-11 10,-17 21,-28 34,-42 5,-4 6,-5 8,-12 2,-9 4,-21 0,-29 -2,1 -2,1 -3,3 -3,2 0,0 -4,2l-6 4c0,0 0,0 0,0l-7 3c-3,1 -2,2 -8,1l0 -3c-13,23 -12,36 -17,60 -1,4 -2,8 -4,12 0,2 -1,4 -2,5 -2,2 -1,1 -2,2z"/>
  <path class="fil16" d="M1653 1342c0,2 4,-5 6,-8 3,-3 5,-6 8,-9 3,-4 1,-1 10,-5 10,-4 6,0 11,-3 0,0 0,0 0,0 1,0 1,0 1,0 0,0 0,-1 0,-1 4,-2 2,-2 5,-4 7,-4 2,-2 6,-5 1,0 1,-1 1,-1 6,-4 5,0 13,-9 1,0 1,0 1,0 3,-3 1,0 3,-3 5,-8 5,-3 8,-8 5,-6 3,-2 8,-7l5 -3c2,-2 2,-4 4,-5 4,-5 1,2 7,-7l4 -5c8,-7 0,-9 21,-7 9,1 19,2 28,4 -2,0 -11,-2 -13,-3 -8,-1 -35,-6 -42,-6 3,-4 10,-8 14,-10 6,-3 5,-1 4,-3 -5,2 -12,6 -17,10 -5,4 -9,8 -14,12 -11,8 -20,15 -30,24 -10,8 -19,17 -28,28 -7,8 -20,25 -24,34z"/>
  <path class="fil16" d="M1786 1227c0,0 -1,1 3,1 6,0 4,-2 5,4 9,3 17,2 25,3 6,0 21,4 26,3l-16 -5c6,-1 6,0 12,-3l10 -3c6,-2 1,2 9,-4 4,-4 0,-4 4,-4 3,-1 11,-2 15,-2 -1,-2 0,0 -2,-2 -17,1 -32,2 -47,3 -7,1 -16,2 -22,4 -5,1 -19,5 -22,5z"/>
  <path class="fil9" d="M1474 1302c3,-5 4,-15 4,-19l-1 -6c-1,-7 -5,-19 -6,-21 4,2 5,6 9,9 -1,-2 -9,-12 -11,-15 -5,-7 -3,-8 -8,-11 -2,-1 -2,-1 -5,-2 -1,10 4,32 7,42 0,2 1,3 1,4 2,4 7,17 10,19z"/>
  <path class="fil9" d="M1671 1260l8 2c6,-8 15,-5 24,-20 1,-2 3,-7 2,-9 0,-2 0,-2 -1,-2 -5,0 -15,7 -19,10 -5,5 -11,11 -14,19z"/>
  <path class="fil4" d="M1698 889c0,4 0,8 2,11 1,1 1,0 2,2 1,1 2,4 7,2 0,2 1,2 -1,3 2,-1 5,-8 5,-10 4,-8 1,-4 0,-12l-2 -1c-9,-3 -8,2 -13,5z"/>
  <path class="fil15" d="M1483 1057l3 6c1,-4 0,-12 2,-16 1,-8 7,-10 5,-16 -3,-12 -7,-2 -9,0 -1,2 -2,4 -4,7 -2,3 -1,4 0,9 1,3 2,7 3,10z"/>
  <path class="fil3" d="M1661 904c0,1 1,1 2,2l6 -4c3,-3 4,-1 6,-9 1,-7 -2,-17 -7,-9 -2,2 -1,-1 -2,1l-4 14c-1,4 -1,1 -1,5z"/>
  <path class="fil6" d="M1448 856c8,11 8,13 17,18 1,0 2,0 2,1 2,0 1,0 2,1 4,1 7,2 9,3 1,-1 2,0 0,-3 -2,-2 0,1 -2,-1l-3 -5c-1,0 -2,-1 -2,-1 -1,-1 -4,-3 -5,-2 0,0 0,1 0,0 -2,-1 -4,-3 -6,-5 -5,-3 -3,-6 -6,-6l-1 0c-5,0 2,0 -2,0 0,0 -1,-1 -1,-1 0,0 -1,0 -1,-1 -1,2 -1,0 -1,2z"/>
  <path class="fil7" d="M1415 998c2,6 1,16 3,22 0,-2 3,-7 4,-9 1,-1 1,-2 2,-4 2,-4 4,-18 -2,-14 0,0 -1,1 -2,2 -2,2 -4,2 -5,3z"/>
  <path class="fil4" d="M1604 934c5,1 1,0 2,0l0 1c0,0 0,0 0,0l1 1c5,-2 6,-4 9,-7 0,-3 -1,-5 -3,-6 -1,-1 -4,-2 -6,0 -2,1 -1,-1 -3,5 -1,1 -1,0 -1,3 0,1 0,1 1,3z"/>
  <path class="fil4" d="M1570 938c2,0 2,0 4,-4l1 -4c-3,-9 -9,-6 -11,-3 -1,1 -1,3 1,7 0,1 1,3 2,3 0,0 1,1 1,1 1,0 1,0 2,0z"/>
  <path class="fil4" d="M1506 1033c2,0 2,0 3,-1 0,0 1,-2 2,-3l1 -2c4,-10 1,-16 0,-15 -2,1 -5,8 -6,10 0,2 -4,13 0,11z"/>
  <path class="fil8" d="M1444 1183c-1,3 -4,13 -5,17 -1,6 -2,11 -3,17 -1,-2 9,-16 12,-19 3,-4 -1,-1 3,-6l5 -13c4,-6 0,-2 4,-12 1,-1 0,0 0,-1 1,-5 0,-2 2,-8 2,-5 3,-5 2,-9 -3,2 -4,5 -6,7 -3,6 -3,14 -14,27z"/>
  <path class="fil20 str0" d="M663 1618c13,-44 26,-89 37,-140 11,-51 19,-108 35,-217 17,-109 41,-268 59,-361 18,-94 30,-121 48,-146 19,-25 44,-48 64,-63 21,-15 37,-21 83,-25 46,-4 124,-4 247,-4 124,0 295,2 466,4 -27,14 -54,28 -77,43 -23,15 -43,31 -58,53 -16,22 -27,51 -38,93 -11,42 -22,98 -36,194 -14,96 -31,232 -44,330 -13,98 -22,158 -38,208 -16,50 -40,91 -69,119 -30,29 -66,46 -95,53 -29,8 -50,6 -71,-1 -22,-7 -43,-19 -50,-44 -6,-24 2,-61 11,-98 -110,0 -219,1 -298,2 -79,0 -127,0 -176,0z"/>
  <path class="fil2" d="M1287 510c0,4 -3,9 -4,14 15,12 5,14 18,14 3,0 8,1 10,1 16,6 10,13 2,25 -10,13 -18,14 -21,22 8,-1 16,-14 33,-22 13,-6 9,7 19,5 3,0 6,-2 9,-3 2,-1 3,-1 5,-2 3,-1 2,-1 4,-1l0 1c5,1 7,4 8,7 -3,0 -7,-7 -14,-2 -6,5 -6,9 -9,18l2 -1c4,0 1,-2 0,3 -1,1 -1,3 -1,4 1,0 3,1 4,1 3,0 1,0 3,-1l4 -2c3,-1 4,-3 6,-5l3 -5c1,-1 2,-2 2,-4l1 -2c4,3 7,21 -1,33 -7,12 -13,17 -22,25 10,6 29,20 23,34 -3,4 -4,11 -7,17 -6,11 -18,25 -26,35 -3,4 -6,9 -9,12 -4,3 -5,5 -13,2 -12,-4 -10,-1 -16,-2 -7,-1 -7,-7 -14,-7 -3,6 -2,13 -1,18 3,12 15,20 5,25 -4,2 -10,2 -15,3 -19,1 -16,4 -25,15 -5,6 -11,14 -19,8 -1,-1 -1,-2 -2,-3 -1,0 -1,-1 -2,-1 -1,-1 1,0 0,0 0,2 5,5 7,6 4,1 7,0 9,-3 3,-6 2,-17 1,-22l-7 -12c-2,-2 -2,-2 -6,-4 0,3 0,1 0,3 1,3 1,1 1,1 0,-1 -1,-2 -2,-4 -3,-5 -3,-4 -5,-4 -4,0 -1,-2 -4,0 -3,3 -3,10 -5,14l2 0c-1,3 -1,8 0,10 0,-3 -5,-10 -11,-10 -6,2 -7,16 -8,22 -2,13 1,14 -5,22 -1,4 -5,7 -7,9 -2,2 -8,5 -9,6 -3,0 -4,1 -6,2 -2,1 -4,1 -6,1 -4,1 -10,2 -13,3 -1,0 0,0 -1,1 1,3 1,7 2,11l-17 -3c-5,-1 -15,-6 -18,-6 -5,1 -10,3 -16,0 -4,-3 -5,-9 -6,-13 -1,1 0,-1 -1,2 -1,-4 0,-2 -3,-6 -11,-9 -4,-11 -7,-17 -6,-1 -17,14 -17,24l0 1c-1,0 -1,0 -1,0l-1 3c-1,1 -2,2 -3,3 -7,3 -18,-8 -22,-12 -13,-11 -21,-3 -34,-4l-3 7c-2,3 0,1 -3,2l-1 -9c0,-3 1,0 -1,-3 -4,-3 -4,-6 -4,-11 1,-10 8,-22 7,-31 -12,-4 -32,23 -38,20 -3,-2 -2,-8 -7,-15 -3,-4 -9,-9 -16,-10 -9,0 -17,10 -29,-12 -5,-8 -8,-20 -9,-31 -1,-7 1,-12 6,-17 3,-3 11,-8 13,-8 2,-1 1,-1 3,-1 14,-1 23,-4 36,-9 4,-1 3,-1 4,-3l8 5c2,2 4,5 5,1 -9,-6 -19,-15 -26,-23 -3,-3 -5,-7 -8,-9 3,-8 5,-3 -2,-14 -1,-2 -2,-5 -3,-7 -2,-6 -2,-4 -2,-8 3,2 1,1 3,3 3,3 3,1 7,3 1,-4 0,-3 2,-7 3,-5 3,-3 2,-6 1,0 1,0 1,0 4,-1 2,-1 5,-4 3,1 6,4 7,6l2 9c-2,-2 0,-1 -2,-3 -1,-2 -2,-1 -3,-3 -1,1 -2,2 -2,2l-3 2c1,5 2,3 3,10 0,2 0,4 1,6 2,7 6,10 10,16 1,2 2,2 2,4 0,-1 -1,-1 -1,-1 -1,0 0,0 -1,0 0,0 0,0 0,0 5,6 10,11 15,17 -4,-2 -8,-6 -11,-8 0,3 -1,1 1,3 2,3 5,5 8,7 9,7 6,9 23,17 3,1 5,2 7,3l2 3c0,2 0,0 -1,2 2,1 2,2 4,3 1,1 3,1 5,2 7,3 8,7 16,10 8,3 6,1 7,5 3,0 1,-1 7,1 3,1 6,2 7,2 4,1 9,4 14,6l2 -2c3,1 5,1 8,2 3,0 4,0 6,-2 2,2 1,1 3,3 11,-5 5,-6 18,-6 1,0 4,-1 5,-1 2,0 2,2 3,3 4,4 7,-1 7,-1l7 1c1,0 2,-1 4,-1 0,0 0,0 0,0 9,0 8,0 13,7 1,2 3,4 5,5l7 0c3,-5 2,-4 4,-10 0,-1 0,-2 1,-2 1,0 1,0 1,0 4,1 -3,-2 1,0 2,2 11,14 13,18 2,3 4,5 6,9 2,4 3,9 5,11 2,-5 0,-4 1,-8 0,-4 0,-2 0,-5l-2 -6c-1,-3 -1,-5 -3,-7 -3,-3 -4,-9 -6,-13 0,-1 -1,-1 -2,-3l-1 -3c-2,-4 -2,-8 -1,-12 -1,1 -1,1 -2,2l-3 -1c2,-2 1,-1 4,-3 15,-10 17,-19 21,-22l-1 4c2,0 7,-2 9,-3 2,-3 -1,0 1,-1l6 -4c1,-1 1,-1 1,-1 5,-1 0,1 2,0 1,-1 1,-1 2,-1 3,-3 2,-1 5,-3l6 -3c1,-1 1,-1 2,-2l3 -2c2,-1 -2,0 2,-1 0,0 0,0 0,0 5,-1 3,-2 6,-3 0,0 0,0 0,0l0 -2c0,-2 -1,1 0,-1 1,-3 2,-2 0,-3 2,0 3,-1 5,-3 3,-2 0,-1 2,-2 1,0 23,0 44,-5 3,-1 6,-2 8,-3 7,-2 10,-1 7,-11 6,-2 13,-5 17,-10 -3,0 -6,1 -8,3 0,-3 -1,-4 -3,-6l-17 6c-3,1 -4,2 -6,0 2,-1 5,-2 6,-3 1,-2 0,-5 0,-7 6,-2 19,-10 25,-14 3,-3 6,-3 7,-8 -2,0 -1,0 -2,1l-21 12c-2,-3 -2,-2 -1,-4 -4,-1 -5,1 -8,2l-21 10c4,-9 7,-8 11,-11l-1 -3c-1,-3 1,-5 3,-8 2,-3 3,-9 5,-13 -2,0 -2,0 -3,0 0,0 0,1 -1,0 -3,-2 3,-7 4,-8 0,0 0,-1 0,-1l-3 -4c-2,-2 0,-2 -3,-4 -1,1 -1,1 -2,2 -1,1 0,1 -1,1 1,-5 2,-4 0,-8l0 -2c-1,-3 1,-2 -3,-4l-2 6c-1,-4 1,-12 -1,-20 -1,-2 -1,-4 -5,-5 -6,-4 -8,2 -11,10 -1,3 -5,11 -7,13 1,-3 1,-1 0,-3 0,0 -1,1 -2,1 0,0 -1,1 -1,1 -4,0 4,0 -2,0l-1 0c-4,0 -2,3 -7,7 -3,2 -5,5 -8,6 0,2 0,0 0,0 -2,-1 -5,1 -6,2 -1,1 -1,2 -2,3l-4 5c-2,2 0,-1 -2,2 -3,4 -2,2 -1,3l-11 2c-2,1 -1,0 -4,1 1,-2 1,-1 2,-3l5 -5c0,0 0,1 0,1 1,1 0,1 0,1 1,0 1,-1 2,-1 0,0 0,0 0,0 0,0 0,-1 0,-1 0,0 1,0 1,0 1,-1 1,-1 3,-3l5 -5c8,-8 6,-12 8,-16 1,1 1,1 1,2l0 3c6,-6 11,-34 12,-43 1,-6 0,-10 0,-15l3 2c0,4 3,7 0,25 -1,4 -1,4 1,6 1,3 1,-2 0,2 1,1 0,3 -1,5l-1 6c5,-14 10,-30 10,-46l3 1c2,-6 0,-4 2,-9 2,1 2,0 2,4l0 15c-1,2 -1,4 -1,6l2 5c0,0 0,0 0,0l-1 10c5,-15 9,-34 9,-50 0,-1 0,-3 0,-4 1,-2 2,-1 3,-3 1,-1 0,-2 1,-3 1,-4 -1,0 2,-3l1 5c1,0 1,0 2,0 2,-2 3,-3 5,-3 2,4 -5,27 -7,33 6,1 3,2 6,-2z"/>
  <path class="fil3" d="M1224 518c0,4 4,12 6,17l4 17c-1,3 0,6 -1,9 -2,4 0,8 -8,16l-5 5c-2,2 -2,2 -3,3 0,0 -1,0 -1,0 0,0 0,1 0,1 0,0 0,0 0,0 -1,0 -1,1 -2,1 0,0 1,0 0,-1 0,0 0,-1 0,-1l-5 5c-1,2 -1,1 -2,3 3,-1 2,0 4,-1l11 -2c3,-2 7,-2 11,-4 1,-1 1,-1 2,-1 1,-1 2,-1 3,-1 11,-6 12,-8 20,-21 2,-2 6,-10 7,-13 3,-8 5,-14 11,-10 4,1 4,3 5,5 2,8 0,16 1,20 0,8 -1,22 -4,30 -4,12 1,4 -7,16 -5,9 -2,8 -14,25 -3,-1 -3,-1 -4,-3 -1,-3 0,-6 1,-9 2,-12 3,-6 4,-12 1,-3 1,-6 2,-9 0,0 -2,3 -3,6 0,0 0,0 0,0l-1 -2c0,-3 2,-6 0,-8 -3,6 -5,11 -8,16 -3,7 -5,12 -11,12 3,-8 5,-9 10,-25 -7,4 -6,16 -17,22l-12 6c0,0 0,1 0,1 -2,-2 -2,-2 -2,-4 -3,8 -9,16 -13,22 -2,3 -2,3 -5,3 -6,1 -9,3 -14,7 2,-3 0,-2 0,-2 -2,2 -4,2 -6,4 0,-3 2,-3 2,-5 0,-2 0,-1 0,-2 -3,1 -2,1 -4,4 -7,11 -9,8 -12,10l-2 1 0 -3c-3,-1 -5,-2 -8,-3l-4 -2c-1,-1 0,0 -1,-1 -3,-1 -3,1 -6,1 -2,-1 -5,-1 -7,-2 7,5 1,17 7,23 3,3 9,3 13,2l4 -1c6,-2 7,-3 12,-6 2,-2 1,0 4,-3 6,-4 8,-4 14,-10l5 -3c6,-2 5,-4 9,-3 2,0 2,0 4,1 1,5 0,15 -3,20l-5 11c-4,3 -6,12 -21,22 -3,2 -2,1 -4,3 -2,3 -17,9 -22,9 -13,2 -13,-8 -27,-6 0,-2 -3,-4 -4,-6 -9,-9 -10,-13 -14,-17 -3,-4 -10,-2 -14,-6 -3,-3 -7,-8 -11,-10 -1,2 -1,2 2,5 2,4 7,10 11,12 -1,0 -3,-1 -3,-1 0,0 -3,-1 -4,-1 0,2 2,5 3,5 -5,-2 -7,-7 -13,-7 0,0 0,0 -1,0 -3,0 -5,-1 -8,-2 -8,-1 -13,-10 -20,-14 0,3 0,2 3,6 0,1 3,6 2,4 -1,0 -2,0 -4,0 -1,0 -1,0 -1,0 -13,1 -18,-16 -27,-14 -1,0 -1,0 -1,0l2 3c1,1 2,2 3,3 2,1 4,3 6,5 6,4 36,26 40,26 -13,-4 -34,-17 -45,-25 -3,-3 -3,-3 -7,-4 -6,-1 -3,-1 -8,-4 -1,4 -1,4 1,6l4 4c3,4 0,3 2,6 1,1 1,1 2,1 -1,3 -2,4 -1,6 -5,0 -22,-15 -25,-18 -5,-6 -11,-14 -16,-21 -1,-2 0,-2 -2,-3 -3,-5 -10,-20 -11,-26l-2 -9c-1,-2 -4,-5 -7,-6 -3,3 -1,3 -5,4 0,0 0,0 -1,0 1,3 1,1 -2,6 -2,4 -1,3 -2,7 -4,-2 -4,0 -7,-3 -2,-2 0,-1 -3,-3 0,4 0,2 2,8 1,2 2,5 3,7 7,11 5,6 2,14 3,2 5,6 8,9 7,8 17,17 26,23 -1,4 -3,1 -5,-1l-8 -5c-4,-2 -14,-12 -16,-15 -3,-3 -5,-6 -7,-9 -2,-2 -5,-8 -6,-9 -1,-6 -19,-30 -2,-49l2 -2c0,0 1,0 1,0 0,0 0,0 0,0 -2,9 -5,4 0,14 1,2 4,11 6,12 -2,-1 -1,-1 -1,-3 6,2 7,-1 8,-3 1,-3 2,-2 3,-3 2,-3 2,-8 2,-12l4 3c5,-4 1,-4 13,1 5,3 8,8 10,10 6,7 15,17 25,20 12,5 22,5 34,3l-1 -8c1,0 0,1 1,0 -1,-2 -1,-5 -1,-8 -1,-2 -2,-4 -1,-7 1,3 4,2 7,4 1,2 1,3 6,6 1,1 5,7 6,8 4,5 2,5 10,6 10,2 17,5 26,4 15,-1 24,-7 29,8 3,6 0,9 4,10 2,-3 2,-3 3,-6l1 1c2,-7 -4,-15 0,-19 3,-2 7,5 9,-1 1,-2 0,-2 1,-3l3 -3c0,1 0,1 1,2 1,3 -1,1 1,2 5,5 6,2 10,2 1,-3 3,-6 2,-9 0,0 0,0 0,0 0,0 0,0 0,0 0,-2 1,-5 1,-7l-7 -6c10,2 27,-8 35,-13 -4,4 -9,6 -6,12l1 0c2,3 0,3 3,7 2,2 0,1 4,2l3 -5 1 4c4,-1 8,-7 9,-12 3,-8 -2,-17 -16,-9 -2,1 -4,1 -6,3 -5,3 -12,6 -18,8 -5,0 -9,1 -14,2 -16,2 -9,16 -10,23 -10,-3 -6,-1 -10,-7l-5 -13c-5,-14 -10,-37 -9,-52l4 -2c2,2 1,2 3,4 2,1 2,1 3,1l2 2c0,-2 0,-2 1,-4l1 5c5,1 9,-2 12,-6 3,-4 2,-17 4,-24l2 17 7 -2c1,-1 0,-1 2,-1l-1 -4c3,2 2,2 4,0 4,-2 1,0 6,-2l5 -2c1,-3 -1,-6 -2,-9 -1,-2 -2,-6 -3,-7 4,4 10,14 12,20 1,3 0,2 3,5 2,2 2,3 4,6 2,2 7,4 10,4 1,-7 -2,-14 -4,-20 1,1 0,1 2,2 5,3 5,-2 8,-4l5 -1c3,-1 5,-3 9,-2 0,3 2,14 3,16l2 4c2,2 2,4 5,6 1,-2 1,-3 3,-4 4,-3 5,-4 4,-10 -1,-5 -1,-10 -3,-15 0,-4 -2,-7 -4,-10l-1 -3c-1,-4 -4,-10 -3,-14 2,1 1,1 2,3 1,2 1,2 2,3z"/>
  <path class="fil18" d="M740 860c-3,0 -1,-1 -3,0 4,2 11,9 14,12 3,3 0,1 1,7 4,12 1,4 6,10l8 10c4,7 5,5 10,12l-19 -7c5,4 21,10 28,14 8,5 16,11 27,15 5,-6 1,-5 8,-1 3,3 3,1 3,1 2,2 3,3 5,5 2,3 7,9 9,13 1,1 1,2 1,3 -1,1 -1,-1 3,5 3,5 6,14 6,20 -6,-5 -36,-18 -46,-22 -2,-1 -12,-5 -14,-6 10,4 20,10 30,15 23,11 14,9 17,21l0 8c1,13 1,4 3,11 1,3 0,5 0,8l3 7c2,8 3,3 3,12 0,7 4,2 3,13 0,5 0,1 1,6 0,0 0,0 1,0 2,15 4,10 7,19 0,0 0,0 0,0 2,6 -2,0 3,10 2,4 -1,3 2,7 0,1 0,1 0,1 0,0 0,0 0,0 0,1 0,1 0,1 4,6 2,-1 10,11 6,9 6,5 7,11 0,5 0,10 1,14 0,5 -1,15 1,13 1,4 -2,7 1,7l-2 3c-13,-9 -25,-21 -36,-31l-31 -33c1,4 1,3 3,7 24,38 38,37 47,56 4,8 6,15 10,24 18,47 22,49 54,88 22,27 43,55 72,80 19,16 59,43 68,67 2,5 1,5 2,9l0 3c0,0 0,0 1,1l15 -37c5,-15 13,-33 19,-49 6,-17 12,-34 17,-52 11,-33 19,-66 27,-100 4,-1 5,-5 8,-7 -23,104 -51,190 -100,286 -38,73 -88,158 -132,231 -4,8 -3,6 -4,4 11,-21 25,-43 37,-64 12,-22 24,-44 36,-66 23,-43 49,-88 70,-133 6,-12 7,-17 -2,-32 -5,-7 -13,-16 -22,-23 -17,-14 -36,-27 -53,-42 -27,-25 -61,-67 -84,-96 -20,-26 -23,-33 -35,-68 -4,-11 -6,-17 -12,-28 -6,-11 -30,-23 -45,-63 -11,-28 -13,-29 -18,-61 -3,-25 -5,-38 -16,-60 -5,-8 -13,-16 -21,-24 -8,-8 -14,-16 -21,-24 -3,-4 -6,-9 -8,-12 -2,-4 -3,-5 -4,-7l-20 -41c-7,-14 -10,-21 -19,-35 -2,-3 -8,-10 -8,-13 10,6 22,19 32,29 6,4 12,10 17,14 6,4 14,8 18,13z"/>
  <path class="fil19" d="M1203 1050l2 0c0,3 0,6 2,8l5 -14c0,1 0,1 1,3 -4,13 -18,34 -19,45 -2,16 -4,31 -7,46 -4,30 -11,68 -20,96 0,-3 2,-6 2,-8 3,-14 13,-60 12,-68 -8,13 -18,48 -21,65 -11,50 -53,167 -78,215 -2,2 -3,5 -4,8 -4,8 -10,19 -14,29 -3,9 -15,30 -21,41 -3,4 -5,10 -7,14 -7,10 -8,15 -11,20 -2,2 -3,4 -4,6 -10,19 -97,176 -106,194 -5,10 -8,21 -12,32 5,-5 118,-205 122,-214 1,2 1,-2 0,3 -2,6 -85,154 -88,160l-35 66c-8,14 -15,31 -26,40 -10,8 -23,16 -42,10l8 -13c0,2 -1,3 4,-4 43,-74 170,-296 208,-369 49,-96 77,-182 100,-286 2,-7 3,-13 6,-20 3,-6 5,-12 8,-19 9,-27 14,-51 17,-79l2 -37 0 -4c0,0 0,0 0,0 -1,0 -1,0 -1,0 0,1 0,1 0,1l-2 4c-1,3 -2,5 -3,7 -2,4 -4,8 -6,12l1 -29c0,-10 0,-20 0,-29 1,-47 -3,-94 -11,-139 -1,-6 -3,-22 -5,-27 4,-1 11,-2 16,-3 3,-1 5,-1 8,-2 3,-1 4,-2 8,-2l5 61c3,37 4,90 3,128l-3 65 6 -13z"/>
  <path class="fil7" d="M1251 922c-2,7 0,4 0,9 -3,-2 -2,-1 -4,-3 -2,-4 -3,-7 -7,-10 -1,5 0,5 2,11 3,7 2,4 2,10 1,2 0,1 1,2 5,12 0,7 5,13l6 17c5,6 0,2 4,7 3,4 15,20 15,23 -2,-7 -3,-14 -5,-21 -1,-5 -4,-17 -6,-20 15,26 21,46 43,73 10,12 18,17 19,37 1,10 -1,41 -6,51 -2,3 -1,3 -2,7 3,-6 6,-37 5,-44l-2 1c0,0 -1,1 -1,1 -3,2 -3,3 -5,6 -3,4 -3,6 -5,12 -5,12 -6,14 -7,26 -1,8 -4,9 -2,23 1,5 1,5 0,11 -1,5 -1,9 -2,13 6,-5 13,-29 16,-38 0,2 0,0 0,3l-11 37c3,-3 17,-14 20,-14 2,-2 4,-3 5,-5l17 -12c1,0 2,-1 3,-2l84 -53c23,-17 28,-23 49,-41l21 -18c-1,3 -10,16 -13,20 -4,7 -8,15 -13,22 -8,15 -16,29 -25,43l-3 -1c-1,2 -3,5 -5,6l-8 2c-5,1 -8,3 -14,7 0,0 0,0 0,0 -5,3 -11,10 -16,11 -4,1 -6,1 -8,3l7 -1c-1,3 -2,4 -4,6 -1,3 -2,6 -3,8 -4,13 -7,4 -6,12 -4,4 -22,11 -29,14 -10,3 -21,6 -35,5 -14,-1 -23,5 -33,9 -3,1 -4,3 -7,4 -3,2 -4,2 -7,4 -2,2 -13,10 -13,11 0,-2 1,-2 -1,-1 5,-9 1,-2 4,-10 2,-5 4,-9 6,-15 3,-9 5,-20 6,-28 5,-25 0,-71 -8,-96 -3,-12 -2,-10 -6,-22l-32 -103c-1,-2 -1,-3 -2,-6 0,-2 0,-3 -1,-5 -2,-7 -2,-3 -6,-16 -2,-7 -4,-15 -5,-23 -2,-7 -10,-42 -12,-45l-1 -6c3,3 26,55 29,62 3,6 8,15 9,21l3 -4z"/>
  <path class="fil8" d="M1267 1218c-6,-2 -1,-2 -8,-11 -2,25 -41,45 -59,56 -1,1 -2,1 -4,2l-14 9c-2,1 -5,2 -7,3l-7 4c-3,2 -5,3 -7,4 -2,2 -5,4 -7,3 3,-3 26,-16 32,-20 22,-13 66,-36 72,-59 3,-9 -1,-14 -4,-20 -5,-13 8,-10 -16,-33 -11,-10 -17,-18 -21,-30 -9,-22 5,-54 -4,-79 -1,-2 -1,-2 -1,-3l-5 14c-2,-2 -2,-5 -2,-8l-2 0c4,-18 8,-11 6,-27 -1,-8 -2,-16 -1,-25 2,-9 4,-18 5,-27 3,-20 3,-55 2,-74l-4 -48c2,3 10,38 12,45 1,8 3,16 5,23 4,13 4,9 6,16 1,2 1,3 1,5 1,3 1,4 2,6l32 103c4,12 3,10 6,22 8,25 13,71 8,96 -1,8 -3,19 -6,28 -2,6 -4,10 -6,15 -3,8 1,1 -4,10z"/>
  <path class="fil7" d="M904 993c-3,-1 -2,-1 -4,1 -2,2 -3,8 -3,11 -1,21 9,24 10,36l10 3c0,11 -14,54 -20,64l3 -10 -20 48c-3,0 0,-3 -1,-7 2,-12 0,-38 -1,-50 -2,-17 -5,-33 -9,-48 -4,-15 -9,-29 -14,-44 -2,-7 -4,-14 -7,-22 -2,-7 -6,-15 -10,-21 0,-1 0,-2 -1,-3 -2,-4 -7,-10 -9,-13 -2,-2 -3,-3 -5,-5 -3,-2 -14,-15 -18,-20 -6,-6 -14,-13 -20,-19 -14,-11 -28,-22 -45,-34 -4,-5 -12,-9 -18,-13 -5,-4 -11,-10 -17,-14 -10,-10 -22,-23 -32,-29 -3,-1 -3,-2 -5,-5 -2,-2 -4,-3 -5,-5 3,-1 5,2 9,4 3,3 6,4 9,7l57 33c11,9 20,20 35,25 16,6 29,2 45,6 42,9 39,41 47,59 7,16 38,62 39,65z"/>
  <path class="fil4" d="M1220 512c-1,4 2,10 3,14l1 3c2,3 4,6 4,10 2,5 2,10 3,15 1,6 0,7 -4,10 -2,1 -2,2 -3,4 -3,-2 -3,-4 -5,-6l-2 -4c-1,-2 -3,-13 -3,-16 -4,-1 -6,1 -9,2l-5 1c-3,2 -3,7 -8,4 -2,-1 -1,-1 -2,-2 2,6 5,13 4,20 -3,0 -8,-2 -10,-4 -2,-3 -2,-4 -4,-6 -3,-3 -2,-2 -3,-5 -2,-6 -8,-16 -12,-20 1,1 2,5 3,7 1,3 3,6 2,9l-5 2c-5,2 -2,0 -6,2 -2,2 -1,2 -4,0l1 4c-2,0 -1,0 -2,1l-7 2 -2 -17c-2,7 -1,20 -4,24 -3,4 -7,7 -12,6l-1 -5c-1,2 -1,2 -1,4l-2 -2c-1,0 -1,0 -3,-1 -2,-2 -1,-2 -3,-4l-4 2c-1,15 4,38 9,52l5 13c4,6 0,4 10,7 1,-7 -6,-21 10,-23 5,-1 9,-2 14,-2 6,-2 13,-5 18,-8 2,-2 4,-2 6,-3 14,-8 19,1 16,9 -1,5 -5,11 -9,12l-1 -4 -3 5c-4,-1 -2,0 -4,-2 -3,-4 -1,-4 -3,-7l-1 0c-3,-6 2,-8 6,-12 -8,5 -25,15 -35,13l7 6c0,2 -1,5 -1,7 0,0 0,0 0,0 0,0 0,0 0,0 1,3 -1,6 -2,9 -4,0 -5,3 -10,-2 -2,-1 0,1 -1,-2 -1,-1 -1,-1 -1,-2l-3 3c-1,1 0,1 -1,3 -2,6 -6,-1 -9,1 -4,4 2,12 0,19l-1 -1c-3,-20 -4,-11 0,-22 -8,-6 -13,-33 -16,-42 0,-5 -2,-12 -2,-19l0 -4c0,-13 -2,-17 7,-29 4,-3 7,-7 12,-7 2,0 0,2 2,-1 6,1 9,-5 17,-9 6,-3 22,-12 28,-1 2,3 4,5 5,8 1,4 7,15 11,16 1,-4 -5,-16 -7,-21 -1,-2 -3,-7 -4,-11 0,-7 8,-9 5,-24 -2,-11 -14,-18 -24,-18 -6,0 -5,1 -5,0 2,-1 4,-2 8,-2 2,-1 6,0 7,-1 14,2 23,9 30,17 4,6 14,20 15,25z"/>
  <path class="fil7" d="M1018 1180c1,5 -1,13 0,16 -2,3 -10,16 -11,17 -1,-14 4,-44 -10,-64 -13,-18 -22,-31 -29,-54 -12,-35 2,-44 -4,-67 -2,-7 -5,-12 -7,-19 -4,-21 19,-53 21,-102 0,-8 -1,-43 0,-46 1,-2 1,-2 1,-2 0,7 2,14 4,20 4,11 9,48 9,59 0,24 4,64 7,87 0,1 0,3 1,5l5 29c11,47 15,68 13,121z"/>
  <path class="fil7" d="M1154 1175c-3,2 -4,6 -8,7l2 -8c-3,2 -5,5 -8,8 -7,7 -19,15 -28,23 -46,39 -47,19 -82,47 -11,9 -24,23 -33,38 -1,-1 -2,0 0,-5l18 -39c7,-13 15,-26 24,-35 15,-17 20,-18 36,-31 12,-10 24,-18 37,-30 23,-21 22,-20 40,-44 22,-27 20,-32 29,-64 1,-3 4,-20 6,-22l-2 37c-3,28 -8,52 -17,79 -3,7 -5,13 -8,19 -3,7 -4,13 -6,20z"/>
  <path class="fil18" d="M1187 1020c-2,2 -5,19 -6,22 -9,32 -7,37 -29,64 -18,24 -17,23 -40,44 -13,12 -25,20 -37,30 -16,13 -21,14 -36,31 -9,9 -17,22 -24,35l-18 39c-2,5 -1,4 0,5 -1,2 -8,16 -6,16 0,1 0,1 -1,2l-3 7c0,-3 -1,-14 -2,-16 4,-14 6,-29 9,-42 1,-7 3,-15 5,-22 2,-7 7,-17 8,-22 1,-1 9,-14 11,-17 0,0 2,-3 3,-4 3,-3 2,-2 4,-6 2,3 3,0 9,-6 4,-2 6,-5 10,-8 20,-19 38,-47 54,-56 21,-12 32,-4 59,-44 7,-10 10,-13 11,-26 6,-68 4,-123 -4,-189 -1,-7 -3,-18 -3,-25 -1,-5 -1,-10 -3,-14 1,-2 0,-1 2,-2 2,5 4,21 5,27 8,45 12,92 11,139 0,9 0,19 0,29l-1 29c2,-4 4,-8 6,-12 1,-2 2,-4 3,-7l2 -4c0,0 0,0 0,-1 0,0 0,0 1,0 0,0 0,0 0,0l0 4z"/>
  <path class="fil3" d="M1139 479c-13,-4 -50,6 -58,19l4 -2c6,-3 21,-9 25,-9 -2,3 -1,3 -2,6 3,0 18,-8 14,5 6,1 10,1 15,3 -1,1 -1,1 -2,2 5,2 3,-1 5,3 -2,9 -11,10 -14,18 -1,0 -5,0 -8,-1 6,5 6,7 16,10 -2,3 0,1 -2,1l-4 -2c-13,-6 -18,-16 -21,-19 -14,2 -23,17 -30,25l-3 6c-4,0 -23,-5 -27,-4l-2 0 15 7c2,4 3,10 1,16 -2,8 -5,10 -10,14 -1,-1 0,0 -1,-1 -7,-7 -6,-1 -11,-9 -1,-1 -1,-1 -1,-2l2 -2c0,-1 0,2 0,-1 0,-1 0,-2 0,-2 0,0 0,0 0,0l0 -1c-1,-7 -2,-4 -2,-6 0,-1 1,-3 1,-3l8 2c2,-2 0,-1 3,-2 5,0 10,4 9,7 1,-3 0,-6 -1,-8 -3,-1 -7,-2 -10,-3 -10,-5 -7,-10 3,-9 0,0 0,-2 1,-4l13 2 -4 -3c0,-5 1,-5 -3,-6 0,-2 1,-3 0,-5 4,1 16,1 17,2l-9 -3 3 -9c1,0 2,0 3,0 3,0 2,1 3,0 1,-4 1,-1 -1,-3l-1 -1 22 3c1,-4 0,-3 -4,-4l-23 -3c-9,-1 -23,-1 -29,-7 0,-4 -1,-4 2,-8 3,-7 16,-11 18,-13 1,0 10,-4 12,-5 4,-1 9,-2 13,-3 7,-2 20,-4 28,-3 6,0 11,0 17,1 7,1 14,3 20,5l0 2c2,0 2,1 4,2 -2,5 -1,2 -2,3l-1 1c0,0 0,0 0,0 -2,0 -4,-1 -6,0 -4,0 -1,1 -5,1z"/>
  <path class="fil5" d="M928 558c0,5 4,12 6,16 2,3 3,6 5,9 2,2 5,6 7,8 -3,4 -3,2 -5,5l-3 2c0,0 0,0 0,0 0,0 -1,0 -1,0l-2 2c-17,19 1,43 2,49 -4,-3 -6,-1 -11,-1 -2,-1 -4,-2 -6,-2l-10 1c-5,1 -1,1 -6,-1 -3,0 1,0 -1,0l-1 1c-3,0 -5,0 -8,-1 4,0 2,1 3,2l-7 -2c-3,3 1,2 -8,2 -3,0 -6,1 -9,0l3 2c0,2 -2,6 -3,7l6 6c0,0 2,0 2,0 4,1 0,1 6,3l4 1c2,0 3,0 4,0l3 1c1,1 0,0 1,1l-15 0c1,1 7,1 10,2 -4,6 -9,13 -10,15l-1 2 -3 -2c0,-3 -1,-4 -1,-8 0,-3 -1,-5 -2,-8 -1,-3 -5,-7 -9,-11 -13,-14 -3,-13 3,-28 3,-7 1,-10 5,-18 4,-5 8,-7 11,-11 4,-6 4,-9 13,-6 5,2 14,7 18,4 -1,-2 -2,-3 -4,-4 -12,-8 -25,-9 -21,-21 2,-6 1,-7 1,-12l2 -1 2 5c4,1 5,1 9,-2 10,-6 5,-4 9,-8l2 -1 -5 -2c3,-1 -1,-5 3,-10l6 2c2,4 4,8 6,12z"/>
  <path class="fil9" d="M1028 1175c-1,-1 0,0 -1,-2 0,-3 1,-5 1,-8 2,-4 3,-9 5,-14 11,-28 21,-40 23,-72l-2 3c-6,-3 -5,-4 -7,-7l-5 -7c0,0 0,0 0,0l-4 -8c-1,-4 -1,-1 -1,-5 -1,-3 0,-2 -1,-5 -10,6 -16,18 -20,29 -3,9 -2,10 -1,18 5,22 7,41 6,65 0,2 0,14 -1,16 -1,2 0,1 -2,2 2,-53 -2,-74 -13,-121l-5 -29c-1,-2 -1,-4 -1,-5 -3,-23 -7,-63 -7,-87 0,-11 -5,-48 -9,-59 -2,-6 -4,-13 -4,-20 0,0 0,0 -1,2 -1,-3 -1,-7 0,-10 2,2 4,14 5,19 2,7 4,12 7,19 3,6 6,10 9,17l11 18c44,72 30,49 49,132 1,7 3,13 3,21 1,16 -6,34 -13,49 -8,17 -15,31 -21,49z"/>
  <path class="fil2" d="M1012 477l0 3c-3,-1 -2,-1 -4,-1 -1,2 -7,30 -8,18l-2 0c0,0 -1,-1 -2,-1 -2,-1 -5,-4 -6,-7 -2,6 -2,11 -2,17 0,1 0,1 0,2l1 2c-1,4 2,8 -2,10 -2,1 -4,-4 -3,-7 0,-2 -6,-25 -7,-28 -1,-3 -2,-6 -6,-8l0 2c2,4 8,13 7,18 0,8 -3,18 -7,25 -3,0 -2,0 -4,0l-2 2 -3 -3c-3,-4 -1,-4 -4,-12l-2 -5c0,0 0,0 0,0l0 -2c0,-2 0,-3 0,-5 -5,2 -5,4 -6,5 0,-4 -2,-4 -3,-5 -1,2 -1,5 -7,5 -6,0 -3,-1 -4,3 -1,2 0,1 -1,1 -2,-1 0,0 -1,-2 -2,-1 0,1 -1,0 -3,-2 -5,-3 -6,-2l-2 -9c-3,13 8,46 9,47 0,4 -4,2 -2,7 -1,3 -1,1 -3,5 0,2 -1,4 -1,6 -2,-4 -4,-8 -6,-12l-7 -27c0,-2 0,-6 -1,-9l-4 2c-1,1 -2,2 -3,3 -2,1 -4,-4 -11,5 -12,16 -7,21 -4,36 1,3 1,5 2,7 0,5 1,6 -1,12 -4,12 9,13 21,21 2,1 3,2 4,4 -4,3 -13,-2 -18,-4 -9,-3 -9,0 -13,6 -3,4 -7,6 -11,11 -4,8 -2,11 -5,18 -6,15 -16,14 -3,28 4,4 8,8 9,11 1,3 2,5 2,8 0,4 1,5 1,8 -6,-9 2,-12 -10,-24 -9,-7 -14,-10 -6,-23 13,-19 3,-16 12,-28 3,-5 6,-7 9,-10 4,-6 2,-7 8,-8 1,0 1,0 1,0l3 -5c-13,-14 1,-1 -6,-35 -1,-4 -5,-12 -4,-16 1,-8 8,-22 15,-24 6,-3 2,2 8,-3 4,-4 3,-2 3,-8 0,-15 3,-31 15,-40 2,-1 2,-2 4,-2 0,1 -1,3 -2,7 0,5 0,17 2,22 0,0 0,0 0,0 3,-2 1,-1 7,1l6 -1 1 -6 4 -2 5 -15c-2,0 0,0 0,0 4,-1 0,1 1,-1 -1,-2 -2,-4 -5,-6 -5,-4 -8,-3 -9,-4 3,-2 9,-2 12,2 3,4 3,7 6,11 3,-3 10,-13 12,-18 2,-7 -3,-14 4,-18l2 -1c-2,3 -5,4 -5,9 1,5 2,5 -1,11 -2,7 -7,14 -11,19 5,12 14,-6 20,19 2,8 3,15 4,23 0,4 0,5 3,8 2,-9 -4,-15 0,-35 2,-6 3,-13 9,-14 6,-1 11,4 15,6z"/>
  <path class="fil2" d="M1372 545c-1,-5 1,-3 -3,-11 -5,-7 -2,-15 -1,-23 1,-5 1,-8 -4,-11 -11,-7 -12,-2 -22,-13 -7,-8 -15,-6 -25,-10 1,7 2,12 1,20 0,6 -2,16 -4,22 -1,3 -1,7 -3,9l-2 -1c-1,-4 3,-3 -2,-6 -2,-2 -3,-3 -5,-3 2,-9 7,-29 5,-35 -2,3 0,0 -3,2 -2,-1 -1,0 -2,-2 -1,1 -1,2 -1,3l-1 1c0,0 -1,0 -1,0l0 -1c0,-1 0,0 0,-1 -1,-1 -1,-1 -1,-2 -4,-1 -2,1 -4,-2l-1 3c-1,-3 1,-15 1,-20 0,-3 0,-11 -2,-13 -3,-4 -3,-1 -2,-4 1,-3 0,0 -2,-6 -2,-6 -5,-14 -9,-17 -4,-3 -8,-6 -13,-7 -9,-3 -10,-2 -13,2l-11 -1c0,5 6,6 7,28 -1,1 0,1 -2,1 -1,-2 -1,-2 -1,-5 -3,0 -3,1 -6,3l-2 1c0,0 0,1 0,1 -1,-1 -1,-1 -1,-2 0,0 0,-1 0,-2l-1 -10c-1,4 0,7 -5,12 -4,4 0,2 -2,5 -2,4 -3,1 -4,1 -1,-1 1,0 0,0 -5,-1 -4,0 -9,-2 0,-2 0,-4 -1,-6l-1 2c-1,1 -1,2 -1,3 -5,-2 2,-1 -5,-3 -3,9 -3,13 -6,15 -2,-2 -1,-3 -2,-5 -1,1 0,0 -1,1l-2 2c-3,-1 -6,-2 -8,-5l-2 -6c-1,0 -1,0 -1,0 -2,-7 -4,-9 2,-20 -5,4 -5,10 -6,13 -1,2 2,-1 -1,2 -2,-2 -1,-1 -2,-2 2,-5 1,-13 6,-16 6,-4 9,3 12,-8 -11,-3 -22,-5 -32,-11 -5,-3 -6,-5 -9,-9 -3,-7 -7,-5 -13,-5 4,-3 12,-1 16,0 7,3 11,16 22,19 5,1 11,2 17,3 1,-3 1,-7 4,-10 2,-3 4,-5 8,-4l3 1 -5 2c-7,4 -8,10 -9,16 2,-2 0,-1 3,-2 2,5 2,6 4,10 1,1 2,5 6,5 2,-1 1,-1 2,-2l5 2c2,-3 4,-1 6,-11 2,-6 -1,-10 -2,-15 -1,-2 0,-2 -1,-4 18,7 15,14 20,15 13,2 9,-2 16,-3 8,0 19,7 24,12 3,3 6,14 9,21 5,11 18,4 26,29 9,3 18,2 26,9 3,3 4,6 8,8 5,3 10,4 14,6 9,5 4,14 3,24 -2,13 6,14 4,23z"/>
  <path class="fil6" d="M1200 690l5 -11c7,-3 5,-1 12,-5 2,-1 3,-3 5,-4l17 -11c3,-2 6,-6 10,-9 7,-6 13,-15 17,-23 4,-6 13,-27 12,-32 3,-8 4,-22 4,-30l2 -6c4,2 2,1 3,4l0 2c2,4 1,3 0,8 1,0 0,0 1,-1 1,-1 1,-1 2,-2 3,2 1,2 3,4l3 4c0,0 0,1 0,1 -1,1 -7,6 -4,8 1,1 1,0 1,0 1,0 1,0 3,0 -2,4 -3,10 -5,13 -2,3 -4,5 -3,8l1 3c-4,3 -7,2 -11,11l21 -10c3,-1 4,-3 8,-2 -1,2 -1,1 1,4l21 -12c1,-1 0,-1 2,-1 -1,5 -4,5 -7,8 -6,4 -19,12 -25,14 0,2 1,5 0,7 -1,1 -4,2 -6,3 2,2 3,1 6,0l17 -6c2,2 3,3 3,6 2,-2 5,-3 8,-3 -4,5 -11,8 -17,10 3,10 0,9 -7,11 -2,1 -5,2 -8,3 -21,5 -43,5 -44,5 -2,1 1,0 -2,2 -2,2 -3,3 -5,3 2,1 1,0 0,3 -1,2 0,-1 0,1l0 2c0,0 0,0 0,0 -3,1 -1,2 -6,3 0,0 0,0 0,0 -4,1 0,0 -2,1l-3 2c-1,1 -1,1 -2,2l-6 3c-3,2 -2,0 -5,3 -1,0 -1,0 -2,1 -2,1 3,-1 -2,0 0,0 0,0 -1,1l-6 4c-2,1 1,-2 -1,1 -2,1 -7,3 -9,3l1 -4z"/>
  <path class="fil6" d="M967 631c1,6 8,21 11,26l5 8c1,3 3,6 5,9 4,5 8,10 13,15 22,22 53,33 84,33 20,1 28,-3 41,-4 14,-2 14,8 27,6 5,0 20,-6 22,-9l3 1c1,-1 1,-1 2,-2 -1,4 -1,8 1,12l1 3c1,2 2,2 2,3 2,4 3,10 6,13 2,2 2,4 3,7l2 6c0,3 0,1 0,5 -1,4 1,3 -1,8 -2,-2 -3,-7 -5,-11 -2,-4 -4,-6 -6,-9 -2,-4 -11,-16 -13,-18 -4,-2 3,1 -1,0 0,0 0,0 -1,0 -1,0 -1,1 -1,2 -2,6 -1,5 -4,10l-7 0c-2,-1 -4,-3 -5,-5 -5,-7 -4,-7 -13,-7 0,0 0,0 0,0 -2,0 -3,1 -4,1l-7 -1c0,0 -3,5 -7,1 -1,-1 -1,-3 -3,-3 -1,0 -4,1 -5,1 -13,0 -7,1 -18,6 -2,-2 -1,-1 -3,-3 -2,2 -3,2 -6,2 -3,-1 -5,-1 -8,-2l-2 2c-5,-2 -10,-5 -14,-6 -1,0 -4,-1 -7,-2 -6,-2 -4,-1 -7,-1 -1,-4 1,-2 -7,-5 -8,-3 -9,-7 -16,-10 -2,-1 -4,-1 -5,-2 -2,-1 -2,-2 -4,-3 1,-2 1,0 1,-2l-2 -3c-2,-1 -4,-2 -7,-3 -17,-8 -14,-10 -23,-17 -3,-2 -6,-4 -8,-7 -2,-2 -1,0 -1,-3 3,2 7,6 11,8 -5,-6 -10,-11 -15,-17 0,0 0,0 0,0 1,0 0,0 1,0 0,0 1,0 1,1 0,-2 -1,-2 -2,-4 -4,-6 -8,-9 -10,-16 -1,-2 -1,-4 -1,-6 -1,-7 -2,-5 -3,-10l3 -2c0,0 1,-1 2,-2 1,2 2,1 3,3 2,2 0,1 2,3z"/>
  <path class="fil8" d="M1131 1347l27 -83c-3,4 -1,2 0,3l-7 22 3 -1c2,1 5,-1 7,-3 2,-1 4,-2 7,-4l7 -4c2,-1 5,-2 7,-3l14 -9c2,-1 3,-1 4,-2 18,-11 57,-31 59,-56 7,9 2,9 8,11 2,-1 1,-1 1,1 -4,1 -5,4 -6,8 -2,4 -3,4 -5,7 12,-2 40,4 52,6 8,2 19,2 27,3 33,3 60,0 91,-12 6,-2 16,-8 21,-9 -10,13 -31,22 -43,27 -24,11 -32,31 -53,32 -47,2 -64,-42 -98,-40 -10,1 -9,3 -20,11 -16,11 -58,37 -77,46 -2,1 -8,4 -9,6 -4,2 -5,9 -6,14 -4,9 -9,20 -11,29z"/>
  <path class="fil10" d="M966 682c-1,2 0,2 -4,3 -13,5 -22,8 -36,9 -2,0 -1,0 -3,1 -4,-1 -13,1 -19,1 -6,-1 -18,-3 -21,-8l1 -2c1,-2 6,-9 10,-15 -3,-1 -9,-1 -10,-2l15 0c-1,-1 0,0 -1,-1l-3 -1c-1,0 -2,0 -4,0l-4 -1c-6,-2 -2,-2 -6,-3 0,0 -2,0 -2,0l-6 -6c1,-1 3,-5 3,-7l-3 -2c3,1 6,0 9,0 9,0 5,1 8,-2l7 2c-1,-1 1,-2 -3,-2 3,1 5,1 8,1l1 -1c2,0 -2,0 1,0 5,2 1,2 6,1l10 -1c2,0 4,1 6,2 5,0 7,-2 11,1 1,1 4,7 6,9 2,3 4,6 7,9 2,3 12,13 16,15z"/>
  <path class="fil19" d="M897 1108c-16,36 -8,83 13,114l15 22c11,15 22,29 34,43 8,8 13,14 26,12 1,2 2,13 2,16l3 -7c1,-1 1,-1 1,-2 -1,20 15,33 32,46 16,12 40,25 60,31l-15 37c-1,-1 -1,-1 -1,-1l0 -3c-1,-4 0,-4 -2,-9 -9,-24 -49,-51 -68,-67 -29,-25 -50,-53 -72,-80 -32,-39 -36,-41 -54,-88 -4,-9 -6,-16 -10,-24 -9,-19 -23,-18 -47,-56 -2,-4 -2,-3 -3,-7l31 33c11,10 23,22 36,31l2 -3 20 -48 -3 10z"/>
  <path class="fil2" d="M1126 718c-13,1 -21,5 -41,4 -31,0 -62,-11 -84,-33 -5,-5 -9,-10 -13,-15 -2,-3 -4,-6 -5,-9l-5 -8c2,1 1,1 2,3 5,7 11,15 16,21 3,3 20,18 25,18 -1,-2 0,-3 1,-6 -1,0 -1,0 -2,-1 -2,-3 1,-2 -2,-6l-4 -4c-2,-2 -2,-2 -1,-6 5,3 2,3 8,4 4,1 4,1 7,4 11,8 32,21 45,25 -4,0 -34,-22 -40,-26 -2,-2 -4,-4 -6,-5 -1,-1 -2,-2 -3,-3l-2 -3c0,0 0,0 1,0 9,-2 14,15 27,14 0,0 0,0 1,0 2,0 3,0 4,0 1,2 -2,-3 -2,-4 -3,-4 -3,-3 -3,-6 7,4 12,13 20,14 3,1 5,2 8,2 1,0 1,0 1,0 6,0 8,5 13,7 -1,0 -3,-3 -3,-5 1,0 4,1 4,1 0,0 2,1 3,1 -4,-2 -9,-8 -11,-12 -3,-3 -3,-3 -2,-5 4,2 8,7 11,10 4,4 11,2 14,6 4,4 5,8 14,17 1,2 4,4 4,6z"/>
  <path class="fil2" d="M1115 593c-3,2 -3,2 -6,2 0,-1 -1,-4 -1,-5 0,3 -1,4 -2,7 -1,4 0,3 0,6 -1,4 -1,4 -3,5 -3,2 -2,2 -4,4 -2,0 -1,0 -3,-1 -3,-2 3,0 -8,-3l0 4c-2,-1 -2,-2 -4,-1 2,6 7,16 8,19 -2,0 -3,1 -4,1 -6,-6 -6,-15 -10,-17 -3,-1 -1,-1 -3,-4 -1,4 0,7 -4,10 -4,1 -7,-3 -9,-6l-1 1c-4,2 -6,1 -7,2 3,3 5,4 8,9 0,0 0,1 0,1l2 6c-6,-3 -15,-21 -15,-25 -1,4 1,10 3,14 2,4 2,3 1,5 -5,-3 -5,-4 -6,-6 -3,-2 -6,-1 -7,-4 -1,3 0,5 1,7 0,3 0,6 1,8 -1,1 0,0 -1,0 -2,-2 -4,-15 -4,-18 0,-6 2,-15 -2,-19 -5,15 0,6 -1,15 -2,8 -4,12 -6,16l-3 1 0 6c-1,-1 -10,-6 -11,-7 1,-3 2,-2 1,-7 0,-7 -2,-13 -2,-17l-1 -12c-2,-3 -2,-7 -5,-11l0 -2 1 -11 2 0c2,0 3,1 4,1 2,1 3,0 4,1 2,3 -1,0 3,3l9 2c-1,0 -1,0 -4,1 -9,3 -5,11 -5,14 4,1 6,1 9,2 3,2 4,3 7,5 4,-4 5,-4 8,-12l2 9c1,3 1,8 1,12 2,-1 2,-2 2,-3 1,0 1,-2 2,-2 3,-8 4,-7 7,-12 -1,3 0,4 1,6l0 1c1,5 -1,-1 0,2l3 7c1,3 -1,1 2,2 5,3 6,-2 5,-6 -1,-6 1,-7 -2,-11 -3,-5 -4,-3 -4,-3 6,-2 5,1 11,-6 2,-1 3,-2 3,-2l-1 0c1,2 0,1 1,3l1 4c1,3 -1,1 2,6l3 4c3,-3 1,-3 3,-3 -1,0 0,-2 -1,0l0 1c0,0 1,1 1,1l1 0c6,4 0,2 5,4l1 0c0,0 1,-1 1,-1 5,-2 7,-13 7,-15 0,-3 0,-2 -1,-4 -1,-2 0,-6 -4,-8 -1,-1 -1,-1 -2,-1 3,1 4,1 7,2 3,1 5,2 8,1 2,1 3,2 3,-1l0 4c0,7 2,14 2,19z"/>
  <path class="fil11" d="M1205 679c3,-5 4,-15 3,-20 -2,-1 -2,-1 -4,-1 -4,-1 -3,1 -9,3l-5 3c-6,6 -8,6 -14,10 -3,3 -2,1 -4,3 -5,3 -6,4 -12,6l-4 1c-4,1 -10,1 -13,-2 -6,-6 0,-18 -7,-23 2,1 5,1 7,2 3,0 3,-2 6,-1 1,1 0,0 1,1l4 2c3,1 5,2 8,3l0 3 2 -1c3,-2 5,1 12,-10 2,-3 1,-3 4,-4 0,1 0,0 0,2 0,2 -2,2 -2,5 2,-2 4,-2 6,-4 0,0 2,-1 0,2 5,-4 8,-6 14,-7 3,0 3,0 5,-3 4,-6 10,-14 13,-22 0,2 0,2 2,4 0,0 0,-1 0,-1l12 -6c11,-6 10,-18 17,-22 -5,16 -7,17 -10,25 6,0 8,-5 11,-12 3,-5 5,-10 8,-16 2,2 0,5 0,8l1 2c0,0 0,0 0,0 1,-3 3,-6 3,-6 -1,3 -1,6 -2,9 -1,6 -2,0 -4,12 -1,3 -2,6 -1,9 1,2 1,2 4,3 12,-17 9,-16 14,-25 8,-12 3,-4 7,-16 1,5 -8,26 -12,32 -4,8 -10,17 -17,23 -4,3 -7,7 -10,9l-17 11c-2,1 -3,3 -5,4 -7,4 -5,2 -12,5z"/>
  <path class="fil11" d="M1051 577c-1,1 0,0 -1,1 -3,1 1,-1 -2,0 -2,2 0,-1 -2,2 -5,-7 -19,-8 -28,-12 -1,-1 -2,0 -4,-1 -1,0 -2,-1 -4,-1 -1,-7 -2,-13 -1,-21 1,-11 4,-15 7,-25 3,-1 7,-9 10,-12 2,-3 8,-8 11,-9 2,-3 1,1 2,-3 6,6 20,6 29,7l23 3c4,1 5,0 4,4l-22 -3 1 1c2,2 2,-1 1,3 -1,1 0,0 -3,0 -1,0 -2,0 -3,0l-3 9 9 3c-1,-1 -13,-1 -17,-2 1,2 0,3 0,5 4,1 3,1 3,6l4 3 -13 -2c-1,2 -1,4 -1,4 -10,-1 -13,4 -3,9 3,1 7,2 10,3 1,2 2,5 1,8 1,-3 -4,-7 -9,-7 -3,1 -1,0 -3,2l-8 -2c0,0 -1,2 -1,3 0,2 1,-1 2,6l0 1c0,0 0,0 0,0 0,0 0,1 0,2 0,3 0,0 0,1l-2 2c0,1 0,1 1,2 5,8 4,2 11,9 1,1 0,0 1,1z"/>
  <path class="fil21" d="M1167 1234c0,5 -7,27 -9,33 -1,-1 -3,1 0,-3l-27 83c-6,21 -41,97 -50,117 -9,18 -19,36 -28,54 -5,8 -24,49 -28,53 1,-5 1,-1 0,-3 -4,9 -40,72 -45,76 4,-11 7,-22 12,-32 8,-18 19,-37 29,-56 1,-2 2,-4 4,-6 3,-5 4,-10 11,-20 2,-4 4,-10 7,-14 6,-11 18,-32 21,-41 4,-10 10,-21 14,-29 1,-3 2,-6 4,-8 25,-48 67,-165 78,-215 3,-17 13,-52 21,-65 1,8 -9,54 -12,68 0,2 -2,5 -2,8z"/>
  <path class="fil5" d="M1372 545c0,5 -4,12 -8,16l0 0c-1,1 -1,1 -2,1 1,-5 -6,-2 -7,-2l-7 -6c-4,-2 -6,-1 -8,-4 2,-2 5,-4 6,-6 -3,0 -2,-1 -5,0 -1,-2 -1,-1 -1,-3l-1 -3c0,-1 0,0 0,-1 1,-1 2,-2 3,-4 3,-2 1,0 3,-3 0,-2 2,-4 1,-6 -2,-1 -4,-1 -5,0l0 -2c0,-1 0,-1 0,-1 -4,1 -15,11 -20,12 -5,0 -7,-2 -10,-2l3 -12c2,-6 4,-16 4,-22 1,-8 0,-13 -1,-20 10,4 18,2 25,10 10,11 11,6 22,13 5,3 5,6 4,11 -1,8 -4,16 1,23 4,8 2,6 3,11z"/>
  <path class="fil5" d="M1091 424c-3,0 -3,0 -6,1l-3 1c0,1 0,1 0,1 -3,1 -5,1 -6,2 -1,4 2,-2 0,1 -1,2 -2,3 -4,1 0,4 -1,9 -7,7 -4,-5 -11,-4 -15,-1 -1,-1 -1,-1 -2,-3 0,-1 -1,-1 -1,-2 -2,-2 -3,-3 -5,-4 -7,-7 -17,-6 -21,4 -2,5 -1,9 -2,14 -2,-1 -2,0 -5,-1 -1,-1 -1,-2 -3,-2l-3 11c-3,-1 -8,-5 -12,-7 -3,-2 -2,-2 -6,-4 -2,-1 -4,-2 -5,-2 5,2 16,12 19,16 2,1 3,3 5,4 0,1 1,2 1,3 2,2 1,0 1,3 -1,5 0,2 1,6l1 2c0,2 1,-1 1,3l-2 -1c-4,-2 -9,-7 -15,-6 -6,1 -7,8 -9,14 -4,20 2,26 0,35 -3,-3 -3,-4 -3,-8 -1,-8 -2,-15 -4,-23 -6,-25 -15,-7 -20,-19 4,-5 9,-12 11,-19 3,-6 2,-6 1,-11 0,-5 3,-6 5,-9 3,-2 10,-4 16,-1 6,2 11,6 16,9l2 1c3,-2 5,-6 8,-8 0,-2 -1,-2 0,-5 1,-4 8,-7 11,-9 18,-9 19,1 42,3 6,1 15,-5 18,3z"/>
  <path class="fil9" d="M1503 1034l-21 18c-21,18 -26,24 -49,41l-84 53c-1,1 -2,2 -3,2l-17 12c-1,2 -3,3 -5,5 -1,-2 -2,1 0,-4 0,-1 2,-3 3,-3l17 -12c44,-28 24,-9 42,-40 9,-15 16,-20 19,-25 -9,0 -42,10 -51,17 -11,7 -22,18 -31,28 -5,6 -5,4 -8,13 -3,9 -10,33 -16,38 1,-4 1,-8 2,-13 1,-6 1,-6 0,-11 -2,-14 1,-15 2,-23 1,-12 2,-14 7,-26 2,-6 2,-8 5,-12 2,-3 2,-4 5,-6 0,0 1,-1 1,-1l2 -1c1,7 -2,38 -5,44 1,-4 0,-4 2,-7 1,2 -1,5 -1,8 23,-31 33,-42 65,-50 34,-9 59,-14 90,-31l24 -14c2,-2 9,-7 11,-8 -1,3 -3,6 -6,8z"/>
  <path class="fil6" d="M1249 446c3,3 0,1 1,3 0,3 1,4 0,8 -13,-5 -18,6 -19,7 -2,1 -3,0 -6,4 2,0 4,-1 6,-3 1,9 2,11 6,17 2,2 3,3 4,5 1,2 2,4 2,7 -2,1 0,0 -1,2 -1,1 -1,2 -2,3 -5,-2 -10,-3 -14,-3 -2,0 -2,0 -5,-1 -3,8 -3,6 0,12 1,3 3,7 3,11 -1,-1 -1,-1 -2,-3 -1,-2 0,-2 -2,-3 -1,-5 -11,-19 -15,-25 -7,-8 -16,-15 -30,-17 1,0 1,0 2,0 3,-1 3,0 3,-7 0,-9 -1,-12 -1,-23 1,1 0,0 2,2 3,-3 0,0 1,-2 1,-3 1,-9 6,-13 -6,11 -4,13 -2,20 0,0 0,0 1,0l2 6c2,3 5,4 8,5l2 -2c1,-1 0,0 1,-1 1,2 0,3 2,5 3,-2 3,-6 6,-15 7,2 0,1 5,3 0,-1 0,-2 1,-3l1 -2c1,2 1,4 1,6 5,2 4,1 9,2 1,0 -1,-1 0,0 1,0 2,3 4,-1 2,-3 -2,-1 2,-5 5,-5 4,-8 5,-12l1 10c0,1 0,2 0,2 0,1 0,1 1,2 0,0 0,-1 0,-1l2 -1c3,-2 3,-3 6,-3 0,3 0,3 1,5 2,0 1,0 2,-1z"/>
  <path class="fil11" d="M1134 533c-10,-3 -10,-5 -16,-10 3,1 7,1 8,1 2,0 2,1 4,0 3,-1 1,0 4,-2 3,-1 3,0 5,-5 7,-13 8,-8 8,-15l-4 -2c2,-1 5,-2 1,-4 1,-5 3,-6 4,-11 -7,-2 -12,-1 -16,-2 -2,0 0,1 -2,-1 2,0 3,0 5,-1 0,0 0,0 0,0 1,0 1,0 1,0 2,-1 2,-1 3,-2 4,0 1,-1 5,-1 2,-1 4,0 6,0 0,0 0,0 0,0l1 -1c1,-1 0,2 2,-3 -2,-1 -2,-2 -4,-2l0 -2c5,0 7,3 11,3 0,1 -1,0 5,0 10,0 22,7 24,18 3,15 -5,17 -5,24 1,4 3,9 4,11 2,5 8,17 7,21 -4,-1 -10,-12 -11,-16 -1,-3 -3,-5 -5,-8 -6,-11 -22,-2 -28,1 -8,4 -11,10 -17,9z"/>
  <path class="fil11" d="M1115 593c3,9 8,36 16,42 -4,11 -3,2 0,22 -1,3 -1,3 -3,6 -4,-1 -1,-4 -4,-10 -5,-15 -14,-9 -29,-8 -9,1 -16,-2 -26,-4 -8,-1 -6,-1 -10,-6 -1,-1 -5,-7 -6,-8 1,-2 1,-1 -1,-5 -2,-4 -4,-10 -3,-14 0,4 9,22 15,25l-2 -6c0,0 0,-1 0,-1 -3,-5 -5,-6 -8,-9 1,-1 3,0 7,-2l1 -1c2,3 5,7 9,6 4,-3 3,-6 4,-10 2,3 0,3 3,4 4,2 4,11 10,17 1,0 2,-1 4,-1 -1,-3 -6,-13 -8,-19 2,-1 2,0 4,1l0 -4c11,3 5,1 8,3 2,1 1,1 3,1 2,-2 1,-2 4,-4 2,-1 2,-1 3,-5 0,-3 -1,-2 0,-6 1,-3 2,-4 2,-7 0,1 1,4 1,5 3,0 3,0 6,-2z"/>
  <path class="fil3" d="M1132 400c-1,2 -1,1 -1,2 -1,0 -1,0 -1,1l-1 0c2,7 6,25 5,32l-1 1c-3,-1 -3,-4 -3,-10 -6,-1 0,2 -6,-2 0,0 0,0 0,0 -1,3 -1,7 -1,10 -2,-1 -2,-2 -2,-4 -3,-6 -2,1 -6,-6 -2,-2 -2,-2 -4,-4 0,3 1,3 2,6 -3,0 -4,-1 -3,3 0,2 1,4 2,6 -3,-1 -3,-5 -6,-7 -3,-3 -2,0 -10,-3l6 9 2 11c-4,-3 -4,-7 -7,-10 -1,-2 -2,-4 -3,-6 0,-1 -1,-1 -1,-3 -1,-2 -1,-1 -2,-2 -3,-8 -12,-2 -18,-3 -23,-2 -24,-12 -42,-3 -3,2 -10,5 -11,9 -1,3 0,3 0,5 -3,2 -5,6 -8,8l-2 -1c1,-1 6,-7 7,-8 0,0 -1,-12 22,-18 10,-3 24,7 36,7 5,0 7,-2 11,-1 -2,-4 -6,-7 -3,-13 2,-3 8,-5 12,-4 1,-6 3,-23 15,-22 12,2 15,14 18,20l4 0z"/>
  <path class="fil5" d="M1179 440c0,11 1,14 1,23 0,7 0,6 -3,7 -2,-4 0,-14 -2,-16 1,-5 -4,-25 -8,-29 -9,-8 -20,7 -25,15l-7 -1 -1 -4c1,-7 -3,-25 -5,-32l1 0c0,-1 0,-1 1,-1 0,-1 0,0 1,-2 3,-5 6,-8 11,-9 6,0 10,-2 13,5 3,4 4,6 9,9 10,6 21,8 32,11 -3,11 -6,4 -12,8 -5,3 -4,11 -6,16z"/>
  <path class="fil3" d="M1299 734c-2,-1 -4,-1 -6,-4 -1,-1 -2,-2 -3,-2 -7,-5 -5,12 -2,18 1,1 1,2 2,4 1,2 6,8 6,11l0 4 -4 3c-5,4 -25,3 -30,6 -12,9 -15,32 -33,21l0 4c-2,-1 -3,-1 -5,-1l-5 1c0,2 -1,5 -3,7 2,-5 3,-9 4,-13 1,-5 2,-7 0,-11 -2,-3 -3,-5 -5,-8 -2,-3 -7,-14 -11,0 -2,7 6,10 6,20l-2 -2c-1,1 -1,1 -2,1l-3 2c-1,1 -1,0 -1,1 -1,1 -1,2 -1,3 -1,6 -1,9 -7,9 6,-8 3,-9 5,-22 1,-6 2,-20 8,-22 6,0 11,7 11,10 -1,-2 -1,-7 0,-10l-2 0c2,-4 2,-11 5,-14 3,-2 0,0 4,0 2,0 2,-1 5,4 1,2 2,3 2,4 0,0 0,2 -1,-1 0,-2 0,0 0,-3 4,2 4,2 6,4l7 12c1,5 2,16 -1,22 -2,3 -5,4 -9,3 -2,-1 -7,-4 -7,-6 1,0 -1,-1 0,0 1,0 1,1 2,1 1,1 1,2 2,3 8,6 14,-2 19,-8 9,-11 6,-14 25,-15 5,-1 11,-1 15,-3 10,-5 -2,-13 -5,-25 -1,-5 -2,-12 1,-18 7,0 7,6 14,7 6,1 4,-2 16,2 8,3 9,1 13,-2 3,-3 6,-8 9,-12 8,-10 20,-24 26,-35 3,-6 4,-13 7,-17 0,2 -1,5 -1,7 -5,15 -18,31 -27,42 -5,7 -11,17 -17,20 -5,3 -7,1 -13,-2 -4,-1 -12,-1 -14,0z"/>
  <path class="fil8" d="M1324 1165c-3,0 -17,11 -20,14l11 -37c0,-3 0,-1 0,-3 3,-9 3,-7 8,-13 9,-10 20,-21 31,-28 9,-7 42,-17 51,-17 -3,5 -10,10 -19,25 -18,31 2,12 -42,40l-17 12c-1,0 -3,2 -3,3 -2,5 -1,2 0,4z"/>
  <path class="fil3" d="M1290 447c-1,3 -1,0 2,4 2,2 2,10 2,13 0,5 -2,17 -1,20 -2,7 -3,19 -6,26 -3,4 0,3 -6,2 2,-6 9,-29 7,-33 -2,0 -3,1 -5,3 -1,0 -1,0 -2,0l-1 -5c-3,3 -1,-1 -2,3 -1,1 0,2 -1,3 -1,2 -2,1 -3,3 0,1 0,3 0,4 0,16 -4,35 -9,50l1 -10c3,-11 4,-27 4,-40 0,-4 -1,-8 -1,-11 -6,-3 -4,-2 -6,-5 -2,-2 -2,0 -4,-4 -2,-5 -6,-3 -3,-12 0,1 -2,3 -3,5 -3,-3 -2,-5 -9,-5 -16,1 -5,21 -6,23 0,0 0,0 0,0 0,0 0,1 0,1 0,0 0,0 -1,0 -4,-6 -5,-8 -6,-17 -2,2 -4,3 -6,3 3,-4 4,-3 6,-4 1,-1 6,-12 19,-7l3 2c5,-15 23,-32 37,-12z"/>
  <path class="fil8" d="M1028 1175l-3 11c-2,4 -1,3 -4,6 -1,1 -3,4 -3,4 -1,-3 1,-11 0,-16 2,-1 1,0 2,-2 1,-2 1,-14 1,-16 1,-24 -1,-43 -6,-65 -1,-8 -2,-9 1,-18 4,-11 10,-23 20,-29 1,3 0,2 1,5 0,4 0,1 1,5l4 8c0,0 0,0 0,0l5 7c2,3 1,4 7,7l2 -3c-2,32 -12,44 -23,72 -2,5 -3,10 -5,14 0,3 -1,5 -1,8 1,2 0,1 1,2z"/>
  <path class="fil2" d="M979 559c1,2 0,3 0,5 -1,8 3,21 7,27l4 1c7,1 10,9 11,15l2 3c1,3 2,2 3,5l2 4c1,3 1,3 1,5 -3,2 -4,1 -9,3 -3,-1 -13,-7 -14,-9 -2,-2 -2,-3 -3,-1 -2,-2 -5,-7 -10,-10 -12,-5 -8,-5 -13,-1l-4 -3c-6,-5 -5,-10 -15,-7 2,-3 2,-1 5,-5 2,2 6,3 9,6 2,2 3,5 7,6 -2,-3 -8,-8 -11,-11 -3,-4 -6,-8 -9,-12 4,-3 1,-1 6,-1 0,-3 -1,-2 -1,-5 3,1 2,3 4,4 4,1 1,-3 4,1 4,7 10,20 17,23 -1,-1 -1,-2 -2,-4 -3,-4 -1,-1 -2,-5 0,-3 -9,-17 -8,-26 2,2 1,1 2,3l5 11c-1,-4 -1,-5 1,-11 2,3 2,9 6,16l7 13c-1,-2 1,0 0,-3 -1,-1 -1,-1 -2,-2 -1,-3 -2,-4 -3,-6 -6,-14 -9,-27 -4,-42 5,3 7,9 7,14l0 -1z"/>
  <path class="fil16" d="M879 1139c-2,2 -1,-8 -1,-13 -1,-4 -1,-9 -1,-14 -1,-6 -1,-2 -7,-11 -8,-12 -6,-5 -10,-11 0,0 0,0 0,-1 0,0 0,0 0,0 0,0 0,0 0,-1 -3,-4 0,-3 -2,-7 -5,-10 -1,-4 -3,-10 0,0 0,0 0,0 -3,-9 -5,-4 -7,-19 -1,0 -1,0 -1,0 -1,-5 -1,-1 -1,-6 1,-11 -3,-6 -3,-13 0,-9 -1,-4 -3,-12l-3 -7c0,-3 1,-5 0,-8 -2,-7 -2,2 -3,-11l0 -8c-3,-12 6,-10 -17,-21 -10,-5 -20,-11 -30,-15 2,1 12,5 14,6 10,4 40,17 46,22 0,-6 -3,-15 -6,-20 -4,-6 -4,-4 -3,-5 4,6 8,14 10,21 3,8 5,15 7,22 5,15 10,29 14,44 4,15 7,31 9,48 1,12 3,38 1,50z"/>
  <path class="fil6" d="M1037 499c-3,1 -9,6 -11,9 -3,3 -7,11 -10,12 2,-3 2,-4 2,-6l-3 2c-2,2 -2,6 -10,12 -4,3 -2,3 -4,6 -4,-2 -1,-2 -3,-5 0,-1 -3,-4 -5,-3 0,0 -1,0 -1,0 -2,1 -1,1 -3,2 -2,-2 0,0 -2,-2 1,7 -6,6 -6,16 1,2 1,-1 1,2 -2,2 -3,2 -3,5 -3,-2 -4,-6 -9,-5 -3,0 -7,2 -8,4l-3 2c-5,-3 -8,-6 -14,-7 -6,-1 -11,0 -13,4 -2,-5 2,-3 2,-7 -1,-1 -12,-34 -9,-47l2 9c-2,8 8,33 11,39 4,-1 2,-2 6,-2 1,0 1,0 2,-1 3,-2 -2,-1 2,-3 2,-1 2,0 5,-2 0,-4 -8,-25 -5,-29 2,2 4,12 5,15 1,5 3,10 4,15 5,-1 6,-1 8,4 3,3 6,0 9,-1l7 -22c2,-2 0,-1 3,-2 -1,3 1,8 3,7 4,-2 1,-6 2,-10 1,0 -1,-1 2,0 0,4 -1,-1 0,1 1,1 -1,-1 1,1 1,2 6,4 7,5 0,2 0,5 1,6 0,0 1,-3 1,-5 1,-4 2,-4 4,-6l4 -4c0,0 0,0 0,0l1 0c1,-2 6,-10 6,-12l-6 -16 8 7c1,-1 2,-1 3,-1 4,-2 5,-3 10,-2 1,4 2,6 4,9l0 1c2,3 2,3 2,5z"/>
  <path class="fil6" d="M1175 454c2,2 0,12 2,16 -1,0 -1,0 -2,0 -1,1 -5,0 -7,1 -4,0 -6,1 -8,2 -4,0 -6,-3 -11,-3 -6,-2 -13,-4 -20,-5 -6,-1 -11,-1 -17,-1 1,-4 -1,-12 -4,-14l-3 6c1,-3 3,-7 3,-9 0,-1 -2,-6 -3,-6 0,2 1,3 0,6 -3,-1 -5,-4 -5,-6 -1,-3 0,0 -1,-2 0,0 0,-1 0,-1 -1,-1 -1,-2 -2,-3 3,3 3,7 7,10l-2 -11c3,-1 3,2 5,3 2,1 3,0 4,3 2,2 4,8 5,10 2,-2 0,-8 -1,-10 1,-1 1,0 2,-1 2,-1 0,-2 2,-3 2,2 3,2 4,4 1,3 0,3 3,5 0,-3 0,-7 0,-10 3,1 2,1 3,3l0 1c4,5 -2,4 5,7l1 -6 8 2c2,-3 4,-7 7,-8 -2,7 -3,8 -1,11l2 3c1,1 0,0 1,1 1,2 1,2 2,3l9 6c0,-2 0,-2 0,-4 1,-1 2,-1 3,-1 0,0 1,-1 1,-1l1 0c2,-2 2,-5 4,-7 1,-1 -1,0 1,-1 1,4 2,6 3,10l-1 0z"/>
  <path class="fil2" d="M1266 530c0,0 0,0 0,0l-2 -5c0,-2 0,-4 1,-6l0 -15c0,-4 0,-3 -2,-4 -2,5 0,3 -2,9l-3 -1c0,16 -5,32 -10,46l1 -6c1,-2 2,-4 1,-5 1,-4 1,1 0,-2 -2,-2 -2,-2 -1,-6 3,-18 0,-21 0,-25l-3 -2c0,-3 1,-4 0,-7 -1,-4 -2,-4 -3,-7 0,-3 -1,-5 -2,-7 -1,-2 -2,-3 -4,-5 1,0 1,0 1,0 0,0 0,-1 0,-1 0,0 0,0 0,0 1,-2 -10,-22 6,-23 7,0 6,2 9,5 1,-2 3,-4 3,-5 -3,9 1,7 3,12 2,4 2,2 4,4 2,3 0,2 6,5 0,3 1,7 1,11 0,13 -1,29 -4,40z"/>
  <path class="fil7" d="M1448 1222c-5,1 -15,7 -21,9 -31,12 -58,15 -91,12 -8,-1 -19,-1 -27,-3 -12,-2 -40,-8 -52,-6 2,-3 3,-3 5,-7 12,-1 26,-4 44,-6 45,-2 56,11 100,8l42 -7z"/>
  <path class="fil10" d="M1016 520c-3,10 -6,14 -7,25 -1,8 0,14 1,21l-2 0 -1 11c-1,-2 -2,-9 -4,-12 -1,-1 0,0 -1,-1 -8,-8 -6,-3 -7,-7 -2,-3 -1,-2 -4,-3 -2,5 1,6 0,10 0,4 -1,3 0,7 3,7 -1,4 2,12 1,2 1,4 1,7 0,3 0,1 0,1 3,1 3,1 5,3 -3,-1 -6,-3 -9,-2l-4 -1c-4,-6 -8,-19 -7,-27 0,-2 1,-3 0,-5 2,-3 0,-8 0,-10 0,-3 1,-3 3,-5 0,-3 0,0 -1,-2 0,-10 7,-9 6,-16 2,2 0,0 2,2 2,-1 1,-1 3,-2 0,0 1,0 1,0 2,-1 5,2 5,3 2,3 -1,3 3,5 2,-3 0,-3 4,-6 8,-6 8,-10 10,-12l3 -2c0,2 0,3 -2,6z"/>
  <path class="fil11" d="M984 513c-3,1 -1,0 -3,2l-7 22c-3,1 -6,4 -9,1 -2,-5 -3,-5 -8,-4 -1,-5 -3,-10 -4,-15 -1,-3 -3,-13 -5,-15 -3,4 5,25 5,29 -3,2 -3,1 -5,2 -4,2 1,1 -2,3 -1,1 -1,1 -2,1 -4,0 -2,1 -6,2 -3,-6 -13,-31 -11,-39 1,-1 3,0 6,2 1,1 -1,-1 1,0 1,2 -1,1 1,2 1,0 0,1 1,-1 1,-4 -2,-3 4,-3 6,0 6,-3 7,-5 1,1 3,1 3,5 1,-1 1,-3 6,-5 0,2 0,3 0,5l0 2c0,0 0,0 0,0l2 5c3,8 1,8 4,12l3 3 2 -2c2,0 1,0 4,0 4,-7 7,-17 7,-25 1,-5 -5,-14 -7,-18l0 -2c4,2 5,5 6,8 1,3 7,26 7,28z"/>
  <path class="fil3" d="M1018 568c9,4 23,5 28,12 5,11 3,9 5,14 13,-20 13,-7 22,-17 10,-11 9,-14 26,-10l11 4c-3,1 -5,0 -8,-1 -3,-1 -4,-1 -7,-2 1,0 1,0 2,1 4,2 3,6 4,8 1,2 1,1 1,4 0,2 -2,13 -7,15 0,0 -1,1 -1,1l-1 0c-5,-2 1,0 -5,-4l-1 0c0,0 -1,-1 -1,-1l0 -1c1,-2 0,0 1,0 -2,0 0,0 -3,3l-3 -4c-3,-5 -1,-3 -2,-6l-1 -4c-1,-2 0,-1 -1,-3l1 0c0,0 -1,1 -3,2 -6,7 -5,4 -11,6 0,0 1,-2 4,3 3,4 1,5 2,11 1,4 0,9 -5,6 -3,-1 -1,1 -2,-2l-3 -7c-1,-3 1,3 0,-2l0 -1c-1,-2 -2,-3 -1,-6 -3,5 -4,4 -7,12 -1,0 -1,2 -2,2 0,1 0,2 -2,3 0,-4 0,-9 -1,-12l-2 -9c-3,8 -4,8 -8,12 -3,-2 -4,-3 -7,-5 -3,-1 -5,-1 -9,-2 0,-3 -4,-11 5,-14 3,-1 3,-1 4,-1l-9 -2c-4,-3 -1,0 -3,-3z"/>
  <path class="fil12" d="M1362 562l0 1c-2,0 -1,0 -4,1 -2,1 -3,1 -5,2 -3,1 -6,3 -9,3 -10,2 -6,-11 -19,-5 -17,8 -25,21 -33,22 3,-8 11,-9 21,-22 8,-12 14,-19 -2,-25 -1,0 -2,-1 -2,-1 0,0 0,0 0,0 0,0 0,0 0,0l2 -7c3,0 5,2 10,2 5,-1 16,-11 20,-12 0,0 0,0 0,1l0 2c1,-1 3,-1 5,0 1,2 -1,4 -1,6 -2,3 0,1 -3,3 -1,2 -2,3 -3,4 0,1 0,0 0,1l1 3c0,2 0,1 1,3 3,-1 2,0 5,0 -1,2 -4,4 -6,6 2,3 4,2 8,4l7 6c1,0 8,-3 7,2z"/>
  <path class="fil13" d="M1099 567c-17,-4 -16,-1 -26,10 -9,10 -9,-3 -22,17 -2,-5 0,-3 -5,-14 2,-3 0,0 2,-2 3,-1 -1,1 2,0 1,-1 0,0 1,-1 5,-4 8,-6 10,-14 2,-6 1,-12 -1,-16l-15 -7 2 0c4,-1 23,4 27,4l3 -6c6,0 17,-3 23,-1l1 2c-3,0 -5,0 -7,0 -3,0 -5,0 -7,1 0,1 0,3 1,5 1,6 1,1 2,2 0,3 1,3 1,7 0,11 0,6 16,14l-8 -1z"/>
  <path class="fil14" d="M922 546l-6 -2c-4,5 0,9 -3,10l5 2 -2 1c-4,4 1,2 -9,8 -4,3 -5,3 -9,2l-2 -5 -2 1c-1,-2 -1,-4 -2,-7 -3,-15 -8,-20 4,-36 7,-9 9,-4 11,-5 1,-1 2,-2 3,-3l4 -2c1,3 1,7 1,9l7 27z"/>
  <path class="fil14" d="M1063 455c-3,4 -7,17 -4,20 -2,2 -15,6 -18,13 -3,4 -2,4 -2,8 -1,4 0,0 -2,3 0,-2 0,-2 -2,-5l0 -1c-2,-3 -3,-5 -4,-9 -5,-1 -6,0 -10,2 -1,0 -2,0 -3,1l-8 -7 6 16c0,2 -5,10 -6,12l-1 0c0,0 0,0 0,0l-4 4c-2,2 -3,2 -4,6 0,2 -1,5 -1,5 -1,-1 -1,-4 -1,-6 -1,-1 -6,-3 -7,-5 -2,-2 0,0 -1,-1 -1,-2 0,3 0,-1 -3,-1 -1,0 -2,0l-1 -2c0,-1 0,-1 0,-2 0,-6 0,-11 2,-17 1,3 4,6 6,7 1,0 2,1 2,1l2 0c1,12 7,-16 8,-18 2,0 1,0 4,1l0 -3 2 1 5 5c3,0 5,-1 9,-1 0,-2 0,-3 -1,-5l1 0c0,0 0,0 1,-1 3,-1 -2,3 1,-1 1,-1 0,0 1,-1l0 -1c2,-3 1,1 2,-3 0,-2 0,-2 1,-4 2,2 0,1 2,3 2,3 2,7 4,10 2,-1 0,-7 0,-9 0,-5 1,0 4,-9 3,2 3,1 5,1 1,5 0,5 2,7 3,-3 0,-8 4,-11l3 -2c2,-1 3,-1 4,-2 -1,2 -1,0 1,1z"/>
  <path class="fil14" d="M1041 632l1 8c-12,2 -22,2 -34,-3 -10,-3 -19,-13 -25,-20 1,-2 1,-1 3,1 1,2 11,8 14,9 5,-2 6,-1 9,-3 0,-2 0,-2 -1,-5l-2 -4c-1,-3 -2,-2 -3,-5l-2 -3c-1,-6 -4,-14 -11,-15 3,-1 6,1 9,2l6 3c3,-5 5,-2 3,-9 0,-3 0,-5 -1,-9 3,4 3,8 5,11l1 12c0,4 2,10 2,17 1,5 0,4 -1,7 1,1 10,6 11,7l0 -6 3 -1c2,-4 4,-8 6,-16 1,-9 -4,0 1,-15 4,4 2,13 2,19 0,3 2,16 4,18z"/>
  <path class="fil3" d="M1116 774c0,6 1,11 0,18 -2,-3 0,-2 -2,-6 -1,-3 -1,-2 -2,-6l-3 -19c-1,-3 -1,-4 -2,-6 -1,-7 -3,-6 0,-15l13 -5 8 19 5 17c1,4 4,26 3,29 0,1 1,1 0,1 -4,2 -1,0 -3,-4 -1,-2 -8,-6 -8,-6 -4,-3 2,1 -3,-6 -1,0 -1,0 -1,-1l-2 -4c-2,-2 -1,-3 -3,-6z"/>
  <path class="fil11" d="M1175 454l1 0c-1,-4 -2,-6 -3,-10 -2,1 0,0 -1,1 -2,2 -2,5 -4,7l-1 0c0,0 -1,1 -1,1 -1,0 -2,0 -3,1 0,2 0,2 0,4l-9 -6c-1,-1 -1,-1 -2,-3 -1,-1 0,0 -1,-1l-2 -3c-2,-3 -1,-4 1,-11 -3,1 -5,5 -7,8l-8 -2 -1 6c-7,-3 -1,-2 -5,-7l0 -1c-1,-2 0,-2 -3,-3 0,3 0,7 0,10 -3,-2 -2,-2 -3,-5 -1,-2 -2,-2 -4,-4 -2,1 0,2 -2,3 -1,1 -1,0 -2,1 1,2 3,8 1,10 -1,-2 -3,-8 -5,-10 -1,-3 -2,-2 -4,-3 -2,-1 -2,-4 -5,-3l-6 -9c8,3 7,0 10,3 3,2 3,6 6,7 -1,-2 -2,-4 -2,-6 -1,-4 0,-3 3,-3 -1,-3 -2,-3 -2,-6 2,2 2,2 4,4 4,7 3,0 6,6 0,2 0,3 2,4 0,-3 0,-7 1,-10 0,0 0,0 0,0 6,4 0,1 6,2 0,6 0,9 3,10l1 -1 1 4 7 1c5,-8 16,-23 25,-15 4,4 9,24 8,29z"/>
  <path class="fil12" d="M1112 464c-8,-1 -21,1 -28,3 -4,1 -9,2 -13,3 -2,1 -11,5 -12,5 -3,-3 1,-16 4,-20l1 -1 2 -6c1,1 1,1 2,2 2,1 2,1 2,1 7,6 3,-1 5,-6 1,2 1,3 1,5l9 -1c1,-1 2,-1 3,-2 0,-6 -1,-6 2,-8 3,1 1,1 3,4 0,0 0,0 0,0l2 -1c3,-1 0,-1 2,-1 1,0 2,0 3,0 0,2 2,5 5,6 1,-3 0,-4 0,-6 1,0 3,5 3,6 0,2 -2,6 -3,9l3 -6c3,2 5,10 4,14z"/>
  <path class="fil14" d="M1314 519l-3 12 -2 7c0,0 0,0 0,0 0,0 0,0 0,0 0,0 1,1 2,1 -2,0 -7,-1 -10,-1 -13,0 -3,-2 -18,-14 1,-5 4,-10 4,-14 3,-7 4,-19 6,-26l1 -3c2,3 0,1 4,2 0,1 0,1 1,2 0,1 0,0 0,1l0 1c0,0 1,0 1,0l1 -1c0,-1 0,-2 1,-3 1,2 0,1 2,2 3,-2 1,1 3,-2 2,6 -3,26 -5,35 2,0 3,1 5,3 5,3 1,2 2,6l2 1c2,-2 2,-6 3,-9z"/>
  <path class="fil14" d="M1290 447c-14,-20 -32,-3 -37,12l-3 -2c1,-4 0,-5 0,-8 -1,-2 2,0 -1,-3 -1,-22 -7,-23 -7,-28l11 1c3,-4 4,-5 13,-2 5,1 9,4 13,7 4,3 7,11 9,17 2,6 3,3 2,6z"/>
  <path class="fil7" d="M1096 821c-4,11 -2,27 -3,38 -6,-3 -12,-12 -15,-17 -4,-6 -7,-12 -9,-20 0,-10 11,-25 17,-24 3,6 -4,8 7,17 3,4 2,2 3,6z"/>
  <path class="fil3" d="M1065 438c2,5 1,5 1,10l-2 6c-1,-4 3,-12 -2,-16 -1,0 -1,0 -2,0l-10 5c-2,1 -1,2 -3,4 -4,0 3,-1 -1,-1 -5,13 -4,3 -8,11 0,0 0,1 0,1l-1 0c-2,-1 0,0 -2,-3l-4 -1c0,1 0,1 0,1 -1,1 -1,1 -1,2l-4 -2c-2,4 -1,1 -1,5 1,6 -2,3 -2,3 -1,-2 -2,-6 -2,-8 -1,-3 -1,-6 -2,-9 1,-5 0,-9 2,-14 4,-10 14,-11 21,-4 2,1 3,2 5,4 0,1 1,1 1,2 1,2 1,2 2,3 4,-3 11,-4 15,1z"/>
  <path class="fil2" d="M1126 524c3,-8 12,-9 14,-18 -2,-4 0,-1 -5,-3 1,-1 1,-1 2,-2 -5,-2 -9,-2 -15,-3 4,-13 -11,-5 -14,-5 1,-3 0,-3 2,-6 -4,0 -19,6 -25,9l-4 2c8,-13 45,-23 58,-19 -1,1 -1,1 -3,2 0,0 0,0 -1,0 0,0 0,0 0,0 -2,1 -3,1 -5,1 2,2 0,1 2,1 4,1 9,0 16,2 -1,5 -3,6 -4,11 4,2 1,3 -1,4l4 2c0,7 -1,2 -8,15 -2,5 -2,4 -5,5 -3,2 -1,1 -4,2 -2,1 -2,0 -4,0z"/>
  <path class="fil3" d="M979 549c0,2 2,7 0,10l0 1c0,-5 -2,-11 -7,-14 -5,15 -2,28 4,42 1,2 2,3 3,6 1,1 1,1 2,2 1,3 -1,1 0,3l-7 -13c-4,-7 -4,-13 -6,-16 -2,6 -2,7 -1,11l-5 -11c-1,-2 0,-1 -2,-3 -1,9 8,23 8,26 1,4 -1,1 2,5 1,2 1,3 2,4 -7,-3 -13,-16 -17,-23 -3,-4 0,0 -4,-1 -2,-1 -1,-3 -4,-4 0,3 1,2 1,5 -5,0 -2,-2 -6,1 3,4 6,8 9,12 3,3 9,8 11,11 -4,-1 -5,-4 -7,-6 -3,-3 -7,-4 -9,-6 -2,-2 -5,-6 -7,-8 -2,-3 -3,-6 -5,-9 0,-1 0,2 1,-2 -2,-2 -2,-1 -2,-4 2,1 3,2 5,2 0,1 3,1 5,2 1,-4 -1,-3 -1,-6 4,2 1,3 5,6 3,-3 1,-1 3,-1 0,2 1,3 5,5 0,-4 -3,-2 0,-7 1,-4 3,-8 3,-12 0,-3 -1,-4 -2,-5l4 1c0,-4 1,-3 2,-5 1,-2 5,-4 8,-4 5,-1 6,3 9,5z"/>
  <path class="fil16" d="M823 933c0,0 0,2 -3,-1 -7,-4 -3,-5 -8,1 -11,-4 -19,-10 -27,-15 -7,-4 -23,-10 -28,-14l19 7c-5,-7 -6,-5 -10,-12l-8 -10c-5,-6 -2,2 -6,-10 -1,-6 2,-4 -1,-7 -3,-3 -10,-10 -14,-12 2,-1 0,0 3,0 17,12 31,23 45,34 6,6 14,13 20,19 4,5 15,18 18,20z"/>
  <path class="fil14" d="M1132 534c-5,0 -8,4 -12,7 -5,-2 -16,-5 -20,-4 -6,-2 -17,1 -23,1 7,-8 16,-23 30,-25 3,3 8,13 21,19l4 2z"/>
  <path class="fil3" d="M934 574c-2,-4 -6,-11 -6,-16 0,-2 1,-4 1,-6 2,-4 2,-2 3,-5 2,-4 7,-5 13,-4 6,1 9,4 14,7l3 -2c-1,2 -2,1 -2,5l-4 -1c1,1 2,2 2,5 0,4 -2,8 -3,12 -3,5 0,3 0,7 -4,-2 -5,-3 -5,-5 -2,0 0,-2 -3,1 -4,-3 -1,-4 -5,-6 0,3 2,2 1,6 -2,-1 -5,-1 -5,-2 -2,0 -3,-1 -5,-2 0,3 0,2 2,4 -1,4 -1,1 -1,2z"/>
  <path class="fil10" d="M1113 570c0,3 -1,2 -3,1l-11 -4 8 1c-16,-8 -16,-3 -16,-14 0,-4 -1,-4 -1,-7 -1,-1 -1,4 -2,-2 -1,-2 -1,-4 -1,-5 2,-1 4,-1 7,-1 2,0 4,0 7,0l-1 -2c4,-1 15,2 20,4 -9,12 -7,16 -7,29z"/>
  <path class="fil11" d="M1064 454l-1 1c-2,-1 -2,1 -1,-1 -1,1 -2,1 -4,2l-3 2c-4,3 -1,8 -4,11 -2,-2 -1,-2 -2,-7 -2,0 -2,1 -5,-1 -3,9 -4,4 -4,9 0,2 2,8 0,9 -2,-3 -2,-7 -4,-10 -2,-2 0,-1 -2,-3 -1,2 -1,2 -1,4 -1,4 0,0 -2,3l0 1c-1,1 0,0 -1,1 -3,4 2,0 -1,1 -1,1 -1,1 -1,1l-1 0c-1,-3 -1,-2 -1,-3 -1,-2 -1,-2 -1,-4 -1,-3 -2,-4 -2,-7 0,0 3,3 2,-3 0,-4 -1,-1 1,-5l4 2c0,-1 0,-1 1,-2 0,0 0,0 0,-1l4 1c2,3 0,2 2,3l1 0c0,0 0,-1 0,-1 4,-8 3,2 8,-11 4,0 -3,1 1,1 2,-2 1,-3 3,-4l10 -5c1,0 1,0 2,0 5,4 1,12 2,16z"/>
  <path class="fil9" d="M1086 1220c0,-7 6,-18 9,-21l4 -6c6,-6 19,-16 20,-17 -5,0 -9,3 -14,3 2,-2 17,-7 21,-8 10,-3 8,-6 15,-5 3,0 3,0 7,1 -6,11 -26,30 -36,38 -2,1 -3,2 -4,3 -4,3 -19,12 -22,12z"/>
  <path class="fil3" d="M932 460c3,-2 7,-4 10,-5 1,1 4,0 9,4 3,2 4,4 5,6 -1,2 3,0 -1,1 0,0 -2,0 0,0l-5 15 -4 2 -1 6 -6 1c-6,-2 -4,-3 -7,-1 0,0 0,0 0,0 -2,-5 -2,-17 -2,-22 1,-4 2,-6 2,-7z"/>
  <path class="fil10" d="M1246 508c0,5 1,9 0,15 -2,-1 -3,-1 -3,-4l-2 0c-1,0 -1,0 -2,0 0,0 1,1 0,-1 0,-3 0,-2 -3,-4 -2,-2 -1,-1 -4,-2 -5,16 4,34 2,40l-4 -17c-2,-5 -6,-13 -6,-17 0,-4 -2,-8 -3,-11 -3,-6 -3,-4 0,-12 3,1 3,1 5,1 4,0 9,1 14,3 1,-1 1,-2 2,-3 1,-2 -1,-1 1,-2 1,3 2,3 3,7 1,3 0,4 0,7z"/>
  <path class="fil3" d="M1210 399c2,-1 3,0 5,1 3,0 5,1 7,1 1,2 0,2 1,4 1,5 4,9 2,15 -2,10 -4,8 -6,11l-5 -2c-1,1 0,1 -2,2 -4,0 -5,-4 -6,-5 -2,-4 -2,-5 -4,-10 -3,1 -1,0 -3,2 1,-6 2,-12 9,-16l5 -2 -3 -1z"/>
  <path class="fil3" d="M1310 686c2,-1 0,-1 1,0 -2,2 -2,0 -3,3 -1,-1 1,0 1,1 1,7 -20,-5 -23,-6 -3,-1 -1,1 -4,-1 -7,-3 -2,-5 -5,-9 0,0 1,0 1,0l1 -1c0,0 -1,1 -2,-3 0,-1 -1,1 0,-2 1,-6 7,-2 10,-1 12,5 18,9 28,17 2,1 8,5 2,5 -1,0 -4,-3 -7,-3z"/>
  <path class="fil3" d="M949 706c-2,6 -1,5 -8,9 -4,2 -17,10 -19,10 -8,1 -21,-4 -8,-16 5,-4 5,-3 10,-4 6,-1 12,-3 18,-1 4,1 3,1 7,2z"/>
  <path class="fil5" d="M1097 435c1,1 1,2 2,3 0,0 0,1 0,1 1,2 0,-1 1,2 -1,0 -2,0 -3,0 -2,0 1,0 -2,1l-2 1c0,0 0,0 0,0 -2,-3 0,-3 -3,-4 -3,2 -2,2 -2,8 -1,1 -2,1 -3,2l-9 1c0,-2 0,-3 -1,-5 -2,5 2,12 -5,6 0,0 0,0 -2,-1 -1,-1 -1,-1 -2,-2 0,-5 1,-5 -1,-10 6,2 7,-3 7,-7 2,2 3,1 4,-1 2,-3 -1,3 0,-1 1,-1 3,-1 6,-2 0,0 0,0 0,-1l3 -1c3,-1 3,-1 6,-1 1,1 1,0 2,2 0,2 1,2 1,3 1,2 2,4 3,6z"/>
  <path class="fil10" d="M1019 446c1,3 1,6 2,9 0,2 1,6 2,8 0,3 1,4 2,7 0,2 0,2 1,4 0,1 0,0 1,3 1,2 1,3 1,5 -4,0 -6,1 -9,1l-5 -5c0,-4 -1,-1 -1,-3l-1 -2c-1,-4 -2,-1 -1,-6 0,-3 1,-1 -1,-3 0,-1 -1,-2 -1,-3 -2,-1 -3,-3 -5,-4 -3,-4 -14,-14 -19,-16 1,0 3,1 5,2 4,2 3,2 6,4 4,2 9,6 12,7l3 -11c2,0 2,1 3,2 3,1 3,0 5,1z"/>
  <path class="fil9" d="M1392 1172c-1,-8 2,1 6,-12 1,-2 2,-5 3,-8 2,-2 3,-3 4,-6l-7 1c2,-2 4,-2 8,-3 5,-1 11,-8 16,-11 0,0 0,0 0,0 6,-4 9,-6 14,-7l8 -2c2,-1 4,-4 5,-6l3 1c-7,11 -18,23 -27,31 -8,8 -25,20 -33,22z"/>
  <path class="fil12" d="M1007 577l0 2c1,4 1,6 1,9 2,7 0,4 -3,9l-6 -3c-2,-2 -2,-2 -5,-3 0,0 0,2 0,-1 0,-3 0,-5 -1,-7 -3,-8 1,-5 -2,-12 -1,-4 0,-3 0,-7 1,-4 -2,-5 0,-10 3,1 2,0 4,3 1,4 -1,-1 7,7 1,1 0,0 1,1 2,3 3,10 4,12z"/>
  <path class="fil12" d="M1246 523c-1,9 -6,37 -12,43l0 -3c0,-1 0,-1 -1,-2 1,-3 0,-6 1,-9 2,-6 -7,-24 -2,-40 3,1 2,0 4,2 3,2 3,1 3,4 1,2 0,1 0,1 1,0 1,0 2,0l2 0c0,3 1,3 3,4z"/>
  <path class="fil3" d="M1370 571c0,1 0,0 1,2 0,2 0,0 0,2l-1 2c0,2 -1,3 -2,4l-3 5c-2,2 -3,4 -6,5l-4 2c-2,1 0,1 -3,1 -1,0 -3,-1 -4,-1 0,-1 0,-3 1,-4 1,-5 4,-3 0,-3l-2 1c3,-9 3,-13 9,-18 7,-5 11,2 14,2z"/>
  <path class="fil9" d="M917 1044l-10 -3c-1,-12 -11,-15 -10,-36 0,-3 1,-9 3,-11 2,-2 1,-2 4,-1 4,3 9,17 11,23 2,8 4,18 2,28z"/>
  <path class="fil4" d="M956 603c0,4 0,9 -2,12 -1,1 -2,0 -3,3 -1,2 -2,5 -8,3 0,2 -1,2 1,3 -2,-1 -5,-10 -6,-12 -5,-10 -2,-5 0,-14l3 -2c10,-3 9,2 15,7z"/>
  <path class="fil15" d="M1216 806l-3 7c-1,-5 0,-15 -3,-19 0,-10 -8,-13 -6,-20 4,-14 9,-3 11,0 2,3 3,5 5,8 2,4 1,6 0,11 -1,4 -2,8 -4,13z"/>
  <path class="fil3" d="M1001 620c0,1 -1,2 -2,2l-8 -4c-3,-4 -5,-2 -7,-11 -1,-9 2,-21 9,-12 2,3 0,0 2,3l5 16c1,4 1,2 1,6z"/>
  <path class="fil6" d="M1258 563c-8,13 -9,15 -20,21 -1,0 -2,0 -3,1 -1,0 -1,0 -2,1 -4,2 -8,2 -11,4 -1,-1 -2,1 1,-3 2,-3 0,0 2,-2l4 -5c1,-1 1,-2 2,-3 1,-1 4,-3 6,-2 0,0 0,2 0,0 3,-1 5,-4 8,-6 5,-4 3,-7 7,-7l1 0c6,0 -2,0 2,0 0,0 1,-1 1,-1 1,0 2,-1 2,-1 1,2 1,0 0,3z"/>
  <path class="fil7" d="M1299 734c-2,7 -2,20 -3,27 0,-3 -5,-9 -6,-11 -1,-2 -1,-3 -2,-4 -3,-6 -5,-23 2,-18 1,0 2,1 3,2 2,3 4,3 6,4z"/>
  <path class="fil4" d="M1070 657c-6,1 -1,-1 -2,0l0 0c0,1 0,1 -1,1l0 1c-7,-2 -9,-5 -12,-8 1,-4 1,-6 4,-8 1,-1 5,-2 7,0 3,1 1,-1 4,6 1,2 1,1 1,3 0,2 0,2 -1,5z"/>
  <path class="fil4" d="M1111 662c-2,-1 -3,-1 -4,-5l-3 -5c4,-11 11,-8 14,-4 2,2 2,4 -1,8 0,1 -1,4 -2,4 0,1 -1,1 -2,1 -1,1 0,1 -2,1z"/>
  <path class="fil4" d="M1189 777c-2,-1 -2,-1 -4,-2 0,0 -2,-3 -2,-3l-2 -3c-5,-12 -1,-20 1,-18 2,1 5,10 6,13 1,2 5,14 1,13z"/>
  <path class="fil22 str0" d="M444 1618c231,-1 462,-2 693,-2 -2,7 -4,15 -5,31 -2,17 -4,42 -2,59 3,18 9,27 23,35 14,9 36,16 47,19 11,4 11,4 -34,6 -45,2 -134,7 -243,8 -108,1 -236,-1 -311,-2 -76,-1 -100,-1 -118,-7 -19,-7 -32,-20 -41,-35 -10,-15 -15,-33 -16,-52 -1,-19 3,-39 7,-60z"/>
  <path class="fil8" d="M1263 958c2,3 5,16 7,20 2,8 3,14 4,21 1,-3 -12,-19 -15,-22 -4,-6 1,-1 -3,-8l-7 -16c-5,-7 0,-2 -5,-14 0,-1 0,0 0,-2 -1,-5 0,-3 -2,-9 -2,-6 -4,-7 -2,-12 3,4 4,7 6,10 5,7 5,16 17,32z"/>
  <path class="fil9" d="M399 1244c2,-8 -2,2 -7,-13 -1,-3 -2,-6 -3,-9 -2,-3 -3,-3 -4,-7l8 1c-3,-2 -5,-2 -9,-3 -6,-1 -13,-9 -18,-13 -1,0 -1,0 -1,0 -6,-4 -9,-7 -16,-8l-8 -2c-2,-1 -5,-4 -6,-7l-4 1c8,13 21,27 31,36 9,8 28,22 37,24z"/>
  <path class="fil23" d="M1679 475c380,316 431,881 115,1261 -37,44 -77,83 -119,118l-1137 0c-1,-1 -3,-2 -5,-3 -379,-317 -431,-881 -115,-1261 317,-380 881,-431 1261,-115z"/>
  <path class="fil24" d="M35 782c12,-25 20,-42 23,-49 4,-10 9,-21 14,-33 5,-13 8,-21 10,-24 6,-15 13,-26 20,-34 7,-8 16,-13 27,-16 11,-3 22,-2 33,3 9,4 17,11 24,19 7,8 12,17 14,28 3,10 4,20 3,29 -1,9 -3,18 -7,27 -3,6 -7,13 -12,20l-10 -1 -1 -2c5,-7 9,-13 11,-18 6,-14 6,-27 1,-39 -6,-12 -15,-21 -29,-27 -14,-7 -27,-7 -39,-2 -13,4 -23,15 -30,33 -4,9 -7,20 -9,33 8,5 27,14 57,27l72 32 31 13c11,5 19,8 23,9 3,1 6,2 7,1 2,0 4,-2 6,-4 2,-3 6,-9 11,-20l1 -1 8 4 1 1c-13,26 -20,41 -21,44 -2,4 -8,19 -19,45l-2 1 -7 -4 -1 -1c4,-10 7,-17 7,-20 1,-4 1,-6 1,-8 -1,-1 -2,-3 -5,-5 -3,-2 -10,-6 -21,-11l-33 -14 -72 -32 -30 -13c-12,-6 -20,-9 -23,-10 -4,-1 -7,-1 -8,-1 -2,1 -3,2 -5,5 -2,2 -6,9 -11,20l-2 1 -8 -4 0 -2z"/>
  <path id="1" class="fil24" d="M281 636c-10,-8 -18,-18 -25,-31 -6,-12 -8,-26 -7,-42 2,-17 8,-32 20,-47 15,-19 33,-29 54,-31 21,-3 41,4 59,18 20,17 32,37 34,60 2,24 -4,46 -19,65 -10,12 -22,20 -37,25 -14,4 -28,5 -42,2 -13,-4 -25,-10 -37,-19zm11 -32c13,10 25,17 37,22 13,4 25,6 36,4 11,-3 21,-8 28,-17 8,-10 11,-22 8,-36 -3,-13 -12,-26 -29,-40 -19,-15 -37,-23 -55,-26 -18,-2 -33,4 -44,18 -9,11 -12,23 -9,37 3,13 13,25 28,38z"/>
  <path id="2" class="fil24" d="M551 429l3 12c-4,14 -9,24 -14,32 -6,8 -12,14 -17,19 -10,8 -22,15 -35,18 -12,4 -26,4 -40,-1 -14,-5 -27,-14 -38,-28 -8,-9 -14,-18 -18,-27 -3,-10 -6,-17 -6,-23 -1,-5 0,-13 2,-22 3,-9 6,-18 10,-26 5,-8 11,-16 18,-22 11,-9 22,-14 34,-16 12,-2 23,0 33,5 9,5 18,12 25,20 2,3 4,6 6,8l0 3c-5,6 -12,14 -22,23 -9,8 -16,14 -19,17l-42 35c16,18 31,27 47,28 16,1 31,-4 43,-14 6,-6 11,-11 15,-18 4,-7 7,-15 11,-24l4 1zm-129 17c2,-1 9,-6 19,-15 11,-8 19,-15 24,-19 12,-10 19,-16 21,-19 -1,-2 -3,-4 -4,-5 -11,-13 -22,-21 -33,-23 -11,-2 -21,1 -31,9 -10,9 -15,19 -14,31 0,13 6,26 18,41z"/>
  <path id="3" class="fil24" d="M518 318l-2 -4 0 -2c7,-8 13,-16 16,-22 -15,-26 -24,-40 -27,-44 8,-10 14,-18 18,-26l5 1c3,6 12,25 29,55 4,-3 10,-6 15,-9 12,-7 20,-12 24,-16l2 1 5 13 -1 2c-5,3 -10,7 -16,10 -6,3 -13,8 -21,13l35 60c8,13 14,22 17,26 3,4 7,6 11,7 4,0 9,-1 15,-4 6,-4 11,-10 15,-16l6 3c-1,3 -4,11 -8,24 -3,6 -8,10 -13,13 -22,13 -39,9 -52,-12 -4,-8 -8,-14 -11,-20 -1,-2 -2,-3 -3,-5l-36 -61 -6 4c-5,3 -9,6 -15,10l-2 -1z"/>
  <path id="4" class="fil24" d="M673 199l4 1c1,6 6,17 12,33l5 -20c2,-6 4,-12 6,-16 1,-3 4,-7 7,-10 4,-3 8,-6 12,-8 4,-1 9,-2 14,-2l2 1c4,15 8,28 13,38l-7 3c-9,-8 -17,-10 -27,-6 -6,3 -11,8 -14,14 -3,6 -4,12 -3,19 1,7 4,15 8,25l7 17c1,3 5,11 11,23 5,12 9,19 10,20 1,2 2,3 4,4 1,0 3,0 4,0 2,-1 10,-3 23,-8l2 1 3 6 -1 2c-14,5 -29,11 -44,17 -12,5 -24,11 -37,18l-2 -1 -2 -7 0 -2c10,-5 16,-7 17,-8 1,-1 2,-2 3,-4 0,-1 0,-3 0,-5 -1,-2 -3,-9 -8,-21 -4,-11 -8,-20 -10,-26l-13 -31c-2,-4 -5,-9 -8,-17 -3,-7 -6,-11 -7,-12 -1,-2 -2,-3 -4,-3 -1,0 -4,1 -8,2l-13 6 -2 -1 -3 -7 0 -1c19,-11 34,-22 46,-34z"/>
  <path id="5" class="fil24" d="M830 406c2,-11 2,-20 2,-28l4 -1c7,5 13,6 20,4 7,-2 13,-7 17,-17 4,-9 8,-28 11,-57 -7,-11 -14,-21 -21,-30l-43 -58c-4,-6 -11,-15 -20,-26 -8,-11 -13,-17 -14,-18 -2,-1 -3,-2 -5,-2 -2,-1 -7,-1 -15,0l-1 -1 -2 -6 1 -2c13,-3 26,-6 39,-9 16,-4 28,-8 36,-10l2 1 1 6 0 2c-2,0 -5,1 -10,3 -6,2 -9,4 -10,5 -1,2 -1,4 -1,6 1,1 4,7 10,16 6,10 12,18 17,25l17 23c11,15 19,26 25,33l4 -21c1,-8 3,-20 5,-35l5 -39c1,-10 1,-16 1,-18 0,-3 0,-4 0,-5 -1,-3 -2,-4 -4,-4 -2,-1 -6,-1 -12,0l-8 1 -1 -1 -2 -7 1 -2c9,-1 20,-4 33,-7 12,-3 21,-6 27,-8l2 1 2 7 -1 1c-4,2 -7,3 -9,5 -3,1 -4,4 -6,7 -1,3 -4,11 -6,24 -3,13 -6,27 -8,41l-7 39 -15 99c-1,8 -3,18 -6,28 -2,10 -7,18 -13,23 -6,6 -13,10 -21,12 -7,2 -14,2 -21,0z"/>
  <path id="6" class="fil24" d="M1341 200l-1 5 -1 2 -8 3c-3,1 -4,2 -4,3 -1,0 -2,4 -3,10 -1,6 -2,13 -4,22 -1,9 -2,20 -2,32l-1 1c-32,8 -65,10 -97,6 -25,-3 -47,-11 -66,-23 -19,-12 -33,-28 -42,-48 -10,-20 -13,-43 -10,-68 5,-39 23,-69 52,-88 30,-20 66,-27 109,-21 31,4 59,13 82,27l1 2c-3,7 -7,23 -13,46l-1 1 -8 -1 -1 -1 1 -18c1,-6 1,-10 0,-11 0,-1 -1,-2 -3,-4 -2,-2 -6,-5 -14,-10 -8,-4 -16,-8 -24,-11 -9,-2 -18,-4 -27,-6 -21,-2 -40,0 -57,6 -16,7 -30,17 -40,33 -10,15 -17,33 -19,53 -3,20 -1,40 5,59 7,19 17,35 32,47 15,12 33,19 55,22 9,1 19,1 29,1 10,-1 18,-2 25,-5 1,-3 3,-11 4,-22l2 -18c2,-9 2,-15 1,-17 -1,-2 -4,-4 -8,-6 -4,-1 -14,-3 -28,-5l-2 -2 1 -7 2 -2 10 2c18,3 32,5 43,6 7,1 16,2 28,3l2 2z"/>
  <path id="7" class="fil24" d="M1417 200l-5 -4 -1 -2 8 -20c24,-7 45,-7 63,0 12,5 21,11 27,19 7,7 10,15 11,24 1,8 0,16 -4,25l-13 32 -18 47c-3,7 -4,11 -3,12 0,2 1,3 2,4 1,1 3,2 6,4l8 4 1 2 -2 7 -2 0c-8,-3 -15,-6 -21,-9 -7,-2 -14,-5 -23,-8l-2 -3 11 -25 -45 13c-7,0 -14,-1 -21,-3 -8,-4 -15,-8 -20,-14 -5,-5 -8,-11 -9,-18 -1,-6 0,-14 3,-22 6,-15 16,-25 29,-30 13,-5 42,-2 88,8 6,-15 7,-28 2,-37 -4,-9 -12,-16 -24,-20 -6,-2 -12,-4 -18,-4 -5,0 -9,0 -10,1 -1,1 -7,6 -16,16l-2 1zm64 53c-31,-6 -52,-8 -61,-5 -10,2 -17,10 -21,22 -7,16 -2,28 15,34 14,5 31,3 51,-8l16 -43z"/>
  <path id="8" class="fil24" d="M1639 251l1 3c-4,6 -10,16 -18,30l19 -8c6,-2 11,-4 16,-5 4,-1 8,-1 13,0 4,0 8,2 12,4 5,3 8,6 11,10l0 2c-9,13 -16,24 -22,34l-7 -4c1,-12 -2,-20 -11,-25 -6,-3 -13,-4 -19,-3 -7,2 -13,5 -18,10 -5,5 -10,12 -15,21l-9 16c-2,3 -5,11 -12,22 -6,12 -9,19 -10,21 0,2 0,4 0,5 1,1 2,3 3,4 1,1 8,5 20,13l1 2 -4 6 -2 1c-12,-8 -26,-16 -40,-24 -11,-7 -23,-13 -36,-19l-1 -2 4 -7 2 0c10,5 15,7 17,8 1,0 2,0 4,0 1,-1 3,-2 4,-3 2,-2 6,-8 12,-19 7,-10 12,-18 15,-24l16 -29c2,-4 5,-10 9,-17 3,-7 5,-11 6,-13 0,-1 0,-3 -1,-4 -1,-2 -3,-4 -7,-6l-12 -7 -1 -2 4 -6 2 -1c20,9 38,14 54,16z"/>
  <path id="9" class="fil24" d="M1861 329l4 -5 2 0c18,12 35,21 50,27l1 3c-10,9 -28,28 -53,58l-74 83c-8,9 -14,16 -20,23 -5,7 -8,11 -8,13 0,2 0,4 1,6 1,2 5,7 13,15l0 2 -4 5 -2 0c-9,-8 -16,-15 -21,-20 -4,-4 -11,-9 -20,-16l0 -3c7,-8 12,-13 15,-17 1,0 2,-2 5,-5 -8,0 -16,-1 -24,-1 -13,0 -20,0 -24,0 -5,-2 -12,-6 -19,-12 -12,-10 -19,-22 -22,-35 -3,-13 -3,-25 2,-38 4,-12 11,-22 19,-32 8,-9 18,-17 30,-23 11,-5 22,-7 32,-5 11,2 22,4 33,6 12,3 22,8 30,14 10,10 18,22 23,36l25 -29c8,-10 14,-17 17,-21 3,-4 5,-7 5,-8 0,-1 0,-3 -1,-4 -1,-2 -6,-6 -15,-14l0 -3zm-50 100c0,-10 -2,-20 -5,-29 -4,-8 -9,-16 -16,-21 -7,-7 -15,-11 -25,-12 -9,-2 -19,0 -28,5 -10,5 -18,12 -26,21 -13,15 -20,30 -20,46 -1,16 5,28 16,38 6,6 13,9 20,11 7,1 15,1 22,-1 8,-2 14,-6 18,-10 5,-4 13,-13 25,-26l19 -22z"/>
  <path id="10" class="fil24" d="M1890 673l-13 3c-13,-5 -23,-10 -31,-16 -7,-6 -13,-12 -17,-18 -9,-11 -14,-22 -17,-35 -4,-13 -2,-26 3,-40 5,-14 15,-26 29,-37 10,-7 19,-13 29,-16 9,-4 17,-6 22,-6 6,0 13,1 22,4 10,2 18,6 26,11 8,5 15,11 21,19 8,11 13,22 14,34 1,12 -1,23 -6,33 -5,9 -12,17 -21,24 -3,2 -6,4 -9,6l-2 -1c-6,-5 -14,-12 -22,-22 -8,-10 -14,-17 -16,-20l-33 -44c-19,15 -29,30 -31,46 -2,16 3,30 13,44 5,6 10,11 17,15 6,5 14,8 23,12l-1 4zm-11 -129c1,2 6,8 14,20 8,11 14,19 18,24 9,13 15,20 18,22 2,-1 4,-2 5,-3 14,-11 22,-22 24,-33 3,-11 0,-21 -7,-31 -8,-10 -19,-16 -31,-16 -12,0 -26,6 -41,17z"/>
  <path id="11" class="fil24" d="M2055 691l-1 4c-7,2 -16,6 -28,10 11,6 21,11 31,15 3,1 6,3 7,4 2,2 4,5 7,9 3,4 6,8 8,13 3,8 5,16 5,25 0,9 -2,16 -5,22 -2,5 -6,10 -12,14 -5,4 -12,8 -21,12l-28 12c-2,0 -14,6 -38,17 -10,4 -16,8 -17,11 -1,3 1,9 6,20l-1 2 -7 3 -1 -1c-5,-13 -9,-22 -11,-27 -1,-3 -4,-10 -11,-22l1 -3c14,-4 32,-11 54,-21l21 -8c12,-5 21,-10 26,-12 5,-3 9,-7 12,-12 4,-5 5,-10 6,-16 0,-6 -1,-12 -4,-19 -2,-6 -5,-10 -8,-13 -2,-4 -6,-7 -12,-10 -5,-4 -10,-6 -14,-7 -4,-1 -7,-1 -10,-1 -3,1 -8,3 -17,7l-27 11c-2,1 -9,5 -22,10 -12,6 -19,10 -21,11 -2,1 -3,3 -3,4 -1,1 -1,3 -1,4 0,2 2,7 6,18l-1 2 -6 2 -2 0c-5,-14 -10,-26 -15,-38 -5,-12 -11,-25 -17,-37l1 -2 6 -3 2 1c5,9 8,15 9,16 1,1 2,2 3,3 2,0 3,0 6,0 2,-1 9,-3 20,-8 12,-4 21,-7 26,-10l31 -13c4,-2 10,-4 17,-8 7,-3 11,-6 13,-6 1,-1 2,-3 2,-4 1,-2 0,-5 -2,-9l-5 -13 0 -2 7 -3 2 1c11,18 22,34 33,45z"/>
 </g>
</svg></a><?php endif;
}


// END ENQUEUE PARENT ACTION
