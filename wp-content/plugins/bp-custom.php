<?php

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

define ( 'BP_AVATAR_FULL_WIDTH', 250 );
define ( 'BP_AVATAR_FULL_HEIGHT', 250 );

function custom_reg_form($section = 'account_details') {
    
    					$fields = bp_nouveau_get_signup_fields( $section );
    if ( ! $fields ) {
        return;
    }
 
    foreach ( $fields as $name => $attributes ) {
        if ( 'signup_password' === $name ) {
            ?>
            <label for="pass1"><?php esc_html_e( 'Password (required)', 'buddypress' ); ?></label>
            <div class="user-pass1-wrap">
                <div class="wp-pwd">
                    <div class="password-input-wrapper">
                        <input type="password" data-reveal="1" name="signup_password" id="pass1" class="password-entry" size="24" />
                    </div>
                </div>
                <div class="pw-weak">
                    <label>
                        <input type="checkbox" name="pw_weak" class="pw-checkbox" />
                        <?php esc_html_e( 'Confirm use of weak password', 'buddypress' ); ?>
                    </label>
                </div>
            </div>
            <?php
        } elseif ( 'signup_password_confirm' === $name ) {
            ?>
            <p class="user-pass2-wrap">
                <label for="pass2"><?php esc_html_e( 'Confirm new password', 'buddypress' ); ?></label><br />
                <input type="password" name="signup_password_confirm" id="pass2" class="password-entry-confirm" size="24" value="" <?php bp_form_field_attributes( 'password' ); ?> />
            </p>
 
            <p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
            <?php
        } else {
            list( $label, $required, $value, $attribute_type, $type, $class ) = array_values( $attributes );
 
            // Text fields are using strings, radios are using their inputs
            $label_output = '<label for="%1$s">%2$s</label>';
            $id           = $name;
            $classes      = '';
 
            if ( $required ) {
                /* translators: Do not translate placeholders. 2 = form field name, 3 = "(required)". */
                $label_output = __( '<label for="%1$s">%2$s %3$s</label>', 'buddypress' );
            }
 
            // Output the label for regular fields
            if ( 'radio' !== $type ) {
                if ( $required ) {
                    printf( $label_output, esc_attr( $name ), esc_html( $label ), __( '(required)', 'buddypress' ) );
                } else {
                    printf( $label_output, esc_attr( $name ), esc_html( $label ) );
                }
 
                if ( ! empty( $value ) && is_callable( $value ) ) {
                    $value = call_user_func( $value );
                }
 
            // Handle the specific case of Site's privacy differently
            } elseif ( 'signup_blog_privacy_private' !== $name ) {
                ?>
                    <span class="label">
                        <?php esc_html_e( 'I would like my site to appear in search engines, and in public listings around this network.', 'buddypress' ); ?>
                    </span>
                <?php
            }
 
            // Set the additional attributes
            if ( $attribute_type ) {
                $existing_attributes = array();
 
                if ( ! empty( $required ) ) {
                    $existing_attributes = array( 'aria-required' => 'true' );
 
                    /**
                     * The blog section is hidden, so let's avoid a browser warning
                     * and deal with the Blog section in Javascript.
                     */
                    if ( $section !== 'blog_details' ) {
                        $existing_attributes['required'] = 'required';
                    }
                }
 
                $attribute_type = ' ' . bp_get_form_field_attributes( $attribute_type, $existing_attributes );
            }
 
            // Specific case for Site's privacy
            if ( 'signup_blog_privacy_public' === $name || 'signup_blog_privacy_private' === $name ) {
                $name      = 'signup_blog_privacy';
                $submitted = bp_get_signup_blog_privacy_value();
 
                if ( ! $submitted ) {
                    $submitted = 'public';
                }
 
                $attribute_type = ' ' . checked( $value, $submitted, false );
            }
 
            // Do not run function to display errors for the private radio.
            if ( 'private' !== $value ) {
 
                /**
                 * Fetch & display any BP member registration field errors.
                 *
                 * Passes BP signup errors to Nouveau's template function to
                 * render suitable markup for error string.
                 */
                if ( isset( buddypress()->signup->errors[ $name ] ) ) {
                    nouveau_error_template( buddypress()->signup->errors[ $name ] );
                    $invalid = 'invalid';
                }
            }
 
            if ( isset( $invalid ) && isset( buddypress()->signup->errors[ $name ] ) ) {
                if ( ! empty( $class ) ) {
                    $class = $class . ' ' . $invalid;
                } else {
                    $class = $invalid;
                }
            }
 
            if ( $class ) {
                $class = sprintf(
                    ' class="%s"',
                    esc_attr( join( ' ', array_map( 'sanitize_html_class', explode( ' ', $class ) ) ) )
                );
            }
 
            // Set the input.
            $field_output = sprintf(
                '<input type="%1$s" name="%2$s" id="%3$s" %4$s value="%5$s" %6$s />',
                esc_attr( $type ),
                esc_attr( $name ),
                esc_attr( $id ),
                $class,  // Constructed safely above.
                esc_attr( $value ),
                $attribute_type // Constructed safely above.
            );
 
            // Not a radio, let's output the field
            if ( 'radio' !== $type ) {
                if ( 'signup_blog_url' !== $name ) {
                    print( $field_output );  // Constructed safely above.
 
                // If it's the signup blog url, it's specific to Multisite config.
                } elseif ( is_subdomain_install() ) {
                    // Constructed safely above.
                    printf(
                        '%1$s %2$s . %3$s',
                        is_ssl() ? 'https://' : 'http://',
                        $field_output,
                        bp_signup_get_subdomain_base()
                    );
 
                // Subfolders!
                } else {
                    printf(
                        '%1$s %2$s',
                        home_url( '/' ),
                        $field_output  // Constructed safely above.
                    );
                }
 
            // It's a radio, let's output the field inside the label
            } else {
                // $label_output and $field_output are constructed safely above.
                printf( $label_output, esc_attr( $name ), $field_output . ' ' . esc_html( $label ) );
            }
        }
    }
 
    /**
     * Fires and displays any extra member registration details fields.
     *
     * This is a variable hook that depends on the current section.
     *
     * @since 1.9.0
     */
    do_action( "bp_{$section}_fields" ); 
    
}

