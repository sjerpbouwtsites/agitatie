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



if (!function_exists('ag_kop_menu_ctrl')) :  function ag_kop_menu_ctrl()
	{

		// 		global $wpdb;
		// 		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options WHERE option_id = 1", OBJECT );

		// 		SELECT * 
		//   FROM wp_posts 
		//  WHERE post_type = 'nav_menu_item';

		$menu_locations = get_nav_menu_locations();

		if (!array_key_exists('openklap-menu', $menu_locations)) {
			$adm_url = get_admin_url('nav-menus.php');
			echo "<p class='foutmelding'><a href='$adm_url'>👉 Todo: menu maken & aan kop toekennen.</a></p>";
			return;
		}

		if (array_key_exists('prio-menu', $menu_locations)) {
			$a = array(
				'theme_location' 			=> 'prio-menu',
				'menu_class'					=> 'prio-menu menu',
				'container_class'			=> 'prio-menu-container',
			);
			wp_nav_menu($a);
		}

		echo "<a id='mobiele-menu-schakel' href='#' class='schakel kopmenu-mobiel' data-toon='.stek-kop-rechts .openklap-menu-container'>
					<span class='menu-menu-tekst'>Menu</span>";
				 ag_mdi('menu', true);
				ag_mdi('close', true);
			echo "</a>";

		$a = array(
			'theme_location' 			=> 'openklap-menu',
			'menu_class'					=> 'openklap-menu menu',
			'container_class'			=> 'openklap-menu-container',
		);
		wp_nav_menu($a);
	}
endif;
