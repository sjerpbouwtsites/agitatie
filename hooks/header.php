<?php


if(!function_exists('ag_kop_links')) : function ag_kop_links() {

	echo "<div class='stek-kop-links'>";
		ag_logo_ctrl();
	echo "</div><!--koplinks-->";

} endif;

add_action('ag_kop_links_action', 'ag_kop_links', 10);


if (!function_exists('ag_kop_rechts')) : function ag_kop_rechts () { ?>

	<div class='stek-kop-rechts'>
		<?php ag_kop_menu_ctrl('horizontaal met-sub menu'); ?>
		<a href='#' class='schakel kopmenu-mobiel' data-toon='.stek-kop-rechts div[class*="menu"]'>Menu <?php ag_mdi('menu', true); ag_mdi('close', true); ?></a>
	</div>

<?php } endif;

add_action('ag_kop_rechts_action', 'ag_kop_rechts', 10);