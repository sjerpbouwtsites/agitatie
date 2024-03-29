<?php

///////////////////////////////////////////////////////////

define('SITE_URI', get_site_url());
define('THEME_DIR', get_template_directory());
define('THEME_URI', get_template_directory_uri());


define('IMG_DIR', THEME_DIR . "/afb");
define('IMG_URI', THEME_URI . "/afb");
define('JS_DIR', THEME_DIR . "/js");
define('JS_URI', THEME_URI . "/js");

///////////////////////////////////////////////////////////

if (!function_exists('agitatie_stijl_en_script')) :
    function agitatie_stijl_en_script()
    {
        wp_enqueue_style('agitatie-stijl', THEME_URI . '/style.css', array(), null);
        //wp_enqueue_script( 'agitatie-script', JS_URI.'/all.js', array(), null, true );
    }
    add_action('wp_enqueue_scripts', 'agitatie_stijl_en_script');
endif;

///////////////////////////////////////////////////////////

// @TODO conditioneel inladen

$include_boom = array(
    'inc' => array(
        'taal',
        'thema-config', //MOET ALS EERST.
        'edit',
        'gereedschap',
        "klassen",
        'models',
        'posttypes',
        'thumbnails',
        'widgets',
        'strip_scripts',
        "acf", //
        "download-posttype"
    ),
    'ctrl' => array(
        'controllers-bundel'
    ),
    'hooks' => array(
        'agenda',
        'header',
        'singular',
        'voorpagina',
        'footer',
        'archief',
    )

);

foreach ($include_boom as $tak => $map) :

    foreach ($map as $bestand) {
        include THEME_DIR . "/{$tak}/{$bestand}.php";
    }

endforeach; //include boom

agitatie\taal\def_is_meertalig();

///////////////////////////////////////////////////////////

//aanpassingen aan dashboard
add_action('admin_menu', 'remove_menu_pages');
function remove_menu_pages()
{
    remove_menu_page('edit.php?post_type=feedback');
    remove_menu_page('edit-comments.php');
    //remove_menu_page( 'edit.php' );

    //verondersteld: programmeur = 1, opdrachtgever = 2, eindgebruiker > 2
    // @OPLEVERING
    if (get_current_user_id() > 2) {
        remove_menu_page('tools.php');
        remove_menu_page('edit.php?post_type=acf-field-group');
    }
}

///////////////////////////////////////////////////////////

// content width
function change_content_width()
{
    $GLOBALS['content_width'] = 760;
}
add_action('template_redirect', 'change_content_width');

function body_data()
{
    echo " data-content-width='" . $GLOBALS['content_width'] . "' ";
}

////////////////////////////////////////////////////////////

// SAFE THE WIDGETS!!!
/**
 * Riff on wp_setup_widgets_block_editor
 */
function stop_wp_setup_widgets_block_editor()
{
    remove_theme_support('widgets-block-editor');
}

add_action('after_setup_theme', 'stop_wp_setup_widgets_block_editor', 99);

function has_sticky_sidebar()
{
    return is_singular() && !is_front_page() && !is_search();
}

/////////////////////////////////////////////////////////////////



function enqueu_used_material_design_icons()
{
    wp_enqueue_style('material-design-icons-used', THEME_URI . '/material-design-icons-used.css', array(), null);
}
add_action('wp_enqueue_scripts', 'enqueu_used_material_design_icons', 10);


if (!function_exists('ag_config_agenda')) : function ag_config_agenda()
{
    $kind_config = $GLOBALS['kind_config'];

    if (empty($kind_config) || (array_key_exists('agenda', $kind_config) && $kind_config['agenda'])) :

        $agenda = new Posttype_voorb('agenda', 'agenda');
        $agenda->pas_args_aan(array(
            'has_archive' => true,
            'public' => true,
            'show_in_nav_menus' => true,
            'menu_icon' => 'dashicons-calendar-alt',
        ));
        $agenda->registreer();

        $agenda->maak_taxonomie('plek', 'plekken');

    endif;
}
endif;

add_action('after_setup_theme', 'ag_config_agenda');
