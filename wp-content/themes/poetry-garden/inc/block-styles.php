<?php 
/**
 * Gutenberg scripts and styles
 */
function pty_gutenberg_scripts() {

	/*wp_enqueue_script(
		'pty-editor', 
		get_stylesheet_directory_uri() . '/js/editor.js', 
		array( 'wp-blocks', 'wp-dom' ), 
		filemtime( get_stylesheet_directory() . '/js/editor.js' ),
		true
	);*/

	wp_register_style(
		'publication-styles', 
		get_stylesheet_directory_uri() . '/css/editor/publication.css',
		'',
		'',
		''
	);

	/*wp_register_style(
		'homepage-editor-styles', 
		get_stylesheet_directory_uri() . '/css/editor/titlepage.css',
		'',
		'',
		''
	);

	wp_register_style(
		'gallery-editor-styles', 
		get_stylesheet_directory_uri() . '/css/editor/gallery.css',
		'',
		'',
		''
	);*/

	$is_homepage = false;

	//curent sceen is the page type
	if (get_current_screen()->post_type == 'page' && get_current_screen()->base=="post" ){

		$id = null;

		// get the ID for the page
		if( $_GET && isset($_GET['post']) && !empty($_GET['post']) && $_GET['post'] != null ){
			$id = $_GET['post'];
		}else{
			if($_POST && isset($_POST['post_ID']) && !empty($_POST['post_ID']) ){
				$id = $_POST['post_ID'];
			}
		}

		// get the current template
		$current_page_template = get_page_template_slug($id);

		if($current_page_template === 'tmpl-home.php'){ 
			$is_homepage = true;
		}
	}

	/*if ( (get_current_screen()->post_type ==='page' && $is_homepage === false) || get_current_screen()->post_type ==='aber_event' ) {
		wp_enqueue_style( 'page-editor-styles', get_stylesheet_directory_uri() . '/css/editor/page.css' );
	}

	if ($is_homepage === true) {
		wp_enqueue_style( 'homepage-editor-styles', get_stylesheet_directory_uri() . '/css/editor/homepage.css' );
	}

	if (get_current_screen()->post_type ==='aber_gallery') {
		wp_enqueue_style( 'gallery-editor-styles', get_stylesheet_directory_uri() . '/css/editor/gallery.css' );
	}*/

	if (get_current_screen()->post_type =='poetry' || get_current_screen()->post_type == 'fiction' || get_current_screen()->post_type == 'non-fiction' ){
		wp_enqueue_style( 'publication-styles', get_stylesheet_directory_uri() . '/css/editor/publication.css' );
	}


}
add_action( 'enqueue_block_editor_assets', 'pty_gutenberg_scripts' );

function enqueue_framework_css() {

	wp_register_style(
		'framework_css', 
		get_stylesheet_directory_uri() . '/css/framework.css',
		'',
		'',
		''
	);

	wp_enqueue_style( 'framework_css', get_stylesheet_directory_uri() . '/css/framework.css' );

}

add_action( 'wp_enqueue_scripts', 'enqueue_framework_css' );
add_action( 'enqueue_block_editor_assets', 'enqueue_framework_css' );

