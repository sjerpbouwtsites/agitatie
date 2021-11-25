<?php

get_header();
set_query_var('klassen_bij_primary', "error-404 not-found verpakking");
get_template_part('/sja/open-main'); ?>

<header class="page-header">
	<h1 class="page-title">
		<?php echo \agitatie\taal\streng('Oeps! Die pagina bestaat niet'); ?>
		!</h1>
</header><!-- .page-header -->

<div class="page-content">
	<p><?php echo \agitatie\taal\streng('Probeer eens onderstaand zoekformulier'); ?>.</p>

	<?php
	get_search_form();

	?>

</div><!-- .page-content -->

<?php
get_template_part('/sja/sluit-main');
get_footer();
