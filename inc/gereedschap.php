<?php



if (!function_exists('ag_pre_dump')) : function ag_pre_dump($a)
	{
		echo "<pre>";
		var_dump($a);
		echo "</pre>";
	}
endif;



if (!function_exists('ag_maak_excerpt')) : function ag_maak_excerpt($post, $lim = 300)
	{

		if (property_exists($post, 'post_excerpt') and $post->post_excerpt !== "") {
			return ag_beperk_woordental($lim, $post->post_excerpt);
		} else if (property_exists($post, 'post_content')) {
			return strip_tags(ag_beperk_woordental($lim, $post->post_content));
		} else if (property_exists($post, 'description')) {
			return strip_tags(ag_beperk_woordental($lim, $post->description));
		} else {
			return '';
		}
	}
endif;



if (!function_exists('ag_beperk_woordental')) : function ag_beperk_woordental($lim = 300, $tekst = '')
	{

		$charlength = $lim;
		$r = "";

		if (mb_strlen($tekst) > $charlength) {
			$subex = mb_substr($tekst, 0, $charlength - 3);
			$exwords = explode(' ', $subex);
			$excut = - (mb_strlen($exwords[count($exwords) - 1]));
			if ($excut < 0) {
				$r .= mb_substr($subex, 0, $excut);
			} else {
				$r .= $subex;
			}
			$r = rtrim($r);
			$r .= '...';

			return $r;
		} else {
			return $tekst;
		}
	}
endif;



if (!function_exists('ag_appendChildBefore')) : function ag_appendChildBefore($orig, $child)
	{
		//werk alleen bij HTML één niveau diep.
		$expl = explode('>', $orig);
		$tag_naam = substr($expl[0], 1);
		return $expl[0] . ">$child</$tag_naam>";
	}
endif;



if (!function_exists('ag_array_naar_queryvars')) : function ag_array_naar_queryvars($ar = array())
	{
		foreach ($ar as $naam => $waarde) {
			set_query_var($naam, $waarde);
		}
	}
endif;



if (!function_exists('ag_pak_template_naam')) : function ag_pak_template_naam()
	{
		$n = get_page_template();
		return str_replace('.php', '', str_replace(THEME_DIR . "/", '', $n));
	}
endif;



//@TODO naar kern class als functionaliteit
if (!function_exists('ag_cp_truthy')) : function ag_cp_truthy($eigenschap, $klas)
	{
		if (!property_exists($klas, $eigenschap)) {
			return false;
		} else if (empty($klas->$eigenschap)) {
			return false;
		} else {
			return true;
		}
	}
endif;



if (!function_exists('ag_voeg_attr_in')) : function ag_voeg_attr_in($orig = '', $invoeging = '')
	{

		$e = explode(' ', $orig);
		$e[0] = $e[0] . " " . $invoeging;
		return implode(' ', $e);
	}
endif;



if (!function_exists('ag_mdi')) : function ag_mdi($a = '', $echo = true)
	{
		$r = "<i class='mdi mdi-$a'></i>";
		if ($echo) {
			echo $r;
		} else {
			return $r;
		}
	}
endif;

/**
 * Draait de ag_console_opslag sessie uit in console logs
 * leegt console_opslag sessie
 * hoort thuis in wp_footer
 */
function ag_print_console()
{
	if (empty($_SESSION) || !$_SESSION) return;

	if (!array_key_exists('ag_console_opslag', $_SESSION)) {
		return;
	}

	echo "<script id='agitatie-console-dump'>";
	echo "console.info('/- - - - - - / /- - - - - - / /- - - - - - /');\n";
	foreach ($_SESSION['ag_console_opslag'] as $naam => $opslag) {
		if (is_string($naam)) {
			echo "console.info('$naam');\n";
		}
		echo "console.log(" . json_encode($opslag) . ") \n";
		echo "console.info('/- - - - - - / /- - - - - - / /- - - - - - /');\n";
	}
	echo "</script>";
	$_SESSION['ag_console_opslag'] = [];
}

add_action('wp_footer', 'ag_print_console');


if (!function_exists('ag_console')) :
	/**
	 * Dumpt een variabele in de javascript console. Houd een lijst bij, kan vaker gebruikt worden.
	 * @param te_printen willekeurige waarde
	 * @param naam facultatieve titel boven console deel.
	 */
	function ag_console($te_printen = [], $naam = '')
	{
		if (empty($_SESSION)) {
			session_start();
		}

		if (!array_key_exists('ag_console_opslag', $_SESSION)) {
			$_SESSION['ag_console_opslag'] = [];
		}
		if ($naam !== '') {
			$_SESSION['ag_console_opslag'][$naam] = $te_printen;
		} else {
			$_SESSION['ag_console_opslag'][] = $te_printen;
		}
	}
endif;
