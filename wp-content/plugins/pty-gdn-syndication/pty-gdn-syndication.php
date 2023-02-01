<?php
/**
 * Plugin Name:       Poetry Garden Syndication
 * Description:       Handles syndication of Posts between root site and child sites
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Evan Buckiewicz
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pty-gdn-syndication
 * */


 /** This plugin is not intended as a standalone plugin. 
  *  It provides functionality designed for a bespoke Multisite system and is not built to be used outside the Poetry Garden network.
  *  The purpose of this plugin is to syndicate publications and comments between the Root site and child sites.  
  */


 //Helper Function
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

//Syndicate Publications (Based on three CPTs, Poetry, Fiction and Non-Fiction) as Posts on Root site, with CPTs mapped as Categories
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


/**
 * 
 * Comment Syndication 
 *
**/

// Syndicate comments from child sites to root site
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

// Syndicate comments from root site to child site
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
