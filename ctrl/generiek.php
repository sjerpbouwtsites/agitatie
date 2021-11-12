<?php


if (!function_exists('ag_paginering_ctrl')) : function ag_paginering_ctrl()
	{

		$m = ag_paginering_model();

		if (!$m) {
			return; //zie model
		} else {
			ag_array_naar_queryvars($m);
			get_template_part('sja/paginering');
		}
		return $m;
	}
endif;



if (!function_exists('ag_kop_menu_ctrl')) :  function ag_kop_menu_ctrl($menu_klasse = '')
	{

		$menu_locations = get_nav_menu_locations();
		ag_console($menu_locations, 'menu locaties');

		if (!array_key_exists('kop', $menu_locations)) {
			$adm_url = get_admin_url('nav-menus.php');
			echo "<p class='foutmelding'><a href='$adm_url'>👉 Todo: menu maken & aan kop toekennen.</a></p>";
			return;
		}

		$a = array(
			'menu' 			=> 'kop',
		);

		if ($menu_klasse !== '') {
			$a['menu_class'] = $menu_klasse;
		}

		wp_nav_menu($a);
	}
endif;
