<?php

/* template name: waaier */


get_header();

if (!$ptn = get_field('post_type') or $ptn === '') {
	get_template_part('404');
	die();
}

$post_type_obj = get_post_type_object( $ptn);

define('POST_TYPE_NAAM', $ptn);

switch ($ptn) {
	case 'post':
		$ptn_mv = 'Berichten';
		break;
	case 'page':
		$ptn_mv = 'Pagina\'s';
		break;
	default:
		$ptn_mv = $post_type_obj->labels->archives;
		break;
}


set_query_var('klassen_bij_primary', "verpakking waaier waaier-".POST_TYPE_NAAM);
get_template_part('/sja/open-main');

echo "<div class='marginveld veel'>";

echo "<h1>".ucfirst($ptn_mv)."</h1>";


$waaier_q = new WP_query(array(
	'post_type'			=> $ptn,
	'posts_per_page'	=> -1,
	'orderby' 			=> 'title',
	'order' 			=> 'ASC'
));

//ja dit is dubbel op. anders ging niet

$letters_gehad_2 = array();

foreach($waaier_q->posts as $w) {
	if (!in_array($w->post_title[0], $letters_gehad_2)) $letters_gehad_2[] = $w->post_title[0];
}

echo "<nav id='indexNav' class='index-nav'>";

echo "<h3>Druk op een letter om alles uit de index te zien die met die letter begint.</h3>";

$index_k = new Ag_knop(array(
	'geen_ikoon' => true,
	'class'		=> 'in-wit'
));

foreach ($letters_gehad_2 as $l) :

	$index_k->tekst = $l;
	$index_k->link = '#index-'.$l;
	$index_k->print();

endforeach;

echo "</nav>";


$letters_gehad = array();
$huidige_letter = '';

echo "<div class='weetje'>";

while($waaier_q->have_posts()) : $waaier_q->the_post();

	if (!in_array($post->post_title[0], $letters_gehad)) {
		$huidige_letter = $post->post_title[0];

		if (count($letters_gehad) > 0) { //als eerste letter
			echo "</div>";
		}

		echo "<div class='index index-$huidige_letter'>";

		echo "<h3>$huidige_letter</h3>";

		$letters_gehad[] = $huidige_letter;

	}

	?>

	<a class='weetje-letter' href="<?php the_permalink(); ?>" title="<?php echo esc_html(ag_maak_excerpt($post, 500)); ?>"><?php the_title(); ?></a>
	<?php

endwhile;

echo "</div>";//index div

echo "</div>"; //weetje

$tax_blok = new Ag_tax_blok(array(
	'post'		=> $post,
	'titel'		=> 'Zoek specifieker',
	'reset'		=> false
));
$tax_blok->print();

echo "</div>"; //marginveld


get_template_part('/sja/sluit-main');

get_footer();
