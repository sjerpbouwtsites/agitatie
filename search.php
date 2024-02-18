<?php

get_header();

set_query_var('klassen_bij_primary', "zoeken verpakking verpakking-klein marginveld");
//set_query_var('titel_hoog', "<h1>".()."</h1>");
get_template_part('/sja/open-main');

do_action('ag_pagina_titel');

?>

<div class='marginveld'>
<div id="zoekveld2" style="display: flex;">

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?=\agitatie\taal\streng('Zoeken naar')?>:</span>
        <input class="search-field" placeholder="<?=\agitatie\taal\streng('Zoeken')?> …" value="" name="s" type="search">
    </label>
    <label for="kop-zoekveld">
        <input id="kop-zoekveld" class="search-submit knop-rond" value="<?=\agitatie\taal\streng('Zoeken')?>" type="submit">
        
    </label>
</form>

</div></div>

<?php

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
                $post
            );

            $art->print();

        endwhile;

        echo "</div>"; // art lijst

    else :

        echo "<p>" . \agitatie\taal\streng('Niets gevonden! Sorry.') . "</p>";

        $voorpagina = new Ag_knop(array(
            'tekst'		=> \agitatie\taal\streng('Terug naar de voorpagina.'),
            'link'		=> SITE_URI,
            'class'		=> 'in-wit',
        ));
        $voorpagina->print();

    endif;

$r = ag_paginering_ctrl();

endif; //als iets gezocht

get_template_part('/sja/sluit-main');
get_footer();
