<?php

$filter_text = "";


if ( count($_POST) and
	(array_key_exists('soort', $_POST) and $_POST['soort'] !== '') ||
	(array_key_exists('locatie', $_POST) and $_POST['locatie'] !== '') ) {


	$filter_t_ar = array();

	if (array_key_exists('soort', $_POST) and $_POST['soort'] !== '') {
		$filter_t_ar[] = $_POST['soort'];
	}

	if (array_key_exists('locatie', $_POST) and $_POST['locatie'] !== '') {
		$filter_t_ar[] = $_POST['locatie'];
	}

	$filter_text = "Je zocht op ". implode(', ', $filter_t_ar) . ".";

}

?>



<p><?=$filter_text?></p>

<form class='doos' id='agenda-filter' action='<?php echo get_post_type_archive_link('agenda'); ?>' method='POST'>
	<div class='flex'>

		<?php
		foreach ($filters_inst as $tax_naam => $opts) {
			$prio = false;



			echo "<section class='flex'>";
			echo "<h3>".$tax_naam."</h3>";

			if (array_key_exists($tax_naam, $_POST)) {
				$prio = $_POST[$tax_naam];
				$prio_naam = '';
				foreach ($opts as $o) {
					if ($o['slug'] === $prio) {
						$prio_naam = $o['name'] ;
						break;
					}
				}
			}

			echo "<select class='agenda-filters ".($prio ? "geklikt" : "")."' name='$tax_naam'>";


			if ($prio) {
				echo "<option value='$prio'>$prio_naam</option>";
			}
				echo "<option value=''>geen keuze</option>";



			foreach ($opts as $o) {
				if ($o['slug'] === $prio) continue;

				$count_print = $filters_actief ? "" : "(".$o['count'].")";

				echo "<option value='".$o['slug']."'>".$o['name']."$count_print</option>";
			}

			echo "</select>";
			echo "</section>";

		}?>

		<input type='submit' value='filter'>
	</div>

	<!--WEG IN PRODUCTIE -->
	<input type='hidden' name='pag' value='agenda'>
</form>