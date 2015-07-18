<?php
/**
 * Kirki Advanced Customizer
 * This is a sample configuration file to demonstrate all fields & capabilities.
 * @package Kirki
 */

// Early exit if Kirki is not installed
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * Create sections using the WordPress Customizer API.
 */
function kirki_demo_sections( $wp_customize ) {

	/**
	 * Add sections
	 */
	$wp_customize->add_section( 'controls_with_choices', array(
		'title'       => __( 'Controls with Choices', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

	$wp_customize->add_section( 'color_section', array(
		'title'       => __( 'Color Controls', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

	$wp_customize->add_section( 'file_controls_section', array(
		'title'       => __( 'File & Image Controls', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

	$wp_customize->add_section( 'text_section', array(
		'title'       => __( 'Text Control', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

	$wp_customize->add_section( 'background_section', array(
		'title'       => __( 'Background Control', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

	$wp_customize->add_section( 'numeric', array(
		'title'       => __( 'Numeric Controls', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

	$wp_customize->add_section( 'custom_section', array(
		'title'       => __( 'Custom Control', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

}
add_action( 'customize_register', 'kirki_demo_sections' );

/**
 * Create panels using the Kirki API
 */
Kirki::add_section( 'boolean_controls', array(
	'priority'    => 10,
	'title'       => __( 'Boolean Controls', 'kirki' ),
	'description' => __( 'This panel contains controls that return true/false Controls', 'kirki' ),
) );

/**
 * Add controls using the 'kirki/fields' filter.
 */
function kirki_controls_with_choices_fields( $fields ) {

	$fields[] = array(
		'type'        => 'radio',
		'settings'    => 'radio_demo',
		'label'       => __( 'Radio Control', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'option-1',
		'priority'    => 10,
		'choices'     => array(
			'option-1' => __( 'Option 1', 'kirki' ),
			'option-2' => __( 'Option 2', 'kirki' ),
			'option-3' => __( 'Option 3', 'kirki' ),
			'option-4' => __( 'Option 4', 'kirki' ),
		),
	);

	$fields[] = array(
		'type'        => 'dropdown-pages',
		'settings'    => 'dropdown_pages_demo',
		'label'       => __( 'Dropdown Pages', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'priority'    => 10,
	);

	$fields[] = array(
		'type'        => 'select',
		'settings'    => 'select_demo',
		'label'       => __( 'Select', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'option-1',
		'priority'    => 10,
		'choices'     => array(
			'option-1' => __( 'Option 1', 'kirki' ),
			'option-2' => __( 'Option 2', 'kirki' ),
			'option-3' => __( 'Option 3', 'kirki' ),
			'option-4' => __( 'Option 4', 'kirki' ),
		),
	);

	$fields[] = array(
		'type'        => 'radio-image',
		'settings'    => 'radio_image_demo',
		'label'       => __( 'Radio-Image', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'option-1',
		'priority'    => 10,
		'choices'     => array(
			'option-1' => admin_url().'/images/align-left-2x.png',
			'option-2' => admin_url().'/images/align-center-2x.png',
			'option-3' => admin_url().'/images/align-right-2x.png',
		),
	);

	$fields[] = array(
		'type'        => 'radio-buttonset',
		'settings'    => 'radio_buttonset_demo',
		'label'       => __( 'Radio-Buttonset', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'option-1',
		'priority'    => 10,
		'choices'     => array(
			'option-1' => __( 'Option 1', 'kirki' ),
			'option-2' => __( 'Option 2', 'kirki' ),
			'option-3' => __( 'Option 3', 'kirki' ),
		),
	);

	$fields[] = array(
		'type'        => 'multicheck',
		'settings'    => 'multicheck_demo',
		'label'       => __( 'Multicheck', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => array(
			'option-1',
			'option-2',
		),
		'priority'    => 10,
		'choices'     => array(
			'option-1' => __( 'Option 1', 'kirki' ),
			'option-2' => __( 'Option 2', 'kirki' ),
			'option-3' => __( 'Option 3', 'kirki' ),
			'option-4' => __( 'Option 4', 'kirki' ),
		),
	);

	$fields[] = array(
		'type'        => 'sortable',
		'settings'    => 'sortable_demo',
		'label'       => __( 'Sortable', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => array(
			'option-3',
			'option-1',
			'option-4',
		),
		'priority'    => 10,
		'choices'     => array(
			'option-1' => __( 'Option 1', 'kirki' ),
			'option-2' => __( 'Option 2', 'kirki' ),
			'option-3' => __( 'Option 3', 'kirki' ),
			'option-4' => __( 'Option 4', 'kirki' ),
			'option-5' => __( 'Option 5', 'kirki' ),
			'option-6' => __( 'Option 6', 'kirki' ),
		),
	);

	// Define custom palettes
	$fields[] = array(
		'type'        => 'palette',
		'settings'    => 'palette_demo',
		'label'       => __( 'Palette', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'red',
		'priority'    => 10,
		'choices'     => array(
			'red'  => array(
				'#ef9a9a',
				'#f44336',
				'#ff1744',
			),
			'pink' => array(
				'#fce4ec',
				'#f06292',
				'#e91e63',
				'#ad1457',
				'#f50057',
			),
			'cyan' => array(
				'#e0f7fa',
				'#80deea',
				'#26c6da',
				'#0097a7',
				'#00e5ff',
			),
		),
	);

	// Define custom palettes
	$fields[] = array(
		'type'        => 'palette',
		'settings'    => 'palette_demo_colourlovers',
		'label'       => __( 'Palettes from Colourlovers', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'red',
		'priority'    => 10,
		'choices'     => Kirki_Colourlovers::get_palettes( 5 ),
	);

	$fields[] = array(
		'type'        => 'select2',
		'settings'    => 'select_demo_2',
		'label'       => __( 'Select2', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'option-1',
		'priority'    => 10,
		'choices'     => Kirki_Fonts::get_font_choices(),
		'output'      => array(
			array(
				'element'  => 'body p',
				'property' => 'font-family',
			),
		),
	);

	$fields[] = array(
		'type'        => 'select2-multiple',
		'settings'    => 'select_demo_3',
		'label'       => __( 'Select2 - multiple', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => 'option-1',
		'priority'    => 10,
		'choices'     => array(
			'option-1' => __( 'Option 1', 'kirki' ),
			'option-2' => __( 'Option 2', 'kirki' ),
			'option-3' => __( 'Option 3', 'kirki' ),
			'option-4' => __( 'Option 4', 'kirki' ),
		),
	);

	return $fields;

}
add_filter( 'kirki/fields', 'kirki_controls_with_choices_fields' );

/**
 * Add file controls
 */
function kirki_file_controls_fields( $fields ) {

	$fields[] = array(
		'type'        => 'image',
		'settings'    => 'image_demo',
		'label'       => __( 'This is the label', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'file_controls_section',
		'default'     => '',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => 'p',
				'property' => 'background-image',
			),
		),
	);

	$fields[] = array(
		'type'        => 'upload',
		'settings'    => 'file_controls_section',
		'label'       => __( 'This is the label', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'file_controls_section',
		'default'     => '',
		'priority'    => 10,
	);

	return $fields;

}
add_filter( 'kirki/fields', 'kirki_file_controls_fields' );

/**
 * Add text fields
 */
function kirki_text_controls_fields( $fields ) {

	$fields[] = array(
		'type'        => 'text',
		'settings'    => 'text_demo',
		'label'       => __( 'Text', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'text_section',
		'default'     => 'This is some default text',
		'priority'    => 10,
	);

	$fields[] = array(
		'type'        => 'textarea',
		'settings'    => 'textarea_demo',
		'label'       => __( 'Textarea', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'text_section',
		'default'     => 'This is some default text',
		'priority'    => 10,
	);

	$fields[] = array(
		'type'        => 'editor',
		'settings'    => 'wysiwyg',
		'label'       => __( 'Editor', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'default'     => '',
		'section'     => 'text_section',
	);

	return $fields;

}
add_filter( 'kirki/fields', 'kirki_text_controls_fields' );

/**
 * Add numeric fields
 */
function kirki_numeric_fields( $fields ) {

	// step = 10
	$fields[] = array(
		'type'        => 'slider',
		'settings'    => 'slider_demo',
		'label'       => __( 'This is the label', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'numeric',
		'default'     => 20,
		'priority'    => 10,
		'choices'     => array(
			'min'  => -100,
			'max'  => 100,
			'step' => 10,
		),
	);

	// step = 0.01
	$fields[] = array(
		'type'        => 'slider',
		'settings'    => 'slider_demo_2',
		'label'       => __( 'This is the label', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'numeric',
		'default'     => 1.58,
		'priority'    => 20,
		'choices'     => array(
			'min'  => 0,
			'max'  => 5,
			'step' => .01,
		),
	);

	$fields[] = array(
		'type'        => 'number',
		'settings'    => 'number_demo',
		'label'       => __( 'This is the label', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'numeric',
		'default'     => '42',
		'priority'    => 10,
	);

	return $fields;

}
add_filter( 'kirki/fields', 'kirki_numeric_fields' );

/**
 * Create a config instance that will be used by fields added via the static methods.
 * For this example we'll be defining our options to be serialized in the db, under the 'kirki_demo' option.
 */
Kirki::add_config( 'kirki_demo', array(
	'option_type' => 'theme_mod',
) );

/**
 * Create Custom field using the Kirki API static functions
 */
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'custom',
	'settings'    => 'custom_demo',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
	'section'     => 'custom_section',
	'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">You can enter custom markup in this control and use it however you want</div>',
	'priority'    => 10,
) );

/**
 * Create Color fields using the Kirki API static functions
 */
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color',
	'settings'    => 'color_demo',
	'label'       => __( 'Color Control', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users.', 'kirki' ),
	'section'     => 'color_section',
	'default'     => '#0088cc',
	'priority'    => 10,
	'output'      => array(
		array(
			'element'  => 'a, a:visited',
			'property' => 'color',
			'units'    => ' !important',
		),
		array(
			'element'  => '#content',
			'property' => 'border-color',
		),
	),
	'transport'   => 'postMessage',
	'js_vars'     => array(
		array(
			'element'  => 'a, a:visited',
			'function' => 'css',
			'property' => 'color',
		),
		array(
			'element'  => '#content',
			'function' => 'css',
			'property' => 'background-color',
		),
	)
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color-alpha',
	'settings'    => 'color_alpha_demo',
	'label'       => __( 'Color-Alpha Control', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users.', 'kirki' ),
	'section'     => 'color_section',
	'default'     => '#0088cc',
	'priority'    => 10,
	'output'      => array(
		array(
			'element'  => 'a, a:visited',
			'property' => 'color',
			'units'    => ' !important',
		),
		array(
			'element'  => '#content',
			'property' => 'border-color',
		),
	),
	'transport'   => 'postMessage',
	'js_vars'     => array(
		array(
			'element'  => 'a, a:visited',
			'function' => 'css',
			'property' => 'color',
		),
		array(
			'element'  => '#content',
			'function' => 'css',
			'property' => 'background-color',
		),
	)
) );

/**
 * Create Boolean fields using the Kirki API static functions
 */
// Checkbox
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'checkbox',
	'settings'    => 'checkbox_demo_0',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users.', 'kirki' ),
	'section'     => 'boolean_controls',
	'default'     => 1,
	'priority'    => 10,
) );

// Switch
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'switch',
	'settings'    => 'switch_demo_0',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users.', 'kirki' ),
	'section'     => 'boolean_controls',
	'default'     => '1',
	'priority'    => 10,
) );

// Toggle
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'toggle',
	'settings'    => 'toggle_demo_1',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users.', 'kirki' ),
	'section'     => 'boolean_controls',
	'default'     => 1,
	'priority'    => 10,
) );

/**
 * Add the background field
 */
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'background',
	'settings'    => 'background_demo',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
	'section'     => 'background_section',
	'default'     => array(
		'color'    => '#ffffff',
		'image'    => '',
		'repeat'   => 'no-repeat',
		'size'     => 'cover',
		'attach'   => 'fixed',
		'position' => 'left-top',
		'opacity'  => 90,
	),
	'priority'    => 10,
	'output'      => '.hentry',
) );

/**
 * Configuration sample for the Kirki Customizer.
 */
function kirki_demo_configuration_sample() {

	$args = array(
		'logo_image'   => 'http://kirki.org/img/kirki-new-logo-white.png',
		'description'  => __( 'This is the theme description. You can edit it in the Kirki configuration and add whatever you want here.', 'kirki' ),
		'color_accent' => '#00bcd4',
		'color_back'   => '#455a64',
		// 'disable_output' => true,
	);

	return $args;

}

add_filter( 'kirki/config', 'kirki_demo_configuration_sample' );
