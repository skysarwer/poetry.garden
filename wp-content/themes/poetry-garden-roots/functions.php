<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

  $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri_segments = explode('/', $uri_path);
            global $uri_segments;

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
//if (
	//!current_user_can('administrator') && 
//	!is_admin()) {
  show_admin_bar(false);
//}
}

add_action( 'wpmu_new_blog', 'process_extra_field_on_blog_signup', 10, 6 );
function process_extra_field_on_blog_signup( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    switch_to_blog($blog_id);
    if ( $homepage )
    {
        update_blog_option( $blog_id, 'page_on_front', $homepage->ID );
        update_blog_option( $blog_id, 'show_on_front', 'page' );
     
    }
    $https_url = str_replace('http://', 'https://', site_url());
    $homepage = get_page_by_title( 'Home' ); 
    $starting_colors = array('#FFFFFF', '#FFFDF2', '#DEF0D3', '#FCCFCF', '#D1D7FC', '#EAD1FC', '#F5F3C4');
    $site_author = get_user_by( 'email', get_blog_option( get_current_blog_id(), 'admin_email' ));
        update_blog_option($blog_id, 'siteurl', $https_url);
        update_blog_option($blog_id, 'home', $https_url);
        update_blog_option($blog_id, 'site_url', $https_url);
        update_blog_option($blog_id, 'blogdescription', '');
        update_blog_option( $blog_id, 'avatar_default', 'blank' );
        update_blog_option($blog_id, 'site_author', $site_author->ID);
        update_field ('field_604521f2c57a1', get_bloginfo('name'), 'options');
        update_field ('field_6029e016c2646', $starting_colors[rand(0, 6)], 'options');
}

function wpmu_limit_subsites($active_signup) {
    $blogs = get_blogs_of_user( get_current_user_id() );
	if ($blogs["1"]) unset($blogs["1"]);
    $n = count($blogs);
    if($n == 3) {
        $active_signup = 'none';
        echo '<p class="one-site-only">Only three sites are allowed per account. <br/><br/></p>';
    } elseif($n > 3) {
        $active_signup = 'none';
        echo '';
    } else {
        $active_signup = $active_signup;
    }
    return $active_signup; /* return "all", "none", "blog" or "user" */
}
add_filter('wpmu_active_signup', 'wpmu_limit_subsites');

//require_once '/home/r00ts/public_html/wp-content/themes/poetry-garden/custom-post-types.php'; //fix this, add code to plugin

