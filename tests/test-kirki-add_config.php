<?php

class Test_Kirki_Add_Config extends WP_UnitTestCase {

	public $wp_customize;

	function setUp() {
		parent::setUp();
		require_once( ABSPATH . WPINC . '/class-wp-customize-manager.php' );
		$GLOBALS['wp_customize'] = new WP_Customize_Manager();
		$this->wp_customize = $GLOBALS['wp_customize'];
	}

	public function test_config() {

		Kirki::add_config( 'test_empty', array() );
		Kirki::add_config( 'test', array(
			'capability'     => 'manage_network_options',
			'option_type'    => 'option',
			'option_name'    => 'my_option_name',
			'compiler'       => array(),
			'disable_output' => true,
			'postMessage'    => 'auto',
		) );

		$this->assertEquals(
			array(
				'capability'     => 'edit_theme_options',
				'option_type'    => 'theme_mod',
				'option_name'    => '',
				'compiler'       => array(),
				'disable_output' => false,
				// 'postMessage'    => '',
				'id'             => 'global',
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
				// 'postMessage'    => '',
				'id'             => 'test_empty',
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
				'id'             => 'test',
			),
			Kirki::$config['test']
		);
		$this->assertEquals( 3, count( Kirki::$config ) );
	}
}
