<?php 
/*
*
* Template Name: Main
*
*/

get_header();
echo '<div class="landing-cont flex justify-center"><span>
<h3 class="mt-2 landing-blurb" >Welcome to Poetry Garden, an open access digital commons, <a href="community/publications">literature repository </a> and site building platform — built for writers to take control of their publishing.</h3>
<br/><br/><br/><center>';
if(is_user_logged_in()) {
global $registered_site;
if (empty($registered_site)) {
    echo '<a href="/register-site">Create Your <br/> Free Site </a>';
}
else { 
        $site = $registered_site[0];
         echo '<a class="button fs-075" href="'.$site->siteurl.'" title="'.$site->siteurl.'" target="blank">Visit Your Site</a>';
    
}
} else {
echo '<a class="button fs-085" href="/register">Create Your Free Site </a>';
}
echo '</center>
</span></div>'.garden_SVG();
 
get_footer();
?>