function bpcodex_rename_profile_tabs() {
    // Change "Activity" to "Dashboard"
    buddypress()->members->nav->edit_nav( array( 'name' => __( 'Profile', 'textdomain' ) ), 'activity' );
}
add_action( 'bp_actions', 'bpcodex_rename_profile_tabs' );


function custom_bp_get_blog_avatar( $args = '' ) {
    global $blogs_template;
 
    // Bail if avatars are turned off
    // @todo Should we maybe still filter this?
    if ( ! buddypress()->avatar->show_avatars ) {
        return false;
    }
 
    $author_displayname = bp_core_get_user_displayname( $blogs_template->blog->admin_user_id );
 
    // Parse the arguments.
    $r = bp_parse_args( $args, array(
        'type'    => 'full',
        'width'   => false,
        'height'  => false,
        'class'   => 'avatar',
        'id'      => false,
        'alt'     => sprintf( __( 'Profile photo of site author %s', 'buddyboss' ), esc_attr( $author_displayname ) ),
        'no_grav' => true,
    ) );
 
    // Use site icon if available.
    $avatar = '';
    if ( bp_is_active( 'blogs', 'site-icon' ) && function_exists( 'has_site_icon' ) ) {
        $site_icon = bp_blogs_get_blogmeta( bp_get_blog_id(), "site_icon_url_{$r['type']}" );
 
        // Never attempted to fetch site icon before; do it now!
        if ( '' === $site_icon ) {
            switch_to_blog( bp_get_blog_id() );
 
            // Fetch the other size first.
            if ( 'full' === $r['type'] ) {
                $size      = bp_core_avatar_thumb_width();
                $save_size = 'thumb';
            } else {
                $size      = bp_core_avatar_full_width();
                $save_size = 'full';
            }
 
            $site_icon = get_site_icon_url( $size );
            // Empty site icons get saved as integer 0.
            if ( empty( $site_icon ) ) {
                $site_icon = 0;
            }
 
            // Sync site icon for other size to blogmeta.
            bp_blogs_update_blogmeta( bp_get_blog_id(), "site_icon_url_{$save_size}", $site_icon );
 
            // Now, fetch the size we want.
            if ( 0 !== $site_icon ) {
                $size      = 'full' === $r['type'] ? bp_core_avatar_full_width() : bp_core_avatar_thumb_width();
                $site_icon = get_site_icon_url( $size );
            }
 
            // Sync site icon to blogmeta.
            bp_blogs_update_blogmeta( bp_get_blog_id(), "site_icon_url_{$r['type']}", $site_icon );
 
            restore_current_blog();
        }
 
        // We have a site icon.
        if ( ! is_numeric( $site_icon ) ) {
            if ( empty( $r['width'] ) && ! isset( $size ) ) {
                $size = 'full' === $r['type'] ? bp_core_avatar_full_width() : bp_core_avatar_thumb_width();
            } else {
                $size = (int) $r['width'];
            }
 
            $avatar = sprintf( '<img src="%1$s" class="%2$s" width="%3$s" height="%3$s" alt="%4$s" />',
                esc_url( $site_icon ),
                esc_attr( "{$r['class']} avatar-{$size}" ),
                esc_attr( $size ),
                sprintf( esc_attr__( 'Site icon for %s', 'buddyboss' ), bp_get_blog_name() )
            );
        }
    }
 
    // Fallback to user ID avatar.
    if ( '' === $avatar ) {
        $avatar = 
        '<img src="'.get_avatar_url($blogs_template->blog->admin_user_id, array(
            "size" => "250",
            "default" => "monsterid", 
            )).'" alt="Profile photo of site author">';
        
    }
 
    /**
     * In future BuddyPress versions you will be able to set the avatar for a blog.
     * Right now you can use a filter with the ID of the blog to change it if you wish.
     * By default it will return the avatar for the primary blog admin.
     *
     * This filter is deprecated as of BuddyPress 1.5 and may be removed in a future version.
     * Use the 'bp_get_blog_avatar' filter instead.
     */
    $avatar = apply_filters( 'bp_get_blog_avatar_' . $blogs_template->blog->blog_id, $avatar );
 
    /**
     * Filters a blog's avatar.
     *
     * @since BuddyPress 1.5.0
     *
     * @param string $avatar  Formatted HTML <img> element, or raw avatar
     *                        URL based on $html arg.
     * @param int    $blog_id ID of the blog whose avatar is being displayed.
     * @param array  $r       Array of arguments used when fetching avatar.
     */
    return apply_filters( 'bp_get_blog_avatar', $avatar, $blogs_template->blog->blog_id, $r );
}

