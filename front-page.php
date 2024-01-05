<?php

get_header();

set_query_var('klassen_bij_primary', "voorpagina");
get_template_part('/sja/open-main');

ag_uitgelichte_afbeelding_ctrl();

do_action('voorpagina_voor_tekst_action');

set_query_var('geen_margin', true);

ag_tekstveld_ctrl(array(
	'formaat'		=> 'klein',
	'titel' 		=> ag_hero_model() === false ? $post->post_title : false
));

do_action('voorpagina_na_tekst_action');

get_template_part('/sja/sluit-main');
get_footer();
