<?php

class Test_Kirki_Add_Config extends WP_UnitTestCase {

	public function __construct() {
		$this->add_config();
	}

	public function add_config() {
		Kirki::add_config( 'test_empty', array() );
		Kirki::add_config( 'test', array(
			'capability'     => 'manage_network_options',
			'option_type'    => 'option',
			'option_name'    => 'my_option_name',
			'compiler'       => array(),
			'disable_output' => true,
			'postMessage'    => 'auto',
		) );
	}

	public function test_config() {
		$this->assertEquals(
			array(
				'capability'     => 'edit_theme_options',
				'option_type'    => 'theme_mod',
				'option_name'    => '',
				'compiler'       => array(),
				'disable_output' => false,
				'postMessage'    => '',
			),
			Kirki::$config['global']
		);
		$this->assertEquals(
			array(
				'capability'     => 'edit_theme_options',
				'option_type'    => 'theme_mod',
				'option_name'    => '',
				'compiler'       => array(),
				'disable_output' => false,
				'postMessage'    => '',
			),
			Kirki::$config['test_empty']
		);
		$this->assertEquals(
			array(
				'capability'     => 'manage_network_options',
				'option_type'    => 'option',
				'option_name'    => 'my_option_name',
				'compiler'       => array(),
				'disable_output' => true,
				'postMessage'    => 'auto',
			),
			Kirki::$config['test']
		);
		$this->assertEquals( 3, count( Kirki::$config ) );
	}
}
