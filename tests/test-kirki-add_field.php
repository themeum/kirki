<?php

class Test_Kirki_Add_Field extends WP_UnitTestCase {

	public function __construct() {
		$this->add_config();
		$this->add_fields();
	}

	public function add_config() {
		Kirki::add_config( 'test', array(
			'capability'     => 'manage_network_options',
			'option_type'    => 'option',
			'option_name'    => 'my_option_name',
			'compiler'       => array(),
			'disable_output' => true,
			'postMessage'    => 'auto',
		) );
	}

	public function add_fields() {

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

	}

	public function test_field() {

		$this->assertEquals(
			array(
				'settings'        => 'my_setting_global',
				'label'           => 'My custom control',
				'section'         => 'my_section',
				'type'            => 'kirki-text',
				'priority'        => 10,
				'default'         => 'some-default-value',
				'kirki_config'    => 'global',
				'option_name'     => '',
				'option_type'     => 'theme_mod',
				'capability'      => 'edit_theme_options',
				'disable_output'  => false,
				'tooltip'         => '',
				'active_callback' => '__return_true',
				'choices'         => array(),
				'output'          => array(),
				'variables'       => null,
				'id'              => 'my_setting_global',
				'sanitize_callback' => 'esc_textarea',
			),
			Kirki::$fields['my_setting_global']
		);

		$this->assertEquals(
			array(
				'settings'        => 'my_option_name[my_setting_test]',
				'label'           => 'My custom control',
				'section'         => 'my_section',
				'type'            => 'kirki-text',
				'priority'        => 10,
				'default'         => 'some-default-value',
				'kirki_config'    => 'test',
				'option_name'     => 'my_option_name',
				'option_type'     => 'option',
				'capability'      => 'manage_network_options',
				'disable_output'  => true,
				'tooltip'         => '',
				'active_callback' => '__return_true',
				'choices'         => array(),
				'output'          => array(),
				'variables'       => null,
				'id'              => 'my_option_name-my_setting_test',
				'sanitize_callback' => 'esc_textarea',
			),
			Kirki::$fields['my_option_name[my_setting_test]']
		);

	}
}
