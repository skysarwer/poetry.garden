<?php
/**
 * The Template for displaying all single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); 

global $post;
$pub_author = get_userdata($post->post_author);

$category = get_the_category()[0];
$parent_permalink = get_post_meta(get_the_ID(), 'parent_permalink')[0];
?>

	          <input type="checkbox" class="modal-input right" id="ata">
	          <div class="pageflap modal ata right">
	              <label for ="ata"><div class="x modal-trigger">+</div></label>
	              <?php
	              
                echo '<a href="'.bp_core_get_user_domain( $pub_author->ID ).'" class="very-subtle no-bg img mt-2"><span class="pub-img">'.get_avatar($pub_author->user_email, 174).'</span></a>';
                echo '<a href="'.bp_core_get_user_domain( $pub_author->ID ).'" class="very-subtle"><h3>'.$pub_author->display_name.'</h3></a>';
                $bio = xprofile_get_field( 6,  $pub_author->ID)->data->value;
                if ($bio != '') {
                    echo '<p>'.$bio.'</p>';
                } else {
                    echo '<p>No biography is currently available for this author.</p>';
                }
                ?>
	          </div>

<?php

?>
    
    <nav class="ml-3">
        
        <p class="mb-05"><a href="/<?php echo $category->slug;?>">&larr; All <?php echo $category->name; ?></a></p>
        <p><a href="<?php echo get_author_posts_url( $post->post_author ); ?>?filterby=<?php echo $category->slug;?>">&larr; <?php echo ' '.$category->name.' by '.get_userdata($post->post_author)->display_name;?></a></p>
        
    </nav>
    
	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main class="mb-2" id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				while ( have_posts() ) :

					the_post();

					get_template_part('content', 'single' );

				endwhile;
			}

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	    <div class="inside-article relative pb-3 pt-3">
	        <a class="pub-btn flex gap-1 very-subtle no-bg" href=" <?php echo $parent_permalink.'?p='.get_post_meta(get_the_ID(), 'parent_post_id')[0]; ?> "> <?php svg_render(publication_button_svg()); ?> <span>Original Publication </span> </a>
	   </div>
	</div>
	<div class="flex justify-space-between full-width sticky bottom">
	    <div class="left"></div>
	    <div class="right flex column justify-right half-width">
            <label for="ata" class="sideNav modal-trigger align-center flex recto">About the Author <?php echo recto_arrow_svg(); ?></label>
        </div>
    </div>
	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	get_footer();
