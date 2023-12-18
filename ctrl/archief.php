<?php

use agitatie\taal as taal;

if (!function_exists('ag_archief_generiek_loop')) : function ag_archief_generiek_loop($post, $afb_formaat = 'lijst', $exc_lim_o = false)
{
    //@TODO dit naar functie hierboven

    $basis_array = array(
        'exc_lim' 		=> $exc_lim_o ? $exc_lim_o : 230,
        'class'			=> 'in-lijst',
        'taxonomieen' 	=> true
    );

    global $kind_config;

    if (
        $kind_config and
        array_key_exists('archief', $kind_config) and
        array_key_exists($post->post_type, $kind_config['archief']) and
        count($kind_config['archief'][$post->post_type])
    ) {
        foreach ($kind_config['archief'][$post->post_type] as $s => $w) {
            $basis_array[$s] = $w;
        }
    }

    $m_art = new Ag_article_c($basis_array, $post);

    if (isset($m_art)) {
        $m_art->afb_formaat	= $afb_formaat;
        $m_art->print();
    }
}
endif;



if (!function_exists('ag_archief_intro_ctrl')) : function ag_archief_intro_ctrl()
{
    global $wp_query;

    if ($archief_intro = ag_archief_intro_model()) {
        echo "<div class='verpakking verpakking-klein'>";
        echo apply_filters('the_content', $archief_intro);
        echo "</div>";
    }
}
endif;



if (!function_exists('ag_archief_sub_tax_ctrl')) : function ag_archief_sub_tax_ctrl()
{
    if ($kinderen = ag_archief_sub_tax_model()) {
        echo "<div class='sub-cat-lijst marginveld'>";

        $vertaal = array(
            'post_tag' => 'Subtags',
            'category' => 'Onder deze categorie:'
        );

        $naam = array_key_exists($kinderen[0]->taxonomy, $vertaal) ? $vertaal[($kinderen[0]->taxonomy)] : $kinderen[0]->taxonomy;


        echo "<p class='geen-margin-top'><strong>$naam:</strong></p>";

        echo "<div class='art-lijst'>";

        foreach ($kinderen as $k) :

            if ($k->count) :

                if (!isset($subcat)) {
                    $subcat = new Ag_article_c(array(
                        'geen_tekst'	=> true,
                        'class'			=> 'in-lijst',
                        'taxonomieen' 	=> false,
                        'is_categorie'	=> true
                    ), $k);
                } else {
                    $subcat->art = $k;
                    $subcat->gecontroleerd = false;
                }

            $subcat->print();

            endif;

        endforeach;

        echo "</div>"; //art lijst

        echo "</div>"; //sub cat lijst
    }

    return !!$kinderen;
}
endif;



if (!function_exists('ag_archief_titel_ctrl')) : function ag_archief_titel_ctrl()
{
    if ($archief_titel = ag_archief_titel_model()) {
        echo "<h1>" . $archief_titel . "</h1>";
    }
}
endif;



if (!function_exists('ag_archief_content_ctrl')) : function ag_archief_content_ctrl()
{
    global $post;
    global $kind_config;

    $extra_class = '';

    if (
        isset($kind_config) and
        array_key_exists('archief', $kind_config) and
        array_key_exists($post->post_type, $kind_config['archief'])
    ) {
        if (
            array_key_exists('geen_afb', $kind_config['archief'][$post->post_type]) and
            $kind_config['archief'][$post->post_type]['geen_afb']
        ) {
            $extra_class = 'geen-afb-buiten';
        }
    }

    echo "<div id='archief-lijst' class='tekstveld art-lijst $extra_class'>";
    if (have_posts()) : while (have_posts()) : the_post();

        //maakt post type objs aan en print @ controllers
        ag_archief_generiek_loop($post);

    endwhile;
    else :

        get_template_part('sja/niets-gevonden');

    endif;
    echo "</div>";
}
endif;



if (!function_exists('ag_archief_footer_ctrl')) : function ag_archief_footer_ctrl()
{
    global $wp_query;

    $vertaal = array(
        'post'	=> \agitatie\taal\streng('berichten'),
        'page'  => \agitatie\taal\streng('pagina\'s'),
        'agenda'=> \agitatie\taal\streng('events'),
    );

    if ($wp_query->is_date || $wp_query->is_category) :

        echo "<footer class='archief-footer'>";
        $terug = new Ag_knop(array(
            'class' 	=> 'in-wit ikoon-links',
            'link' 		=> get_post_type_archive_link(POST_TYPE_NAAM),
            'tekst'		=> 'Alle ' . $vertaal[($wp_query->posts[0]->post_type)],
            'ikoon'		=> 'arrow-left-thick'
        ));

        $this->html.= $terug->html;

        echo "<footer>";

    endif; //als category of datum
}
endif;
