<?php

function ag_vp_print_nieuws_hook() {

	echo "<section class='vp-nieuws verpakking verpakking-klein'>
	<h2>Recent nieuws</h2>";

	$vp_posts = new WP_Query(array(
		'posts_per_page' => 6
	));

	echo "<div class='art-lijst'>";

	if (count($vp_posts->posts)) : foreach ($vp_posts->posts as $vp_post) :

		if (!isset($a)) {
			$a = new Ag_article_c(array(
				'class' 		=> 'in-lijst',
				'htype'			=> 3,
				'geen_tekst'	=> true,
				'geen_afb'		=> false
			), $vp_post);
		} else {
			$a->art = $vp_post;
		}

		$a->gecontroleerd = false;
		$a->print();

	endforeach; endif;

	echo "</div>"; //art lijst

	echo "<footer>";

	$k = new Ag_knop(array(
		'link' 		=> get_post_type_archive_link('post'),
		'tekst' 	=> 'alle berichten',
		'class'		=> 'in-wit'
	));
	$k->print();

	echo "</footer>";

	echo "</section>";

}

add_action('voorpagina_na_tekst_action', 'ag_vp_print_nieuws_hook', 20);


function ag_vp_print_menu () {

	$locaties = get_nav_menu_locations();

	if (array_key_exists('voorpagina', $locaties)) {

		$menu = wp_get_nav_menu_object($locaties['voorpagina']);
		$menu_stukken = wp_get_nav_menu_items($menu->term_id);

		if ($menu_stukken and count($menu_stukken)) :
			echo "<section class='vp-menu verpakking verpakking-klein'>";
			echo "<h2>Lees meer over...</h2>";

			echo "<nav class='knoppendoos'>";
			foreach ($menu_stukken as $menu_stuk) {
				$k = new Ag_knop(array(
					'link' 		=> $menu_stuk->url,
					'tekst'		=> $menu_stuk->title,
					'class'		=> 'in-kleur'
				));
				$k->print();
			}
			echo "</nav>";//Ag_knoppendoos

			echo "</section>";

		endif;

	}

}

add_action('voorpagina_na_tekst_action', 'ag_vp_print_menu', 10);




/*function ag_vp_print_meer_nieuws_hook() {

	echo "<section class='vp-nieuws verpakking verpakking-klein'>
	<h2>Veelgestelde vragen</h2>";

	$vp_posts = new WP_Query(array(
		'posts_per_page' => 6,
		'offset'		=> 6
	));

	echo "<div class='art-lijst'>";

	if (count($vp_posts->posts)) : foreach ($vp_posts->posts as $vp_post) :

		if (!isset($a)) {
			$a = new Ag_article_c(array(
				'class' 		=> 'in-lijst',
				'htype'			=> 3,
				'geen_tekst'	=> false,
				'geen_afb'		=> true,
				'geen_datum'	=> true,
				'exc_lim'		=> 146

			), $vp_post);
		} else {
			$a->art = $vp_post;
		}

		$a->gecontroleerd = false;
		$a->print();

	endforeach; endif;

	echo "</div>"; //art lijst

	echo "<footer>";

	$k = new Ag_knop(array(
		'link' 		=> get_post_type_archive_link('post'),
		'tekst' 	=> 'alle berichten',
		'class'		=> 'in-wit'
	));
	$k->print();

	echo "</footer>";

	echo "</section>";

}

add_action('voorpagina_na_tekst_action', 'ag_vp_print_meer_nieuws_hook', 20);*/