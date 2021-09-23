<?php

	if (has_sticky_sidebar()) {
	echo "<aside id='sticky-sidebar' class='sticky-sidebar'>";
	echo "<div class='sticky-binnen'>";
	if (is_active_sidebar('sticky-sidebar')) {
		dynamic_sidebar('sticky-sidebar');
	}
	echo "</div>";
	echo "</aside>";
	}