//Helper

function get_post_by_name($post_name, $output = OBJECT) {
    global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type='post'", $post_name ));
        if ( $post ) {
            return get_post($post, $output);
		} else {
    return null;
		}
}

//Post Syndication 

// Set Post content based on custom field
function set_post_content($post_id) {
    $publication = get_post($post_id);
	$cpt_types = array('poetry', 'fiction', 'non-fiction');
	if (in_array($publication->post_type, $cpt_types) ) {
	$post_content = get_field('writing', $post_id);
	
	if ($publication->post_type == 'poetry') {
		$publication_category = 1;
	} else if ($publication->post_type == 'fiction') {
		$publication_category = 38;
	} else if ($publication->post_type == 'non-fiction') {
		$publication_category = 39;
	}
		$update_args = array(
				    'ID' => $post_id,
      'post_content' => $post_content,
				    );
		// unhook this function so it doesn't loop infinitely
        remove_action( 'save_post', 'set_post_content' );
 
        // update the post, which calls save_post again
        wp_update_post( $update_args );
		
		$parent_blog_id = get_current_blog_id();
		
		$DOI = '0'.$parent_blog_id.'0'.$post_id.'0';
		
		$new_postarr = array(
                
 				'post_content' => $post_content, 
				'post_author' => get_current_user_id(),
 				'post_title' => get_the_title($post_id), 
 				'post_excerpt' => get_the_excerpt($post_id), 
 				'post_status' => get_post_status($post_id), 
 				'comment_status' => $publication->comment_status, 
 				'post_name' => $DOI, 
 				'guid' => get_the_permalink($post_id), 
 				'post_category' => array($publication_category),
 				'meta_input' => array(
 					'parent_site'=> get_bloginfo( 'name' ), 
 					'parent_post_id'=>$post_id, 
 					'parent_site_ID' => get_current_blog_id(), 
 					'parent_permalink' => get_the_permalink($post_id),
 					),
 				);
		
		switch_to_blog(1);
		$post_name = get_post_by_name($DOI);
		$post_name_2 = get_post_by_name($DOI.'-2');
		if ( $post_name  != null ) {
 			 $new_postarr['ID'] = $post_name->ID;
		} elseif ( $post_name_2 != null ) {
			$new_postarr['ID'] = $post_name_2->ID;
		}
		
   		wp_insert_post ($new_postarr, true); // 

		
 		
		restore_current_blog(); 	
	
        // re-hook this function
        add_action( 'save_post', 'set_post_content' );
	}
}

