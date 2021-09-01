<?php get_template_part('head');?>

<body <?php body_class(); ?>>
<header id='stek-kop'>
	<div class='rel'>
		<div class='verpakking'>

			<?php
				do_action('ag_kop_links_action');
				do_action('ag_kop_rechts_action');
			?>

		</div><!--verpakking-->

	</div>
</header>


