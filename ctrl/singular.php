<?php


if(!function_exists('ag_print_datum_ctrl')) : function ag_print_datum_ctrl() {

	global $post;

	if ($post->post_type !== 'page') {
		get_template_part('sja/datum');
	}

} endif;

add_action('ag_pagina_voor_tekst', 'ag_print_datum_ctrl', 10);




if(!function_exists('ag_art_meta_print_share')) : function ag_art_meta_print_share () {
	sharing_display( '', true ); 
} endif;

if(!function_exists('ag_art_meta_wrap_datum_en_share_start')) : function ag_art_meta_wrap_datum_en_share_start() {
	echo "<div class='art-meta'>";
} endif;

if (!function_exists('ag_art_meta_wrap_datum_en_share_eind')) : function ag_art_meta_wrap_datum_en_share_eind() {
	echo "</div>";
}
endif;

if(!function_exists('ag_art_meta_ctrl')) : function ag_art_meta_ctrl() {

	global $post;

	if (is_admin()) return;

	if (get_option('page_on_front') == $post->ID) {
		//voorpagina. geen art meta.
		return;
	}

    remove_filter( 'the_content', 'sharing_display', 19 );
    remove_filter( 'the_excerpt', 'sharing_display', 19 );

    if ( function_exists( 'sharing_display' ) ) {

    	add_action('ag_pagina_voor_tekst', 'ag_art_meta_print_share', 20);

	}

	//art-meta gestart aan begin van action,
	//gesloten op 99.
	add_action('ag_pagina_voor_tekst', 'ag_art_meta_wrap_datum_en_share_start', 5);
	add_action('ag_pagina_voor_tekst', 'ag_art_meta_wrap_datum_en_share_eind', 99);

}

add_action( 'loop_start', 'ag_art_meta_ctrl' );

endif;

