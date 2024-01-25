<?php

get_header();
set_query_var('klassen_bij_primary', "error-404 not-found verpakking verpakking-klein marginveld");
get_template_part('/sja/open-main'); ?>

<header class="page-header">
	<h1 class=" gecentreerde-titel serif-letter tekst-zijkleur is-page-of-post-titel">
		<?php echo \agitatie\taal\streng('Oeps! Die pagina bestaat niet'); ?>
		!</h1>
</header><!-- .page-header -->

<div class="bericht-tekst">
	<p><?php echo \agitatie\taal\streng('Probeer eens onderstaand zoekformulier'); ?>.</p>
	
	<div id="zoekveld2" style="display: flex;">

		<form role="search" method="get" class="search-form" action="<?=get_site_url()?>">
			<label>
				<span class="screen-reader-text">Zoeken naar:</span>
				<input class="search-field" placeholder="Zoeken …" value="" name="s" type="search">
			</label>
			<label for="kop-zoekveld">
				<input id="kop-zoekveld" class="search-submit knop-rond" value="Zoeken" type="submit">
				
			</label>
		</form>

</div>

</div><!-- .page-content -->

<?php
get_template_part('/sja/sluit-main');
get_footer();
