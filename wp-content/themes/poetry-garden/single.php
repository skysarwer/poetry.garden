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

$pref_disable = get_field('disable_pref', 'options');
if( $pref_disable && in_array('hide_post', $pref_disable) ) {
		$hide_pref = true;
	} else {
		$hide_pref = false;
	}
	
	$toc_disable = get_field('disable_toc', 'options');
if( $toc_disable && in_array('hide_post', $toc_disable) ) {
		$hide_toc = true;
	} else {
		$hide_toc = false;
	}
	
	$ata_disable = get_field('disable_ata', 'options');
if( $ata_disable && in_array('hide_post', $ata_disable) ) {
		$hide_ata = true;
	} else {
		$hide_ata = false;
	}

	$Abstract_disable = get_field('disable_Abstract', 'options');
if( $Abstract_disable && in_array('hide_post', $Abstract_disable) ) {
		$hide_Abstract = true;
	} else {
		$hide_Abstract = false;
	}
	
	$discussion_disable = get_field('disable_discussion', 'options');
if( $discussion_disable && in_array('hide_post', $discussion_disable) ) {
		$hide_discussion = true;
	} else {
		$hide_discussion = false;
	}

	$pref_location = get_field('pref_location', 'options');
	if (!$pref_location) {
		$pref_location = 'top_left';
	}
	$pref_side = str_replace(array('top_', 'bottom_'), '', $pref_location);
	$toc_location = get_field('toc_location', 'options');
	if (!$toc_location) {
		$toc_location = 'top_left';
	}
	$toc_side = str_replace(array('top_', 'bottom_'), '', $toc_location);
	$ata_location = get_field('ata_location', 'options');
	if (!$ata_location) {
		$ata_location = 'bottom_right';
	}
	$ata_side = str_replace(array('top_', 'bottom_'), '', $ata_location);

$Abstract_location = get_field('Abstract_location', 'options');
	if (!$Abstract_location) {
		$Abstract_location = 'top_left';
	}
	$Abstract_side = str_replace(array('top_', 'bottom_'), '', $Abstract_location);

	$discussion_location = get_field('discussion_location', 'options');
	if (!$discussion_location) {
		$discussion_location = 'bottom_right';
	}
	$discussion_side = str_replace(array('top_', 'bottom_'), '', $discussion_location);


	pageflap_render($hide_pref, 'pref_flap', $pref_side);
	pageflap_render ($hide_toc, 'toc_flap',  $toc_side, get_post_type());
	pageflap_render($hide_ata, 'ata_flap', $ata_side);
	pageflap_render($hide_Abstract, 'Abstract_flap', $Abstract_side);
	pageflap_render($hide_discussion, 'discussion_flap', $discussion_side);?>

<div class="flex sticky top wrap justify-space-between">
	<div class="left flex column justify-left">
		<?php 
		pageflap_trigger($hide_toc, 'toc', 'top_left', $toc_location, 'verso');
		pageflap_trigger($hide_pref, 'pref', 'top_left', $pref_location, 'verso');
		pageflap_trigger($hide_ata, 'ata', 'top_left', $ata_location, 'verso'); 
		pageflap_trigger($hide_Abstract, 'abst', 'top_left', $Abstract_location, 'verso');
		pageflap_trigger($hide_discussion, 'discussion', 'top_left', $discussion_location, 'verso');
		?>
	</div>
	<div class="right flex justify-right half-width">
		<?php 
		pageflap_trigger($hide_toc, 'toc', 'top_right', $toc_location, 'recto');
		pageflap_trigger($hide_pref, 'pref', 'top_right', $pref_location, 'recto');
		pageflap_trigger($hide_ata, 'ata', 'top_right', $ata_location, 'recto'); 
		pageflap_trigger($hide_Abstract, 'abst', 'top_right', $Abstract_location, 'recto');
		pageflap_trigger($hide_discussion, 'discussion', 'top_right', $discussion_location, 'recto');
		?>
	</div>
</div>

<main id="section" class="relative">
	<?php the_post_thumbnail();?>
	<div>
		<h3><?php the_title();?></h3><br/>
		<?php echo get_the_content();?>
		<div class="overlay"></div>
	</div>
</main>
<br>
<div class="flex justify-space-between full-width sticky bottom">
	<div class="left flex justify-left half-width">
		<?php
		pageflap_trigger($hide_discussion, 'discussion', 'bottom_left', $discussion_location, 'verso');
		pageflap_trigger($hide_toc, 'toc', 'bottom_left', $toc_location, 'verso');
		pageflap_trigger($hide_pref, 'pref', 'bottom_left', $pref_location, 'verso');
		pageflap_trigger($hide_ata, 'ata', 'bottom_left', $ata_location, 'verso'); 
		pageflap_trigger($hide_Abstract, 'abst', 'bottom_left', $Abstract_location, 'verso');
		?>
	</div>
	<div class="right flex column justify-right half-width">
		<?php
		pageflap_trigger($hide_discussion, 'discussion', 'bottom_right', $discussion_location, 'recto');
		pageflap_trigger($hide_toc, 'toc', 'bottom_right', $toc_location, 'recto');
		pageflap_trigger($hide_pref, 'pref', 'bottom_right', $pref_location, 'recto');
		pageflap_trigger($hide_ata, 'ata', 'bottom_right', $ata_location, 'recto'); 
		pageflap_trigger($hide_Abstract, 'abst', 'bottom_right', $Abstract_location, 'recto');
		?>
	</div>
</div>
<?php
poetry_garden_svg(true);
	get_footer();
