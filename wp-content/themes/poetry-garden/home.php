<?php
/*
* Template Name: Home
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
		<!--- <link rel="icon" href="<?php // if (get_field('site_icon','options')){ echo get_field('site_icon', 'options'); } else { 
	//echo site_url().'/icon.png'; } ?>" type="image/png" /> --->
<?php theme_styles();?>
</head>
<body>
	<?php
	
	/**
	 * wp_body_open hook. @since 2.3
	 */
	do_action( 'wp_body_open' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core WP hook.
	//do_action( 'generate_header' );
	global $site_author;
	?>
	
	<div id="framework">
		<div class="overlay">
			
		</div>
		<?php 
		ata_flap('right');
		pref_flap('right');
		?>
		<div id="title-page" class="flex p-column full-height full-width">
		<div class="verso flex column justify-center align-center full padding-mid">
			<div class="front-title">
			<h1>
				<a class="prime" href="<?php echo site_url();?>"><?php echo get_bloginfo( 'name' ); ?></a>
			</h1><h3>
			by <?php echo $site_author->nickname; ?>
				</h3></div>
			</div>
	<div class="recto p-justify-start flex column justify-center align-center full padding-mid">
		<?php display_menu('flex column full-width title');?>
			</div>
			<div class="flex justify-space-between full-width fixed bottom">
<div class="left flex justify-left half-width">
	
</div>
	<div class="right flex column justify-right half-width">
		<?php  
		ata('recto');
		pref('recto');
	echo ''; ?>
	</div></div>
		</div><?php
		if ( have_posts() ) : while ( have_posts() ) : the_post();
the_content();
endwhile; endif;
		poetry_garden_svg();
get_footer();
?>