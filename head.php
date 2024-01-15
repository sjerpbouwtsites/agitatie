<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php get_template_part('sja/header/google-analytics'); ?>
	<style>
		<?php if (!$_GET['debug']) : ?>body.hidden-body {
    		opacity: 0;
		}<?php endif;?>
	</style>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php wp_head(); ?>
<?php get_template_part('sja/header/google-fonts'); ?>
<meta name="format-detection" content="telephone=no"/>
</head>