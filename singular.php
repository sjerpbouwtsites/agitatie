<?php

get_header();
set_query_var('klassen_bij_primary', "singular");
get_template_part('/sja/open-main');

echo "<article class='bericht'>";

while (have_posts()) : the_post();
    echo "<div class='verpakking verpakking-klein marginveld titel-over-afbeelding-indien-aanwezig'>";

    do_action('ag_pagina_titel');

    ag_uitgelichte_afbeelding_ctrl();

    do_action('ag_pagina_voor_tekst');

    echo "<div class='bericht-tekst'>";
    the_content();
    echo "</div>";

    echo "</div>";
endwhile; // End of the loop.

echo "</article>";

do_action('ag_singular_na_artikel');

get_template_part('/sja/sluit-main');
get_footer();
