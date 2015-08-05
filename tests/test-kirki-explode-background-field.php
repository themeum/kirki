<?php

class Test_Kirki_Explode_Background_Field extends WP_UnitTestCase {

	public function initial_fields() {
		return array( array(
			'type' => 'background',
			'settings' => 'my_setting',
			'label' => 'Control Title',
			'section' => 'my_section',
			'default' => array(
				'image' => 'http://example.com/foo.png',
				'color' => 'rgba(255,230,34,1)',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'fixed',
				'position' => 'left-top',
				'opacity' => 1
			),
			'priority' => 20,
			'output' => 'body',
		) );
	}

	public function final_fields() {
		$initial_fields = $this->initial_fields();
		return array(
			$initial_fields[0],
			'my_setting_color' => array(
				'type' => 'color-alpha',
				'label' => '',
				'section' => 'my_section',
				'settings' => 'my_setting_color',
				'priority' => 20,
				'help' => '',
				'description' => 'Background Color',
				'required' => null,
				'transport' => 'refresh',
				'default' => 'rgba(255,230,34,1)',
				'output' => array(
					array(
						'element' => 'body',
						'property' => 'background-color',
					),
				),
				'option_type' => 'theme_mod',
				'choices' => array(),
				'sanitize_callback' => array( 'Kirki_Sanitize', 'color' ),
				'js_vars' => null,
				'id' => 'my_setting_color',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			),
			'my_setting_image' => array(
				'type' => 'image',
				'label' => 'Control Title',
				'section' => 'my_section',
				'settings' => 'my_setting_image',
				'priority' => 20,
				'help' => '',
				'description' => 'Background Image',
				'required' => null,
				'transport' => 'refresh',
				'default' => 'http://example.com/foo.png',
				'output' => array(
					array(
						'element' => 'body',
						'property' => 'background-image',
					),
				),
				'option_type' => 'theme_mod',
				'choices' => array(),
				'sanitize_callback' => 'esc_url_raw',
				'js_vars' => null,
				'id' => 'my_setting_image',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			),
			'my_setting_repeat' => array(
				'type' => 'select',
				'label' => '',
				'section' => 'my_section',
				'settings' => 'my_setting_repeat',
				'priority' => 20,
				'choices' => array(
					'no-repeat' => 'No Repeat',
					'repeat' => 'Repeat All',
					'repeat-x' => 'Repeat Horizontally',
					'repeat-y' => 'Repeat Vertically',
					'inherit' => 'Inherit',
				),
				'help' => '',
				'description' => 'Background Repeat',
				'required' => null,
				'transport' => 'refresh',
				'default' => 'no-repeat',
				'output' => array(
					array(
						'element' => 'body',
						'property' => 'background-repeat',
					),
				),
				'option_type' => 'theme_mod',
				'sanitize_callback' => 'esc_attr',
				'js_vars' => null,
				'id' => 'my_setting_repeat',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			),
			'my_setting_size' => array(
				'type' => 'select',
				'label' => '',
				'section' => 'my_section',
				'settings' => 'my_setting_size',
				'priority' => 20,
				'choices' => array(
					'inherit' => 'Inherit',
					'cover' => 'Cover',
					'contain' => 'Contain',
				),
				'help' => '',
				'description' => 'Background Size',
				'required' => null,
				'transport' => 'refresh',
				'default' => 'cover',
				'output' => array(
					array(
						'element' => 'body',
						'property' => 'background-size',
					),
				),
				'option_type' => 'theme_mod',
				'sanitize_callback' => 'esc_attr',
				'js_vars' => null,
				'id' => 'my_setting_size',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			),
			'my_setting_attach' => array(
				'type' => 'select',
				'label' => '',
				'section' => 'my_section',
				'settings' => 'my_setting_attach',
				'priority' => 20,
				'choices' => array(
					'inherit' => 'Inherit',
					'fixed' => 'Fixed',
					'scroll' => 'Scroll',
				),
				'help' => '',
				'description' => 'Background Attachment',
				'required' => null,
				'transport' => 'refresh',
				'default' => 'fixed',
				'output' => array(
					array(
						'element' => 'body',
						'property' => 'background-attachment',
					),
				),
				'option_type' => 'theme_mod',
				'sanitize_callback' => 'esc_attr',
				'js_vars' => null,
				'id' => 'my_setting_attach',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			),
			'my_setting_position' => array(
				'type' => 'select',
				'label' => '',
				'section' => 'my_section',
				'settings' => 'my_setting_position',
				'priority' => 20,
				'choices' => array(
					'left-top' => 'Left Top',
					'left-center' => 'Left Center',
					'left-bottom' => 'Left Bottom',
					'right-top' => 'Right Top',
					'right-center' => 'Right Center',
					'right-bottom' => 'Right Bottom',
					'center-top' => 'Center Top',
					'center-center' => 'Center Center',
					'center-bottom' => 'Center Bottom',
				),
				'help' => '',
				'description' => 'Background Position',
				'required' => null,
				'transport' => 'refresh',
				'default' => 'left-top',
				'output' => array(
					array(
						'element' => 'body',
						'property' => 'background-position',
					),
				),
				'option_type' => 'theme_mod',
				'sanitize_callback' => 'esc_attr',
				'js_vars' => null,
				'id' => 'my_setting_position',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			)
		);
	}

	public function test_build_background_fields() {
		$this->assertEquals( $this->final_fields(), Kirki_Explode_Background_Field::process_fields( $this->initial_fields() ) );
	}

}
