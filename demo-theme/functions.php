<?php

/**
 * Add the theme's styles.css
 */
function theme_name_scripts() {
	wp_enqueue_style( 'kirki-demo', get_stylesheet_uri(), array(), time() );
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

if ( class_exists( 'Kirki' ) ) {
    /**
     * Add sections
     */
    Kirki::add_section( 'checkbox', array(
        'title'          => __( 'Checkbox Controls', 'kirki-demo' ),
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'text', array(
        'title'          => __( 'Text Controls', 'kirki-demo' ),
        'priority'       => 2,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'color', array(
        'title'          => __( 'Color & Color-Alpha Controls', 'kirki-demo' ),
        'priority'       => 3,
        'capability'     => 'edit_theme_options',
    ) );

	Kirki::add_section( 'numeric', array(
        'title'          => __( 'Numeric Controls', 'kirki-demo' ),
        'priority'       => 4,
        'capability'     => 'edit_theme_options',
    ) );

	Kirki::add_section( 'radio', array(
        'title'          => __( 'Radio Controls', 'kirki-demo' ),
        'priority'       => 5,
        'capability'     => 'edit_theme_options',
    ) );

	Kirki::add_section( 'select', array(
        'title'          => __( 'Select Controls', 'kirki-demo' ),
        'priority'       => 6,
        'capability'     => 'edit_theme_options',
    ) );

	Kirki::add_section( 'composite', array(
        'title'          => __( 'Composite Controls', 'kirki-demo' ),
        'priority'       => 7,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'custom', array(
        'title'          => __( 'Custom Control', 'kirki-demo' ),
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
        'label'       => __( 'Checkbox demo', 'kirki' ),
        'description' => __( 'This is a simple checkbox', 'kirki-demo' ),
        'section'     => 'checkbox',
        'default'     => true,
        'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'switch',
        'settings'    => 'switch_demo',
        'label'       => __( 'Switch demo', 'kirki' ),
        'description' => __( 'This is a switch control. Internally it is a checkbox and you can also change the ON/OFF labels.', 'kirki-demo' ),
        'section'     => 'checkbox',
        'default'     => true,
        'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'toggle',
        'settings'    => 'toggle_demo',
        'label'       => __( 'Toggle demo', 'kirki' ),
        'description' => __( 'This is a toggle. it is basically identical to a switch, the only difference is that it does not have any labels and to save space it is inline with the label. Internally this is a checkbox.', 'kirki-demo' ),
        'section'     => 'checkbox',
        'default'     => true,
        'priority'    => 10,
    ) );

	Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'text',
    	'settings'    => 'text_demo',
    	'label'       => __( 'Text Control', 'kirki-demo' ),
		'default'     => __( 'This text is entered in the "text" control.', 'kirki-demo' ),
    	'section'     => 'text',
    	'default'     => '',
    	'priority'    => 10,
    ) );

	Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'textarea',
    	'settings'    => 'textarea_demo',
    	'label'       => __( 'Textarea Control', 'kirki-demo' ),
		'default'     => __( 'This text is entered in the "textarea" control.', 'kirki-demo' ),
    	'section'     => 'text',
    	'default'     => '',
    	'priority'    => 10,
    ) );

	Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'editor',
    	'settings'    => 'editor_demo',
    	'label'       => __( 'Editor Control', 'kirki-demo' ),
    	'section'     => 'text',
    	'default'     => __( 'This text is entered in the "editor" control.', 'kirki-demo' ),
    	'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'code',
        'settings'    => 'code_demo',
        'label'       => __( 'Code Control', 'kirki' ),
        'description' => __( 'This is a cimple code control. You can define the language you want as well as the theme. For a full list of available languages and themes see http://ace.c9.io/build/kitchen-sink.html. In this demo we are using a CSS editor with the monokai theme.', 'kirki-demo' ),
        'section'     => 'text',
        'default'     => 'body { background: #fff; }',
        'priority'    => 10,
        'choices'     => array(
            'language' => 'css',
            'theme'    => 'monokai',
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'color',
        'settings'    => 'color_demo',
        'label'       => __( 'Color Control', 'kirki' ),
		'description' => __( 'This uses the default WordPress-core color control.', 'kirki-demo' ),
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
        'label'       => __( 'Color-Alpha Control', 'kirki' ),
		'description' => __( 'Similar to the default Color control but with a teist: This one allows you to also select an opacity for the color and saves the value as HEX or RGBA depending on the alpha channel\'s value.', 'kirki-demo' ),
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
    	'label'       => __( 'Custom Control', 'kirki-demo' ),
    	'description' => __( 'This is the control description', 'kirki-demo' ),
    	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki-demo' ),
    	'section'     => 'custom',
    	'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">You can enter custom markup in this control and use it however you want</div>',
    	'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'dimension',
        'settings'    => 'dimension_demo',
        'label'       => __( 'Dimension Control', 'kirki' ),
        'description' => __( 'In this example we are changing the width of the body', 'kirki-demo' ),
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
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'multicheck',
    	'settings'    => 'multicheck_demo',
    	'label'       => __( 'Multicheck control', 'kirki-demo' ),
		'description' => __( 'You can define choices for this control and it will save the selected values as an array.', 'kirki-demo' ),
    	'section'     => 'checkbox',
    	'default'     => array( 'option-1', 'option-3' ),
    	'priority'    => 10,
        'choices'     => array(
            'option-1' => __( 'Option 1', 'kirki-demo' ),
            'option-2' => __( 'Option 2', 'kirki-demo' ),
            'option-3' => __( 'Option 3', 'kirki-demo' ),
            'option-4' => __( 'Option 4', 'kirki-demo' ),
            'option-5' => __( 'Option 5', 'kirki-demo' ),
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'sortable',
    	'settings'    => 'sortable_demo',
    	'label'       => __( 'Sortable Control', 'kirki-demo' ),
    	'section'     => 'checkbox',
		'description' => __( 'Similar to the "multicheck" control, you can define choices foir this control and the options will be saved as an array. The main difference between the multicheck control and this one is that this one also allows you to rearrange the order of the items.', 'kirki-demo' ),
    	'default'     => array( 'option-1', 'option-3' ),
    	'priority'    => 10,
        'choices'     => array(
            'option-1' => __( 'Option 1', 'kirki-demo' ),
            'option-2' => __( 'Option 2', 'kirki-demo' ),
            'option-3' => __( 'Option 3', 'kirki-demo' ),
            'option-4' => __( 'Option 4', 'kirki-demo' ),
            'option-5' => __( 'Option 5', 'kirki-demo' ),
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'number',
    	'settings'    => 'number_demo',
    	'label'       => __( 'Number Control', 'kirki-demo' ),
		'description' => __( 'This is a simple num,ber control that allows you to select integer values.', 'kirki-demo' ),
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
    	'label'       => __( 'Slider Control', 'kirki-demo' ),
		'description' => __( 'Similar to the number control. The main difference is that on this one you can define a min, max & step value thus allowing you to use decimal values instead of just integers.', 'kirki-demo' ),
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
    	'label'       => __( 'Radio Control', 'kirki-demo' ),
		'description' => __( 'A simple radio-inputs control.', 'kirki-demo' ),
    	'section'     => 'radio',
    	'default'     => 'red',
    	'priority'    => 10,
        'choices'     => array(
            'red'   => __( 'Red', 'kirki-demo' ),
            'green' => __( 'Green', 'kirki-demo' ),
            'blue'  => __( 'Blue', 'kirki-demo' ),
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'radio-buttonset',
    	'settings'    => 'radio_buttonset_demo',
    	'label'       => __( 'Radio-Buttonset Control', 'kirki-demo' ),
		'description' => __( 'This is a radio control styled as inline buttons. You can use this if you have few options with short titles that will fit in a single line.', 'kirki-demo' ),
    	'section'     => 'radio',
    	'default'     => 'green',
    	'priority'    => 10,
        'choices'     => array(
            'red'   => __( 'Red', 'kirki-demo' ),
            'green' => __( 'Green', 'kirki-demo' ),
            'blue'  => __( 'Blue', 'kirki-demo' ),
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'radio-image',
        'settings'    => 'radio_image_demo',
        'label'       => __( 'Radio-Image Control', 'kirki' ),
		'description' => __( 'This is a radio control that allows you to define an image for every option is the array of choices in the field. Useful if you want for example to select a layout. You can even use the images included in the Kirki plugin for that, in the /assets/images directory.', 'kirki-demo' ),
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
        'label'       => __( 'Palette Control', 'kirki' ),
		'description' => __( 'This is basically a radio control. It allows you to define an array of colors that will be used in order to convey your message in a visually compelling way.', 'kirki-demo' ),
        'section'     => 'radio',
        'default'     => 'light',
        'priority'    => 10,
        'choices'     => kirki_demo_get_palettes(),
    ) );

	Kirki::add_field( 'kirki_demo', array(
        'type'        => 'typography',
        'settings'    => 'typography_demo',
        'label'       => __( 'Typography Control', 'kirki' ),
        'description' => __( 'This is a composite typography control. It saves the data as an array, and you can define which of the controls you want shown.', 'kirki' ),
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
        ),
        'output' => array(
            array(
                'element' => 'body',
            ),
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'repeater',
    	'label'       => __( 'Repeater Control', 'kirki' ),
		'description' => __( 'The "repeater" control allows you to create rows of data and you can define the fields that the rows will use. Valide field-types are: text, checkbox, radio, select, textarea. The data is saves as a multi-dimentional array.'),
    	'section'     => 'composite',
        'priority'    => 10,
    	'settings'    => 'repeater_demo',
    	'default'     => array(
            array(
                'link_text' => __( 'Kirki Site', 'kirki-demo' ),
                'link_url'  => 'https://kirki.org',
            ),
            array(
                'link_text' => __( 'Kirki Repository', 'kirki-demo' ),
                'link_url'  => 'https://github.com/aristath/kirki',
            ),
        ),
    	'fields' => array(
    		'link_text' => array(
                'type'        => 'text',
    			'label'       => __( 'Link Text', 'kirki-demo' ),
    			'description' => __( 'This will be the label for your link', 'kirki-demo' ),
    			'default'     => ''
    		),
    		'link_url' => array(
                'type'        => 'text',
    			'label'       => __( 'Link URL', 'kirki-demo' ),
    			'description' => __( 'This will be the link URL', 'kirki-demo' ),
    			'default'     => ''
    		),
    	)
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'select',
    	'settings'    => 'select_demo',
    	'label'       => __( 'Select Control', 'kirki-demo' ),
		'description' => __( 'A simple select (dropdown) control, allowing you to make a single option from a relatively large pool of options.', 'kirki-demo' ),
    	'section'     => 'select',
    	'default'     => 'green',
    	'priority'    => 10,
        'choices'     => array(
            'red'   => __( 'Red', 'kirki-demo' ),
            'green' => __( 'Green', 'kirki-demo' ),
            'blue'  => __( 'Blue', 'kirki-demo' ),
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'select',
    	'settings'    => 'select_multiple_demo',
    	'label'       => __( 'Select Control (multiple)', 'kirki-demo' ),
		'description' => __( 'A multi-select control, allowing you to select multiple items simultaneously as well as re-arrange them at will using a simple drag-n-drop interface. Data is saved as an array.', 'kirki-demo' ),
    	'section'     => 'select',
    	'default'     => array( 'option-1' ),
    	'priority'    => 10,
        'multiple'    => 3,
        'choices'     => array(
            'option-1' => __( 'Option 1', 'kirki-demo' ),
            'option-2' => __( 'Option 2', 'kirki-demo' ),
            'option-3' => __( 'Option 3', 'kirki-demo' ),
            'option-4' => __( 'Option 4', 'kirki-demo' ),
            'option-5' => __( 'Option 5', 'kirki-demo' ),
        ),
    ) );

}
