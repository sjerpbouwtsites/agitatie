<?php

get_header('sectie');
set_query_var('klassen_bij_primary', "los-bericht strak-tegen-header");
get_template_part('/sja/open-main');

?>

<article class='bericht'>

		<?php
			ag_uitgelichte_afbeelding_ctrl();
		?>

	<div class='verpakking'>

		<?php

		while ( have_posts() ) : the_post();

			echo "<p><strong>".get_field('datum')."</strong></p>";

			the_content();

			echo "<p>";

			$terug_naar_agenda = new Ag_knop(array(
				'class' 	=> 'in-wit ikoon-links',
				'link' 		=> get_post_type_archive_link('agenda'),
				'tekst'		=> 'Terug naar de agenda',
				'ikoon'		=> 'arrow-left-thick'
			));

			$terug_naar_agenda->print();

			echo "</p>";

		endwhile; // End of the loop.
		?>
	</div>
</article>


<?php
get_template_part('/sja/sluit-main');
get_footer();