add_action( 'save_post', 'set_post_content' );


//Comment Syndication 

function syndicate_root_comment( $id, $comment) {
    
    $site_id = get_current_blog_id();
    
    if ($site_id != 1) {
    
        $post_name = '0'.$site_id.'0'.$comment->comment_post_ID.'0';
        
        $comment_args =  array ( 
            'meta_query' => array (
                
                array (
                    
                    'key' => 'syndicated_id',
                    'value' => $id,
                    
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
            
            if ($comment->comment_parent != '') {
            
                $parent_args =  array ( 
                    'meta_query' => array (
                        
                        array (
                            
                            'key' => 'syndicated_id',
                            'value' => $comment->comment_parent,
                            
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
            
                'comment_author' => $comment->comment_author,
            'comment_author_email' =>  $comment->comment_author_email,
            'comment_author_url' =>  $comment->comment_author_url,
            'comment_content' =>  $comment->comment_content,
            'comment_date' => $comment->comment_date,
            'comment_date_gmt' => $comment->comment_date_gmt,
            //'comment_type' => $comment->comment_content,
                'comment_parent' => $synced_comment_parent,
                'comment_post_ID' => $post_id, 
                'user_id' => $comment->user_id,
                'comment_agent' =>  $comment->comment_agent,
                'comment_author_IP' =>  $comment->comment_author_IP,
                'comment_meta' => array (
                    
                            'syndicated_id' => $id,
                            'syndicated_site' => $site_id,
        
                    ),
            
            );
            
            remove_action ('wp_insert_comment', 'syndicate_comment', 10, 2); 
            
            wp_new_comment ($new_commentdata);
            
            add_action('wp_insert_comment', 'syndicate_comment', 10, 2); 
        }
        
        restore_current_blog();
    }
    
}
add_action('wp_insert_comment', 'syndicate_root_comment', 10, 2); 

function syndicate_comment( $comment_ID, $comment_approved, $commentdata) {
    
    if ($commentdata['comment_meta'][0]['syndicated_id'] != '') {
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
    
}
add_action('comment_post', 'syndicate_comment', 11, 3); 

?>