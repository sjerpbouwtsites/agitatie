<?php

if (function_exists('pll_the_languages')) :

    echo "<div class='multi-lang-vlaggen__buiten'>";
    echo "<ul class='multi-lang-vlaggen'>";
    pll_the_languages(array('show_flags' => 1, 'show_names' => 0));
    echo "<script>
    document.querySelectorAll('#lang_choice_1 option').forEach(option => {
      if (option.textContent.includes('nl')) {
        option.setAttribute('aria-label', 'Nederlands');
      }
      if (option.textContent.includes('en')) {
        option.setAttribute('aria-label', 'English');
      }      
    });
  </script>";
    echo "</ul>";
    echo "</div>";

endif; // pll_the_languages exists
