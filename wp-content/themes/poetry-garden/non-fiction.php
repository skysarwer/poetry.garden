<?php
/*
* Template Name: Non-Fiction
*/

get_header();
if ( have_posts() ) : while ( have_posts() ) : the_post();
the_content();
endwhile; endif;

view_posts('non-fiction');
poetry_garden_svg();
get_footer();
?>