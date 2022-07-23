<?php // POST TYPE REGISTRATIONS

function cptui_register_my_cpts() {

	/**
	 * Post Type: Poems.
	 */
	 global $post;

	$labels = [
		"name" => __( "Poems", "custom-post-type-ui" ),
		"singular_name" => __( "Poem", "custom-post-type-ui" ),
		"menu_name" => __( "Poetry", "custom-post-type-ui" ),
		"all_items" => __( "View Poems", "custom-post-type-ui" ),
		"add_new" => __( "Add New", "custom-post-type-ui" ),
		 'bp_activity_admin_filter' => __( 'New poem published', 'custom-post-type-ui' ),
            'bp_activity_front_filter' => __( 'Poetry', 'custom-post-type-ui' ),
            'bp_activity_new_post'     => __( '%1$s published a new poem', 'custom-post-type-ui' ),
            'bp_activity_new_post_ms'  => __( '%1$s published a new poem, in %3$s', 'custom-post-type-ui' ),
            'bp_activity_new_comment'           => __( '%1$s commented on a poem', 'custom-textdomain' ),
    'bp_activity_new_comment_ms'        => __( '%1$s commented on a poem, from the site %3$s', 'custom-textdomain' ),
	];

	$args = [
		"label" => __( "Poems", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "poetry", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 1,
		"supports" => [ "title", "editor", "thumbnail", "comments", "buddypress-activity" ],
		'bp_activity' => array(
        'comment_action_id' => 'new_poetry_comment',             // The activity type for comments
    ),
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "poetry", $args );

	/**
	 * Post Type: Fiction.
	 */

	$labels = [
		"name" => __( "Fiction", "custom-post-type-ui" ),
		"singular_name" => __( "Story", "custom-post-type-ui" ),
		"menu_name" => __( "Fiction", "custom-post-type-ui" ),
		"all_items" => __( "View Fiction", "custom-post-type-ui" ),
		 'bp_activity_admin_filter' => __( 'New fiction piece published', 'custom-post-type-ui' ),
            'bp_activity_front_filter' => __( 'Fiction', 'custom-post-type-ui' ),
            'bp_activity_new_post'     => __( '%1$s published a new fiction piece', 'custom-post-type-ui' ),
            'bp_activity_new_post_ms'  => __( '%1$s published a new fiction piece, in %3$s', 'custom-post-type-ui'),
             'bp_activity_new_comment'           => __( '%1$s commented on a fiction piece', 'custom-textdomain' ),
    'bp_activity_new_comment_ms'        => __( '%1$s commented on a fiction piece, from the site %3$s', 'custom-textdomain' ),
	];

	$args = [
		"label" => __( "Fiction", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "fiction", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 1,
		"supports" => [ "title", "editor", "thumbnail", "comments", "buddypress-activity"],
		'bp_activity' => array(
            'comment_action_id' => 'new_fiction_comment',             // The activity type for comments
            ),
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "fiction", $args );

	/**
	 * Post Type: Non-Fiction.
	 */

	$labels = [
		"name" => __( "Non-Fiction", "custom-post-type-ui" ),
		"singular_name" => __( "Post", "custom-post-type-ui" ),
		"menu_name" => __( "Non-Fiction", "custom-post-type-ui" ),
		"all_items" => __( "View Non-Fiction", "custom-post-type-ui" ),
		"add_new" => __( "Add new", "custom-post-type-ui" ),
		"add_new_item" => __( "Add new Post", "custom-post-type-ui" ),
		"edit_item" => __( "Edit Post", "custom-post-type-ui" ),
		"new_item" => __( "New Post", "custom-post-type-ui" ),
		"view_item" => __( "View Post", "custom-post-type-ui" ),
		"view_items" => __( "View Non-Fiction", "custom-post-type-ui" ),
		"search_items" => __( "Search Non-Fiction", "custom-post-type-ui" ),
		"not_found" => __( "No Non-Fiction found", "custom-post-type-ui" ),
		"not_found_in_trash" => __( "No Non-Fiction found in trash", "custom-post-type-ui" ),
		"parent" => __( "Parent Post:", "custom-post-type-ui" ),
		"featured_image" => __( "Featured image for this Post", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set featured image for this Post", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove featured image for this Post", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use as featured image for this Post", "custom-post-type-ui" ),
		"archives" => __( "Post archives", "custom-post-type-ui" ),
		"insert_into_item" => __( "Insert into Post", "custom-post-type-ui" ),
		"uploaded_to_this_item" => __( "Upload to this Post", "custom-post-type-ui" ),
		"filter_items_list" => __( "Filter Non-Fiction list", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Non-Fiction list navigation", "custom-post-type-ui" ),
		"items_list" => __( "Non-Fiction list", "custom-post-type-ui" ),
		"attributes" => __( "Non-Fiction attributes", "custom-post-type-ui" ),
		"name_admin_bar" => __( "Post", "custom-post-type-ui" ),
		"item_published" => __( "Post published", "custom-post-type-ui" ),
		"item_published_privately" => __( "Post published privately.", "custom-post-type-ui" ),
		"item_reverted_to_draft" => __( "Post reverted to draft.", "custom-post-type-ui" ),
		"item_scheduled" => __( "Post scheduled", "custom-post-type-ui" ),
		"item_updated" => __( "Post updated.", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Parent Post:", "custom-post-type-ui" ),
		 'bp_activity_admin_filter' => __( 'New non-fiction piece published', 'custom-post-type-ui' ),
            'bp_activity_front_filter' => __( 'Non-Fiction', 'custom-post-type-ui' ),
            'bp_activity_new_post'     => __( '%1$s published a newnon-fiction piece', 'custom-post-type-ui' ),
            'bp_activity_new_post_ms'  => __( '%1$s published a new non-fiction piece, in %3$s', 'custom-post-type-ui'),
             'bp_activity_new_comment'           => __( '%1$s commented on a non-fiction piece', 'custom-textdomain' ),
    'bp_activity_new_comment_ms'        => __( '%1$s commented on a non-fiction piece, from the site %3$s', 'custom-textdomain' ),
	];

	$args = [
		"label" => __( "Non-Fiction", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "non-fiction", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 1,
		"supports" => [ "title", "editor", "thumbnail", "comments", "buddypress-activity" ],
		'bp_activity' => array(
            'comment_action_id' => 'new_non-fiction_comment',             // The activity type for comments
            ),
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "non-fiction", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Collections.
	 */

	$labels = [
		"name" => __( "Collections", "custom-post-type-ui" ),
		"singular_name" => __( "Collection", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Collections", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'poetry_collection', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "poetry_collection",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
			];
	register_taxonomy( "poetry_collection", [ "poem" ], $args );

	/**
	 * Taxonomy: Collections.
	 */

	$labels = [
		"name" => __( "Collections", "custom-post-type-ui" ),
		"singular_name" => __( "Collection", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Collections", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'fiction_collection', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "fiction_collection",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
			];
	register_taxonomy( "fiction_collection", [ "fiction" ], $args );

	/**
	 * Taxonomy: Collections.
	 */

	$labels = [
		"name" => __( "Collections", "custom-post-type-ui" ),
		"singular_name" => __( "Collection", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Collections", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'non_fiction_collections', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "non_fiction_collections",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
			];
	register_taxonomy( "non_fiction_collections", [ "non-fiction" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );?>