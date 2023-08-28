<?php

if (!function_exists('ag_vp_print_nieuws_hook')) : function ag_vp_print_nieuws_hook()
	{
		$vp_posts = new WP_Query(array(
			'posts_per_page' => 5
		));

		if (count($vp_posts->posts)) : 

			$footerknop = new Ag_knop(array(
				'link' 		=> get_post_type_archive_link('post'),
				'tekst' 	=> ucfirst(\agitatie\taal\streng('alle')) . ' ' . \agitatie\taal\streng('posts'),
				'class'		=> 'in-wit'
			));

			echo "<section class='vp-nieuws verpakking'>
				<h2>" . ucfirst(\agitatie\taal\streng('nieuws')) . "</h2>";
			
			foreach ($vp_posts->posts as $vp_post) :

				if (!isset($a)) {
					$a = new Ag_article_c(array(
						'class' 		=> 'in-lijst',
						'htype'			=> 3,
						'geen_afb'		=> false
					), $vp_post);
				} else {
					$a->art = $vp_post;
				}
				$a->gecontroleerd = false;
		
				echo "<div class='art-lijst'>";
					$a->print();
				echo "</div>"; //art lijst
				
			endforeach;

			echo "<footer>";
				$footerknop->print();
			echo "</footer>";

			echo "</section>";

		endif;

		//$afm = ag_agenda_filter_ctrl();

		$agenda = new Ag_agenda(array(
			'aantal' => 10,
			'omgeving' => 'pagina'
		));

		if (count($agenda->agendastukken) > 0) :

			echo "<section class='verpakking verpakking-klein marginveld'>";
			echo "<div class='agenda'>
			<h2>Agenda</h2>";

			$agenda->print();
			echo "</div>";
			echo "</section>";

		endif; // als agendastukken

	}
endif;

add_action('voorpagina_na_tekst_action', 'ag_vp_print_nieuws_hook', 20);


if (!function_exists('ag_vp_print_menu')) : function ag_vp_print_menu()
	{

		$locaties = get_nav_menu_locations();

		if (array_key_exists('voorpagina', $locaties)) {

			$menu = wp_get_nav_menu_object($locaties['voorpagina']);

			if (empty($menu)) {
				return;
			}
			$menu_stukken = wp_get_nav_menu_items($menu->term_id);

			if ($menu_stukken and count($menu_stukken)) :

				echo "<section class='vp-menu verpakking paddingveld marginveld veel normale-padding achtergrond-zijkleur'>";
				echo "<h2 class='tekst-wittig geen-margin-top lineheight-fix' >" . \agitatie\taal\streng('Zie ook') . "</h2>";

				echo "<nav class='knoppendoos groot'>";
				foreach ($menu_stukken as $menu_stuk) {
					$k = new Ag_knop(array(
						'link' 		=> $menu_stuk->url,
						'tekst'		=> $menu_stuk->title,
						'class'		=> 'in-wit'
					));
					$k->print();
				}
				echo "</nav>"; //Ag_knoppendoos

				echo "</section>";

			endif;
		}
	}
endif; // if ag_vp_print_menu exists
add_action('voorpagina_na_tekst_action', 'ag_vp_print_menu', 15);




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
