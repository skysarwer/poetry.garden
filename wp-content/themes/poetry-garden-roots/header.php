<?php
/**
 * The template for displaying the header.
 *
 * @package Poetry Garden
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body>
<?php

	       if(is_user_logged_in()) {
			        global $userlogin;
			        $userlogin = true;
			         global $registered_site;
			         $registered_site = array();
			         $user_blogs = get_blogs_of_user(get_current_user_id());
			      	foreach ($user_blogs as $site) {
		    //echo '<p>'.$site->userblog_id.'</p>';
		    if (current_user_can_for_blog( $site->userblog_id, 'edit_posts' )) {
		        array_push($registered_site, $site);
		        } 
		}}

$unread_message_count = messages_get_unread_count( get_current_user_id() );


     //$unread_message_count++;
 


?>
	<div id="page-cont">
	      <span>
	      <input type="checkbox" class="modal-input" id="header-login" <?php if(isset($_POST['username']) || isset($_POST['password'])) {echo 'checked';} ?>>
	      <div class="modal flex align-center justify-center"> <label class="modal-trigger" for ="header-login"><div class="background"></div></label>
<div class="login-modal" onclick="event.stopPropagation();">

<div class="flex align-center justify-space-between"><h1>Login </h1><label class="modal-trigger" for ="header-login"><div class="x">+</div></label>
</div>
			<?php echo do_shortcode('[user_registration_my_account]');?></div>
</div>
	      </span>
	      <span>
	          <input type="checkbox" class="modal-input" id="header-chat" <?php if (isset($_GET['new-message'])) {
	              echo 'checked';
	          } ?>>
	          <div class="pageflap chat right">
	              <div class="flex justify-space-between align-center flaphead"><h3>Chat</h3><label for ="header-chat"><div class="x">+</div></label></div>
	              <?php echo BP_Better_Messages()->functions->get_page(); ?>
	          </div>
	      </span>
	      
	      <span>
	          <input type="checkbox" class="modal-input" id="header-account">
	          <div class="pageflap account right">
	              <div class="flex justify-space-between align-start flaphead">
	                
	                      <div class="flex flex-grow gap-5"><a href="<?php echo site_url()?>/community/members/me">
	                        <?php echo get_avatar(get_current_user_id(), 75); ?></a><a class="wt" href="<?php echo site_url()?>/community/members/me">
	                        <h3>Welcome, <?php echo get_userdata(get_current_user_id())->user_firstname;?></h3>
	                        </a></div>
	                      <label for ="header-account" class="line-height-1">
	                      
	                       <div class="x">+</div>
	                       </label>
	                       </div>
	              <div class="flapbody">
	                  <br/>
	                <p class="ml-2"><a href="<?php echo site_url();?>/community/members/me/profile/edit">Edit Profile</a></p>
	              <p class="ml-2"><a href="<?php echo site_url();?>/community/members/me/settings">Account Settings</a></p>
	              <?php if (count($registered_site) < 3 ) { ?> 
	                <p class="ml-2"><a href="<?php echo site_url();?>/register-site">Create a Site</a> </p> 
	                <?php }
	              if (count($registered_site) > 0) {
	               echo '<h4>Your Sites</h4>'; 
	               foreach ($registered_site as $site) {
	                   echo '<p class="ml-2">'.$site->blogname.'<div class="flex justify-space-between sitenav"><a href="'.$site->siteurl.'" target="_blank">Visit Site</a><a href="'.$site->siteurl.'/wp-admin/admin.php?page=site_details" target="_blank">Site Admin</a></div></p>';
	               }
	              }?>
	              <?php if ( is_active_sidebar( 'notifications' ) ) : ?>
    <div>
    <?php //dynamic_sidebar( 'notifications' ); ?>
    </div>
<?php endif; ?>
	              
	              </div>
	          </div>
	      </span>
	      
		<div id="header">
			<span class="flex justify-center"><a class="flex justify-center full-width home" href="<?php echo site_url();?>"><img class="header_icon" src="/img/poetry_garden_icon.png"><h3>
				Poetry Garden
				</h3></a>
			</span>
			<div class="lower-menu">
			    <?php if(is_user_logged_in()) {
		
		if (count($registered_site) > 1) {
			               echo '<a href="'.site_url().'/community/members/me/blogs">Your Sites </a> ';
			         } else if (!empty($registered_site)) {
			             echo '<a href="'.$registered_site[0]->siteurl.'" target="blank" title="'.$registered_site[0]->siteurl.'">Your Site </a> ';
			         } 
		 if (empty($registered_site)) {
		            echo '<a href="'.site_url().'/register-site">Register Site    </a>';
		        }
		?><a href="<?php echo wp_logout_url( get_permalink() ); ?>">Logout</a> 
			      <?php } else {
			      ?> <label role="button" tabindex=0 class="modal-trigger" for="header-login">Login</label>
				<a href="<?php echo site_url()?>/register">Register</a> <?php
			      }?>
				<span>|</span>
				<a href="#"  title="Coming Soon">Blog</a>
					<li class="list-title relative"><a href="/community">Community</a><ul class="submenu absolute">
					    	<li class="list-title"><a href="/community/publications">Publications</a></li><br/>		
					    	<li class="list-title"><a href="/community/sites">Sites</a></li><br/>
					    	<li class="list-title"> <a href="/community/forums">Forums</a></li><br/>
					     	<li class="list-title"> <a href="/community/members">Members</a></li><br/>
					</ul></li>
			</div>
		
		
	
	

		</div>
			<div class="sticky bar flex">
			    <div class="icons flex">
			        <?php 
			        global $uri_segments;
			        if ($uri_segments[1] == 'community' && $uri_segments[4] != 'profile' && $uri_segments[4] != 'settings' || is_archive('post')) {
			            echo '<label for="community-nav-input" class="nav-label flex column justify-space-between">
			            <div class="bar"></div>
			            <div class="bar"></div>
			            <div class="bar"></div>
			            </label>';
			        }
			        ?>
			        
			    </div>
			     <?php get_search_form(); ?>
			   
			    <div class="icons flex justify-end">
			        <?php  if(is_user_logged_in()) { ?>
			        	    <?php  //echo do_shortcode('[buddy_notification_bell]'); ?>
			        <label for="header-chat" <?php if ($unread_message_count > 0) { echo 'class="active"';} ?>>
			            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="5.0798mm" height="5.0798mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 508 508"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <defs>
  <style type="text/css">
   <![CDATA[
    .str0hs {stroke:#373435;stroke-width:32;}
    .fil0hs {fill:var(--bg-color);}
   ]]>
  </style>
 </defs>
 <g id="Layer_x0020_1">
  <metadata id="CorelCorpID_0Corel-Layer"/>
  <path class="fil0hs str0hs" d="M494 80l0 242c0,22 -3,35 -23,46 -17,10 -71,6 -93,6l-1 103 -88 -80c-31,-28 -19,-23 -61,-23l-168 0c-14,0 -26,-6 -34,-14 -11,-13 -9,-27 -9,-47l0 -203c0,-25 -3,-43 11,-60 18,-22 58,-16 96,-16l293 0c31,0 55,-5 72,20 6,10 5,12 5,26z"/>
 </g>
</svg>
<?php if ($unread_message_count > 0) { echo '<span class="count">'.$unread_message_count.''; } ?>
			        </label>
			        
			         <label for="header-account">
			             <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="5.0798mm" height="5.0798mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 508 508"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <defs>
  <style type="text/css">
   <![CDATA[
    .fil0hs {fill:var(--bg-color);}
    .fil1hs {fill:black;fill-rule:nonzero}
   ]]>
  </style>
 </defs>
 <g id="_309239584">
   <path id="_1" class="fil1hs" d="M446 444l0 45 0 0 -7 0 -8 0 -8 0 -11 0 -12 0 -12 0 -14 0 -14 0 -16 0 -16 0 -16 1 -17 0 -16 0 -18 0 -17 0 -17 0 -18 0 -17 0 -16 0 -17 0 -15 0 -15 0 -14 0 -13 0 -13 0 -11 -1 -11 0 -8 0 -8 0 -6 -1 -5 0 -5 0 8 -45 0 0 4 1 6 0 6 0 9 0 10 1 11 0 13 0 13 0 14 0 15 0 15 0 17 0 16 0 17 0 17 0 18 0 17 0 17 0 17 0 17 0 16 0 16 0 15 -1 15 0 14 0 12 0 12 0 10 0 9 0 8 0 7 0 0 0 0 0zm12 0l6 45 -3 0 -1 0 -1 0 0 0 -1 0 0 0 0 0 -1 0 -1 0 0 0 -1 0 0 0 0 0 -1 0 0 0 -1 0 0 0 0 0 -1 0 0 0 -1 0 -1 0 0 0 0 0 -1 0 0 0 -1 0 0 0 -1 0 0 0 0 0 -1 0 0 0 0 -45 0 0 1 0 0 0 0 0 1 0 0 0 1 0 1 0 0 0 0 0 1 0 0 0 1 0 1 0 0 0 0 0 1 0 0 0 1 0 0 0 0 0 0 0 1 0 1 0 1 0 0 0 0 0 0 0 1 0 1 0 0 0 1 0 -3 0zm6 45l-2 0 -1 0 3 0zm13 -2l-13 2 -6 -45 13 -2 24 29 -18 16 0 0zm18 -16l-4 14 -14 2 18 -16zm-54 -106l42 -18 0 0 1 3 1 3 1 4 1 3 1 3 1 3 1 4 1 4 1 3 1 5 0 3 1 5 1 3 1 5 0 4 0 4 1 4 1 5 0 4 1 4 0 4 0 4 0 5 0 3 0 5 0 4 0 4 -1 4 0 3 -1 5 -1 3 -1 4 -43 -12 0 -2 1 -1 0 -3 0 -2 0 -3 0 -3 0 -3 1 -3 -1 -2 0 -4 0 -4 0 -3 0 -3 0 -4 -1 -4 0 -3 -1 -4 0 -4 -1 -3 0 -4 -1 -3 -1 -3 -1 -3 0 -4 -1 -3 -1 -3 0 -3 -1 -2 -1 -3 -1 -2 0 -2 -1 -1 0 0 0 0zm-47 -56l22 -39 0 0 3 1 3 3 2 1 3 1 3 3 2 2 3 1 2 3 2 2 3 2 3 2 2 2 2 2 2 3 2 2 3 3 2 2 2 3 2 2 2 3 2 2 1 3 2 3 2 3 1 3 3 3 1 2 1 4 2 3 1 3 2 2 1 3 -42 18 -1 -3 -1 -2 -1 -2 -1 -3 -1 -2 -1 -2 -1 -1 -2 -3 -1 -2 -1 -2 -2 -2 -1 -2 -1 -2 -2 -1 -1 -3 -2 -1 -1 -1 -2 -3 -1 -1 -2 -2 -1 -1 -2 -1 -2 -2 -1 -1 -2 -2 -2 -1 -1 -2 -3 -1 -1 -1 -2 -1 -2 -1 -2 -2 0 0 0 0zm-96 -62l11 44 -5 -45 5 1 5 0 5 0 4 1 5 0 4 0 4 1 5 0 3 0 5 1 3 0 4 1 4 1 3 0 4 1 4 1 3 1 3 0 3 1 3 1 3 0 4 2 3 1 2 0 3 2 3 1 3 1 2 1 3 1 2 2 3 0 2 2 -22 39 -1 0 -2 -1 -2 -1 -1 -1 -3 0 -1 -2 -2 0 -2 -1 -3 -1 -2 -1 -2 0 -2 0 -2 -1 -3 -1 -3 -1 -2 0 -3 -1 -3 0 -3 -1 -2 -1 -3 0 -4 0 -4 0 -3 -1 -3 0 -5 -1 -3 0 -5 0 -3 0 -5 0 -4 -1 -5 0 -5 -45zm5 45l-179 -5 174 -40 5 45zm44 -149l45 -5 0 0 1 6 1 7 0 6 1 7 0 6 -1 6 0 6 -1 7 0 6 -1 5 -2 6 -1 6 -1 6 -3 6 -2 5 -2 6 -3 5 -3 4 -3 5 -3 6 -4 4 -4 4 -4 4 -5 4 -5 3 -4 4 -6 3 -5 2 -6 3 -5 2 -7 2 -5 1 -11 -44 5 0 3 -2 3 -1 4 -1 3 -2 3 -2 3 -1 2 -2 2 -3 3 -2 2 -2 2 -3 2 -2 2 -3 2 -3 1 -3 1 -4 2 -3 1 -4 1 -4 2 -3 0 -5 1 -4 1 -4 0 -5 1 -4 0 -5 0 -5 -1 -5 0 -6 -1 -5 -1 -6 0 0 0 0zm-103 -76l-8 -45 0 0 8 -1 8 0 7 0 7 0 7 0 7 2 7 1 7 2 7 2 5 2 7 2 6 4 6 3 6 4 5 3 6 4 4 4 5 5 4 5 5 4 4 5 4 5 3 6 4 5 3 6 3 5 3 6 2 7 2 6 2 5 1 7 1 7 -45 5 0 -3 -1 -5 -2 -3 0 -5 -2 -3 -2 -4 -1 -4 -3 -4 -2 -4 -3 -3 -3 -4 -2 -3 -3 -4 -3 -2 -3 -3 -4 -3 -4 -3 -3 -2 -4 -3 -4 -3 -4 -1 -4 -2 -4 -2 -4 -1 -5 -1 -4 -1 -5 0 -5 -1 -5 0 -4 0 -5 0 -5 1 0 0 0 0zm-79 106l-44 7 0 0 -2 -8 0 -7 0 -8 0 -8 0 -7 1 -7 1 -7 2 -7 2 -7 2 -6 3 -6 3 -7 4 -6 3 -6 4 -5 4 -5 4 -5 5 -5 5 -4 4 -5 5 -3 5 -5 6 -3 6 -3 5 -3 6 -3 7 -3 5 -2 6 -3 7 -1 6 -1 6 -2 8 45 -5 1 -4 1 -5 1 -4 1 -4 2 -4 2 -4 2 -4 2 -4 2 -3 2 -4 3 -4 3 -3 2 -3 4 -3 3 -3 4 -2 3 -3 3 -2 4 -3 4 -2 4 -1 4 -2 5 -1 4 -1 5 -1 4 0 5 -1 4 0 6 0 5 1 6 0 5 0 0 0 0zm49 120l-1 -45 -5 45 -5 -2 -5 -1 -5 -2 -5 -2 -4 -2 -5 -2 -4 -3 -5 -3 -3 -3 -4 -3 -4 -3 -3 -4 -3 -3 -3 -4 -3 -4 -3 -3 -2 -5 -2 -3 -2 -5 -3 -3 -2 -5 -1 -4 -2 -5 -1 -4 -2 -4 -1 -5 -1 -4 -1 -5 -1 -4 -1 -4 -1 -5 0 -4 44 -7 1 3 0 5 1 3 1 3 1 4 1 4 0 3 2 3 1 3 1 4 1 3 1 3 2 2 1 3 2 2 1 3 2 2 1 2 2 2 2 2 2 2 1 2 3 2 2 1 2 2 2 1 3 2 2 0 3 2 3 0 3 2 4 1 -5 44 0 0zm5 -44l172 39 -177 5 5 -44 0 0zm-101 60l-22 -40 0 0 2 -1 3 -2 2 -1 3 -1 2 -1 3 -1 3 -1 3 -1 3 -1 3 -1 3 -1 4 0 2 -1 4 -1 4 0 3 -1 3 0 4 -1 4 -1 4 0 4 0 4 -1 4 0 5 -1 4 -1 5 0 4 0 5 0 5 0 5 0 5 -1 5 0 1 45 -5 0 -4 0 -5 1 -5 0 -4 0 -4 1 -5 0 -3 0 -4 0 -5 1 -3 0 -3 1 -4 0 -3 1 -3 0 -3 0 -3 1 -3 1 -3 1 -2 0 -3 0 -2 1 -3 1 -2 1 -1 0 -2 0 -2 1 -2 1 -2 0 -1 1 -1 1 -1 1 0 0 0 0zm-75 134l-8 45 -18 -19 -1 -6 -1 -7 0 -7 -1 -7 0 -7 0 -7 0 -7 1 -7 0 -7 0 -7 2 -7 1 -7 1 -7 2 -7 2 -7 2 -7 2 -6 3 -7 3 -6 3 -7 4 -7 3 -5 4 -6 4 -6 5 -6 5 -6 5 -5 5 -5 6 -5 6 -4 6 -4 7 -4 22 40 -5 2 -4 3 -4 3 -4 3 -4 4 -3 3 -3 4 -4 4 -3 4 -3 5 -2 4 -3 4 -2 6 -2 5 -2 5 -2 5 -1 5 -2 5 -1 6 -2 5 0 6 -1 6 -1 5 -1 6 0 6 0 5 0 6 0 6 0 5 1 6 1 5 1 6 -19 -19 0 0zm-8 45l-16 -3 -2 -16 18 19z"/>
   <path class="fil0hs" d="M42 498c6,0 307,12 432,2 8,-28 -4,-120 -13,-143 -12,-29 -32,-53 -57,-67 -22,-11 -49,-19 -101,-20 54,-13 75,-64 66,-129 -9,-55 -63,-106 -130,-96 -58,10 -109,60 -98,132 8,44 24,83 71,94 -54,2 -88,8 -107,19 -60,32 -74,143 -63,208z"/>
  </g>
</svg>
			         </label>
			          <?php } ?>
			    </div>
			</div>
		<div id="content">