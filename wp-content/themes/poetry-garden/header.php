<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
		<!--- <link rel="icon" href="<?php // if (get_field('site_icon','options')){ echo get_field('site_icon', 'options'); } else { 
	//echo site_url().'/icon.png'; } ?>" type="image/png" /> --->
<style>
<?php 
	global $site_author;
	function custom_style_var($field, $default) {
		if(get_field($field, 'options')){echo get_field($field, 'options').';';} else {echo $default.';';}
	}?>
	:root {
		--site-background: <?php custom_style_var('field_6029e016c2646', 'palegoldenrod');?>
 --page-background: <?php custom_style_var('field_604436e836339', 'var(--site-background)');?>
		--site-text: <?php custom_style_var('field_6044370f3633a', '#000000');?>
			--page-text: <?php custom_style_var('field_604437513633b', '#000000');?>
			--font-family: <?php if(get_field('site_font', 'options')){echo get_field('field_60b197c7e84b7', 'options')['font_family'].';';} else {echo '"Palatino Linotype", "Book Antiqua", Palatino, serif;';}?>
	}
	</style>
</head>

<body>
	<?php
	
	/**
	 * wp_body_open hook. @since 2.3
	 */
	do_action( 'wp_body_open' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core WP hook.
	//do_action( 'generate_header' );
	?>
	
	<div id="header" class="relative">
		<div class="inner flex p-column align-center justify-space-between">
			<div class="justify-s-left full-width">
				<h3 class="sig"><a class="prime" href="<?php echo site_url();?>"><?php echo get_bloginfo( 'name' ); ?></a></h3>
				<p class="sig">
					by <?php echo $site_author->nickname;?>
				</p>
			</div>
			<div class="justify-s-center full-width">
			</div>
			<div class="justify-s-right full-width">
				<?php display_menu('flex justify-right p-justify-center');?>
			</div>	
		</div>
			<div class="overlay absolute full">
			
		</div>
	</div>
	<div id="framework">
		<div class="overlay">
			
		</div>
	
	