require_once get_stylesheet_directory().'/inc/template-functions.php';
require_once get_stylesheet_directory().'/inc/svg.php';
require_once get_stylesheet_directory().'/inc/media-profile-icons.php';
require_once get_stylesheet_directory().'/inc/bp-custom.php';

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6029dfd91f726',
	'title' => 'General Customize Fields',
	'fields' => array(
		array(
			'key' => 'field_6029e016c2646',
			'label' => 'Site Background Color',
			'name' => 'background_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#EEE8AA',
		),
		array(
			'key' => 'field_6044370f3633a',
			'label' => 'Site Background Text Color',
			'name' => 'outside_text_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#000000',
		),
		array(
			'key' => 'field_604436e836339',
			'label' => 'Page Background Color',
			'name' => 'page_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#FFFFFF',
		),
		array(
			'key' => 'field_604437513633b',
			'label' => 'Page Text Color',
			'name' => 'page_text_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#000000',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-general',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_604521e4977b3',
	'title' => 'Site Details',
	'fields' => array(
		array(
			'key' => 'field_604521f2c57a1',
			'label' => 'Site Title',
			'name' => 'site_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_604521fcc57a2',
			'label' => 'Site Description',
			'name' => 'site_description',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'very_simple',
			'media_upload' => 0,
			'delay' => 0,
		),
		array(
			'key' => 'field_60452211c57a3',
			'label' => 'Site Image',
			'name' => 'site_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_60452232c57a4',
			'label' => 'Site Icon',
			'name' => 'site_icon',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => 150,
			'max_height' => 150,
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_6048197ccf3ea',
			'label' => 'Community Network Settings',
			'name' => 'community_network_settings',
			'type' => 'clone',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'clone' => array(
				0 => 'field_603d500c1482a',
				1 => 'field_603d50431482b',
				2 => 'field_603d50ef1482c',
			),
			'display' => 'seamless',
			'layout' => 'block',
			'prefix_label' => 0,
			'prefix_name' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'site_details',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

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
        'updated_message' => 'Options saved',
		'autoload' => true,
		
    ));
}
add_action('acf/init', 'add_acf_menu_pages');

add_filter( 'avatar_defaults', 'wpb_new_gravatar' );
function wpb_new_gravatar ($avatar_defaults) {
$myavatar = 'https://poetry.garden/img/pg-avatar.png';
$avatar_defaults[$myavatar] = "Default Gravatar";
return $avatar_defaults;
}


function notifications_widget() {
  register_sidebar( array(
    'name'          => __( 'Notifications', 'poetry-garden-roots' ),
    'id'            => 'notifications',
    'description'   => __( 'Notifications', 'poetry-garden-roots' ),
    'before_widget' => '<aside">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2>',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'notifications_widget' );

function icondeposit_bp_activity_entry_meta() {
 
        global $wpdb, $post, $bp;
        $theimg = wp_get_attachment_image_src(  get_post_thumbnail_id( bp_get_activity_secondary_item_id() ) );
        ?>
        <img src="<?php echo $theimg[0]; ?>" >
 
 
<?php }
//add_action('bp_activity_excerpt_append_text', 'icondeposit_bp_activity_entry_meta');

/*function syndicate_comment( $comment_ID, $comment_approved, $commentdata) {
    
    if ($commentdata['comment_meta'][0]['key'] == 'syndicated_id') {
        return;
    }

    $syndicated_site = get_post_meta( $commentdata['comment_post_ID'], 'parent_site_ID', true );

    $comment_args =  array ( 
        'meta_query' => array (
            
            array (
                
                'key' => 'syndicated_site',
                'value' => $syndicated_site,
                
                ),
            
            ),
        'number' => 1,
    );
    
    $comment_query = new WP_Comment_Query;
    
    $comment_results = $comment_query->query($comment_args);

    $syndicated_comment = array();

    if (!empty($comment_results)) {
        
        foreach ($comment_results as $comment) {
             $syndicated_comment[] = get_comment_meta($comment->comment_ID, 'syndicated_id', true);  
        }
    } else {
        $syndicated_comment[] = 0;
    }
    
    $syndicated_comment_value = $syndicated_comment[0];
    
    $syndicated_id = $syndicated_comment_value + 1; 
    
    add_comment_meta ($comment_ID, 'syndicated_id', $syndicated_id);
    
    add_comment_meta ($comment_ID, 'syndicated_site', $syndicated_site);

    if ($commentdata['comment_parent'] != '') {
    
        $synced_comment_parent = get_comment_meta(  $commentdata['comment_parent'], 'syndicated_id', true   );
    
    } else {
    
       $synced_comment_parent = 0;
    }
    
    $synced_comment_post = get_post_meta( $commentdata['comment_post_ID'], 'parent_post_id', true );
    
    $new_commentdata = array (
    
        'comment_author' => $commentdata['comment_author'],
        'comment_author_email' =>  $commentdata['comment_author_email'],
        'comment_author_url' =>  $commentdata['comment_author_url'],
        'comment_content' =>  $commentdata['comment_content'],
        'comment_date' => $commentdata['comment_date'],
        'comment_date_gmt' => $commentdata['comment_date_gmt'],
        //'comment_type' => $commentdata['comment_content'],
        'comment_parent' => $synced_comment_parent,
        'comment_post_ID' => $synced_comment_post,
        'user_id' => $commentdata['user_id'],
        'comment_agent' =>  $commentdata['comment_agent'],
        'comment_author_IP' =>  $commentdata['comment_author_IP'],
    
    );
    
    
    switch_to_blog($syndicated_site);
    
    if (get_comment($syndicated_id) ==  '' ) {
        
        remove_action ('comment_post', 'syndicate_comment', 11, 3); 
        
        wp_new_comment ($new_commentdata);
        
        add_action('comment_post', 'syndicate_comment', 11, 3); 
    
    restore_current_blog();
    }  
    
}*/
//add_action('comment_post', 'syndicate_comment', 11, 3); 


// END ENQUEUE PARENT ACTION
