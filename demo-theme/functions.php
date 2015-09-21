<?php

/**
 * Add the theme's styles.css
 */
function theme_name_scripts() {
	wp_enqueue_style( 'kirki-demo', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

if ( class_exists( 'Kirki' ) ) {
    /**
     * Add sections
     */
    Kirki::add_section( 'checkbox', array(
        'title'          => __( 'Checkbox Control', 'kirki-demo' ),
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'code', array(
        'title'          => __( 'Code Control', 'kirki-demo' ),
        'priority'       => 2,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'color', array(
        'title'          => __( 'Color & Color-Alpha Controls', 'kirki-demo' ),
        'priority'       => 3,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'custom', array(
        'title'          => __( 'Custom Control', 'kirki-demo' ),
        'priority'       => 4,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'dimension', array(
        'title'          => __( 'Dimension Control', 'kirki-demo' ),
        'priority'       => 5,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'text', array(
        'title'          => __( 'Text Controls', 'kirki-demo' ),
        'priority'       => 6,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'multicheck', array(
        'title'          => __( 'Multicheck Control', 'kirki-demo' ),
        'priority'       => 7,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'number', array(
        'title'          => __( 'Number Control', 'kirki-demo' ),
        'priority'       => 8,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'palette', array(
        'title'          => __( 'Palette Control', 'kirki-demo' ),
        'priority'       => 9,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'radio', array(
        'title'          => __( 'Radio Control', 'kirki-demo' ),
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'repeater', array(
        'title'          => __( 'Repeater Control', 'kirki-demo' ),
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'select', array(
        'title'          => __( 'Select Controls', 'kirki-demo' ),
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
    ) );

    Kirki::add_section( 'typography', array(
        'title'          => __( 'Typography Control', 'kirki-demo' ),
        'priority'       => 10,
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
        'description' => __( 'This is the control description', 'kirki-demo' ),
        'section'     => 'checkbox',
        'default'     => true,
        'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'switch',
        'settings'    => 'switch_demo',
        'label'       => __( 'Switch demo', 'kirki' ),
        'description' => __( 'This is the control description', 'kirki-demo' ),
        'section'     => 'checkbox',
        'default'     => true,
        'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'toggle',
        'settings'    => 'toggle_demo',
        'label'       => __( 'Toggle demo', 'kirki' ),
        'description' => __( 'This is the control description', 'kirki-demo' ),
        'section'     => 'checkbox',
        'default'     => true,
        'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'code',
        'settings'    => 'code_demo',
        'label'       => __( 'Code demo', 'kirki' ),
        'description' => __( 'Enter some custom CSS', 'kirki-demo' ),
        'section'     => 'code',
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
        'label'       => __( 'Color demo', 'kirki' ),
        'section'     => 'color',
        'default'     => '#81d742',
        'priority'    => 10,
        'output'      => array(
            array(
                'element'  => '.demo.color p',
                'property' => 'color',
            ),
        ),
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
        'label'       => __( 'Color-Alpha demo', 'kirki' ),
        'section'     => 'color',
        'default'     => '#333333',
        'priority'    => 10,
        'output'      => array(
            array(
                'element'  => '.demo.color',
                'property' => 'background-color',
            ),
        ),
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
    	'label'       => __( 'This is the label', 'kirki-demo' ),
    	'description' => __( 'This is the control description', 'kirki-demo' ),
    	'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki-demo' ),
    	'section'     => 'custom',
    	'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">You can enter custom markup in this control and use it however you want</div>',
    	'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'dimension',
        'settings'    => 'dimension_demo',
        'label'       => __( 'This is the label', 'kirki' ),
        'description' => __( 'This controls the width of the body', 'kirki-demo' ),
        'section'     => 'dimension',
        'default'     => '980px',
        'priority'    => 10,
        'output'      => array(
            array(
                'element'  => 'body',
                'property' => 'width',
            ),
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'editor',
    	'settings'    => 'editor_demo',
    	'label'       => __( 'This is the label', 'kirki-demo' ),
    	'section'     => 'text',
    	'default'     => __( 'This text is entered in the "editor" control.', 'kirki-demo' ),
    	'priority'    => 10,
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'multicheck',
    	'settings'    => 'multicheck_demo',
    	'label'       => __( 'This is the label', 'kirki-demo' ),
    	'section'     => 'multicheck',
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
    	'label'       => __( 'This is the label', 'kirki-demo' ),
    	'section'     => 'multicheck',
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
    	'label'       => __( 'This is the label', 'kirki-demo' ),
    	'section'     => 'number',
    	'default'     => '10',
    	'priority'    => 10,
        'output'      => array(
            array(
                'element'  => '.number-demo-border-radius',
                'property' => 'border-radius',
                'units'    => 'px',
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
    	'label'       => __( 'This is the label', 'kirki-demo' ),
    	'section'     => 'number',
    	'default'     => '10',
    	'priority'    => 10,
        'output'      => array(
            array(
                'element'  => '.slider-demo-border-radius',
                'property' => 'border-radius',
                'units'    => 'px',
            ),
        ),
        'choices'      => array(
            'min'  => 0,
            'max'  => 30,
            'step' => 1,
        )
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
        'label'       => __( 'This is the label', 'kirki' ),
        'section'     => 'palette',
        'default'     => 'light',
        'priority'    => 10,
        'choices'     => kirki_demo_get_palettes(),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'radio',
    	'settings'    => 'radio_demo',
    	'label'       => __( 'This is the label', 'kirki-demo' ),
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
    	'label'       => __( 'This is the label', 'kirki-demo' ),
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
        'label'       => __( 'Radio-Image', 'kirki' ),
        'section'     => 'radio',
        'default'     => 'left',
        'priority'    => 10,
        'choices'     => array(
            'left'   => admin_url().'/images/align-left-2x.png',
            'center' => admin_url().'/images/align-center-2x.png',
            'right'  => admin_url().'/images/align-right-2x.png',
        ),
    ) );

    Kirki::add_field( 'kirki_demo', array(
    	'type'        => 'repeater',
    	'label'       => __( 'This is the label', 'kirki' ),
    	'section'     => 'repeater',
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
    	'label'       => __( 'This is the label', 'kirki-demo' ),
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
    	'label'       => __( 'This is the label', 'kirki-demo' ),
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

    Kirki::add_field( 'kirki_demo', array(
        'type'        => 'typography',
        'settings'    => 'typography_demo',
        'label'       => __( 'Typography Control', 'kirki' ),
        'description' => __( 'This is the control description', 'kirki' ),
        'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
        'section'     => 'typography',
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
    	'label'       => __( 'Social Media', 'kirki' ),
    	'section'     => 'my-section',
        'priority'    => 10,
    	'settings'    => 'social_networks',
    	'default'     => array(),
    	'fields' => array(
    		'network' => array(
                'type'        => 'select',
    			'label'       => __( 'Social Network', 'kirki-demo' ),
    			'default'     => 'facebook',
                'choices'     => array(
                    'facebook'    => 'Facebook',
                    'twitter'     => 'Twitter',
                    'google-plus' => 'Google+'
                ),
    		),
    		'url' => array(
                'type'        => 'text',
    			'label'       => __( 'Link URL', 'kirki-demo' ),
    			'default'     => 'https://'
    		),
    	)
    ) );
}
