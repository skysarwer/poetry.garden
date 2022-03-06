<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
		    <!-- Index template --> 
		     <div class="flex gap-1 mr-1">
            <?php community_nav();?>

			<div class="full-width ml-1">
			    <?php publications_header(); ?>
			    <div class="flex wrap gap-3 mt-2">
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				if ( have_posts() ) :

					while ( have_posts() ) :

						the_post();

						generate_do_template_part( 'index' );

					endwhile;
                    ?> </div> <?php
				    //pagination
					do_action( 'generate_after_loop', 'index' );

				else :

					generate_do_template_part( 'none' );

				endif;
			}
			?> 
			</div>
			</div>
		</main>
	</div> 
	<?php
    get_footer();
