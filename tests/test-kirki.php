<?php

class Test_Kirki extends WP_UnitTestCase {

	public function init_customizer() {
		global $wp_customize;
		if ( ! isset( $wp_customize ) ) {
			if ( ! class_exists( 'WP_Customize_Manager' ) ) {
				require_once( ABSPATH . '/wp-includes/class-wp-customize-manager.php' );
			}
			$wp_customize = new WP_Customize_Manager();
		}
		return $wp_customize;
	}


	public function add_config() {
		Kirki::add_config( 'my_config_theme_mods', array(
			'option_type' => 'theme_mod',
			'capability' => 'edit_posts',
		) );
		Kirki::add_config( 'my_config_options', array(
			'option_type' => 'option',
			'capability' => 'edit_posts',
		) );
		Kirki::add_config( 'my_config_options_serialized', array(
			'option_type' => 'option',
			'option_name' => 'my_option',
			'capability' => 'edit_posts',
		) );
	}

	public function add_panel() {
		Kirki::add_panel( 'panel_id', array(
			'priority' => 10,
			'title' => 'My Title',
			'description' => 'My Description',
		) );
	}

	public function add_section() {
		Kirki::add_section( 'section_id', array(
			'title' => 'My Title',
			'description' => 'My Description',
			'panel' => 'panel_id',
			'priority' => 160,
			'capability' => 'edit_theme_options',
		) );
	}

	public function add_field() {

		Kirki::add_field( 'my_config_theme_mods', array(
			'settings' => 'my_setting_theme_mods',
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'text',
			'priority' => 10,
			'default' => 'some-default-value',
		) );

		Kirki::add_field( 'my_config_options', array(
			'settings' => 'my_setting_options',
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'text',
			'priority' => 10,
			'default' => 'some-default-value',
		) );

		Kirki::add_field( 'my_config_options_serialized', array(
			'settings' => 'my_setting_options_serialized',
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'text',
			'priority' => 10,
			'default' => 'some-default-value',
		) );

	}

