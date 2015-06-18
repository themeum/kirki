<?php

class Kirki_Test_Field extends WP_UnitTestCase {

	public function test_sanitize_control_type() {

		$this->assertEquals( 'checkbox', Kirki_Field::sanitize_control_type( array( 'type' => 'checkbox' ) ) );

		$this->assertEquals( 'color-alpha',     Kirki_Field::sanitize_control_type( array( 'type' => 'color-alpha' ) ) );
		$this->assertEquals( 'color-alpha',     Kirki_Field::sanitize_control_type( array( 'type' => 'color_alpha' ) ) );
		$this->assertEquals( 'color-alpha',     Kirki_Field::sanitize_control_type( array( 'type' => 'color', 'default' => 'rgba(0,0,0,1)' ) ) );
		$this->assertEquals( 'color',           Kirki_Field::sanitize_control_type( array( 'type' => 'color' ) ) );
		$this->assertEquals( 'custom',          Kirki_Field::sanitize_control_type( array( 'type' => 'custom' ) ) );
		$this->assertEquals( 'custom',          Kirki_Field::sanitize_control_type( array( 'type' => 'group-title' ) ) );
		$this->assertEquals( 'custom',          Kirki_Field::sanitize_control_type( array( 'type' => 'group_title' ) ) );
		$this->assertEquals( 'dropdown-pages',  Kirki_Field::sanitize_control_type( array( 'type' => 'dropdown-pages' ) ) );
		$this->assertEquals( 'editor',          Kirki_Field::sanitize_control_type( array( 'type' => 'editor' ) ) );
		$this->assertEquals( 'image',           Kirki_Field::sanitize_control_type( array( 'type' => 'image' ) ) );
		$this->assertEquals( 'multicheck',      Kirki_Field::sanitize_control_type( array( 'type' => 'multicheck' ) ) );
		$this->assertEquals( 'number',          Kirki_Field::sanitize_control_type( array( 'type' => 'number' ) ) );
		$this->assertEquals( 'palette',         Kirki_Field::sanitize_control_type( array( 'type' => 'palette' ) ) );
		$this->assertEquals( 'radio-buttonset', Kirki_Field::sanitize_control_type( array( 'type' => 'radio-buttonset' ) ) );
		$this->assertEquals( 'radio-buttonset', Kirki_Field::sanitize_control_type( array( 'type' => 'radio', 'mode' => 'buttonset' ) ) );
		$this->assertEquals( 'radio-image',     Kirki_Field::sanitize_control_type( array( 'type' => 'radio-image' ) ) );
		$this->assertEquals( 'radio-image',     Kirki_Field::sanitize_control_type( array( 'type' => 'radio', 'mode' => 'image' ) ) );
		$this->assertEquals( 'radio',           Kirki_Field::sanitize_control_type( array( 'type' => 'radio' ) ) );
		$this->assertEquals( 'select',          Kirki_Field::sanitize_control_type( array( 'type' => 'select' ) ) );
		$this->assertEquals( 'slider',          Kirki_Field::sanitize_control_type( array( 'type' => 'slider' ) ) );
		$this->assertEquals( 'sortable',        Kirki_Field::sanitize_control_type( array( 'type' => 'sortable' ) ) );
		$this->assertEquals( 'switch',          Kirki_Field::sanitize_control_type( array( 'type' => 'switch' ) ) );
		$this->assertEquals( 'switch',          Kirki_Field::sanitize_control_type( array( 'type' => 'checkbox', 'mode' => 'switch' ) ) );
		$this->assertEquals( 'text',            Kirki_Field::sanitize_control_type( array( 'type' => 'text' ) ) );
		$this->assertEquals( 'textarea',        Kirki_Field::sanitize_control_type( array( 'type' => 'textarea' ) ) );
		$this->assertEquals( 'toggle',          Kirki_Field::sanitize_control_type( array( 'type' => 'toggle' ) ) );
		$this->assertEquals( 'toggle',          Kirki_Field::sanitize_control_type( array( 'type' => 'checkbox', 'mode' => 'toggle' ) ) );
		$this->assertEquals( 'upload',          Kirki_Field::sanitize_control_type( array( 'type' => 'upload' ) ) );

	}

	public function test_sanitize_type() {
		$this->assertEquals( 'theme_mod', Kirki_Field::sanitize_type( array( 'option_type' => 'theme_mod' ) ) );
		$this->assertEquals( 'option',    Kirki_Field::sanitize_type( array( 'option_type' => 'option' ) ) );
		$this->assertEquals( 'theme_mod', Kirki_Field::sanitize_type( array() ) );
	}

	public function test_sanitize_variables() {
		$this->assertEquals( false, Kirki_Field::sanitize_variables( array() ) );
		$this->assertEquals( array(), Kirki_Field::sanitize_variables( array( 'variables' => array() ) ) );
	}

	public function test_sanitize_active_callback() {
		$this->assertEquals( '__return_true',               Kirki_Field::sanitize_active_callback( array( 'active_callback' => '__return_true' ) ) );
		$this->assertEquals( 'kirki_field_active_callback', Kirki_Field::sanitize_active_callback( array() ) );
	}

