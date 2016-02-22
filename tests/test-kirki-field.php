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

	/**
	 * We can set an "option_name" in the field itself.
	 */
	public function test_defined_option_name() {

		Kirki::add_field( 'global', array(
			'setting'     => 'my_setting',
			'type'        => 'text',
		) );
		$this->assertEquals( '', Kirki::$fields['my_setting']['option_name'] );

		Kirki::add_field( 'global', array(
			'setting'     => 'my_setting',
			'type'        => 'text',
			'option_name' => 'tralala',
		) );
		$this->assertEquals( 'tralala', Kirki::$fields['my_setting']['option_name'] );

	}

	/**
	 * Test generic field tweaks
	 */
	public function test_generic_field_edge_cases() {
		Kirki::add_field( 'global', array(
			'setting' => 'my_setting',
			'type'    => 'kirki-generic',
		) );
		$this->assertEquals( 'input', Kirki::$fields['my_setting']['choices']['element'] );
	}

	/**
	 * We can set an "capability" in the field itself.
	 */
	public function test_defined_capability() {

		Kirki::add_field( 'global', array(
			'setting' => 'my_setting',
			'type'    => 'text',
		) );
		$this->assertEquals( 'edit_theme_options', Kirki::$fields['my_setting']['capability'] );

		Kirki::add_field( 'global', array(
			'setting'    => 'my_setting',
			'type'       => 'text',
			'capability' => 'manage_network_options',
		) );
		$this->assertEquals( 'manage_network_options', Kirki::$fields['my_setting']['capability'] );

	}

	/**
	 * Test tooltip & help arguments
	 */
	public function test_tooltips() {

		Kirki::add_field( 'global', array(
			'setting' => 'my_setting',
			'type'    => 'text',
			'tooltip' => 'Tooltip Message',
		) );
		$this->assertEquals( 'Tooltip Message', Kirki::$fields['my_setting']['tooltip'] );

		Kirki::add_field( 'global', array(
			'setting' => 'my_setting',
			'type'    => 'text',
			'help'    => 'Tooltip Message using help argument',
		) );
		$this->assertEquals( 'Tooltip Message using help argument', Kirki::$fields['my_setting']['tooltip'] );

	}

	/**
	 * Test sanitize_config_id
	 */
	public function test_sanitize_config_id() {
		// Define invalid config IDs. should return 'global'.
		$this->assertEquals( 'global', Kirki_Field::sanitize_config_id( 'foo', array( 'kirki_config' => 'bar' ) ) );

		$this->assertEquals( 'global', Kirki_Field::sanitize_config_id( array() ) );

		Kirki::add_config( 'foo' );
		Kirki::add_config( 'bar' );
		$this->assertEquals( 'bar', Kirki_Field::sanitize_config_id( 'foo', array( 'kirki_config' => 'bar' ) ) );

		$this->assertEquals( 'foo', Kirki_Field::sanitize_config_id( 'foo', array() ) );

		$this->assertEquals( 'global', Kirki_Field::sanitize_config_id( '', array() ) );

		$this->assertEquals( 'global', Kirki_Field::sanitize_config_id() );
	}

	/**
	 * test sanitize_option_name edge cases
	 */
	public function test_sanitize_option_name() {
		$this->assertEquals( '', Kirki_Field::sanitize_option_name() );
	}

	/**
	 * Test sanitize_capability edge cases
	 */
	public function test_sanitize_capability() {
		$this->assertEquals( 'edit_theme_options', Kirki_Field::sanitize_capability() );
	}

	/**
	 * Test sanitize_option_type edge cases
	 */
	public function test_sanitize_option_type() {
		$this->assertEquals( 'theme_mod', Kirki_Field::sanitize_option_type() );
	}

	/**
	 * Test sanitize_active_callback edge cases
	 */
	public function test_sanitize_active_callback() {
		$this->assertEquals(
			'__return_false',
			Kirki_Field::sanitize_active_callback( '', array( 'active_callback' => '__return_false' ) )
		);
		$this->assertEquals(
			'__return_true',
			Kirki_Field::sanitize_active_callback( '', array( 'active_callback' => 'nonexistend_dummy_function_name' ) )
		);
		$this->assertEquals(
			'__return_false',
			Kirki_Field::sanitize_active_callback( '', array(
				'active_callback' => '__return_false',
				'required'        => array( 'foo' => 'bar' )
			) )
		);
		$this->assertEquals(
			array( 'Kirki_Active_Callback', 'evaluate' ),
			Kirki_Field::sanitize_active_callback( '', array(
				'required' => array( 'foo' => 'bar' )
			) )
		);
	}

	/**
	 * Test sanitize_control_type edge cases
	 */
	public function test_sanitize_control_type() {
		$this->assertEquals(
			'kirki-text',
			Kirki_Field::sanitize_control_type( 'global', array() )
		);
		$this->assertEquals(
			'switch',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'checkbox', 'mode' => 'switch' ) )
		);
		$this->assertEquals(
			'toggle',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'checkbox', 'mode' => 'toggle' ) )
		);
		$this->assertEquals(
			'kirki-checkbox',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'checkbox' ) )
		);
		$this->assertEquals(
			'kirki-radio',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'radio' ) )
		);
		$this->assertEquals(
			'radio-buttonset',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'radio', 'mode' => 'buttonset' ) )
		);
		$this->assertEquals(
			'radio-image',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'radio', 'mode' => 'image' ) )
		);
		$this->assertEquals(
			'custom',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'group-title' ) )
		);
		$this->assertEquals(
			'custom',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'group_title' ) )
		);
		$this->assertEquals(
			'color-alpha',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'color-alpha' ) )
		);
		$this->assertEquals(
			'color-alpha',
			Kirki_Field::sanitize_control_type( 'global', array( 'type' => 'color', 'default' => 'rgba(0,0,0,0)' ) )
		);
	}

	/**
	 * Test fallback_callback functionality
	 */
	public function test_fallback_callback() {
		$this->assertEquals(
			array( 'Kirki_Sanitize_Values', 'color' ),
			Kirki_Field::fallback_callback( 'global', array( 'type' => 'color' ) )
		);
	}
}