	public function add_background_fields() {
		Kirki::add_field( 'my_config_theme_mods', array(
			'settings' => 'my_settings_test_background_theme_mod',
			'section' => 'my_section',
			'type' => 'background',
			'default' => array(
				'color' => '#333333',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
		) );
		Kirki::add_field( 'my_config_options', array(
			'settings' => 'my_settings_test_background_options',
			'section' => 'my_section',
			'type' => 'background',
			'default' => array(
				'color' => '#333333',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
		) );
		Kirki::add_field( 'my_config_options_serialized', array(
			'settings' => 'my_settings_test_background_options_serialized',
			'section' => 'my_section',
			'type' => 'background',
			'default' => array(
				'color' => '#333333',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
		) );
	}

	function add_controls_via_filter( $fields ) {

		// Add the controls
		$fields[] = array(
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'settings' => 'my_setting_3',
			'type' => 'text',
			'priority' => 10,
			'option_type' => 'theme_mod',
			'capability' => 'edit_posts',
			'default' => 'some-default-value',
		);

		$fields[] = array(
			'label' => __( 'My custom control 2', 'translation_domain' ),
			'section' => 'my_section',
			'settings' => 'my_setting_4',
			'type' => 'checkbox',
			'priority' => 20,
			'option_type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '0',
		);

		return $fields;

	}

	public function test_config() {
		$this->add_config();
		// Default config
		$this->assertArrayHasKey( 'global', Kirki::$config );
		$this->assertEquals( 'edit_theme_options', Kirki::$config['global']['capability'] );
		$this->assertEquals( 'theme_mod', Kirki::$config['global']['option_type'] );
		// Custom config
		$this->assertArrayHasKey( 'my_config_theme_mods', Kirki::$config );
		$this->assertArrayHasKey( 'my_config_options', Kirki::$config );
		$this->assertArrayHasKey( 'my_config_options_serialized', Kirki::$config );

		$this->assertEquals( 'edit_posts', Kirki::$config['my_config_theme_mods']['capability'] );
		$this->assertEquals( 'option', Kirki::$config['my_config_options']['option_type'] );
		$this->assertEquals( 'my_option', Kirki::$config['my_config_options_serialized']['option_name'] );
	}

	public function test_panels() {
		$this->add_panel();
		$this->assertArrayHasKey( 'panel_id', Kirki::$panels );
		$this->assertEquals( 'panel_id', Kirki::$panels['panel_id']['id'] );
		$this->assertEquals( 10, Kirki::$panels['panel_id']['priority'] );
		$this->assertEquals( 'My Title', Kirki::$panels['panel_id']['title'] );
		$this->assertEquals( 'My Description', Kirki::$panels['panel_id']['description'] );
	}

	public function test_sections() {
		$this->add_section();
		$this->assertArrayHasKey( 'section_id', Kirki::$sections );
		$this->assertEquals( 'section_id', Kirki::$sections['section_id']['id'] );
		$this->assertEquals( 160, Kirki::$sections['section_id']['priority'] );
		$this->assertEquals( 'My Title', Kirki::$sections['section_id']['title'] );
		$this->assertEquals( 'My Description', Kirki::$sections['section_id']['description'] );
	}

	public function test_fields() {
		Kirki::$fields = array();
		$this->add_config();
		$this->add_field();

		$this->assertArrayHasKey( 'my_setting_theme_mods', Kirki::$fields );
		$this->assertEquals( 'My custom control', Kirki::$fields['my_setting_theme_mods']['label'] );
		$this->assertEquals( 'my_section', Kirki::$fields['my_setting_theme_mods']['section'] );
		$this->assertEquals( 'text', Kirki::$fields['my_setting_theme_mods']['type'] );
		$this->assertEquals( 10, Kirki::$fields['my_setting_theme_mods']['priority'] );
		$this->assertEquals( 'some-default-value', Kirki::$fields['my_setting_theme_mods']['default'] );
		$this->assertEquals( 'edit_posts', Kirki::$fields['my_setting_theme_mods']['capability'] );
		$this->assertEquals( 'theme_mod', Kirki::$fields['my_setting_theme_mods']['option_type'] );
		$this->assertEquals( 'option', Kirki::$fields['my_setting_options']['option_type'] );
		$this->assertEquals( 'option', Kirki::$fields['my_option[my_setting_options_serialized]']['option_type'] );
	}

	public function test_fields_via_filter() {
		Kirki::$fields = array();
		add_filter( 'kirki/fields', array( $this, 'add_controls_via_filter' ) );
		do_action( 'wp_loaded' );

		// my_setting
		$this->assertArrayHasKey( 'my_setting_3', Kirki::$fields );
		$this->assertArrayHasKey( 'my_setting_4', Kirki::$fields );
		$this->assertEquals( 'My custom control', Kirki::$fields['my_setting_3']['label'] );
		$this->assertEquals( 'my_section', Kirki::$fields['my_setting_3']['section'] );
		$this->assertEquals( 'text', Kirki::$fields['my_setting_3']['type'] );
		$this->assertEquals( 10, Kirki::$fields['my_setting_3']['priority'] );
		$this->assertEquals( 'some-default-value', Kirki::$fields['my_setting_3']['default'] );
		$this->assertEquals( 'edit_posts', Kirki::$fields['my_setting_3']['capability'] );

	}

	public function test_get_option() {
		Kirki::$config = null;
		Kirki::$fields = null;
		$this->add_config();
		$this->add_field();
		$this->assertEquals( 'some-default-value', Kirki::get_option( 'my_config_theme_mods', 'my_setting_theme_mods' ) );
		$this->assertEquals( 'some-default-value', Kirki::get_option( 'my_config_options', 'my_setting_options' ) );
		$this->assertEquals( 'some-default-value', Kirki::get_option( 'my_config_options_serialized', 'my_option[my_setting_options_serialized]' ) );

		Kirki::$config = null;
		Kirki::$fields = null;
		$this->add_config();
		$this->add_background_fields();
		$this->assertEquals(
			array(
				'color' => '#333333',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
			Kirki::get_option( 'my_config_theme_mods', 'my_settings_test_background_theme_mod' )
		);
		$this->assertEquals(
			array(
				'color' => '#333333',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
			Kirki::get_option( 'my_config_options', 'my_settings_test_background_options' )
		);
		$this->assertEquals(
			array(
				'color' => '#333333',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
			Kirki::get_option( 'my_config_options_serialized', 'my_option[my_settings_test_background_options_serialized]' )
		);

		Kirki::$config = null;
		Kirki::$fields = null;
		$this->add_config();
		$this->add_background_fields();

		set_theme_mod( 'my_settings_test_background_theme_mod_color', '#000000' );
		$this->assertEquals(
			array(
				'color' => '#000000',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
			Kirki::get_option( 'my_config_theme_mods', 'my_settings_test_background_theme_mod' )
		);
		update_option( 'my_settings_test_background_options_color', '#222222' );
		$this->assertEquals(
			array(
				'color' => '#222222',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
			Kirki::get_option( 'my_config_options', 'my_settings_test_background_options' )
		);
		update_option( 'my_option', array( 'my_settings_test_background_options_serialized_color' => '#444444' ) );
		$this->assertEquals(
			array(
				'color' => '#444444',
				'image' => 'http://foo.com/bar.png',
				'repeat' => 'no-repeat',
				'size' => 'cover',
				'attach' => 'scroll',
				'position' => 'center-bottom',
				'opacity' => '.6',
			),
			Kirki::get_option( 'my_config_options_serialized', 'my_option[my_settings_test_background_options_serialized]' )
		);
	}

}
