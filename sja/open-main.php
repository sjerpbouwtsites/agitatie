<div id="primary" class="<?=$klassen_bij_primary?>">
	<?php if (isset($titel_hoog)) echo $titel_hoog; ?>
	<main id="main" class="site-main <?=has_sticky_sidebar() ? 'heeft-sticky' : ''?> <?=has_post_thumbnail() ? 'heeft-uitgelicht': 'geen-uitgelicht'?> <?=ag_hero_model() ? 'heeft-hero' : ''?>">