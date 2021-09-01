<?php


add_action( 'ag_singular_na_artikel', 'sk_related_posts', 20 );
/**
 * Outputs related posts with thumbnail.
 *
 * @author Nick the Geek
 * @url http://designsbynickthegeek.com/tutorials/related-posts-genesis
 * @global object $post
 * @author 2: Sjerp van Wouden - major edit - gone with the genesis stuff - compatible with agitaite theme
 * @url https://sjerpbouwtsites.nl
 */
function sk_related_posts() {
    global $do_not_duplicate;

    // If we are not on a single post page, abort.
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    global $count;
    $count = 0;

    $related = '';

    $do_not_duplicate = array();

    // Get the tags for the current post.
    $tags = get_the_terms( get_the_ID(), 'post_tag' );

    // Get the categories for the current post.
    $cats = get_the_terms( get_the_ID(), 'category' );

    // If we have some tags, run the tag query.
    if ( $tags ) {
        $query    = sk_related_tax_query( $tags, $count, 'tag' );
        $related .= $query['related'];
        $count    = $query['count'];
    }

    // If we have some categories and less than 3 posts, run the cat query.
    if ( $cats && $count <= 2 ) {
        $query    = sk_related_tax_query( $cats, $count, 'category' );
        $related .= $query['related'];
        $count    = $query['count'];
    }

    // End here if we don't have any related posts.
    if ( ! $related ) {
        return;
    }

    // Display the related posts section.
    echo '<div class="related  verpakking verpakking-klein">';
        echo '<h3 class="related-title">Bij dit artikel</h3>';
        echo '<div class="related-posts">' . $related . '</div>';
    echo '</div>';
}

/**
 * The taxonomy query.
 *
 * @since  1.0.0
 *
 * @param  array  $terms Array of the taxonomy's objects.
 * @param  int    $count The number of posts.
 * @param  string $type  The type of taxonomy, e.g: `tag` or `category`.
 *
 * @return string
 */
function sk_related_tax_query( $terms, $count, $type ) {
    global $do_not_duplicate;

    // If the current post does not have any terms of the specified taxonomy, abort.
    if ( ! $terms ) {
        return;
    }

    // Array variable to store the IDs of the posts.
    // Stores the current post ID to begin with.
    $post_ids = array_merge( array( get_the_ID() ), $do_not_duplicate );

    $term_ids = array();

    // Array variable to store the IDs of the specified taxonomy terms.
    foreach ( $terms as $term ) {
        $term_ids[] = $term->term_id;
    }

    $tax_query = array(
        array(
            'taxonomy'  => 'post_format',
            'field'     => 'slug',
            'terms'     => array(
                'post-format-link',
                'post-format-status',
                'post-format-aside',
                'post-format-quote',
            ),
            'operator' => 'NOT IN',
        ),
    );

    $showposts = 3 - $count;

    $args = array(
        $type . '__in'        => $term_ids,
        'post__not_in'        => $post_ids,
        'showposts'           => $showposts,
        'ignore_sticky_posts' => 1,
        'tax_query'           => $tax_query,
    );

    $related  = '';

    $tax_query = new WP_Query($args);

    if ( $tax_query->have_posts() ) {
        while ( $tax_query->have_posts() ) {

        	global $post;

            $tax_query->the_post();

            $do_not_duplicate[] = get_the_ID();

            $count++;

            $title = get_the_title();

            $related .= '<div class="related-post">';

            	$related .= '<a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to ' . $title . '">';

            	$related .= get_the_post_thumbnail($post->ID, 'lijst');

            	$related .= "</a>";

            	$related .= '<div class="related-post-info"><a class="related-post-title" href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to ' . $title . '">' . $title . '</a>';

            	$related .= '<div class="related-post-date">' . get_the_date() . '</div>';

            	$related .= '</div>';

            $related .= '</div>';
        }
    }

    wp_reset_postdata();

    $output = array(
        'related' => $related,
        'count'   => $count,
    );

    return $output;
}


function related_posts_enqeue() {
    wp_enqueue_style( 'related-stijl', THEME_URI.'/css/related-posts.css', array(), null );
    wp_enqueue_script( 'related-script', JS_URI.'/related-posts.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'related_posts_enqeue' );
