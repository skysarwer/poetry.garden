<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
		 
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );
            ?> <br><h5><em><center>Search results still under development. Thank you for your understanding.</center></em></h5><?php
			if ( generate_has_default_loop() ) {
				if ( have_posts() ) :
					?>

					<header class="page-header">
						<h1 class="page-title">
							<?php
							printf(
								/* translators: 1: Search query name */
								__( 'Search Results for: %s', 'generatepress' ),
								'<span>' . get_search_query() . '</span>'
							);
							?>
						</h1>
					</header>

					<?php
					while ( have_posts() ) :

						the_post();

						generate_do_template_part( 'search' );

					endwhile;

					/**
					 * generate_after_loop hook.
					 *
					 * @since 2.3
					 */
					do_action( 'generate_after_loop', 'search' );

				else :

					echo '<div class="inside-article"><h2>Nothing Found</h2><p>Nothing was found matching your search terms. You are welcome to try again.</p></div>';

				endif;
			}

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();
