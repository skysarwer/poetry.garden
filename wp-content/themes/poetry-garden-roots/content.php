<?php
/**
 * The template for displaying posts within the loop.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php
global $post;
$pub_author = get_userdata($post->post_author);
$content = get_the_content();
$first_paragraph = substr( $content, 0, strpos( $content, '</p>' ) + 4 );
if (strpos($first_paragraph, '<br />') !== FALSE) {
    $first_line = substr($first_paragraph, 0, stripos($first_paragraph, '<br />'));
} else {
    $first_line = $first_paragraph; 
}

if (strpos ($first_line, '.') !== FALSE) {
$first_line = substr($first_line, 0, strpos($first_line, '.') + 1);
}

$first_line = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $first_line);

?>
<article class="publication-listing" <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">
			<header>
			    
				<?php 
				if (get_the_title() != '') {
				    echo '<a href="'.get_the_permalink().'" class="very-subtle"><h4 class="mb-0">'. get_the_title() .'</h4></a>';
				} else {
				    echo '<a href="'.get_the_permalink().'" class="very-subtle"><h4 class="mb-0">Untitled</h4></a>';
				}
				?>
				<?php
				$parent_permalink = get_post_meta(get_the_ID(), 'parent_permalink')[0];
				if (is_author()) {
				    echo '<p class="publication-meta">published by <a href="'.bp_core_get_user_domain( $pub_author->ID ).'">'.$pub_author->display_name.'</a>, in <a href="'.$parent_permalink.'" target="_blank">'.get_post_meta(get_the_ID(), 'parent_site')[0].'</a></p>';
				} else {
				
                echo '<p class="publication-meta">published by <a href="'.get_author_posts_url($pub_author->ID).( !is_home() ? '/?filterby='.get_queried_object()->slug : '').'">'.$pub_author->display_name.'</a>, in <a href="'.$parent_permalink.'" target="_blank">'.get_post_meta(get_the_ID(), 'parent_site')[0].'</a></p>';
                }?>
			</header>

			<div class="first-line" itemprop="text">
			    
				<?php echo '<a href="'.get_the_permalink().'" class="very-subtle no-bg">'.$first_line.'<br/>...</a>'; ?>
			
				
				
			</div>	
			<div class="actions flex align-center"><a class="pub-btn flex gap-1 very-subtle no-bg" href=" <?php echo $parent_permalink.'?p='.get_post_meta(get_the_ID(), 'parent_post_id')[0]; ?> "> <?php svg_render(publication_button_svg()); ?> <span>Original Publication </span> </a><a href="<?php the_permalink(); ?>">Read on Poetry Garden</a></div>
	</div>
</article>
