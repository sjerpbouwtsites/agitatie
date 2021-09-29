<?php

if(!function_exists('ag_agenda_filter_ctrl')) : function ag_agenda_filter_ctrl() {

$m = ag_agenda_filter_model();

ag_array_naar_queryvars($m);

get_template_part('sja/agenda-filter');

return $m;

} endif;