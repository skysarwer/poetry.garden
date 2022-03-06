<?php 

function community_nav($active='') {
?>
    <input type="checkbox" id="community-nav-input" class="modal-input" checked>
    <aside class="community-nav">
        <ul class="outer">
		<li>
		 <a class="flex align-center" href="<?php echo site_url(); ?>/community">
		 <?php svg_render(sites_svg(), 'scale');?>
		 <p>Overview</p></a>
		        
		</li>
		
		<li>
		 <a class="flex align-center" href="<?php echo site_url(); ?>/community/publications">
		 <?php svg_render(publications_svg());?>
		 <p>Publications</p></a>
		        
		</li>
		        
		<li><a class="flex align-center" href="<?php echo site_url(); ?>/community/sites"><?php svg_render(get_field('svg', 208));?><p>Sites</p></a>
		</li>
		
		<?php 
		
		if (isset($_GET['dev'])) { ?>
		    
	        <li><a class="flex align-center" href="<?php echo site_url(); ?>/community/groups"><?php svg_render(cbox_svg());?><p>Groups</p></a>
		    </li>
		<?php } ?>
		
		<li><a class="flex align-center" href="<?php echo site_url(); ?>/community/forums"><?php svg_render(forums_svg());?><p>Forums</p></a>
		</li>
		        
		<li><a class="flex align-center" href="<?php echo site_url(); ?>/community/members"><?php svg_render(members_svg());?><p>Members</p></a>  
		</li>
		</ul>   
    </aside>    
<?php
}

function account_nav() {
  ?>
    <aside class="account-nav">
        <ul class="outer">
		<li>
		 <a class="underline" href="<?php echo site_url(); ?>/community/members/me/profile/edit">
		 <p>Edit Profile</p></a>
		        <ul>
		            
		            <li>
		                <a href="<?php echo site_url(); ?>/community/members/me/profile/edit"><p>General Settings</p></a>
		            </li>
		            
		            <li>
		                <a href="<?php echo site_url(); ?>/community/members/me/profile/edit/group/3"><p>Media Profiles</p></a>
		            </li>
		            
		            <li>
		                <a href="<?php echo site_url(); ?>/community/members/me/profile/change-avatar/"><p>Change Profile Picture</p></a>
		            </li>
		            
		            <li>
		                <a href="<?php echo site_url(); ?>/community/members/me/profile/change-cover-image/"><p>Change Cover Image</p></a>
		            </li>
		        </ul>
		</li>
		
		<li>
		 <a class="underline" href="<?php echo site_url(); ?>/community/members/me/settings">
		    <p>Account Settings</p></a>
		    <ul>
                <li><a href="<?php echo site_url(); ?>/community/members/me/settings/"><p>Email and Password</p></a></li>
                <li><a href="<?php echo site_url(); ?>/community/members/me/settings/notifications"><p>Notifications</p></a></li>
                <li><a href="<?php echo site_url(); ?>/community/members/me/settings/data"><p>Export Data</p></a></li>
                <li><a href="<?php echo site_url(); ?>/community/members/me/settings/delete-account"><p>Delete Account</p></a></li>
                
		    </ul>
		</li>
		        
		</ul>   
    </aside>    
<?php  
}

function publications_header() {
	echo '<nav class="forum-header flex gap-2 mb-1">';
	
    echo '<li class="list-title"><a class="flex align-center" href="'. (is_author() && $_GET['filterby'] != 'poetry' ? '?filterby=' : '/').'poetry">'; svg_render(poetry_svg()); echo 'Poetry </a>';
    
    echo '<li class="list-title"><a class="flex align-center" href="'. (is_author() && $_GET['filterby'] != 'fiction' ? '?filterby=' : '/').'fiction">'; svg_render(publications_svg()); echo 'Fiction </a>';
    
    echo '<li class="list-title"><a class="flex align-center" href="'. (is_author() && $_GET['filterby'] != 'non-fiction' ? '?filterby=' : '/').'non-fiction">'; svg_render(non_fiction_svg()); echo 'Non-Fiction </a>';
    
    echo '</ul></li>';

	echo '</nav>';
}

function forum_header() {
    $forum_loop = new wp_query(array('post_type' => 'forum', 'post_parent' => 0, 'order' => 'asc'));
	echo '<nav class="forum-header flex gap-2 mb-1">';
	while ( $forum_loop->have_posts() ) {
    $forum_loop->the_post();
    global $post;
    $child_forums = new wp_query(array('post_type' => 'forum', 'post_parent' => get_the_ID(), 'order' => 'asc'));
     $parent_name = $post->post_name;
    echo '<li class="list-title"><a class="flex align-center" href="'.site_url().'/community/forum/'.$parent_name.'">'; svg_render(get_field('svg')); echo get_the_title() . '</a><ul class="submenu absolute">';
        while ($child_forums->have_posts()) {
            $child_forums->the_post();
            echo '<li class="list-title"><a class="flex align-center" href="'.site_url().'/community/forum/'.$parent_name.'/'.$post->post_name.'">'; svg_render(get_field('svg')); echo get_the_title() . '</a></li>';
        }
        wp_reset_query();
    echo '</ul></li>';
}
	echo '</nav>';
}

function publication_query( $query ) {
    if ( is_archive( 'post' ) || is_home() ) {
        $query->set( 'posts_per_page', 12 );
    }
    
    if ( is_author() && isset($_GET['filterby']) ) {
        $query->set ( 'category_name', $_GET['filterby'] );
    }
    
    
}
add_filter( 'pre_get_posts', 'publication_query' );

function svg_render($g, $class = '', $size= '8.4666mm') {
    
    echo '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="'.$size.'" height="'.$size.'" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 847 847"
 xmlns:xlink="http://www.w3.org/1999/xlink">'.$g.'</svg>'; 
}

function mp_svg_render ($g, $class='') {
     echo '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="6.3498mm" height="6.3498mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 635 635"
 xmlns:xlink="http://www.w3.org/1999/xlink">'.$g.'</svg>'; 
}

?>