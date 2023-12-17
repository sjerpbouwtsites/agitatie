<?php

if (!function_exists('ag_agenda_singular_hooks')) :
    function ag_agenda_singular_hooks()
    {
        if (!is_singular()) {
            return;
        }
        global $post;
        if ($post->post_type !== 'agenda') {
            return;
        }

        add_action('af_pagina_voor_tekst', 'ag_agenda_singular_print_date');
        add_action('ag_singular_na_artikel', 'ag_agenda_singular_back_to_agenda', 20);
        remove_action('ag_singular_na_artikel', 'ag_singular_taxonomieen', 20);

        add_action('ag_pagina_voor_tekst', 'ag_agenda_plek_adres');
    }
endif;

if (!function_exists('ag_agenda_plek_adres')) :
    function ag_agenda_plek_adres()
    {
        global $post;

        $plekken = wp_get_post_terms($post->ID, 'locatie');
        if (count($plekken) < 1) {
            return;
        }



        foreach ($plekken as $p) {
            $straat = get_field('straat', 'plek_' . $p->term_id);
            $straat2 = get_field('straat', 'locatie_' . $p->term_id);
            $huisnummer = get_field('huisnummer', 'plek_' . $p->term_id);
            $postcode = get_field('postcode', 'plek_' . $p->term_id);
            $stad = get_field('stad', 'plek_' . $p->term_id);
            $tijd = get_field('datum');

            echo "<address class='agenda-address'>
        <span class='agenda-address__regel'>$straat $straat2 $huisnummer</span>
        <span class='agenda-address__regel'>$postcode $stad</span>
        <span class='agenda-address__regel'>$tijd</span>
        </address>";
        }
    }
endif;

if (!function_exists('ag_agenda_singular_print_date')) :
    function ag_agenda_singular_print_date()
    {
        global $post;
        echo "<p><strong>" . get_field('datum', $post->id) . "</strong></p>";
    }
endif;

if (!function_exists('ag_agenda_singular_back_to_agenda')) :
    function ag_agenda_singular_back_to_agenda()
    {
        $terug_naar_agenda = new Ag_knop(array(
          'class'   => 'in-wit ikoon-links',
          'link'     => get_post_type_archive_link('agenda'),
          'tekst'    => 'Terug naar de agenda',
          'ikoon'    => 'arrow-left-thick'
        ));

        echo "<div class='verpakking verpakking-klein'>";
        $terug_naar_agenda->print();
        echo "</div>";
    }
endif;



add_action('template_redirect', 'ag_agenda_singular_hooks');
