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


				if (isset($call_to_action) and !!$call_to_action) {
					$cta = new Ag_knop(array(
						'tekst'		=> $call_to_action['title'],
						'class'		=> 'link',
						'link'		=> $call_to_action['url']
					));

					echo "<div class='uitgelichte-afb-knop'>";
						$cta->print();
					echo "</div>";
				}



			echo "</div>";

		}

	?>
</div>