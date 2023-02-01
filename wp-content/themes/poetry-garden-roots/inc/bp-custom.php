<?php
function bp_extra_tabs() {
global $bp;
bp_core_new_nav_item(
  array(
      'name' => __('Publications', 'buddypress'),
      'slug' => 'publications',
      'parent_url' => $bp->displayed_user->domain,
      'position' => 10,
      'show_for_displayed_user' => true,
      'screen_function' => 'publication_tab',
      'default_subnav_slug' => 'all',
      'item_css_id' => $bp->messages->id
    )
);

bp_core_new_subnav_item(
    array (
    
        'name' =>  __('All', 'buddypress'),
        'slug' => 'all',
        'parent_slug' => 'publications',
        'parent_url'    => trailingslashit( bp_displayed_user_domain() . 'publications' )  ,
        'screen_function' => 'publication_tab',
        
    )
);

bp_core_new_subnav_item (
      
    array (
    
    'name' =>  __('Poetry', 'buddypress'),
    'slug' => 'poetry',
    'parent_slug' => 'publications',
    'parent_url'    => trailingslashit( bp_displayed_user_domain() . 'publications' )  ,
    'screen_function' => 'poetry_tab',
    'position'          => 100,
        
    )
    
);

bp_core_new_subnav_item (
      
    array (
    
    'name' =>  __('Fiction', 'buddypress'),
    'slug' => 'fiction',
    'parent_slug' => 'publications',
    'parent_url'    => trailingslashit( bp_displayed_user_domain() . 'publications' )  ,
    'screen_function' => 'fiction_tab',
    'position'          => 100,
        
    )
    
);

bp_core_new_subnav_item (
      
    array (
    
    'name' =>  __('Non-Fiction', 'buddypress'),
    'slug' => 'non-fiction',
    'parent_slug' => 'publications',
    'parent_url'    => trailingslashit( bp_displayed_user_domain() . 'publications' )  ,
    'screen_function' => 'non_fiction_tab',
    'position'          => 100,
        
    )
    
);

}
add_action( 'bp_setup_nav', 'bp_extra_tabs', 1000 );

