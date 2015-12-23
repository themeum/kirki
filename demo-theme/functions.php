<?php

/**
 * Add the theme's styles.css
 */
function kirki_demo_scripts() {
	wp_enqueue_style( 'kirki-demo', trailingslashit( Kirki::$url ) . 'demo-theme/style.css', array(), time() );
}
add_action( 'wp_enqueue_scripts', 'kirki_demo_scripts' );

if ( class_exists( 'Kirki' ) ) {
	/**
	 * Add sections
	 */
	Kirki::add_section( 'checkbox', array(
		'title'          => esc_attr__( 'Checkbox Controls', 'kirki-demo' ),
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'text', array(
		'title'          => esc_attr__( 'Text Controls', 'kirki-demo' ),
		'priority'       => 2,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'color', array(
		'title'          => esc_attr__( 'Color & Color-Alpha Controls', 'kirki-demo' ),
		'priority'       => 3,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'numeric', array(
		'title'          => esc_attr__( 'Numeric Controls', 'kirki-demo' ),
		'priority'       => 4,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'radio', array(
		'title'          => esc_attr__( 'Radio Controls', 'kirki-demo' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'select', array(
		'title'          => esc_attr__( 'Select Controls', 'kirki-demo' ),
		'priority'       => 6,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'composite', array(
		'title'          => esc_attr__( 'Composite Controls', 'kirki-demo' ),
		'priority'       => 7,
		'capability'     => 'edit_theme_options',
	) );

	Kirki::add_section( 'custom', array(
		'title'          => esc_attr__( 'Custom Control', 'kirki-demo' ),
		'priority'       => 4,
		'capability'     => 'edit_theme_options',
	) );

	/**
	 * Add the configuration.
	 * This way all the fields using the 'kirki_demo' ID
	 * will inherit these options
	 */
	Kirki::add_config( 'kirki_demo', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );

	/**
	 * Add fields
	 */
	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'checkbox',
		'settings'    => 'checkbox_demo',
		'label'       => esc_attr__( 'Checkbox demo', 'kirki' ),
		'description' => esc_attr__( 'This is a simple checkbox', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'checkbox',
		'default'     => true,
		'priority'    => 10,
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'switch',
		'settings'    => 'switch_demo',
		'label'       => esc_attr__( 'Switch demo', 'kirki' ),
		'description' => esc_attr__( 'This is a switch control. Internally it is a checkbox and you can also change the ON/OFF labels.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'checkbox',
		'default'     => true,
		'priority'    => 10,
		'required'    => array(
			array(
				'setting'  => 'checkbox_demo',
				'operator' => '==',
				'value'    => true,
			),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'toggle',
		'settings'    => 'toggle_demo',
		'label'       => esc_attr__( 'Toggle demo', 'kirki' ),
		'description' => esc_attr__( 'This is a toggle. it is basically identical to a switch, the only difference is that it does not have any labels and to save space it is inline with the label. Internally this is a checkbox.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'checkbox',
		'default'     => true,
		'priority'    => 10,
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'text',
		'settings'    => 'text_demo',
		'label'       => esc_attr__( 'Text Control', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'default'     => esc_attr__( 'This text is entered in the "text" control.', 'kirki-demo' ),
		'section'     => 'text',
		'default'     => '',
		'priority'    => 10,
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'textarea',
		'settings'    => 'textarea_demo',
		'label'       => esc_attr__( 'Textarea Control', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'default'     => esc_attr__( 'This text is entered in the "textarea" control.', 'kirki-demo' ),
		'section'     => 'text',
		'default'     => '',
		'priority'    => 10,
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'editor',
		'settings'    => 'editor_demo',
		'label'       => esc_attr__( 'Editor Control', 'kirki-demo' ),
		'description' => esc_attr__( 'Editor Control Description', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'text',
		'default'     => esc_attr__( 'This text is entered in the "editor" control.', 'kirki-demo' ),
		'priority'    => 10,
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'code',
		'settings'    => 'code_demo',
		'label'       => esc_attr__( 'Code Control', 'kirki' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'description' => esc_attr__( 'This is a simple code control. You can define the language you want as well as the theme. In this demo we are using a CSS editor with the monokai theme.', 'kirki-demo' ),
		'section'     => 'text',
		'default'     => 'body { background: #fff; }',
		'priority'    => 10,
		'choices'     => array(
			'language' => 'css',
			'theme'    => 'monokai',
			'height'   => 250,
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'color',
		'settings'    => 'color_demo',
		'label'       => esc_attr__( 'Color Control', 'kirki' ),
		'description' => esc_attr__( 'This uses the default WordPress-core color control.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'color',
		'default'     => '#81d742',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => '.demo.color p',
				'property' => 'color',
			),
		),
		'transport'   => 'postMessage',
		'js_vars'     => array(
			array(
				'element'  => '.demo.color p',
				'function' => 'css',
				'property' => 'color',
			),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'color-alpha',
		'settings'    => 'color_alpha_demo',
		'label'       => esc_attr__( 'Color-Alpha Control', 'kirki' ),
		'description' => esc_attr__( 'Similar to the default Color control but with a teist: This one allows you to also select an opacity for the color and saves the value as HEX or RGBA depending on the alpha channel\'s value.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'color',
		'default'     => '#333333',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => '.demo.color',
				'property' => 'background-color',
			),
		),
		'transport'   => 'postMessage',
		'js_vars'     => array(
			array(
				'element'  => '.demo.color',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'custom',
		'settings'    => 'custom_demo',
		'label'       => esc_attr__( 'Custom Control', 'kirki-demo' ),
		'description' => esc_attr__( 'This is the control description', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki-demo' ),
		'section'     => 'custom',
		'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">You can enter custom markup in this control and use it however you want</div>',
		'priority'    => 10,
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'dimension',
		'settings'    => 'dimension_demo',
		'label'       => esc_attr__( 'Dimension Control', 'kirki' ),
		'description' => esc_attr__( 'In this example we are changing the width of the body', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'composite',
		'default'     => '980px',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => 'body',
				'property' => 'width',
			),
		),
		'transport'   => 'postMessage',
		'js_vars'     => array(
			array(
				'element'  => 'body',
				'property' => 'width',
				'function' => 'css',
			),
		),
		'choices' => array(
			'units' => array( '%', 'rem', 'vmax' )
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'multicheck',
		'settings'    => 'multicheck_demo',
		'label'       => esc_attr__( 'Multicheck control', 'kirki-demo' ),
		'description' => esc_attr__( 'You can define choices for this control and it will save the selected values as an array.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'checkbox',
		'default'     => array( 'option-1', 'option-3' ),
		'priority'    => 10,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'kirki-demo' ),
			'option-2' => esc_attr__( 'Option 2', 'kirki-demo' ),
			'option-3' => esc_attr__( 'Option 3', 'kirki-demo' ),
			'option-4' => esc_attr__( 'Option 4', 'kirki-demo' ),
			'option-5' => esc_attr__( 'Option 5', 'kirki-demo' ),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'sortable',
		'settings'    => 'sortable_demo',
		'label'       => esc_attr__( 'Sortable Control', 'kirki-demo' ),
		'section'     => 'checkbox',
		'description' => esc_attr__( 'Similar to the "multicheck" control, you can define choices foir this control and the options will be saved as an array. The main difference between the multicheck control and this one is that this one also allows you to rearrange the order of the items.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'default'     => array( 'option-1', 'option-3' ),
		'priority'    => 10,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'kirki-demo' ),
			'option-2' => esc_attr__( 'Option 2', 'kirki-demo' ),
			'option-3' => esc_attr__( 'Option 3', 'kirki-demo' ),
			'option-4' => esc_attr__( 'Option 4', 'kirki-demo' ),
			'option-5' => esc_attr__( 'Option 5', 'kirki-demo' ),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'number',
		'settings'    => 'number_demo',
		'label'       => esc_attr__( 'Number Control', 'kirki-demo' ),
		'description' => esc_attr__( 'This is a simple num,ber control that allows you to select integer values.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'numeric',
		'default'     => '10',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => '.number-demo-border-radius',
				'property' => 'border-radius',
				'units'    => 'px',
			),
		),
		'transport'    => 'postMessage',
		'js_vars'      => array(
			array(
				'element'  => '.number-demo-border-radius',
				'property' => 'border-radius',
				'units'    => 'px',
				'function' => 'css',
			),
		),
		'choices'      => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1,
		)
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'slider',
		'settings'    => 'slider_demo',
		'label'       => esc_attr__( 'Slider Control', 'kirki-demo' ),
		'description' => esc_attr__( 'Similar to the number control. The main difference is that on this one you can define a min, max & step value thus allowing you to use decimal values instead of just integers.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'numeric',
		'default'     => '10',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => '.slider-demo-border-radius',
				'property' => 'border-radius',
				'units'    => 'px',
			),
		),
		'transport'    => 'postMessage',
		'js_vars'      => array(
			array(
				'element'  => '.slider-demo-border-radius',
				'property' => 'border-radius',
				'units'    => 'px',
				'function' => 'css',
			),
		),
		'choices'      => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1,
		)
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'radio',
		'settings'    => 'radio_demo',
		'label'       => esc_attr__( 'Radio Control', 'kirki-demo' ),
		'description' => esc_attr__( 'A simple radio-inputs control.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'radio',
		'default'     => 'red',
		'priority'    => 10,
		'choices'     => array(
			'red'   => esc_attr__( 'Red', 'kirki-demo' ),
			'green' => esc_attr__( 'Green', 'kirki-demo' ),
			'blue'  => esc_attr__( 'Blue', 'kirki-demo' ),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'radio-buttonset',
		'settings'    => 'radio_buttonset_demo',
		'label'       => esc_attr__( 'Radio-Buttonset Control', 'kirki-demo' ),
		'description' => esc_attr__( 'This is a radio control styled as inline buttons. You can use this if you have few options with short titles that will fit in a single line.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'radio',
		'default'     => 'green',
		'priority'    => 10,
		'choices'     => array(
			'red'   => esc_attr__( 'Red', 'kirki-demo' ),
			'green' => esc_attr__( 'Green', 'kirki-demo' ),
			'blue'  => esc_attr__( 'Blue', 'kirki-demo' ),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'radio-image',
		'settings'    => 'radio_image_demo',
		'label'       => esc_attr__( 'Radio-Image Control', 'kirki' ),
		'description' => esc_attr__( 'This is a radio control that allows you to define an image for every option is the array of choices in the field. Useful if you want for example to select a layout. You can even use the images included in the Kirki plugin for that, in the /assets/images directory.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'radio',
		'default'     => 'left',
		'priority'    => 10,
		'choices'     => array(
			'left'   => admin_url() . '/images/align-left-2x.png',
			'center' => admin_url() . '/images/align-center-2x.png',
			'right'  => admin_url() . '/images/align-right-2x.png',
		),
	) );

	function kirki_demo_get_palettes() {
		return array(
			'light' => array(
				'#ECEFF1',
				'#FFF176',
				'#4DD0E1',
			),
			'dark' => array(
				'#37474F',
				'#F9A825',
				'#00ACC1',
			),
		);
	}
	Kirki::add_field( '', array(
		'type'        => 'palette',
		'settings'     => 'palette_demo',
		'label'       => esc_attr__( 'Palette Control', 'kirki' ),
		'description' => esc_attr__( 'This is basically a radio control. It allows you to define an array of colors that will be used in order to convey your message in a visually compelling way.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'radio',
		'default'     => 'light',
		'priority'    => 10,
		'choices'     => kirki_demo_get_palettes(),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'typography',
		'settings'    => 'typography_demo',
		'label'       => esc_attr__( 'Typography Control', 'kirki' ),
		'description' => esc_attr__( 'This is a composite typography control. It saves the data as an array, and you can define which of the controls you want shown.', 'kirki' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'composite',
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
			'units'          => array( 'px', 'rem' ),
		),
		'output' => array(
			array(
				'element' => 'body',
			),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'repeater',
		'label'       => esc_attr__( 'Repeater Control', 'kirki' ),
		'description' => esc_attr__( 'The "repeater" control allows you to create rows of data and you can define the fields that the rows will use. Valide field-types are: text, checkbox, radio, select, textarea. The data is saves as a multi-dimentional array.' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'composite',
		'priority'    => 10,
		'settings'    => 'repeater_demo',
		'default'     => array(
			array(
				'link_text' => esc_attr__( 'Kirki Site', 'kirki-demo' ),
				'link_url'  => 'https://kirki.org',
			),
			array(
				'link_text' => esc_attr__( 'Kirki Repository', 'kirki-demo' ),
				'link_url'  => 'https://github.com/aristath/kirki',
			),
		),
		'fields' => array(
			'link_text' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Link Text', 'kirki-demo' ),
				'description' => esc_attr__( 'This will be the label for your link', 'kirki-demo' ),
				'default'     => '',
			),
			'link_url' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Link URL', 'kirki-demo' ),
				'description' => esc_attr__( 'This will be the link URL', 'kirki-demo' ),
				'default'     => '',
			),
		)
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'select',
		'settings'    => 'select_demo',
		'label'       => esc_attr__( 'Select Control', 'kirki-demo' ),
		'description' => esc_attr__( 'A simple select (dropdown) control, allowing you to make a single option from a relatively large pool of options.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'select',
		'default'     => 'green',
		'priority'    => 10,
		'choices'     => array(
			''      => esc_attr__( 'Placeholder Text', 'kirki-demo' ),
			'red'   => esc_attr__( 'Red', 'kirki-demo' ),
			'green' => esc_attr__( 'Green', 'kirki-demo' ),
			'blue'  => esc_attr__( 'Blue', 'kirki-demo' ),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'select',
		'settings'    => 'select_multiple_demo',
		'label'       => esc_attr__( 'Select Control (multiple)', 'kirki-demo' ),
		'description' => esc_attr__( 'A multi-select control, allowing you to select multiple items simultaneously as well as re-arrange them at will using a simple drag-n-drop interface. Data is saved as an array.', 'kirki-demo' ),
		'help'        => esc_attr__( 'This is a tooltip', 'kirki-demo' ),
		'section'     => 'select',
		'default'     => array( 'option-1' ),
		'priority'    => 10,
		'multiple'    => 3,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'kirki-demo' ),
			'option-2' => esc_attr__( 'Option 2', 'kirki-demo' ),
			'option-3' => esc_attr__( 'Option 3', 'kirki-demo' ),
			'option-4' => esc_attr__( 'Option 4', 'kirki-demo' ),
			'option-5' => esc_attr__( 'Option 5', 'kirki-demo' ),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'preset',
		'settings'    => 'preset_demo',
		'label'       => esc_attr__( 'Preset control', 'kirki-demo' ),
		'description' => esc_attr__( 'Bulk-changes the value of other controls.', 'kirki-demo' ),
		'section'     => 'select',
		'default'     => '1',
		'priority'    => 10,
		'multiple'    => 3,
		'choices'     => array(
			'1' => array(
				'label'    => esc_attr__( 'Option 1', 'kirki-demo' ),
				'settings' => array(
					'select_demo'             => 'red',
					'select_multiple_demo'    => array( 'option-1', 'option-2' ),
					'color_demo_preset'       => '#0088cc',
					'color_alpha_preset'      => 'rgba(237,226,23,0.58)'
				),
			),
			'2' => array(
				'label'    => esc_attr__( 'Option 2', 'kirki-demo' ),
				'settings' => array(
					'select_demo'             => 'green',
					'select_multiple_demo'    => array( 'option-4', 'option-1' ),
					'color_demo_preset'       => '#333333',
					'color_alpha_preset'      => 'rgba(181,18,178,0.58)'
				),
			),
		),
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'color',
		'settings'    => 'color_demo_preset',
		'label'       => esc_attr__( 'Color Control', 'kirki' ),
		'section'     => 'select',
		'default'     => '#81d742',
		'priority'    => 10,
	) );

	Kirki::add_field( 'kirki_demo', array(
		'type'        => 'color-alpha',
		'settings'    => 'color_alpha_preset',
		'label'       => esc_attr__( 'Color Alpha Control', 'kirki' ),
		'section'     => 'select',
		'default'     => '#ffffff',
		'priority'    => 10,
	) );

}
