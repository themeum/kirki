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
		Kirki::add_config( 'my_config', array(
			'option_type' => 'option',
			'option_name' => 'my_option',
			'capability' => 'edit_posts',
		) );
		Kirki::add_config( 'my_config2', array(
			'option_type' => 'theme_mod',
			'capability' => 'edit_posts',
		) );
		Kirki::add_config( 'my_config3', array(
			'option_type' => 'option',
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

		Kirki::add_field( 'my_config', array(
			'settings' => 'my_setting',
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'text',
			'priority' => 10,
			'default' => 'some-default-value',
		) );

		Kirki::add_field( 'my_config', array(
			'settings' => 'my_setting0',
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'text',
			'priority' => 10,
			'default' => 'some-default-value',
		) );

		Kirki::add_field( 'my_config2', array(
			'settings' => 'my_setting1',
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'text',
			'priority' => 10,
			'default' => 'some-default-value',
		) );

		Kirki::add_field( 'my_config3', array(
			'settings' => 'my_setting2',
			'label' => __( 'My custom control', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'text',
			'priority' => 10,
			'default' => 'some-default-value',
		) );

		Kirki::add_field( 'my_config', array(
			'settings' => 'my_setting_2',
			'label' => __( 'My custom control 2', 'translation_domain' ),
			'section' => 'my_section',
			'type' => 'checkbox',
			'priority' => 20,
			'default' => '1',
			'capability' => 'edit_theme_options',

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
			'options_type' => 'theme_mod',
			'capability' => 'edit_posts',
			'default' => 'some-default-value',
		);

		$fields[] = array(
			'label' => __( 'My custom control 2', 'translation_domain' ),
			'section' => 'my_section',
			'settings' => 'my_setting_4',
			'type' => 'checkbox',
			'priority' => 20,
			'options_type' => 'theme_mod',
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
		$this->assertArrayHasKey( 'my_config', Kirki::$config );
		$this->assertEquals( 'edit_posts', Kirki::$config['my_config']['capability'] );
		$this->assertEquals( 'option', Kirki::$config['my_config']['option_type'] );
		$this->assertEquals( 'my_option', Kirki::$config['my_config']['option_name'] );
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
		$this->add_config();
		$this->add_field();
		// my_setting
		$this->assertArrayHasKey( 'my_setting', Kirki::$fields );
		$this->assertEquals( 'My custom control', Kirki::$fields['my_setting']['label'] );
		$this->assertEquals( 'my_section', Kirki::$fields['my_setting']['section'] );
		$this->assertEquals( 'text', Kirki::$fields['my_setting']['type'] );
		$this->assertEquals( 10, Kirki::$fields['my_setting']['priority'] );
		$this->assertEquals( 'some-default-value', Kirki::$fields['my_setting']['default'] );
		$this->assertEquals( 'edit_posts', Kirki::$fields['my_setting']['capability'] );
		// Inherited from config
		$this->assertEquals( 'option', Kirki::$fields['my_setting']['option_type'] );

		// my_setting
		$this->assertArrayHasKey( 'my_setting_2', Kirki::$fields );
		$this->assertEquals( 'My custom control 2', Kirki::$fields['my_setting_2']['label'] );
		$this->assertEquals( 'my_section', Kirki::$fields['my_setting_2']['section'] );
		$this->assertEquals( 'checkbox', Kirki::$fields['my_setting_2']['type'] );
		$this->assertEquals( 20, Kirki::$fields['my_setting_2']['priority'] );
		$this->assertEquals( '1', Kirki::$fields['my_setting_2']['default'] );
		// Inherited from config
		$this->assertEquals( 'edit_theme_options', Kirki::$fields['my_setting_2']['capability'] );
		$this->assertEquals( 'option', Kirki::$fields['my_setting_2']['option_type'] );
	}

	public function test_fields_via_filter() {
		add_filter( 'kirki/fields', array( $this, 'add_controls_via_filter' ) );
		do_action( 'wp_loaded' );

		// my_setting
		$this->assertArrayHasKey( 'my_setting', Kirki::$fields );
		$this->assertEquals( 'My custom control', Kirki::$fields['my_setting_3']['label'] );
		$this->assertEquals( 'my_section', Kirki::$fields['my_setting_3']['section'] );
		$this->assertEquals( 'text', Kirki::$fields['my_setting_3']['type'] );
		$this->assertEquals( 10, Kirki::$fields['my_setting_3']['priority'] );
		$this->assertEquals( 'some-default-value', Kirki::$fields['my_setting_3']['default'] );
		$this->assertEquals( 'edit_posts', Kirki::$fields['my_setting_3']['capability'] );

		// my_setting
		$this->assertArrayHasKey( 'my_setting_2', Kirki::$fields );
		$this->assertEquals( 'My custom control 2', Kirki::$fields['my_setting_4']['label'] );
		$this->assertEquals( 'my_section', Kirki::$fields['my_setting_4']['section'] );
		$this->assertEquals( 'checkbox', Kirki::$fields['my_setting_4']['type'] );
		$this->assertEquals( 20, Kirki::$fields['my_setting_4']['priority'] );
		$this->assertEquals( '0', Kirki::$fields['my_setting_4']['default'] );
	}

	public function test_get_option() {
		$this->add_config();
		$this->add_field();
		$this->assertEquals( 'some-default-value', Kirki::get_option( 'my_config', 'my_setting0' ) );
		$this->assertEquals( 'some-default-value', Kirki::get_option( 'my_config2', 'my_setting1' ) );
		$this->assertEquals( 'some-default-value', Kirki::get_option( 'my_config3', 'my_setting2' ) );
	}

}
