<?php

use agitatie\taal as taal;

if (!function_exists('ag_agenda_singular_hooks')) :
    function ag_agenda_singular_hooks()
    {
        if (!is_singular()) {
            return;
        }
        global $post;
        if ($post->post_type !== 'event') {
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
            //$straat = get_field('straat', 'locatie_' . $p->term_id);
            //$huisnummer = get_field('huisnummer', 'locatie_' . $p->term_id);
            //$postcode = get_field('postcode', 'locatie_' . $p->term_id);
            $stad = get_field('stad', 'locatie_' . $p->term_id);
            $tijd = get_field('datum');

            echo "<address class='agenda-address'>";
            //<span class='agenda-address__regel'>$straat $huisnummer</span>
            //<span class='agenda-address__regel'>$postcode $stad</span>
            echo "<span class='agenda-address__regel'>$stad</span>";
            echo "<span class='agenda-address__regel'>$tijd</span>";
            echo "</address>";
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
          'link'     => get_post_type_archive_link('event'),
          'tekst'    => 'Terug naar de agenda',
          'ikoon'    => 'arrow-left-thick'
        ));

        echo "<div class='verpakking verpakking-klein'>";
        $terug_naar_agenda->print();
        echo "</div>";
    }
endif;



add_action('template_redirect', 'ag_agenda_singular_hooks');


function ag_event_single_knop_terug()
{
    global $post;

    if (!is_singular() || $post->post_type !== 'event') {
        return ;
    }

    echo "<div class='Ag_knoppen-doos Ag_knoppen-doos--agenda'>";

    $archief = array_key_exists('archief', $_GET);
    $agenda_link = get_post_type_archive_link('event');

    //wat als er uberhaupt geen GET zijn => andere link
    $archief_link = site_url(str_contains($_SERVER['REQUEST_URI'], '/en/') ? "event-archive" : "event-archief");
    $archief_Ag_knop = new Ag_knop(array(
        'ikoon'=> ($archief ? "arrow-right-thick" : "step-backward-2"),
        'class'=> 'in-wit '.($archief ? "" : "ikoon-links"),
        'link' => $archief ? $agenda_link : $archief_link,
        'tekst'=> $archief ? taal\streng('events') : taal\streng('events archief')
    ));

    $archief_Ag_knop->print();

    //als filters actief Ag_knop terug naar begin.

    if (count($_POST)) {
        $agenda_begin = new Ag_knop(array(
            'ikoon' => 'replay',
            'class'=> 'in-wit',
            'link' => $agenda_link,
            'tekst'=> "Verwijder filters",
        ));
        $agenda_begin->print();
    }

    echo "</div>";
}

add_action('ag_singular_na_artikel', 'ag_event_single_knop_terug', 80);
