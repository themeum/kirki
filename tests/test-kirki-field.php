<?php

class Test_Kirki_Field extends WP_UnitTestCase {

	public $wp_customize;

	function setUp() {
		parent::setUp();
		require_once( ABSPATH . WPINC . '/class-wp-customize-manager.php' );
		// @codingStandardsIgnoreStart
		$GLOBALS['wp_customize'] = new WP_Customize_Manager();
		// @codingStandardsIgnoreEnd
		$this->wp_customize = $GLOBALS['wp_customize'];
	}

	public function test_color_field_tweaks() {

		Kirki::add_field( 'global', array(
			'setting' => 'my_setting',
			'type'    => 'color',
		) );
		$this->assertEquals( 'color-alpha', Kirki::$fields['my_setting']['type'] );
		$this->assertEquals( false, Kirki::$fields['my_setting']['choices']['alpha'] );

		Kirki::add_field( 'global', array(
			'setting' => 'my_setting',
			'type'    => 'color-alpha',
		) );
		$this->assertEquals( 'color-alpha', Kirki::$fields['my_setting']['type'] );
		$this->assertEquals( true, Kirki::$fields['my_setting']['choices']['alpha'] );
	}
}
