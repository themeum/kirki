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

	/**
	 * Color & color-alpha fields use the same control.
	 * Their difference is the ['choices']['alpha'] argument.
	 */
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

	/**
	 * Normal select fields should have a "multiple" argument = 1
	 * multiselect fields control the number of selectable options
	 * via this argument so we need to make sure it's properly sanitized
	 */
	public function test_multiselect_field_tweaks() {

		Kirki::add_field( 'global', array(
			'setting' => 'my_setting',
			'type'    => 'select',
		) );
		$this->assertEquals( 1, Kirki::$fields['my_setting']['multiple'] );

		Kirki::add_field( 'global', array(
			'setting'  => 'my_setting',
			'type'     => 'select',
			'multiple' => 9,
		) );
		$this->assertEquals( 9, Kirki::$fields['my_setting']['multiple'] );

		Kirki::add_field( 'global', array(
			'setting'  => 'my_setting',
			'type'     => 'select',
			'multiple' => 'tralala',
		) );
		$this->assertEquals( 0, Kirki::$fields['my_setting']['multiple'] );
	}

	/**
	 * If we define the "kirki_config" argument on a field,
	 * we have to make sure that it overrides the config set in $config_id.
	 * If the "kirki_config" defined does not exist, then we have to fallback to "global".
	 */
	public function test_override_kirki_config() {

		Kirki::add_field( 'global', array(
			'setting'      => 'my_setting',
			'type'         => 'text',
			'kirki_config' => 'tralala',
		) );
		$this->assertEquals( 'global', Kirki::$fields['my_setting']['kirki_config'] );

		Kirki::add_config( 'new_config', array() );
		Kirki::add_field( 'global', array(
			'setting'      => 'my_setting',
			'type'         => 'text',
			'kirki_config' => 'new_config',
		) );
		$this->assertEquals( 'new_config', Kirki::$fields['my_setting']['kirki_config'] );
	}
}
