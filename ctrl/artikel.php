<?php


if(!function_exists('ag_tekstveld_ctrl')) :  function ag_tekstveld_ctrl($invoer = array())
{
    //als tekst leeg
    if(!array_key_exists('tekst', $invoer)) {
        global $post;
        $invoer['tekst'] = $post->post_content;
    }

    //terugval opties
    $basis_waarden = array(
        'formaat'	=> 'groot',
        'titel'		=> false,
        'titel_el'	=> 'h2',
        'class'     => '',
        'html_onder'=> '',
    );

    //er in zetten
    foreach ($basis_waarden as $k => $v) {
        if (!array_key_exists($k, $invoer)) {
            $invoer[$k] = $v;
        }
    }

    if ($invoer['titel']) {
        $id = preg_replace('/[^a-zA-Z0-9\']/', '-', $invoer['titel']);
        $id = str_replace("'", '', $id);
        $id = str_replace('"', '', $id);
        $id = strtolower(rtrim($id, '-'));
        $id = "id='$id'";
    } else {
        $id = '';
    }

    $invoer['tv_id'] = $id;

    //afgeleide gegevens
    $toevoeving = array();

    if (!$invoer['titel']) {
        $toevoeving['veld_element'] = "div";
        $toevoeving['header'] = '';
    } else {
        $toevoeving['veld_element'] = "section";
        $toevoeving['header'] = "<{$invoer['titel_el']} class='titel-uit-tekstveld-ctrl'>{$invoer['titel']}</{$invoer['titel_el']}>";
    }

    //
    $invoer['verwerkte_tekst'] = apply_filters('the_content', $invoer['tekst']);

    $template_args = array_merge($invoer, $toevoeving);

    ag_array_naar_queryvars($template_args);

    get_template_part('sja/tekstveld');
} endif;



if(!function_exists('ag_print_lijst_ctrl')) : function ag_print_lijst_ctrl($post, $htype = '2', $exc_lim = 140)
{
    if (!$post) {
        return;
    }

    global $kind_config;

    $aaa = [
        'class' 	=> 'in-lijst',
        'htype'		=> $htype,
        'exc_lim'	=> $exc_lim];
    if (array_key_exists('archief', $kind_config)) {
        if (array_key_exists($post->post_type, $kind_config['archief'])) {
            $aaa = array_merge($aaa, $kind_config['archief'][$post->post_type]);
        }
    }

    if (!isset($a)) {
        $a = new Ag_article_c($aaa, $post);
    } else {
        $a->art = $post;
    }

    $a->print();
} endif;
