<?php
    /**
     * Kirki Advanced Customizer
     * This is a sample configuration file to demonstrate all fields & capabilities.
     * CAUTION:
     * USE THIS WITH THE DEVELOP BRANCH ON THE GITHUB REPOSITORY:
     * https://github.com/aristath/kirki/tree/develop
     *
     * @package Kirki
     */


    /*
     * TO LOAD THIS DEMO, SIMPLY INCLUDE THIS CODE ANYWHERE AFTER plugins_loaded HAS RUN

        if ( defined( 'KIRKI_PATH' ) && file_exists( KIRKI_PATH . '/sample-config.php' ) ) {
            include( KIRKI_PATH . '/sample-config.php' );
        }

     */



    /**
     * Create our panels and sections.
     * For this example we'll be creating 2 panels (1 for default WordPress controls and another for our custom controls)
     * and then a separate section for each control type.
     */
    function kirki_demo_panels_sections( $wp_customize ) {
        /**
         * Add panels
         */
        $wp_customize->add_panel( 'default_controls', array(
            'priority'    => 10,
            'title'       => __( 'Default WordPress Controls', 'kirki' ),
            'description' => __( 'This panel contains the default WordPress Controls', 'kirki' ),
        ) );

        $wp_customize->add_panel( 'kirki_controls', array(
            'priority'    => 10,
            'title'       => __( 'Kirki Custom Controls', 'ornea' ),
            'description' => __( 'This panel contains the Kirki custom controls', 'kirki' ),
        ) );

        /**
         * Add sections
         */
        $wp_customize->add_section( 'radio_section', array(
            'title'       => __( 'Radio Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'checkbox_section', array(
            'title'       => __( 'Checkbox Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'color_section', array(
            'title'       => __( 'Color Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'dropdown_pages_section', array(
            'title'       => __( 'Dropdown-Pages Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'image_section', array(
            'title'       => __( 'Image Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'select_section', array(
            'title'       => __( 'Select Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'text_section', array(
            'title'       => __( 'Text Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'textarea_section', array(
            'title'       => __( 'Textarea Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'upload_section', array(
            'title'       => __( 'Upload Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'default_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'radio_image_section', array(
            'title'       => __( 'Radio-Image Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'radio_buttonset_section', array(
            'title'       => __( 'Radio-Buttonset Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'background_section', array(
            'title'       => __( 'Background Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'multicheck_section', array(
            'title'       => __( 'Multicheck Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'slider_section', array(
            'title'       => __( 'Slider Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'switch_section', array(
            'title'       => __( 'Switch Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'toggle_section', array(
            'title'       => __( 'Toggle Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'sortable_section', array(
            'title'       => __( 'Sortable Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'number_section', array(
            'title'       => __( 'Number Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'custom_section', array(
            'title'       => __( 'Custom Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

        $wp_customize->add_section( 'palette_section', array(
            'title'       => __( 'Palette Control', 'kirki' ),
            'priority'    => 10,
            'panel'       => 'kirki_controls',
            'description' => __( 'This is the section description', 'kirki' ),
        ) );

    }

    add_action( 'customize_register', 'kirki_demo_panels_sections' );


    /**
     * Add our controls.
     */
    function kirki_demo_controls( $controls ) {

        $controls[] = array(
            'type'        => 'radio',
            'setting'     => 'radio_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'radio_section',
            'default'     => 'option-1',
            'priority'    => 10,
            'choices'     => array(
                'option-1' => __( 'Option 1', 'kirki' ),
                'option-2' => __( 'Option 2', 'kirki' ),
                'option-3' => __( 'Option 3', 'kirki' ),
                'option-4' => __( 'Option 4', 'kirki' ),
            ),
        );

        // checked
        $controls[] = array(
            'type'        => 'checkbox',
            'setting'     => 'checkbox_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'checkbox_section',
            'default'     => 1,
            'priority'    => 10,
        );

        // unchecked
        $controls[] = array(
            'type'        => 'checkbox',
            'setting'     => 'checkbox_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'checkbox_section',
            'default'     => 0,
            'priority'    => 10,
        );

        $controls[] = array(
            'type'        => 'color',
            'setting'     => 'color_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'color_section',
            'default'     => '#0088cc',
            'priority'    => 10,
            'output'      => array(
                array(
                    'element'  => 'a, a:visited',
                    'property' => 'color',
                    'units'    => ' !important'
                ),
                array(
                    'element'  => '#content',
                    'property' => 'border-color'
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
        );

        $controls[] = array(
            'type'        => 'dropdown-pages',
            'setting'     => 'dropdown_pages_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'dropdown_pages_section',
            'priority'    => 10,
        );

        $controls[] = array(
            'type'        => 'image',
            'setting'     => 'image_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'image_section',
            'default'     => '',
            'priority'    => 10,
            'output'      => array(
                array(
                    'element'  => 'p',
                    'property' => 'background-image',
                ),
            ),
        );

        $controls[] = array(
            'type'        => 'select',
            'setting'     => 'select_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'select_section',
            'default'     => 'option-1',
            'priority'    => 10,
            'choices'     => array(
                'option-1' => __( 'Option 1', 'kirki' ),
                'option-2' => __( 'Option 2', 'kirki' ),
                'option-3' => __( 'Option 3', 'kirki' ),
                'option-4' => __( 'Option 4', 'kirki' ),
            ),
        );

        $controls[] = array(
            'type'        => 'text',
            'setting'     => 'text_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'text_section',
            'default'     => 'This is some default text',
            'priority'    => 10,
        );

        $controls[] = array(
            'type'        => 'textarea',
            'setting'     => 'textarea_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'textarea_section',
            'default'     => 'This is some default text',
            'priority'    => 10,
        );

        $controls[] = array(
            'type'        => 'editor',
            'setting'     => 'wysiwyg',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'default'     => '',
            'section'     => 'textarea_section',
        );

        $controls[] = array(
            'type'        => 'upload',
            'setting'     => 'upload_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'upload_section',
            'default'     => '',
            'priority'    => 10,
        );

        $controls[] = array(
            'type'        => 'radio-image',
            'setting'     => 'radio_image_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'radio_image_section',
            'default'     => 'option-1',
            'priority'    => 10,
            'choices'     => array(
                'option-1' => admin_url() . '/images/align-left-2x.png',
                'option-2' => admin_url() . '/images/align-center-2x.png',
                'option-3' => admin_url() . '/images/align-right-2x.png',
            ),
        );

        $controls[] = array(
            'type'        => 'radio-buttonset',
            'setting'     => 'radio_buttonset_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'radio_buttonset_section',
            'default'     => 'option-1',
            'priority'    => 10,
            'choices'     => array(
                'option-1' => __( 'Option 1', 'kirki' ),
                'option-2' => __( 'Option 2', 'kirki' ),
                'option-3' => __( 'Option 3', 'kirki' ),
            ),
        );

        $controls[] = array(
            'type'        => 'background',
            'setting'     => 'background_demo',
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
        );

        $controls[] = array(
            'type'        => 'multicheck',
            'setting'     => 'multicheck_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'multicheck_section',
            'default'     => array(
                'option-1',
                'option-2'
            ),
            'priority'    => 10,
            'choices'     => array(
                'option-1' => __( 'Option 1', 'kirki' ),
                'option-2' => __( 'Option 2', 'kirki' ),
                'option-3' => __( 'Option 3', 'kirki' ),
                'option-4' => __( 'Option 4', 'kirki' ),
            ),
        );

        // step = 10
        $controls[] = array(
            'type'        => 'slider',
            'setting'     => 'slider_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'slider_section',
            'default'     => 20,
            'priority'    => 10,
            'choices'     => array(
                'min'  => - 100,
                'max'  => 100,
                'step' => 10
            ),
        );

        // step = 0.01
        $controls[] = array(
            'type'        => 'slider',
            'setting'     => 'slider_demo_2',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'slider_section',
            'default'     => 1.58,
            'priority'    => 20,
            'choices'     => array(
                'min'  => 0,
                'max'  => 5,
                'step' => .01
            ),
        );

        // Off
        $controls[] = array(
            'type'        => 'switch',
            'setting'     => 'switch_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'switch_section',
            'default'     => 0,
            'priority'    => 10,
        );

        // On
        $controls[] = array(
            'type'        => 'switch',
            'setting'     => 'switch_demo_2',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'switch_section',
            'default'     => 1,
            'priority'    => 10,
        );

        // Off
        $controls[] = array(
            'type'        => 'toggle',
            'setting'     => 'toggle_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'toggle_section',
            'default'     => 0,
            'priority'    => 10,
        );

        // On
        $controls[] = array(
            'type'        => 'toggle',
            'setting'     => 'toggle_demo_2',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'toggle_section',
            'default'     => 1,
            'priority'    => 10,
        );

        $controls[] = array(
            'type'        => 'sortable',
            'setting'     => 'sortable_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'sortable_section',
            'default'     => array(
                'option-3',
                'option-1',
                'option-4'
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

        $controls[] = array(
            'type'        => 'number',
            'setting'     => 'number_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'number_section',
            'default'     => '42',
            'priority'    => 10,
        );

        $controls[] = array(
            'type'        => 'custom',
            'setting'     => 'custom_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'custom_section',
            'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">You can enter custom markup in this control and use it however you want</div>',
            'priority'    => 10,
        );

        // Define custom palettes
        $controls[] = array(
            'type'        => 'palette',
            'setting'     => 'palette_demo',
            'label'       => __( 'This is the label', 'kirki' ),
            'description' => __( 'This is the control description', 'kirki' ),
            'help'        => __( 'This is some extra help. You can use this to add some additional instructions for users. The main description should go in the "description" of the field, this is only to be used for help tips.', 'kirki' ),
            'section'     => 'palette_section',
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

        return $controls;

    }

    add_filter( 'kirki/controls', 'kirki_demo_controls' );

    /**
     * Configuration sample for the Kirki Customizer
     */
    function kirki_demo_configuration_sample() {

        $args = array(
            'logo_image'   => 'http://kirki.org/images/logo.png',
            'description'  => __( 'This is the theme description. You can edit it in the Kirki configuration and add whatever you want here.', 'kirki' ),
            'color_accent' => '#00bcd4',
            'color_back'   => '#455a64',
        );

        return $args;

    }

    add_filter( 'kirki/config', 'kirki_demo_configuration_sample' );