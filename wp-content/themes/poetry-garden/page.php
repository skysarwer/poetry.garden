<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$post=get_post();
if ($post->ID== '1'){
	get_template_part('home');
} elseif ($post->ID == '2'){
	get_template_part('poetry');
}elseif ($post->ID == '3') {
	get_template_part('fiction');
} elseif ($post->ID == '4') {
	get_template_part('non-fiction');
} else {

get_header(); 

			if ( generate_has_default_loop() ) {
				while ( have_posts() ) :

					the_post();

					generate_do_template_part( 'page' );

				endwhile;
			}	
		poetry_garden_svg();
	get_footer();
}