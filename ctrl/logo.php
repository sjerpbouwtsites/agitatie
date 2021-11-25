<?php

use agitatie\taal as taal;

// print
if (!function_exists('ag_logo_ctrl')) : function ag_logo_ctrl($print = true)
	{

		if (!has_custom_logo()) {

			// if (is_user_logged_in()) {
			// 	$logo_url = wp_customize_url();
			// 	echo "<p class='foutmelding'><a href='$logo_url'>👉Todo: logo</a></p>";
			// 	return;
			// }

			echo "<a href='" . taal\home_url() . "' class='custom-logo geen-logo' rel='home' itemprop='url'>";
			echo get_bloginfo();
			echo "</a>";
			return;
		}

		if ($print) {
			the_custom_logo();
		} else {
			ob_start();
			the_custom_logo();
			return  ob_get_clean();
		}
	}
endif;
