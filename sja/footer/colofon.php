<?php

$colofon = get_field('colofon', 'option');

if ($colofon and $colofon !== '') {
	echo "<div class='colofon'>";
	echo apply_filters('the_content', $colofon);
	echo "</div>";
}

