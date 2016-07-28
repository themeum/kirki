/**
 * Kirki Advanced Customizer
 * This is a sample configuration file to demonstrate all fields & capabilities.
 * You could include this file, or it's contents in a theme's functions.php
 * and your WP Customizer will be populated with the content below.
 * The sample-config file from the Ornea theme offers even more options,
 * however it may not work in your theme as it is:
 * https://github.com/aristath/ornea/blob/master/inc/kirki/sample-config.php
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

	$wp_customize->add_section( 'repeater_section', array(
		'title'       => __( 'Repeater Control', 'kirki' ),
		'priority'    => 10,
		'description' => __( 'This is the section description', 'kirki' ),
	) );

}
add_action( 'customize_register', 'kirki_demo_sections' );

/**
 * Create panels using the Kirki API
 */
Puredemo_Kirki::add_section( 'boolean_controls', array(
	'priority'    => 10,
	'title'       => __( 'Boolean Controls', 'kirki' ),
	'description' => __( 'This panel contains controls that return true/false Controls', 'kirki' ),
) );

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

	$fields[] = array(
		'type'        => 'code',
		'settings'    => 'code_monokai',
		'label'       => __( 'Code-CSS-Monokai', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'default'     => '',
		'section'     => 'text_section',
		'choices'     => array(
			'theme'    => 'monokai',
			'language' => 'css',
			'height'   => 250,
		)
	);

	$fields[] = array(
		'type'        => 'code',
		'settings'    => 'code_chrom',
		'label'       => __( 'Code-HTML-Chrome', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'default'     => '',
		'section'     => 'text_section',
		'choices'     => array(
			'theme'    => 'chrome',
			'language' => 'html',
			'height'   => 250,
		)
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

	$fields[] = array(
		'type'        => 'dimension',
		'settings'    => 'dimension_demo',
		'label'       => __( 'This is the label', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'numeric',
		'default'     => '42px',
		'priority'    => 10,
	);

	return $fields;

}
add_filter( 'kirki/fields', 'kirki_numeric_fields' );

/**
 * Create a config instance that will be used by fields added via the static methods.
 * For this example we'll be defining our options to be serialized in the db, under the 'pure-demo' option.
 */
Puredemo_Kirki::add_config( 'pure-demo', array(
	'option_type' => 'theme_mod',
) );

Puredemo_Kirki::add_field( 'pure-demo', array(
	'type'        => 'repeater',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help text.', 'kirki' ),
	'section'     => 'repeater_section',
	'default'     => array(),
	'priority'    => 10,
	'settings' => 'pure-demo',
	'fields' => array(
		'subsetting_1' => array(
			'type' => 'text',
			'label' => 'Setting A',
			'description' => 'lalala',
			'default' => 'Yeah'
		),
		'subsetting_2' => array(
			'type' => 'text',
			'label' => 'Setting B',
			'description' => 'lalala',
			'default' => ''
		),
		'subsetting_3' => array(
			'type' => 'checkbox',
			'description' => 'A checkbox',
			'default' => true
		),
		'subsetting_4' => array(
			'label' => 'A selector',
			'type' => 'select',
			'description' => 'lalala',
			'default' => '',
			'choices' => array(
				'' => 'None',
				'choice_1' => 'Choice 1',
				'choice_2' => 'Choice 2'
			)
		),
		'subsetting_5' => array(
			'type' => 'textarea',
			'label' => 'A textarea',
			'description' => 'lalalala',
			'default' => ''
		),
		'subsetting_6' => array(
			'label' => 'A radio',
			'type' => 'radio',
			'description' => 'yipiyai',
			'default' => 'choice-1',
			'choices' => array(
				'choice-1' => 'First choice',
				'choice-2' => 'Second choice'
			)
		),
	)
) );

/**
 * Create Custom field using the Kirki API static functions
 */
Puredemo_Kirki::add_field( 'pure-demo', array(
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
Puredemo_Kirki::add_field( 'pure-demo', array(
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

Puredemo_Kirki::add_field( 'pure-demo', array(
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
Puredemo_Kirki::add_field( 'pure-demo', array(
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
Puredemo_Kirki::add_field( 'pure-demo', array(
	'type'        => 'switch',
	'settings'    => 'switch_demo_0',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users.', 'kirki' ),
	'section'     => 'boolean_controls',
	'default'     => '1',
	'priority'    => 10,
) );
Puredemo_Kirki::add_field( 'pure-demo', array(
	'type'        => 'switch',
	'settings'    => 'switch_demo_1',
	'label'       => __( 'This is the label', 'kirki' ),
	'description' => __( 'This is the control description', 'kirki' ),
	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users.', 'kirki' ),
	'section'     => 'boolean_controls',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => array( 'round' => true ),
) );

// Toggle
Puredemo_Kirki::add_field( 'pure-demo', array(
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
Puredemo_Kirki::add_field( 'pure-demo', array(
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
		// 'logo_image'   => KIRKI_URL . 'assets/images/kirki-toolkit.png',
		// 'color_accent' => '#00bcd4',
		'color_back'   => '#f7f7f7',
		// 'width'        => '350px'
	);

	return $args;
}
add_filter( 'kirki/config', 'kirki_demo_configuration_sample' );

/**
 * Add controls using the 'kirki/fields' filter.
 */
function kirki_controls_with_choices_fields( $fields ) {

	$fields[] = array(
		'type'        => 'typography',
		'settings'    => 'typography_demo',
		'label'       => __( 'Typography Control', 'kirki' ),
		'description' => __( 'This is the control description', 'kirki' ),
		'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
		'section'     => 'controls_with_choices',
		'default'     => array(
			'font-style'     => array( 'bold', 'italic' ),
			'font-family'    => 'Roboto',
			'font-size'      => '14',
			'font-weight'    => '400',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
		),
		'priority'    => 10,
		'choices'     => array(
			'font-style'     => true,
			'font-family'    => true,
			'font-size'      => true,
			'font-weight'    => true,
			'line-height'    => true,
			'letter-spacing' => true,
		),
		'output'  => '.site-description'
	);

	return $fields;

}
add_filter( 'kirki/fields', 'kirki_controls_with_choices_fields' );

function kirki_hooks_init() {
	Puredemo_Kirki::add_config( 'my_kirki_repeater', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'option',
		'option_name'   => 'my_kirki_repeater',
	) );

	Puredemo_Kirki::add_section( 'my_kirki_repeater_section', array(
		'title'          => __( 'Kirki Repeater' ),
		'description'    => __( 'Add custom CSS here' ),
		'panel'          => '', // Not typically needed.
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	) );
}
