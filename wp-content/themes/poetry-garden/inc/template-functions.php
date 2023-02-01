<?php 
//variables

$site_author = get_user_by('id', get_option ('site_author'));
global $site_author;


//shortcodes

function site_url_shortcode() {
	return get_site_url();
}
add_shortcode('site_url', 'site_url_shortcode');

function pen_name_shortcode() {
	global $site_author;
	return $site_author->nickname;
}
add_shortcode('pen_name', 'pen_name_shortcode');

function display_menu($ulClass) {
	echo '<ul class="menu '.$ulClass.'">';
	if (have_rows('default_links', 'options')):
	 while( have_rows('default_links', 'options') ): the_row();
		$menuli1 = get_sub_field('1');
		$menuli2 = get_sub_field('2');
		$menuli3 = get_sub_field('3');
	 endwhile;
	 else:
		$menuli1 = array( "title" => "Poetry", "url" => "/poetry");
		$menuli2 = array( "title" => "Fiction", "url" => "/fiction");
		$menuli3 = array( "title" => "Non-Fiction", "url" => "/non-fiction");
	endif;
	if ($menuli1){
		echo '<li><a class="prime" href="'.$menuli1['url'].'">'.$menuli1['title'].'</a></li>';
		} 
	if ($menuli2):
		echo '<li><a class="prime" href="'.$menuli2['url'].'">'.$menuli2['title'].'</a></li>';
	endif;
	if ($menuli3):
		echo '<li><a class="prime" href="'.$menuli3['url'].'">'.$menuli3['title'].'</a></li>';
	endif;
	if (have_rows('new_link', 'options')):
	 while (have_rows('new_link','options')): the_row();
	if (get_sub_field('link')):	
	echo '<li><a class="prime" href="'.get_sub_field('link')['url'].'">'.get_sub_field('link')['title'].'</a></li>';
	endif;
	
	 endwhile;
	endif;
echo '</ul>';
}

function custom_style_var($field, $default) {
	if( get_field($field, 'options') ){
		echo get_field($field, 'options').';';
	} else {
		echo $default.';';
	}
}

function theme_styles() { 

	ob_start(); ?>

	<style type="text/css">
		:root {
			--site-background: <?php custom_style_var('field_6029e016c2646', 'palegoldenrod');?>
			--page-background: <?php custom_style_var('field_604436e836339', 'var(--site-background)');?>
			--site-text: <?php custom_style_var('field_6044370f3633a', '#000000');?>
			--page-text: <?php custom_style_var('field_604437513633b', '#000000');?>
			--font-family: <?php if(get_field('site_font', 'options')){echo get_field('field_60b197c7e84b7', 'options')['font_family'].';';} else {echo '"Palatino Linotype", "Book Antiqua", Palatino, serif;';}?>
		}
	</style>

	<?php 
	echo ob_get_contents();
}
add_action( 'admin_head', 'theme_styles' );


