<div class='uitgelichte-afbeelding-buiten <?=$heeft_hero ? "hero" : ""?>'>
	<?php

        get_template_part('sja/afb/post-afb-met-desc');
if ($heeft_hero) {
    echo "<div class='uitgelichte-afbeelding-binnen'>";

    echo "<h1>".get_the_title();

    if (isset($payoff) and !!$payoff) {
        echo "<br><span class='slagzin'>$payoff</span>";
    }

    echo "</h1>";

    $cta1OK = isset($call_to_action) and !!$call_to_action;
    $cta2OK = isset($call_to_action_2) and !!$call_to_action_2;


    if ($cta1OK || $cta2OK) {
        echo "<div class='uitgelichte-afb-knop'>";
    }

    if ($cta1OK) {
        $cta = new Ag_knop(array(
            'tekst'		=> $call_to_action['title'],
            'class'		=> 'link',
            'link'		=> $call_to_action['url']
        ));

        $cta->print();
    }


    if ($cta2OK) {
        $cta2 = new Ag_knop(array(
            'tekst'		=> $call_to_action_2['title'],
            'class'		=> 'link ghost',
            'link'		=> $call_to_action_2['url']
        ));


        $cta2->print();
    }

    if ($cta1OK || $cta2OK) {
        echo "</div>";
    }


    echo "</div>";
}

?>
</div>