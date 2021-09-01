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
	function agitatie_stijl_en_script() {
	    wp_enqueue_style( 'agitatie-stijl', THEME_URI.'/style.css', array(), null );
	    wp_enqueue_script( 'agitatie-script', JS_URI.'/all.js', array(), null, true );
	}
	add_action( 'wp_enqueue_scripts', 'agitatie_stijl_en_script' );
endif;

///////////////////////////////////////////////////////////

// @TODO conditioneel inladen

$include_boom = array(
	'inc' => array(
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
	),
	'jetpack-rip' => array(
		'widget-conditions',
		'related-posts',
		'sharedaddy',
	),
	'ctrl' => array(
		'controllers',
		'archief',
		'categorie',
		'singular'
	),
	'hooks' => array(
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

///////////////////////////////////////////////////////////

//aanpassingen aan dashboard
add_action( 'admin_menu', 'remove_menu_pages' );
function remove_menu_pages() {

	remove_menu_page( 'edit.php?post_type=feedback' );
	remove_menu_page( 'edit-comments.php' );
	//remove_menu_page( 'edit.php' );

	//verondersteld: programmeur = 1, opdrachtgever = 2, eindgebruiker > 2
	// @OPLEVERING
	if( get_current_user_id() > 2) {
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'edit.php?post_type=acf-field-group' );
	}

}

//////////////////////////////////////////////////////////

//js toevoegingen aan dashboard
function js_admin_aanpassing() {
	wp_register_script( 'admin-aanpassing', get_template_directory_uri() . '/admin/admin-aanpassing.js' );
	wp_enqueue_script( 'admin-aanpassing' );
}
add_action( 'admin_enqueue_scripts', 'js_admin_aanpassing' );

///////////////////////////////////////////////////////////

//css toevoegingen aan dashboard
function css_admin_aanpassing() {
	wp_register_style( 'admin-css-aanpassing', THEME_URI . '/admin/admin-aanpassing.css');
	wp_enqueue_style( 'admin-css-aanpassing');
}
add_action('admin_init', 'css_admin_aanpassing' );
