<?php


/***********************************************************************************************
 *    thumbnail formaat instellingen
 *
 */

if(!function_exists('mk_tmb_frm')) : function mk_tmb_frm($naam, $breedte, $hoogte, $crop = true){
    return array(
        'naam'             => $naam,
        'breedte'          => $breedte,
        'hoogte'           => $hoogte,
        'crop'             => $crop,
    );
} endif;

//thumbnailformaten normaal alleen opvraagbaar via query. Dit maakt ze beschikbaar.
//naam //breedte //hoogte //crop

if(!function_exists('thumbnail_init')) : function thumbnail_init() {

    global $kind_thumbs;
    global $thema_ondersteuning;

    $thumbnail_formaten = array(
        'lijst'                     => mk_tmb_frm( 'lijst', 750, 416 ),
        'hele-breedte'              => mk_tmb_frm( 'hele-breedte', 2000, 1400),
        'bovenaan_art'              => mk_tmb_frm( 'bovenaan_art', 2000, 700),
        'portfolio'                 => mk_tmb_frm( 'portfolio', 600, 600),
    );

    if ($kind_thumbs) {
        $thumbnail_formaten = array_merge($thumbnail_formaten, $kind_thumbs);
    }


    foreach ($thumbnail_formaten as $tf) {
        add_image_size($tf['naam'], $tf['breedte'], $tf['hoogte'], $tf['crop']);
    }

    $thema_ondersteuning['thumbnail_formaten'] = $thumbnail_formaten;

}
add_action( 'after_setup_theme', 'thumbnail_init' );
endif;

