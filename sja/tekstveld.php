<?php

 $mv_class = (isset($geen_margin) ? ($geen_margin ? '' : 'marginveld') : 'marginveld');
 $veel_class = (isset($veel_margin) ? ($veel_margin ? 'veel' : '') : 'veel');

 echo "
	<$veld_element $tv_id class='tekstveld verpakking verpakking-$formaat $mv_class $veel_class'>

		$header
		<div class='tekst'>$verwerkte_tekst</div>
	</$veld_element>
";
