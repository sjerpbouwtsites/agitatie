<?php if (function_exists('pll_the_languages')) :

  echo "<div class='multi-lang-vlaggen__buiten'>";
  echo "<ul class='multi-lang-vlaggen'>";
  pll_the_languages(array('show_flags' => 1, 'show_names' => 0));
  echo "</ul>";
  echo "</div>";

endif; // pll_the_languages exists			
