<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php get_template_part('sja/header/google-analytics'); ?>
	<?php get_template_part('sja/header/google-fonts'); ?>
	<style>
		body.hidden-body {
    		opacity: 0;
		}
		body.has-animation {
    transition-property: opacity;
    transition-duration: 0.075s ease-in;
}

body.hidden-body {
    opacity: 1 !important;
}

body.hidden-body.animate-into-view {
    opacity: 1;
}
	</style>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php wp_head(); ?>
<meta name="format-detection" content="telephone=no"/>
</head>