<?php

 $mv_class = (isset($geen_margin) ? ($geen_margin ? '' : 'marginveld') : 'marginveld');
 $veel_class = (isset($veel_margin) ? ($veel_margin ? 'veel' : '') : 'veel');
 $html_na_tekst = (isset($html_onder) ? $html_onder : '');
 $tekst_wrap_in = (isset($html_onder) ? "<div class='tekstveld-links'>" : '');
 $tekst_wrap_uit = (isset($html_onder) ? "</div>" : '');

 echo "
	<$veld_element $tv_id class='tekstveld verpakking verpakking-$formaat $mv_class $veel_class $class'>
		$tekst_wrap_in
		$header
		<div class='tekst'>$verwerkte_tekst</div>
		$tekst_wrap_uit
		$html_na_tekst
	</$veld_element>
";
