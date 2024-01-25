<?php

use agitatie\taal as taal;

get_template_part('head');?>

<body <?php body_class('hidden-body');
body_data(); ?>>
<a id='skip-to-content-link' class="skip-to-content-link" href="#main">
  <?=taal\streng('spring naar inhoud')?>
</a>
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


