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
?>