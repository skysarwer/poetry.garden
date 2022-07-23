<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

function generate_comment( $comment, $args, $depth ) {
		$args['avatar_size'] = apply_filters( 'generate_comment_avatar_size', 65 );

		if ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'generatepress' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'generatepress' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" <?php generate_do_element_classes( 'comment-body', 'comment-body' ); ?>>
				<footer class="comment-meta">
					<?php
					if ( 0 != $args['avatar_size'] ) { // phpcs:ignore
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<div class="comment-author-info">
						<div <?php generate_do_element_classes( 'comment-author' ); ?>>
							<?php printf( '<cite itemprop="name" class="fn">%s</cite>', get_comment_author_link() ); ?>
						</div>

						<div class="entry-meta comment-metadata">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
									<?php
										printf(
											/* translators: 1: date, 2: time */
											_x( '%1$s at %2$s', '1: date, 2: time', 'generatepress' ), // phpcs:ignore
											get_comment_date(), // phpcs:ignore
											get_comment_time() // phpcs:ignore
										);
									?>
								</time>
							</a>
							<?php edit_comment_link( __( 'Edit', 'generatepress' ), '<span class="edit-link">| ', '</span>' ); ?>
						</div>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : // phpcs:ignore ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'generatepress' ); ?></p>
					<?php endif; ?>
				</footer>

				<div class="comment-content" itemprop="text">
					<?php
					/**
					 * generate_before_comment_content hook.
					 *
					 * @since 2.4
					 */
					do_action( 'generate_before_comment_text', $comment, $args, $depth );

					comment_text();

					/**
					 * generate_after_comment_content hook.
					 *
					 * @since 2.4
					 */
					do_action( 'generate_after_comment_text', $comment, $args, $depth );
					?>
				</div>
			</article>
			<?php
		endif;
	}

add_filter( 'avatar_defaults', 'wpb_new_gravatar' );
function wpb_new_gravatar ($avatar_defaults) {
$myavatar = '404';
$avatar_defaults[$myavatar] = "No Default Gravatar";
return $avatar_defaults;
}

function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = get_the_content(null, false, $post_id ); //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 30; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

   // $the_excerpt = '<p>' . $the_excerpt . '</p>';

    return $the_excerpt;
}

//SEO

add_filter( 'the_seo_framework_fetched_description_excerpt', function( $excerpt, $post_id ) {
	$field = function_exists( 'get_field' ) ? preg_replace( "/\r|\n/", " ", get_excerpt_by_id($post_id) ) : '';
	return $field ?: $excerpt;
}, 10, 2 );

require_once get_stylesheet_directory().'/inc/template-functions.php';
require_once get_stylesheet_directory().'/inc/custom-post-types.php';
require_once get_stylesheet_directory().'/inc/svg.php';
require_once get_stylesheet_directory().'/inc/admin-screen.php';
require_once get_stylesheet_directory().'/inc/acf-custom.php';
require_once get_stylesheet_directory().'/inc/block-styles.php';
require_once get_stylesheet_directory().'/inc/theme-config.php';


add_filter('acf/format_value/type=text', 'do_shortcode');




// END ENQUEUE PARENT ACTION
