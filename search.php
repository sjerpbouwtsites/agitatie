<?php
get_header();

set_query_var('klassen_bij_primary', "zoeken verpakking marginveld");
//set_query_var('titel_hoog', "<h1>".()."</h1>");
get_template_part('/sja/open-main');

do_action('ag_pagina_titel');

get_search_form();

if ($_GET['s'] !== '') :
	if (have_posts()) :

		echo "<div class='art-lijst'>";

		while (have_posts()) : the_post();

			$art = new Ag_article_c(
				array(
					'class' => "in-lijst",
					'htype' => 3,
					'exc_lim' => 350
				),
			$post);

			$art->print();

		endwhile;

		echo "</div>"; // art lijst

	else :

		echo "<p>Niets gevonden! Sorry.</p>";

		$voorpagina = new Ag_knop(array(
			'tekst'		=> 'Terug naar voorpagina',
			'link'		=> SITE_URI,
			'class'		=> 'in-wit',
		));
		$voorpagina->print();

	endif;

	$r = ag_paginering_ctrl();

endif; //als iets gezocht



get_template_part('/sja/sluit-main');
get_footer();
