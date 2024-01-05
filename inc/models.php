<?php

if (!function_exists('ag_paginering_model')) : function ag_paginering_model()
{
    if (is_singular() && !is_search()) {
        return false;
    }

    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return false;
    }

    $m = array(
        'pagi_paged' => get_query_var('paged') ? absint(get_query_var('paged')) : 1,
        'pagi_max'  => intval($wp_query->max_num_pages),
        'pagi_links' => array()
    );

    /** Add current page to the array */
    if ($m['pagi_paged'] >= 1) {
        $m['pagi_links'][] = $m['pagi_paged'];
    }

    /** Add the pages around the current page to the array */
    if ($m['pagi_paged'] >= 3) {
        $m['pagi_links'][] = $m['pagi_paged'] - 1;
        $m['pagi_links'][] = $m['pagi_paged'] - 2;
    }

    if (($m['pagi_paged'] + 2) <= $m['pagi_max']) {
        $m['pagi_links'][] = $m['pagi_paged'] + 2;
        $m['pagi_links'][] = $m['pagi_paged'] + 1;
    }

    sort($m['pagi_links']);


    $m['pagi_prev_link'] = get_previous_posts_link();

    if ($m['pagi_prev_link']) {
        $m['pagi_prev_link_res'] = ag_appendChildBefore($m['pagi_prev_link'], "<i class='mdi mdi-arrow-left-thick'></i>");
    }

    $m['pagi_volgende_link'] = get_next_posts_link();

    if ($m['pagi_volgende_link']) {
        $m['pagi_volgende_link_res'] = ag_appendChildBefore($m['pagi_volgende_link'], "<i class='mdi mdi-arrow-right-thick'></i>");
    }

    return $m;
}
endif;


if (!function_exists('ag_archief_intro_model')) : function ag_archief_intro_model()
{
    global $wp_query;

    if ($wp_query->is_category || $wp_query->queried_object->description !== '') {
        return $wp_query->queried_object->description;
    } else {
        return false;
    }
}
endif;


if (!function_exists('ag_archief_titel_model')) : function ag_archief_titel_model()
{
    global $wp_query;

    if (isset($wp_query) && property_exists($wp_query, 'queried_object')) {
        if (property_exists($wp_query->queried_object, 'taxonomy')) {
            return $wp_query->queried_object->name;
        }
    }

    $post_type = ag_post_naam_model();



    if ($post_type && $post_type !== '') {
        $obj = get_post_type_object($post_type);
        $post_type = $obj->label;
    } else {
        return false;
    }



    if ($wp_query->is_date) { //is dit een datum archief?
        $archief_titel = ucfirst($post_type) . " ";

        //als op dag, dan 'van', anders, 'uit'
        if (array_key_exists('day', $wp_query->query)) {
            $archief_titel .= 'van ' . $wp_query->query['day'] . " ";
        } else {
            $archief_titel .= 'uit ';
        }

        if (array_key_exists('monthnum', $wp_query->query)) {
            switch ($wp_query->query['monthnum']) {
                case '01':
                    $archief_titel .= 'januari ';
                    break;
                case '02':
                    $archief_titel .= 'februari ';
                    break;
                case '03':
                    $archief_titel .= 'maart ';
                    break;
                case '04':
                    $archief_titel .= 'april ';
                    break;
                case '05':
                    $archief_titel .= 'mei ';
                    break;
                case '06':
                    $archief_titel .= 'juni ';
                    break;
                case '07':
                    $archief_titel .= 'juli ';
                    break;
                case '08':
                    $archief_titel .= 'augustus ';
                    break;
                case '09':
                    $archief_titel .= 'september ';
                    break;
                case '10':
                    $archief_titel .= 'oktober ';
                    break;
                case '11':
                    $archief_titel .= 'november ';
                    break;
                case '12':
                    $archief_titel .= 'december ';
                    break;
                default:
                        //
                    break;
            }
        }

        $archief_titel .= $wp_query->query['year'];
    } elseif (!property_exists($wp_query->queried_object, 'label')) {
        //is dit een taxonomy pagina?

        $tax_naam = $wp_query->queried_object->taxonomy;
        if ($tax_naam === 'category') {
            $tax_naam = 'categorie';
        }
        if ($tax_naam === 'post_tag') {
            $tax_naam = 'tag';
        }

        //bij post type berichten niet 'berichten' ervoor zetten.
        if ($post_type === 'Berichten' || $post_type === 'Posts') {
            $archief_titel = ucfirst($wp_query->queried_object->name);
        } else {
            $archief_titel = ucfirst($post_type !== '' ? $post_type : $tax_naam) . ": " . strtolower($wp_query->queried_object->name);
        }
    } else {
        $archief_titel = ($post_type !== '' ? $post_type : $wp_query->queried_object->label);
    }

    return $archief_titel;
}
endif;


if (!function_exists('ag_archief_sub_tax_model')) : function ag_archief_sub_tax_model()
{
    global $wp_query;

    if ($wp_query->is_post_type_archive || $wp_query->is_date) {
        return false;
    }

    $kind_verz = array();

    $kinderen = get_term_children($wp_query->queried_object->term_id, $wp_query->queried_object->taxonomy);

    if ($kinderen and count($kinderen)) {
        foreach ($kinderen as $kind) {
            $kind_verz[] = get_term_by('id', $kind, $wp_query->queried_object->taxonomy);
        }

        return $kind_verz;
    } else {
        return false;
    }
}
endif;



if (!function_exists('ag_post_naam_model')) : function ag_post_naam_model()
{
    global $wp_query;

    //is query op post type?
    if (array_key_exists('post_type', $wp_query->query)) {
        return $wp_query->query['post_type'];
    } elseif (count($wp_query->posts)) { //neem aan: query op tax
        return $wp_query->posts[0]->post_type;
    } else {
        //lege query
        return false;
    }
}
endif;


if (!function_exists('ag_hero_model')) : function ag_hero_model()
{
    global $post;

    if (empty($post)) {
        return false;
    }

    if (!$hero_aan = get_field('gebruik_hero', $post->ID)) {
        return false;
    }
    if (!has_post_thumbnail()) {
        return false;
    }

    $payoff = get_field('payoff', $post->ID);
    $call_to_action = get_field('call_to_action', $post->ID);
    $call_to_action_2 = get_field('call_to_action_2', $post->ID);

    $r = array(
        'payoff' => $payoff ? ($payoff !== '' ? $payoff : '') : '',
        'call_to_action' => $call_to_action ? ($call_to_action !== '' ? $call_to_action : '') : false,
        'call_to_action_2' => $call_to_action_2 ? ($call_to_action_2 !== '' ? $call_to_action_2 : '') : false,
    );

    return $r;
}
endif;
