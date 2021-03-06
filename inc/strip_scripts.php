<?php



/**
 * Jetpack hardstikke leuk maar we willen niet al die meuk in de requests hebben.
 */

function sjerpbouwtsites_scripts() {

  // jetpack tracking pixel
	wp_dequeue_script( 'devicepx' );
	
}

add_action( 'wp_enqueue_scripts', 'sjerpbouwtsites_scripts' );

remove_action('wp_head', 'wp_enqueue_scripts', 1);
add_action('wp_footer', 'wp_enqueue_scripts', 1);


/***********************************************************************************************
 *    Emoji's eruit gooien.
 *
 */


function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}