function view_posts($var) {
	$post_loop = new WP_Query( array(
    'post_type' => $var,
    'order' => 'DESC',
	 'posts_per_page'=>'-1',
	 //'tag' => $tags_array
  ));
	if ($post_loop->have_posts()) :
	
		$pref_disable = get_field('disable_pref', 'options');
if( $pref_disable && in_array('hide_archive', $pref_disable) ) {
		$hide_pref = true;
	} else {
		$hide_pref = false;
	}
	
	$toc_disable = get_field('disable_toc', 'options');
if( $toc_disable && in_array('hide_archive', $toc_disable) ) {
		$hide_toc = true;
	} else {
		$hide_toc = false;
	}
	
	$ata_disable = get_field('disable_ata', 'options');
if( $ata_disable && in_array('hide_archive', $ata_disable) ) {
		$hide_ata = true;
	} else {
		$hide_ata = false;
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
	pageflap_render($hide_pref, 'pref_flap', $pref_side);
	pageflap_render ($hide_toc, 'toc_flap',  $toc_side, $var);
	pageflap_render($hide_ata, 'ata_flap', $ata_side); ?>
<div class="flex sticky top wrap justify-space-between">
	<div class="left flex column justify-left">
		<?php 
		pageflap_trigger($hide_toc, 'toc', 'top_left', $toc_location, 'verso');
		pageflap_trigger($hide_pref, 'pref', 'top_left', $pref_location, 'verso');
		pageflap_trigger($hide_ata, 'ata', 'top_left', $ata_location, 'verso'); ?>
	</div>
	<div class="right">
		<?php 
		pageflap_trigger($hide_toc, 'toc', 'top_right', $toc_location, 'recto');
		pageflap_trigger($hide_pref, 'pref', 'top_right', $pref_location, 'recto');
		pageflap_trigger($hide_ata, 'ata', 'top_right', $ata_location, 'recto');
		?>
	</div>
</div>
<main id="section" class="relative"><?php
	$postCount = 0;
while ( $post_loop->have_posts() ) : $post_loop->the_post();
	$postCount++;
		if ($postCount > 1) {
				echo '<div class="divider">***</div>';
			}
	//echo $postCount.'.';
	?><a href="<?php the_permalink();?>"><?php
	the_post_thumbnail();?></a>
		<h3><a class="prime" href="<?php the_permalink();?>"><?php the_title();?></a></h3><br/>
			<div><a class="prime" href="<?php the_permalink();?>"><?php echo get_the_content();?>
				</a></div><?php
		

	
		$post_content = get_the_content();
	
		if ($var == 'poetry') {
			$publication_category = 1;
		} else if ($var == 'fiction') {
			$publication_category = 38;
		} else if ($var == 'non-fiction') {
			$publication_category = 39;
		}	
		global $site_author;
		$parent_blog_id = get_current_blog_id();
		$post_id = get_the_ID();
		
		$DOI = '0'.$parent_blog_id.'0'.$post_id.'0';
	
		$new_postarr = array(
                
 				'post_content' => $post_content,  
				'post_author' => $site_author->ID,
 				'post_title' => get_the_title(), 
 				'post_excerpt' => get_the_excerpt(), 
 				'post_status' => get_post_status(), 
 				'comment_status' => the_post()->comment_status, 
 				'post_name' => $DOI, 
 				'post_category' => array($publication_category),
 				'meta_input' => array(
 					'parent_site'=> get_bloginfo( 'name' ), 
 					'parent_post_id'=>$post_id, 
 					'parent_site_ID' => get_current_blog_id(), 
 					'parent_permalink' => site_url(),
 					),
 				);
		if (isset($_GET['dev'])) {
			echo "dev mode";
			switch_to_blog(1);
			$root_post = get_post_by_name($DOI);
			if ($root_post->post_name == $DOI) {	
				echo $root_post->ID;
				$new_postarr['ID'] = $root_post->ID;
				print_r($new_postarr);
				wp_update_post($new_postarr);
			} else {
				echo "test failed";
			}
			restore_current_blog();
		}
				$update_args = array(
				    'ID'           => get_the_id(),
      'post_content' => get_the_content(),
      'post_excerpt' => 'excerpt',
				    );
				//wp_update_post($update_args);
				echo '<!---'.get_the_excerpt().'--->';
endwhile;
	?></main> 
<div class="flex justify-space-between full-width sticky bottom">
	<div class="left flex column justify-left">
		<?php 
		pageflap_trigger($hide_toc, 'toc', 'bottom_left', $toc_location, 'verso');
		pageflap_trigger($hide_pref, 'pref', 'bottom_left', $pref_location, 'verso');
		pageflap_trigger($hide_ata, 'ata', 'bottom_left', $ata_location, 'verso'); ?>
	</div>
	<div class="right flex justify-right half-width">
		<?php  
		pageflap_trigger($hide_toc, 'toc', 'bottom_right', $toc_location, 'recto');
		pageflap_trigger($hide_pref, 'pref', 'bottom_right', $pref_location, 'recto');
		pageflap_trigger($hide_ata, 'ata', 'bottom_right', $ata_location, 'recto');?>
	</div>
</div>
<?php else : ?>
	<div class="full flex column justify-center align-center">There are no <?php echo $var;?> entries published yet. <br/><br/>
		
		<?php 
	global $site_author;
	if (get_current_user_id() == $site_author->ID) {
	echo '<span class="admin_message">You can start to publish '.$var.' in the <a href="'.site_url().'/wp-admin/edit.php?post_type='.$var.'">'.$var.' section of the Site Admin.</a></span>';
}	
?>
		
	</div>
<?php endif;
}

function pageflap_trigger(bool $bool, $slug, $location, $var, $rectoverso) {
	
	if ($var == $location and $bool == false) {
		$slug($rectoverso);
	}
}

function pageflap_render(bool $bool, $function, $location, $var = '') {
	if ($bool == false) {
	$function($location, $var);
	}
}
function pageflap_image($field, $position) {
	if (have_rows($field, 'options')):
		while (have_rows($field, 'options')): the_row();
		$picture_object = get_sub_field('image');
		if ($picture_object) {
		echo '<span class="pageflap_img '.get_sub_field('image_size').' '.get_sub_field('image_orientation').' '.$position.'"> <img src="'.esc_url($picture_object['url']).'" alt="'.esc_attr($picture_object['alt']).'"/></span>';
		}
	endwhile;
	endif;
}

function pref_flap($float) {
		global $pref_main_content;
	$pref_main_content = get_field('field_6057bcaebfdfb', 'options');
	echo '<input type="checkbox" id="Preface" class="modal-input '.$float.' '.$float.' Preface"><div class="pageflap fixed Preface '.$float.'"><label for="Preface" class="x cursor-pointer">+</label>';
	$pref_title = get_field('field_6057bc6ebfdf8', 'options');
	pageflap_image('field_6057bc03bfdf6', 'top');
	if ($pref_title) {
		echo '<h3>'.$pref_title.'</h3>';
	}
	pageflap_image('field_6057bc89bfdf9', '');
	if ($pref_main_content == 'show_site_description') {
	echo '<span>'.get_field('site_description', 'options').'</span>';
	} else if($pref_main_content == 'show_custom_text') {
		echo '<span>'.get_field('field_6057bcfdbfdfc', 'options').'<span>';
	}
	pageflap_image ('field_6057bd30bfdfd', 'bottom');
	echo '</div>';
}

function pref($float) {
	global $pref_main_content;
	if (get_field('site_description','options') or $pref_main_content == 'show_custom_text') { 
		echo '<label for="Preface" class="sideNav cursor-pointer align-center flex '.$float.'">'.get_field('field_6057bb1cbfdf5', 'options').call_user_func($float . '_arrow_SVG').'</label>';
}}



function Abstract_flap($float) {
	echo '<input type="checkbox" id="Abstract" class="modal-input '.$float.' '.$float.' Abstract"><div class="pageflap fixed Abstract '.$float.'"><span class="flex justify-center"><label for="Abstract" class="x cursor-pointer">+</label></span><h3>Abstract</h3>';
	echo get_field('abstract');
	echo '</div>';
}

function abst($float) {
	if (get_field('abstract')) { 
		echo '<label for="Abstract" class="sideNav cursor-pointer align-center flex '.$float.'">Abstract'.call_user_func($float . '_arrow_SVG').'</label>';
}}


function discussion_flap($float) {
	echo '<input type="checkbox" id="Disc" class="modal-input right Disc">
		<div class="pageflap fixed Disc '.$float.'">
			<span class="flex justify-center">
				<label for="Disc" class="x cursor-pointer">+</label>
			</span>
			<h3>Discussion</h3>';
			comments_template();
	echo '</div>';
}

function discussion($float) {
	echo '<label for="Disc" class="sideNav cursor-pointer align-center flex '.$float.'-float">Discussion'.call_user_func($float . '_arrow_SVG').'</label>';
}

function ata_flap($float) {
	global $site_author;
	echo '<input type="checkbox" id="AtA" class="modal-input '.$float.' AtA"><div class="pageflap fixed AtA '.$float.'"><label for="AtA" class="x cursor-pointer">+</label>';
		if (have_rows('field_6050cffc6b4e1', 'options')):
		while (have_rows('field_6050cffc6b4e1', 'options')): the_row();
	$profile_pic_var = get_sub_field('profile_photo');
	if ($profile_pic_var == 'show_profile_photo') { 
		echo '<span class="pageflap_img '.get_sub_field('image_size').' '.get_sub_field('image_orientation').' top">'.get_avatar($site_author).'</span>'; }
	else if ($profile_pic_var == 'show_custom_photo') {
		$alt_profile_pic = get_sub_field('custom_image');
		if ($alt_profile_pic) {
		echo '<span class="pageflap_img '.get_sub_field('image_size').' '.get_sub_field('image_orientation').' top"> <img src="'.esc_url($alt_profile_pic['url']).'" alt="'.esc_attr($alt_profile_pic['alt']).'"/></span>';
	}}
	endwhile;
	endif;
	
	$ata_title = get_field('field_60515422eaefe', 'options');
	if ($ata_title == 'show_pen_name') {
	echo '<h3>'.$site_author->nickname.'</h3>';
	} else if ($ata_title == 'ata_title_custom_text') {
		echo '<h3>'.get_field('field_6050d5091c214', 'options').'</h3>';
	} else {
		echo '';
	}
	pageflap_image('field_6050d45e1c210', '');
	$ata_main_content = get_field('field_6050d1b904c67', 'options');
	if ($ata_main_content == 'show_author_bio') {
	echo '<p>'.xprofile_get_field( 6, $site_author->ID)->data->value.'</p>';
	} else if ($ata_main_content = "show_custom_text") {
		echo '<span>'.get_field('field_6050d1f604c68', 'options').'</span>';
	}
	pageflap_image('field_6050d5251c215', 'bottom');
	echo '</div>';
}

function ata($float) {
	echo '<label for="AtA" class="sideNav cursor-pointer align-center flex '.$float.'">'.get_field('field_6050cf8c6b4e0', 'options').call_user_func($float . '_arrow_SVG').'</label>';
}


function toc_flap($float, $var) {
	echo '<input type="checkbox" id="ToC" class="modal-input '.$float.' ToC"><div class="pageflap fixed '.$float.' ToC"><label for="ToC" class="x cursor-pointer">+</label>';
	pageflap_image('field_6050c7b16597b', 'top');
	echo '<h3>'.get_field('field_6050c95c87b64', 'options').'</h3>';
	pageflap_image('field_6050ca703dbcb', '');
	echo '<span class="toc-list relative">';
	$post_loop = new WP_Query( array(
    'post_type' => $var,
    'order' => 'DESC',
	 'posts_per_page'=>'-1',
	 //'tag' => $tags_array
  ));
	if ($post_loop->have_posts()) : while ( $post_loop->have_posts() ) : $post_loop->the_post();
	//echo '<p><a href="'.get_the_permalink().'">';
	if (get_the_title() === '') {
		$start = strpos(get_the_content(), '<p>');
		$end = strpos(get_the_content(), '</p>', $start);
		$paragraph = substr(get_the_content(), $start, $end-$start+4);
		if (! $start) {
			$paragraph = '';
		}
		echo '<span><a href="'.get_the_permalink().'"><em>'.$paragraph.'</em></a></span>'; 
	} else { 
		echo '<p><a href="'.get_the_permalink().'">'.get_the_title().'</a></p>'; 
	}
		//echo '</a></p>';
	endwhile;
	wp_reset_postdata();
	endif;
	echo '</span>';
	pageflap_image('field_6050cc22cf79f','bottom');
	echo'</div>';
}

function toc($float) {
	echo '<label for="ToC" class="sideNav cursor-pointer align-center flex '.$float.'">'.get_field('field_6050c76e6597a', 'options').'<svg
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:cc="http://creativecommons.org/ns#"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:svg="http://www.w3.org/2000/svg"
   xmlns="http://www.w3.org/2000/svg"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   viewBox="0 0 29.371149 32.482407"
   height="32.482407mm"
   width="29.371149mm">
  <defs
     id="defs2" />

  <g
     transform="translate(-6.1334978,-9.0838923)"
     id="layer1"
     inkscape:groupmode="layer"
     inkscape:label="Layer 1">
    <path
       id="path24"
       d="M 19.927265,41.49264 C 19.431497,41.31968 8.0180238,35.92809 7.7610998,35.74561 c -0.691083,-0.49084 -1.303804,-1.40745 -1.543332,-2.30877 -0.08111,-0.30518 -0.08427,-0.74736 -0.08427,-11.755289 0,-10.787066 0.0046,-11.452837 0.07966,-11.6956426 0.107847,-0.348527 0.323166,-0.617588 0.617157,-0.77117 0.302678,-0.158111 0.760281,-0.174444 1.142048,-0.04074 0.134714,0.04717 1.101082,0.487862 2.1475062,0.9792996 1.046422,0.491438 2.198168,1.031127 2.559432,1.199309 1.891405,0.880526 6.624656,3.108225 6.924673,3.259089 0.414155,0.20825 0.853801,0.530839 1.057893,0.776206 l 0.148742,0.178826 0.326818,-0.314307 c 0.179737,-0.172875 0.444754,-0.38318 0.588898,-0.467364 0.327191,-0.191081 11.635679,-5.4986436 11.959599,-5.6131526 0.28749,-0.101618 0.81119,-0.110785 1.03314,-0.01798 0.28689,0.119875 0.46904,0.297799 0.62113,0.606725 l 0.14752,0.2996716 0.0117,11.529738 c 0.0117,11.433221 0.0109,11.532781 -0.0797,11.892131 -0.19281,0.76445 -0.76576,1.66174 -1.3661,2.13945 -0.37442,0.29794 -0.22545,0.22511 -5.85912,2.86634 -2.616058,1.22651 -5.082626,2.3833 -5.481263,2.57063 -1.072273,0.50394 -1.094883,0.50997 -1.898356,0.50743 -0.500136,-0.002 -0.738466,-0.0203 -0.887578,-0.0734 z m -0.0015,-2.14122 c 0.03196,-0.0598 0.0469,-3.63093 0.0469,-11.21393 0,-11.907104 0.01216,-11.245493 -0.211997,-11.448433 -0.107189,-0.09696 -11.5567742,-5.471742 -11.6561762,-5.471742 -0.04009,0 -0.09734,0.02456 -0.127244,0.05437 -0.04198,0.04198 -0.05437,2.600525 -0.05437,11.240307 0,11.126508 5.14e-4,11.186728 0.09108,11.333318 0.07931,0.12838 0.323807,0.25667 1.891266,0.99288 0.9901002,0.46505 3.5940512,1.68899 5.7865592,2.71986 2.192506,1.03087 4.031522,1.87582 4.086705,1.87764 0.05538,0.002 0.121344,-0.036 0.147223,-0.0843 z m 7.815796,-2.63171 c 3.139263,-1.4734 5.745523,-2.71282 5.791673,-2.75427 0.22253,-0.20005 0.21053,0.45251 0.21053,-11.457588 0,-12.262645 0.0223,-11.356704 -0.27792,-11.259684 -0.0838,0.0271 -2.70054,1.245353 -5.81489,2.707255 -3.854201,1.809194 -5.705861,2.700794 -5.798363,2.791994 -0.126003,0.124231 -0.134967,0.154541 -0.122939,0.416299 0.0071,0.155276 0.02279,5.233222 0.03469,11.284344 l 0.02178,11.00201 0.123851,-0.0258 c 0.06812,-0.0152 2.692349,-1.23124 5.831618,-2.70461 z"
       style="fill:var(--site-text);stroke-width:0.0452996" />
  </g>
</svg></label>';	
}

function recto_arrow_SVG() {
	return '<svg style="padding-top:0.2rem;" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="29.6332mm" height="32.8506mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" 
viewBox="0 0 2963 3285"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <defs>
  <style type="text/css">
   <![CDATA[
    .str0pfl {stroke:#373435;stroke-width:211.66;stroke-linecap:round}
    .fil0pfl {fill:none}
   ]]>
  </style>
 </defs>
 <g id="Layer_x0020_1">
  <metadata id="CorelCorpID_0Corel-Layer"/>
  <path class="fil0pfl str0pfl" d="M473 717c530,313 1059,626 1589,940 -534,304 -1067,608 -1601,911"/>
 </g>
</svg>';
}

function verso_arrow_SVG() {
	return '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="29.6332mm" height="32.8506mm" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
viewBox="0 0 2963 3285"
 xmlns:xlink="http://www.w3.org/1999/xlink">
 <defs>
  <style type="text/css">
   <![CDATA[
    .str0pfl {stroke:#373435;stroke-width:211.66;stroke-linecap:round}
    .fil0pfl {fill:none}
   ]]>
  </style>
 </defs>
 <g id="Layer_x0020_1">
  <metadata id="CorelCorpID_0Corel-Layer"/>
  <path class="fil0pfl str0pfl" d="M2488 717c-530,313 -1060,626 -1590,940 534,304 1068,608 1602,911"/>
 </g>
</svg>';
}


?>