function publication_tab () {
    add_action( 'bp_template_title', 'publications_nav');
	add_action( 'bp_template_content', 'the_publications' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function publications_nav() {
    echo '<span class="pl-1 pt-1 block">Publications</span>';
}

function the_publications() {
    publications_query();
}

function poetry_tab () {
    add_action( 'bp_template_title', 'poetry_nav' );
	add_action( 'bp_template_content', 'the_poetry' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function poetry_nav() {
    echo '<span class="pl-1 pt-1 block">Poetry</span>';
}

function the_poetry() {
    publications_query('poetry');
}

function fiction_tab () {
    add_action( 'bp_template_title', 'fiction_nav' );
	add_action( 'bp_template_content', 'the_fiction' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function fiction_nav() {
    echo '<span class="pl-1 pt-1 block">Fiction</span>';
}

function the_fiction() {
    publications_query('fiction');
}

function non_fiction_tab () {
    add_action( 'bp_template_title', 'non_fiction_nav' );
	add_action( 'bp_template_content', 'the_non_fiction' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function non_fiction_nav() {
    echo '<span class="pl-1 pt-1 block">Non-Fiction</span>';
}

function the_non_fiction() {
    publications_query('non-fiction');
}

function publications_query($cat = '') {
    
    $pub_args = array (
        
        'author' => bp_displayed_user_id(),
        'posts_per_page' => 12,
        
        );
        
    if (isset($_GET['orderby'])) {
        $pub_args['orderby'] = $_GET['orderby'];
    }
    
    if ($cat != '') {
        $pub_args['category_name'] = $cat;
    }
    
    $pub_query = new WP_Query($pub_args);
    
    if ($pub_query->have_posts()) : 
         ?> 
        <div class="flex wrap gap-3 mt-2 pl-2">
            <?php
            while ($pub_query->have_posts()) : $pub_query->the_post();
                generate_do_template_part( 'archive' );
            endwhile;
            ?>
        </div>
    <?php
    endif;
    
}

function bpfr_hide_tabs() {
global $bp;
	 /**
	 * class_exists() & bp_is_active are recommanded to avoid problems during updates 
	 * or when Component is deactivated
	 */

	if( class_exists( 'bbPress' ) || bp_is_active ( 'groups' ) ) :
        
        /** here we fix the conditions. 
        * Are we on a profile page ? | is user site admin ? | is user logged in ?
        */
	if ( bp_is_user()
	//&& !is_super_admin() && !is_user_logged_in() 
	) {

        /* and here we remove our stuff ! */
		//bp_core_remove_nav_item( 'settings' );
		//bp_core_remove_nav_item( 'notifications' );
		bp_core_remove_nav_item( 'messages' );
		// bp_core_remove_subnav_item( 'profile', 'public' );
	}
	endif;
}
add_action( 'bp_setup_nav', 'bpfr_hide_tabs', 15 );

function my_bp_activity_types( $retval ) {
// list of all BP activity types  - remove or comment those you won't show.
    $retval['action'] = array(        
        //'activity_comment',
	//	'activity_update',
	//	'created_group',
	//	'friendship_created',
	//	'joined_group',
	//	'last_activity',
//		'new_avatar',
	//	'new_blog_comment',
               // 'new_blog_post',
                //'new_site_created',
                //'new_blog_created',
                //'new_blog',
                //'new_item_published',
                'new_site',
               // 'activity_comment',
                'new_fiction',
                'new_poetry',
                'new_fiction_comment',
                'new_non-fiction_comment',
                'new_poetry_comment',
                'new_non-fiction',
                'bbp_topic_create',
' bbp_reply_create',
	//	'new_member',
	//	'updated_profile'        
    );
 
    return $retval;
}
add_filter( 'bp_after_has_activities_parse_args', 'my_bp_activity_types' );

function bpcodex_rename_profile_tabs() {
    // Change "Activity" to "Profile"
    buddypress()->members->nav->edit_nav( array( 'name' => __( 'Profile', 'pty-gdn' ) ), 'activity' );
}
add_action( 'bp_actions', 'bpcodex_rename_profile_tabs' );

define ( 'BP_AVATAR_FULL_WIDTH', 250 );
define ( 'BP_AVATAR_FULL_HEIGHT', 250 );

//ActivityPub plugin filters

function activitypub_metadata ($json, $author_id) {
    
    $json = json_decode(json_encode($json), true);
    $member_bio = xprofile_get_field( 6,  $author_id)->data->value; // get specific BP profile field, unique to this instance
    $json['summary'] = $member_bio; // add your profile data
    
    $json['url'] = bp_core_get_user_domain( $author_id ); //add BP member profile URL as user URL
    
     $cover_image_url = bp_attachments_get_attachment( 'url', array( 'item_id' => $author_id ) );
    
    if ( $cover_image_url ) {
	    $json['image'] = array(
    		'type' => 'Image',
	    	'url'  => $cover_image_url,
    	);
    }
    
    $activitypub_meta = array();
    $member_website = xprofile_get_field( 7,  $author_id)->data->value;
    if ($member_website) {
        $activitypub_meta[] = array(
	        'type' => 'PropertyValue',
	        'name' => \__( 'Website', 'activitypub' ),
	        'value' => \html_entity_decode(
		        '<a rel="me" title="' . \esc_attr( $member_website ) . '" target="_blank" href="' .$member_website . '">' . \wp_parse_url( $member_website, \PHP_URL_HOST ) . '</a>',
		        \ENT_QUOTES,
		        'UTF-8'
	        ),
        );
    }
    
    $user_blogs = get_blogs_of_user($author_id); //get sites of user to send as AP metadata
    
    foreach($user_blogs as $blog) {
        if ($blog->userblog_id != 1) {
            $activitypub_meta[] = array (
                'type' => 'PropertyValue',
                'name' => \__($blog->blogname, 'activitypub'),
                'value' => \html_entity_decode(
		            '<a rel="me" title="' . \esc_attr( $blog->siteurl ) . '" target="_blank" href="' .$blog->siteurl. '">' . \wp_parse_url( $blog->siteurl, \PHP_URL_HOST ) . '</a>',
	        	    \ENT_QUOTES,
	        	    'UTF-8'
        	    ),
            );
        }
    }
    
    /*Attempt to pull metadata from BP Profile Group 3 (Media Profile information in this intance). 
    *Written to spec with https://codex.buddypress.org/developer/loops-reference/the-profile-fields-loop-bp_has_profile/ , but not working. */
    /*if (  bp_has_profile('profile_group_id=3&user_id='.$author_id) ) : 
    while ( bp_profile_groups() ) : bp_the_profile_group(); 
    
   
        if ( bp_profile_group_has_fields() ) : 
 
 
        while ( bp_profile_fields() ) : bp_the_profile_field(); 
 
          if ( bp_field_has_data() ) : 
          
             
            $mp_value = xprofile_get_field( bp_get_the_profile_field_id(),  bp_displayed_user_id())->data->value;
            $activitypub_meta[] = array (
                
                'type' => 'PropertyValue',
                'name' => \_(bp_the_profile_field_name(), 'activitypub'),
                'value' => \html_entity_decode(
                    
                        '<a rel="me" title="'.$mp_value.'" target="_blank" href="'.$mp_value.'">' .$mp_value. '</a>',
                        \ENT_QUOTES,
                        'UTF-8'
                    
                    ),
                
                );
            endif;
        endwhile;
        
        endif;
    endwhile;
    endif;*/
             
            

   
    $json['attachment'] = $activitypub_meta;  
  
    return $json;
}

add_filter( 'activitypub_json_author_array', 'activitypub_metadata', 11, 2 );