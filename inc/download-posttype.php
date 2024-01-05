<?php

namespace agitatie\downloads;

use agitatie\taal;

if ($kind_config && $kind_config['downloads']) {
    \add_action('init', 'agitatie\downloads\registreer_downloads');
    \add_action('after_setup_theme', 'agitatie\downloads\registreer_downloads_velden');
    \add_action('template_redirect', '\agitatie\downloads\geen_single');
}

function geen_single()
{
    global $post;
    if (is_singular() && $post->post_type === 'download') {
        wp_redirect(get_post_type_archive_link('download'));
        exit;
    }
}



function registreer_downloads()
{
    $download_desc = ucfirst(taal\streng('download posters, flyers, etc!'));

    $download = new \Posttype_voorb('download', 'downloads');
    $download->pas_args_aan(array(
      'menu_icon'           => 'dashicons-download',
      'description'         => "<div class='bericht-tekst'>
          <p>$download_desc</p>
      </div>",
      'supports' =>         array(
        'title',
        'excerpt',
        'thumbnail',

      ),
    ));
    $download->registreer();
}

function registreer_downloads_velden()
{
    if (function_exists('acf_add_local_field_group')) :

        if (function_exists('acf_add_local_field_group')) :

            acf_add_local_field_group(array(
              'key' => 'group_6226b5debb427',
              'title' => 'Download',
              'fields' => array(
                array(
                  'key' => 'field_6226b95404132',
                  'label' => 'bestand of url',
                  'name' => 'bestand_of_url',
                  'type' => 'radio',
                  'instructions' => 'Gebruik je een bestand of een url?',
                  'required' => 0,
                  'conditional_logic' => 0,
                  'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'choices' => array(
                    'bestand' => 'bestand',
                    'url' => 'url',
                  ),
                  'allow_null' => 0,
                  'other_choice' => 0,
                  'default_value' => 'bestand',
                  'layout' => 'vertical',
                  'return_format' => 'value',
                  'save_other_choice' => 0,
                ),
                array(
                  'key' => 'field_6226b5e752dc6',
                  'label' => 'bestand',
                  'name' => 'bestand',
                  'type' => 'file',
                  'instructions' => '',
                  'required' => 1,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field' => 'field_6226b95404132',
                        'operator' => '==',
                        'value' => 'bestand',
                      ),
                    ),
                  ),
                  'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'return_format' => 'url',
                  'library' => 'all',
                  'min_size' => '',
                  'max_size' => '',
                  'mime_types' => '',
                ),
                array(
                  'key' => 'field_6226b98a04133',
                  'label' => 'url',
                  'name' => 'url',
                  'type' => 'url',
                  'instructions' => 'url naar een extern bestand.',
                  'required' => 0,
                  'conditional_logic' => array(
                    array(
                      array(
                        'field' => 'field_6226b95404132',
                        'operator' => '==',
                        'value' => 'url',
                      ),
                    ),
                  ),
                  'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                  ),
                  'default_value' => '',
                  'placeholder' => '',
                ),
              ),
              'location' => array(
                array(
                  array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'download',
                  ),
                ),
              ),
              'menu_order' => 0,
              'position' => 'normal',
              'style' => 'default',
              'label_placement' => 'top',
              'instruction_placement' => 'label',
              'hide_on_screen' => '',
              'active' => true,
              'description' => '',
              'show_in_rest' => 0,
            ));

        endif;

    endif;
}
