<?php
//

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}


function my_acf_google_map_api( $api ){

	$api['key'] = 'AIzaSyBDW__wSO7mbHOr5VkRoqNR01dXY2exje0';
	return $api;

}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');



if( function_exists('acf_add_local_field_group') ):

	ag_acf_footervelden();
	ag_acf_terugval_afb_optie();
	ag_acf_cat_afb();
	ag_acf_waaier();
	ag_acf_colofon();
	ag_acf_hero();

endif;

function ag_acf_footervelden() {
	acf_add_local_field_group(array(
		'key' => 'group_5a2a87f4a85e0',
		'title' => 'Footer',
		'fields' => array(
			array(
				'key' => 'field_5a2a87ff30e07',
				'label' => 'footervelden',
				'name' => 'footervelden',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'box',
				'button_label' => '',
				'sub_fields' => array(
					array(
						'key' => 'field_5a2a881c30e08',
						'label' => 'titel',
						'name' => 'titel',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_footer_veld',
						'label' => 'veld',
						'name' => 'veld',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'delay' => 1,
					),
				),
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}

function ag_acf_terugval_afb_optie() {
	acf_add_local_field_group(array(
		'key' => 'group_5a995377a4eee',
		'title' => 'terugval afbeelding',
		'fields' => array(
			array(
				'key' => 'field_5a995382bd91b',
				'label' => 'ta afbeelding',
				'name' => 'ta_afbeelding',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}

function ag_acf_cat_afb(){
	acf_add_local_field_group(array(
		'key' => 'group_5ab227a7cd334',
		'title' => 'categorie afbeelding',
		'fields' => array(
			array(
				'key' => 'field_5ab227b1bc075',
				'label' => 'cat afb',
				'name' => 'cat_afb',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'lijst',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'soort',
				),
			),
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'category',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}

function ag_acf_waaier(){



	acf_add_local_field_group(array(
		'key' => 'group_5aa3f750af1d3',
		'title' => 'waaier',
		'fields' => array(
			array(
				'key' => 'field_5aa3f7728529b',
				'label' => 'post type',
				'name' => 'post_type',
				'type' => 'text',
				'instructions' => 'bericht is post, pagina is page. Vul anderen met hand in.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => array(
				),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'return_format' => 'value',
				'placeholder' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'waaier.php',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}

function ag_acf_colofon(){

	acf_add_local_field_group(array(
		'key' => 'group_5ab26c5b0a940',
		'title' => 'colofon',
		'fields' => array(
			array(
				'key' => 'field_5ab26c619f25a',
				'label' => 'colofon',
				'name' => 'colofon',
				'type' => 'wysiwyg',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
				'delay' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}

function ag_acf_hero() {

acf_add_local_field_group(array(
	'key' => 'group_5abfa064542e7',
	'title' => 'hero',
	'fields' => array(
		array(
			'key' => 'field_5abfa06ac535c',
			'label' => 'gebruik_hero',
			'name' => 'gebruik_hero',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5abfa079c535d',
			'label' => 'payoff',
			'name' => 'payoff',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5abfa06ac535c',
						'operator' => '==',
						'value' => '1',
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
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5abfa19915921',
			'label' => 'call to action ',
			'name' => 'call_to_action',
			'type' => 'link',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5abfa06ac535c',
						'operator' => '==',
						'value' => '1',
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
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));


}