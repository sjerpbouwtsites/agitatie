<?php
if (!function_exists('ag_logo_in_footer_hook')) :function ag_logo_in_footer_hook() {
	ag_logo_ctrl();
}
endif;
add_action('ag_footer_voor_velden_action','ag_logo_in_footer_hook', 10);


if(!function_exists('ag_print_footer_widgets')) : function ag_print_footer_widgets() {

   global $wp_registered_sidebars;

   if (array_key_exists('footer-sidebar', $wp_registered_sidebars)) { ?>

	<div class='verpakking widgets'>
		<div class='neg-marge'>
			<?php dynamic_sidebar('footer'); ?>
		</div>
	</div>
	<?php
   }
} endif;

add_action('ag_footer_widget_action', 'ag_print_footer_widgets', 10);