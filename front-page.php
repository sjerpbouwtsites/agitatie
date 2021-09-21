<?php

get_header();

set_query_var('klassen_bij_primary', "voorpagina veel marginveld");
get_template_part('/sja/open-main');

do_action('voorpagina_voor_tekst_action');

set_query_var('geen_margin', true);

ag_tekstveld_ctrl(array(
	'formaat'		=> 'klein',
	'titel' 		=> $post->post_title,
	'titel_el'		=> 'h1'
));

do_action('voorpagina_na_tekst_action');

get_template_part('/sja/sluit-main');
get_footer();