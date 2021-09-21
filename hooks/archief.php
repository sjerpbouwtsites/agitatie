<?php



if(!function_exists('ag_archief_titel_hook')) : function ag_archief_titel_hook() {

	ag_archief_titel_ctrl();

} endif;

add_action('ag_archief_titel_action', 'ag_archief_titel_hook', 10);



if(!function_exists('ag_archief_intro_hook')) : function ag_archief_intro_hook() {

	 ag_archief_intro_ctrl(); 

} endif;

add_action('ag_archief_intro_action', 'ag_archief_intro_hook', 10);



if(!function_exists('ag_archief_content_hook')) : function ag_archief_content_hook() {

	
	ag_archief_content_ctrl();
	ag_archief_sub_tax_ctrl();

} endif;

add_action('ag_archief_content_action', 'ag_archief_content_hook', 10);



if(!function_exists('ag_archief_na_content_hook')) : function ag_archief_na_content_hook() {

	ag_paginering_ctrl();

	// global $post;

	// $tax_blok = new Ag_tax_blok(array(
	// 	'post'		=> $post,
	// 	'titel'		=> 'Zoek sneller',
	// 	'reset'		=> false
	// ));
	// $tax_blok->print();

} endif;

add_action('ag_archief_na_content_action', 'ag_archief_na_content_hook', 10);



if(!function_exists('ag_archief_footer_hook')) : function ag_archief_footer_hook() {

	ag_archief_footer_ctrl();

} endif;

add_action('ag_archief_footer_action', 'ag_archief_footer_hook', 10);