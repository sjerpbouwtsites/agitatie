<?php
ob_start();

$img_grootte = isset($overschrijf_thumb_grootte) ? $overschrijf_thumb_grootte : "bovenaan_art";


if (!isset($expliciete_img)) {
	the_post_thumbnail($img_grootte);
} else {
	echo $expliciete_img;
}

//the_post_thumbnail($img_grootte);
$img = ob_get_clean();

if ($img !== '') {

	//echo ag_voeg_attr_in($img, "itemprop='image'");

	echo $img;

	$doc = new DOMDocument();
	$doc->loadHTML($img);
	$xpath = new DOMXPath($doc);
	$desc = strip_tags($xpath->evaluate("string(//img/@data-image-description)"), "<br>");

	if ($desc !== '') echo "<span class='onderschrift'>".($desc !== '' ? $desc : '')."</span>";
}