	public function test_sanitize_capability() {
		$capabilities = array(
			'activate_plugins',
			'delete_others_pages',
			'delete_others_posts',
			'delete_pages',
			'delete_posts',
			'delete_private_pages',
			'delete_private_posts',
			'delete_published_pages',
			'delete_published_posts',
			'edit_dashboard',
			'edit_others_pages',
			'edit_others_posts',
			'edit_pages',
			'edit_posts',
			'edit_private_pages',
			'edit_private_posts',
			'edit_published_pages',
			'edit_published_posts',
			'edit_theme_options',
			'export',
			'import',
			'list_users',
			'manage_categories',
			'manage_links',
			'manage_options',
			'moderate_comments',
			'promote_users',
			'publish_pages',
			'publish_posts',
			'read_private_pages',
			'read_private_posts',
			'read',
		);
		foreach ( $capabilities as $capability ) {
			$this->assertEquals( $capability, Kirki_Field::sanitize_capability( array( 'capability' => $capability ) ) );
		}

		$this->assertEquals( 'edit_theme_options', Kirki_Field::sanitize_capability( array() ) );
	}

	public function test_sanitize_settings_raw() {
		$this->assertEquals( 'my_settingsub-setting', Kirki_Field::sanitize_settings_raw( array( 'settings' => 'my_setting[sub-setting]' ) ) );
		$this->assertEquals( 'my_settingsub-setting', Kirki_Field::sanitize_settings_raw( array( 'settings' => 'my_setting["sub-setting"]' ) ) );
		$this->assertEquals( 'my_settingsub-setting', Kirki_Field::sanitize_settings_raw( array( 'settings' => 'my_setting sub-setting' ) ) );

		$this->assertEquals( 'my_settingsub-setting', Kirki_Field::sanitize_settings_raw( array( 'setting'  => 'my_setting sub-setting' ) ) );
	}

	public function test_sanitize_settings() {
		$this->assertEquals( 'foo',      Kirki_Field::sanitize_settings( array( 'settings' => 'foo' ) ) );
		$this->assertEquals( 'foo[bar]', Kirki_Field::sanitize_settings( array( 'settings' => 'bar', 'option_type' => 'option', 'option_name' => 'foo' ) ) );
		$this->assertEquals( 'foo[bar]', Kirki_Field::sanitize_settings( array( 'settings' => 'foo[bar]' ) ) );
	}

	public function test_sanitize_label() {
		$this->assertEquals( 'This is my LABEL', Kirki_Field::sanitize_label( array( 'label' => 'This is my LABEL' ) ) );
	}

	public function test_sanitize_section() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_section( array( 'section' => 'foo' ) ) );
	}

	public function test_sanitize_id() {
		$this->assertEquals( 'foo',     Kirki_Field::sanitize_id( array( 'settings' => 'foo' ) ) );
		$this->assertEquals( 'foo-bar', Kirki_Field::sanitize_id( array( 'settings' => 'foo[bar]' ) ) );
		$this->assertEquals( 'foo-bar', Kirki_Field::sanitize_id( array( 'settings' => 'foo[ bar ]' ) ) );
	}

	public function test_sanitize_default() {
		$this->assertEquals( '<div class="foo">bar</div>', Kirki_Field::sanitize_default( array( 'type' => 'custom', 'default' => '<div class="foo">bar</div>' ) ) );
		$this->assertEquals( 'foo', Kirki_Field::sanitize_default( array( 'default' => 'foo' ) ) );
		$this->assertEquals( array( 'foo', 'bar' ), Kirki_Field::sanitize_default( array( 'default' => array( 'foo', 'bar' ) ) ) );
		$this->assertEquals( 'rgba(0,0,0,0)', Kirki_Field::sanitize_default( array( 'default' => 'rgba(0,0,0,0)' ) ) );
	}

	public function test_sanitize_description() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_description( array( 'description' => 'foo' ) ) );
		$this->assertEquals( 'foo', Kirki_Field::sanitize_description( array( 'subtitle'    => 'foo' ) ) );
		$this->assertEquals( 'bar', Kirki_Field::sanitize_description( array( 'description' => '<div class="foo">bar</div>' ) ) );
	}

	public function test_sanitize_help() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_help( array( 'help' => 'foo' ) ) );
		$this->assertEquals( 'bar', Kirki_Field::sanitize_help( array( 'subtitle' => 'foo', 'description' => 'bar' ) ) );
		$this->assertEquals( 'bar', Kirki_Field::sanitize_help( array( 'help' => '<div class="foo">bar</div>' ) ) );
	}

	public function test_sanitize_choices() {
		$this->assertEquals( array( 'min' => -10, 'max' => 999, 'step' => 3 ), Kirki_Field::sanitize_choices( array( 'choices' => array( 'min' => -10, 'max' => 999, 'step' => 3 ) ) ) );
		$this->assertEquals( array( 'foo', 'bar' ), Kirki_Field::sanitize_choices( array( 'choices' => array( 'foo', 'bar' ) ) ) );
		$this->assertEquals( array(), Kirki_Field::sanitize_choices( array() ) );
	}

}
