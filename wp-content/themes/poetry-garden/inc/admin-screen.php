<?php
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