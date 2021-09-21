<?php

 $mv_class = (isset($geen_margin) ? ($geen_margin ? '' : 'marginveld') : 'marginveld');

echo "
	<$veld_element $tv_id class='tekstveld verpakking verpakking-$formaat $mv_class'>

		$header
		<div class='tekst'>$verwerkte_tekst</div>
	</$veld_element>
";

