<?php

class Test_Kirki_Add_Field extends WP_UnitTestCase {

	public $wp_customize;

	function setUp() {
		parent::setUp();
		require_once( ABSPATH . WPINC . '/class-wp-customize-manager.php' );
		// @codingStandardsIgnoreStart
		$GLOBALS['wp_customize'] = new WP_Customize_Manager();
		// @codingStandardsIgnoreEnd
		$this->wp_customize = $GLOBALS['wp_customize'];
	}

	public function test_field() {

		Kirki::add_config( 'test', array(
			'capability'     => 'manage_network_options',
			'option_type'    => 'option',
			'option_name'    => 'my_option_name',
			'compiler'       => array(),
			'disable_output' => true,
			'postMessage'    => 'auto',
		) );

		Kirki::add_field( 'global', array(
			'settings' => 'my_setting_global',
			'label'    => __( 'My custom control', 'translation_domain' ),
			'section'  => 'my_section',
			'type'     => 'text',
			'priority' => 10,
			'default'  => 'some-default-value',
		) );

		Kirki::add_field( 'test', array(
			'settings' => 'my_setting_test',
			'label'    => __( 'My custom control', 'translation_domain' ),
			'section'  => 'my_section',
			'type'     => 'text',
			'priority' => 10,
			'default'  => 'some-default-value',
		) );
		$this->assertEquals(
			array(
				'settings'          => 'my_setting_global',
				'label'             => 'My custom control',
				'section'           => 'my_section',
				'type'              => 'kirki-generic',
				'priority'          => 10,
				'default'           => 'some-default-value',
				'kirki_config'      => 'global',
				'option_name'       => '',
				'option_type'       => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'disable_output'    => false,
				'tooltip'           => '',
				'active_callback'   => '__return_true',
				'choices'           => array(),
				'output'            => array(),
				'variables'         => array(),
				'id'                => 'my_setting_global',
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_textarea',
				'choices'           => array(
					'element' => 'input',
					'type'    => 'text',
				),
				'js_vars'           => array(),
				'help'              => '',
				'mode'              => '',
				'required'          => array(),
				'multiple'          => 1,
				'description'       => '',
				'fields'            => array(),
				'width'          	=> 150,
				'height'         	=> 150,
				'flex_width'        => false,
				'flex_height'       => false,
				'row_label'         => array(),
			),
			Kirki::$fields['my_setting_global']
		);

		$this->assertEquals(
			array(
				'settings'          => 'my_option_name[my_setting_test]',
				'label'             => 'My custom control',
				'section'           => 'my_section',
				'type'              => 'kirki-generic',
				'priority'          => 10,
				'default'           => 'some-default-value',
				'kirki_config'      => 'test',
				'option_name'       => 'my_option_name',
				'option_type'       => 'option',
				'capability'        => 'manage_network_options',
				'disable_output'    => true,
				'tooltip'           => '',
				'active_callback'   => '__return_true',
				'choices'           => array(),
				'output'            => array(),
				'variables'         => array(),
				'id'                => 'my_option_name-my_setting_test',
				'sanitize_callback' => 'esc_textarea',
				'transport'         => 'refresh',
				'choices'           => array(
					'element' => 'input',
					'type'    => 'text',
				),
				'js_vars'           => array(),
				'help'              => '',
				'mode'              => '',
				'required'          => array(),
				'multiple'          => 1,
				'description'       => '',
				'fields'            => array(),
				'width'          	=> 150,
				'height'         	=> 150,
				'flex_width'        => false,
				'flex_height'       => false,
				'row_label'         => array(),
			),
			Kirki::$fields['my_option_name[my_setting_test]']
		);

	}

	public function test_generic_field_tweaks() {

		Kirki::add_field( 'global', array(
			'settings' => 'my_setting_global',
			'label'    => __( 'My custom control', 'translation_domain' ),
			'section'  => 'my_section',
			'type'     => 'textarea',
			'priority' => 10,
			'default'  => 'some-default-value',
		) );

		$this->assertEquals(
			array(
				'settings'          => 'my_setting_global',
				'label'             => 'My custom control',
				'section'           => 'my_section',
				'type'              => 'kirki-generic',
				'priority'          => 10,
				'default'           => 'some-default-value',
				'kirki_config'      => 'global',
				'option_name'       => '',
				'option_type'       => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'disable_output'    => false,
				'tooltip'           => '',
				'active_callback'   => '__return_true',
				'output'            => array(),
				'variables'         => array(),
				'id'                => 'my_setting_global',
				'sanitize_callback' => 'wp_kses_post',
				'transport'         => 'refresh',
				'choices'           => array(
					'element' => 'textarea',
					'rows'    => '5',
				),
				'js_vars'           => array(),
				'help'              => '',
				'mode'              => '',
				'required'          => array(),
				'multiple'          => 1,
				'description'       => '',
				'fields'            => array(),
				'width'          	=> 150,
				'height'         	=> 150,
				'flex_width'        => false,
				'flex_height'       => false,
				'row_label'         => array(),
			),
			Kirki::$fields['my_setting_global']
		);

		Kirki::add_field( 'global', array(
			'settings' => 'my_setting_global45',
			'label'    => __( 'My custom control', 'translation_domain' ),
			'section'  => 'my_section',
			'type'     => 'kirki-generic',
			'priority' => 10,
			'default'  => 'some-default-value',
		) );

		$this->assertEquals(
			array(
				'settings'          => 'my_setting_global45',
				'label'             => 'My custom control',
				'section'           => 'my_section',
				'type'              => 'kirki-generic',
				'priority'          => 10,
				'default'           => 'some-default-value',
				'kirki_config'      => 'global',
				'option_name'       => '',
				'option_type'       => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'disable_output'    => false,
				'tooltip'           => '',
				'active_callback'   => '__return_true',
				'choices'           => array(
					'element' => 'input',
				),
				'output'            => array(),
				'variables'         => array(),
				'id'                => 'my_setting_global45',
				'sanitize_callback' => 'wp_kses_post',
				'transport'         => 'refresh',
				'js_vars'           => array(),
				'help'              => '',
				'mode'              => '',
				'required'          => array(),
				'multiple'          => 1,
				'description'       => '',
				'fields'            => array(),
				'width'          	=> 150,
				'height'         	=> 150,
				'flex_width'        => false,
				'flex_height'       => false,
				'row_label'         => array(),
			),
			Kirki::$fields['my_setting_global45']
		);

	}
}
