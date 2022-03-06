<?php
/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


get_header(); 

?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
            <!-- Archive Template --> 		    
		  <div class="flex gap-1 mr-1">
            <?php community_nav();?>

			<div class="full-width ml-1">
			    <?php publications_header(); ?>
			 <div class="flex gap-2 mr-1 justify-space-between">
			 <div class="flex-shrink-30">

			        <?php
		        	/**
			        * generate_before_main_content hook.
			        *
			        * @since 0.1
			        */
			        do_action( 'generate_before_main_content' );

        				if ( have_posts() ) :
                        ?> 
                        <div class="flex wrap gap-3 mt-2">
                        <?php
        					while ( have_posts() ) :

        						the_post();

        						generate_do_template_part( 'archive' );

        				    endwhile;
                    ?> 
                    </div> 
                    <?php
					//pagination
					do_action( 'generate_after_loop', 'archive' );
               
				else :

					generate_do_template_part( 'none' );

				endif;
				 ?>
                </div>
                
                 <?php if (is_author()) { ?>
                <div class="pub-col">
                <?php 
                
                $pub_author = get_queried_object();
                echo '<a href="'.bp_core_get_user_domain( $pub_author->ID ).'" class="very-subtle no-bg"><span class="pub-img">'.get_avatar($pub_author->user_email, 174).'</span></a>';
                echo '<a href="'.bp_core_get_user_domain( $pub_author->ID ).'" class="very-subtle"><h3>'.$pub_author->display_name.'</h3></a>';
                $bio = xprofile_get_field( 6,  $pub_author->ID)->data->value;
                if ($bio != '') {
                    echo '<p>'.$bio.'</p>';
                } else {
                    echo '<p>No biography is currently available for this author.</p>';
                }
                ?>
                </div>
            <?php } ?>
            </div>
            
           
			</div>
			</div>
		</main>
	</div>
    <?php
	get_footer();
