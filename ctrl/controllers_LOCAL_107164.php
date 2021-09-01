<?php

// print
if(!function_exists('ag_logo_ctrl')) : function ag_logo_ctrl($print = true) {

	if (!has_custom_logo()) {

		echo "<a href='".get_site_url()."' class='custom-logo geen-logo' rel='home' itemprop='url'>";
		echo get_bloginfo();
		echo "</a>";
	}
	else if ($print) {
		the_custom_logo();
	} else {
		ob_start();
		the_custom_logo();
		return  ob_get_clean();
	}
} endif;



if(!function_exists('ag_paginering_ctrl')) : function ag_paginering_ctrl() {

	$m = ag_paginering_model();

	if (!$m) {
        return; //zie model
    } else {
        ag_array_naar_queryvars($m);
        get_template_part('sja/paginering');
    }
    return $m;
} endif;



if(!function_exists('ag_agenda_filter_ctrl')) : function ag_agenda_filter_ctrl() {

	$m = ag_agenda_filter_model();

	ag_array_naar_queryvars($m);

	get_template_part('sja/agenda-filter');

	return $m;

} endif;



if(!function_exists('ag_kop_menu_ctrl')) :  function ag_kop_menu_ctrl($menu_klasse = ''){

	$a = array(
		'menu' 			=> 'kop',
	);

	if ($menu_klasse !== '') {
		$a['menu_class'] = $menu_klasse;
	}

	wp_nav_menu($a);

} endif;



if(!function_exists('ag_foto_video_gallery_ctrl')) :  function ag_foto_video_gallery_ctrl($css_class = '', $gallerij = false) {

	global $post;

	echo "<div class='foto-video-gallerij $css_class gallerij'>";

		$speelAg_knop = new Ag_knop(array(
			'class'		=> 'speel-video',
			'tekst'		=> 'speel',
			'ikoon'		=> 'play'
		));

/*		$thumb_id = get_post_thumbnail_id($post);
		$thumb_url = wp_get_attachment_image_src($thumb_id,'large', true);
		$thumb_url = $thumb_url[0];*/

		if ($gallerij) : foreach ($gallerij as $g) :

			$m = $g['mime_type'];

			if ($m === "image/jpeg" || $m === "image/png" || $m === "image/gif") {
				echo "<img src='{$g['sizes']['medium_large']}' alt='{$g['alt']}' title='{$g['title']}' width='{$g['sizes']['medium_large-width']}' height='{$g['sizes']['medium_large-height']}'/>";
			} else {
				ag_array_naar_queryvars(array(
					'vid'		=> $g,
					'vid_attr'	=> 'loop',
					'poster'	=> false,
					'vid_onder'	=> $speelAg_knop->maak()
				));
				get_template_part('sja/viddoos');
			}


		endforeach; endif;


	echo "</div>";
} endif;



if(!function_exists('ag_tekstveld_ctrl')) :  function ag_tekstveld_ctrl($invoer = array()){

	//als tekst leeg
	if(!array_key_exists('tekst', $invoer)) {
		global $post;
		$invoer['tekst'] = $post->post_content;
	}

	//terugval opties
	$basis_waarden = array(
		'formaat'	=> 'groot',
		'titel'		=> false,
		'titel_el'	=> 'h2'
	);

	//er in zetten
	foreach ($basis_waarden as $k => $v) {
		if (!array_key_exists($k, $invoer)) {
			$invoer[$k] = $v;
		}
	}

	if ($invoer['titel']) {
		$id = preg_replace('/[^a-zA-Z0-9\']/', '-', $invoer['titel']);
		$id = str_replace("'", '', $id);
		$id = str_replace('"', '', $id);
		$id = strtolower(rtrim($id, '-'));
		$id = "id='$id'";
	} else {
		$id = '';
	}

	$invoer['tv_id'] = $id;

	//afgeleide gegevens
	$toevoeving = array();

	if (!$invoer['titel']) {
		$toevoeving['veld_element'] = "div";
		$toevoeving['header'] = '';
	} else {
		$toevoeving['veld_element'] = "section";
		$toevoeving['header'] = "<{$invoer['titel_el']}>{$invoer['titel']}</{$invoer['titel_el']}>";
	}

	//
	$invoer['verwerkte_tekst'] = apply_filters('the_content', $invoer['tekst']);

	$template_args = array_merge($invoer, $toevoeving);

	ag_array_naar_queryvars($template_args);

	get_template_part('sja/tekstveld');


} endif;



if(!function_exists('ag_print_lijst_ctrl')) : function ag_print_lijst_ctrl($post, $htype = '2', $exc_lim = 140) {

	if (!$post) return;

	if (!isset($a)) {
		$a = new Ag_article_c(array(
			'class' 	=> 'in-lijst',
			'htype'		=> $htype,
			'exc_lim'	=> $exc_lim
		), $post);
	} else {
		$a->art = $post;
	}

	$a->print();
} endif;




if(!function_exists('ag_uitgelichte_afbeelding_ctrl')) : function ag_uitgelichte_afbeelding_ctrl() {

	global $post;
	global $wp_query;

	if ($wp_query->is_archive) {
		//niet op post type archive, alleen category archive
		return;
	}

	//op post met afbeelding
	if (!$wp_query->is_category and has_post_thumbnail($post)) {
		get_template_part('sja/afb/uitgelichte-afbeelding-buiten');
	} else {

		//op cat of op post zonder afbeelding
		//heeft cat afb?
		$afb_verz = get_field('cat_afb', 'category_'.$wp_query->queried_object_id);

		if ($afb_verz and $afb_verz !== '') {

			$img = "<img
				src='{$afb_verz['sizes']['lijst']}'
				alt='{$afb_verz['alt']}'
				height='{$afb_verz['sizes']['lijst-width']}'
				width='{$afb_verz['sizes']['lijst-height']}'
			/>";

			set_query_var('expliciete_img', $img);
			get_template_part('sja/afb/uitgelichte-afbeelding-buiten');
		} else {
			get_template_part('sja/afb/geen-uitgelichte-afbeelding');
		}

	}


} endif;