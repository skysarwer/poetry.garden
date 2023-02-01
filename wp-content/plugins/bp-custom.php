<?php

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
	$post_content = get_the_content(null, false, $post_id);
	
	if ($publication->post_type == 'poetry') {
		$publication_category = 1;
	} else if ($publication->post_type == 'fiction') {
		$publication_category = 38;
	} else if ($publication->post_type == 'non-fiction') {
		$publication_category = 39;
	}
		
		// unhook this function so it doesn't loop infinitely
        remove_action( 'save_post', 'set_post_content' );
		
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