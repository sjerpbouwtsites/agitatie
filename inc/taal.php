<?php

namespace agitatie\taal;

function def_is_meertalig()
{
    define('IS_MEERTALIG', function_exists('pll_home_url'));
}

/**
 * indien IS_MULTILANG, geeft home url van taal.
 * indien taal null, gebruik huidige taal.
 * @param $taal slug van taal, 2 letters
 * @return string url.
 */
function home_url($taal = null)
{
    if (IS_MEERTALIG) :
        return pll_home_url($taal);
    else :
        return get_site_url();
    endif;
}

/**
 * Haalt uit een lijst met taxonomie namen de namen van de taxonomieen gebruikt door polylang.
 * @param string array met taxonomie namen
 * @return string array.
 */
function verwijder_meertaligheids_tax($stringverzameling = []): array
{
    if (!IS_MEERTALIG) {
        return $stringverzameling;
    }
    $r = [];
    foreach ($stringverzameling as $s) {
        if ($s === 'language' || $s === 'post_translations') {
            continue;
        }
        $r[] = $s;
    }
    return $r;
}

function registreer_strengen()
{
    if (!IS_MEERTALIG) {
        return;
    }

    $GLOBALS['agitatie_strengen'] = [];

    // name, string, group, multiline
    $strengen = [
      reg_streng_h('menu_menu', 'Menu'),
      reg_streng_h('menu_taal_schakel', 'Schakel van taal'),



      reg_streng_h('widget_pag_fam_lees_verder', 'lees verder'),

      reg_streng_h('categorie_taxonomie_naam', 'categorie'),
      reg_streng_h('tag_taxonomie_naam', 'tag'),

      reg_streng_h('post_type_post_naam', 'bericht'),
      reg_streng_h('post_type_post_naam_mv', 'berichten'),
      reg_streng_h('post_type_post_naam', 'post'),
      reg_streng_h('post_type_post_naam_mv', 'posts'),
      reg_streng_h('post_type_post_naam', 'story'),
      reg_streng_h('post_type_post_naam_mv', 'stories'),
      reg_streng_h('post_type_post_naam', 'download'),
      reg_streng_h('post_type_post_naam_mv', 'downloads'),
      reg_streng_h('post_type_post_naam', 'agenda'),
      reg_streng_h('post_type_post_naam_mv', 'agendas'),

      reg_streng_h('telwoord_alle', 'alle', 'agitatie-telwoorden'),
      reg_streng_h('telwoord_alles', 'alles', 'agitatie-telwoorden'),
      reg_streng_h('telwoord_meer', 'meer', 'agitatie-telwoorden'),

      reg_streng_h('zoekterm_niets_gevonden', 'Niets gevonden! Sorry.', 'agitatie-zoektermen'),
      reg_streng_h('zoekterm_terug_voorpagina', 'Terug naar de voorpagina.', 'agitatie-zoektermen'),
      reg_streng_h('zoekterm_je_zocht', 'Je zocht', 'agitatie-zoektermen'),
      reg_streng_h('zoekterm_wat_zoek_je', 'Wat zoek je', 'agitatie-zoektermen'),
      reg_streng_h('zoekterm_zoeken', 'Zoeken', 'agitatie-zoektermen'),
      reg_streng_h('zoekterm_zoek', 'Zoek', 'agitatie-zoektermen'),
      reg_streng_h('zoekterm_404_melding', 'Oeps! Die pagina bestaat niet', 'agitatie-zoektermen'),
      reg_streng_h('zoekterm_404_zoek_hint', 'Probeer eens onderstaand zoekformulier', 'agitatie-zoektermen'),

      reg_streng_h('download-posttype-description', 'Download posters, flyers, etc!', 'agitatie-downloads', true),

      reg_streng_h('voorpagina_zie_ook', 'Zie ook', 'agitatie-voorpagina'),
      reg_streng_h('voorpagina_nieuws', 'nieuws', 'agitatie-voorpagina'),






    ];
    foreach ($strengen as $streng) {
        pll_register_string(...$streng);
        $GLOBALS['agitatie_strengen'][] = $streng[1];
    }
}

add_action('after_setup_theme', 'agitatie\taal\registreer_strengen');

function reg_streng_h($name, $string, $group = 'agitatie', $multiline = false)
{
    return [$name, $string, $group, $multiline];
}

function streng($streng)
{
    if (!IS_MEERTALIG) {
        return $streng;
    }
    if (!in_array($streng, $GLOBALS['agitatie_strengen'])) {
        throw new \Exception("'" . $streng .  "' nog niet geregistreerd! Nog even doen in inc/taal.php", 1);
    }
    return pll__($streng);
}
