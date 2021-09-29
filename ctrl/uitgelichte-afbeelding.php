<?php


if(!function_exists('ag_uitgelichte_afbeelding_ctrl')) : function ag_uitgelichte_afbeelding_ctrl() {

	global $post;
	global $wp_query;

	// volgende pagina's hebben MOGELIJK een afbeelding.
	// page / page-template
	// single
	// categorie / taxonomie

	if (!in_array('true', array(
		$wp_query->is_singular,
		$wp_query->is_category,
		$wp_query->is_tax,
	))) {
		return false;
	}

	if (!$hero_ar = ag_hero_model()) {
		set_query_var('heeft_hero', $hero_ar);
	} else {
		$hero_ar['heeft_hero'] = true;
		ag_array_naar_queryvars($hero_ar);
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