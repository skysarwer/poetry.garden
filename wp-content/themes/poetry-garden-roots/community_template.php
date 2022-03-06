<?php 
/*
*
* Template Name: Community
*
*/


get_header(); ?>
<!--- Community Template -->
	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
		    <div class="flex gap-1 mr-1">
		  <?php global $uri_segments; 
		    if ($uri_segments[4] != 'profile' && $uri_segments[4] != 'settings'):
		  ?>      
            <?php community_nav();?>
		    <?php endif; ?>
			<div class="full-width">

		<?php	if ( generate_has_default_loop() ) {
				while ( have_posts() ) :

					the_post();

					generate_do_template_part( 'page' );

				endwhile;
			}

			?>
			</div></div>
		</main>
	</div>

	<?php
	get_footer();
