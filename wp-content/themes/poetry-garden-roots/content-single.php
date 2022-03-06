<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
$parent_permalink = get_post_meta(get_the_ID(), 'parent_permalink')[0];
$pub_author = get_userdata($post->post_author);


?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article relative">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action( 'generate_before_content' );

		if ( generate_show_entry_header() ) :
			?>
			<header class="entry-header">
			
			    <h1 class="publication-title"><?php echo get_the_title();?></h1>
				<?php 
				
				echo '<p class="publication-meta">published by <a href="'.bp_core_get_user_domain( $pub_author->ID ).'">'.$pub_author->display_name.'</a>, in <a href="'.$parent_permalink.'" target="_blank">'.get_post_meta(get_the_ID(), 'parent_site')[0].'</a></p>';
				
				?>
				
			</header>
			<?php
		endif;

		/**
		 * generate_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_post_image - 10
		 */
		//do_action( 'generate_after_entry_header' );

	//	$itemprop = '';

		//if ( 'microdata' === generate_get_schema_type() ) {
	//		$itemprop = ' itemprop="text"';
	//	}
		?>

		<div class="publication-content"<?php// echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
			<?php
			the_content();

			/*wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
					'after'  => '</div>',
				)
			);*/
			?>
		</div>

		<?php
		/**
		 * generate_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_footer_meta - 10
		 */
	//	do_action( 'generate_after_entry_content' );

		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
	//	do_action( 'generate_after_content' );
		?>
	</div>
	
	
	
</article>
