<?php

get_header();
set_query_var('klassen_bij_primary', "index");
get_template_part('/sja/open-main');

if (have_posts()) : while (have_posts()) : the_post();

	ag_print_lijst_ctrl($post, '2', 140);

endwhile; endif;

get_template_part('/sja/sluit-main');
get_footer();
