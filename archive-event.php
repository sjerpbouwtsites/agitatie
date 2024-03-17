<?php

use agitatie\taal as taal;

get_header();

set_query_var('klassen_bij_primary', "agenda-pag");
get_template_part('/sja/open-main');

?>
<div class='verpakking'>
	<div class='agenda'>
		<h1><?php

            $arch = array_key_exists('archief', $_POST) || array_key_exists('archief', $_GET);
if (!$arch) {
    echo ucfirst(taal\streng('events'));
} else {
    echo ucfirst(taal\streng('events archief'));
}
?></h1>

		<?php

//$afm = ag_agenda_filter_ctrl();

if (have_posts()) :

    $agenda = new Ag_agenda(array(
        'aantal' => 150,
        'omgeving' => 'pagina'
    ));

    $agenda->print();

    ?>

		<?php // ag_paginering_ctrl();

else :

    echo "<p>Niets gevonden met deze opdracht.</p>";

endif;

?>
	</div>
</div>

<?php

get_template_part('/sja/sluit-main');
get_footer();
