<?php

class Test_Kirki_Field_Sanitize extends WP_UnitTestCase {

	public function test_sanitize_control_type() {

		$this->assertEquals( 'kirki-checkbox', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'checkbox' ) ) );
		$this->assertEquals( 'color-alpha', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'color-alpha' ) ) );
		$this->assertEquals( 'color-alpha', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'color_alpha' ) ) );
		$this->assertEquals( 'color-alpha', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'color', 'default' => 'rgba(0,0,0,1)' ) ) );
		$this->assertEquals( 'color', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'color' ) ) );
		$this->assertEquals( 'custom', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'custom' ) ) );
		$this->assertEquals( 'custom', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'group-title' ) ) );
		$this->assertEquals( 'custom', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'group_title' ) ) );
		$this->assertEquals( 'dropdown-pages', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'dropdown-pages' ) ) );
		$this->assertEquals( 'editor', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'editor' ) ) );
		$this->assertEquals( 'image', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'image' ) ) );
		$this->assertEquals( 'multicheck', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'multicheck' ) ) );
		$this->assertEquals( 'number', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'number' ) ) );
		$this->assertEquals( 'palette', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'palette' ) ) );
		$this->assertEquals( 'radio-buttonset', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'radio-buttonset' ) ) );
		$this->assertEquals( 'radio-buttonset', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'radio', 'mode' => 'buttonset' ) ) );
		$this->assertEquals( 'radio-image', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'radio-image' ) ) );
		$this->assertEquals( 'radio-image', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'radio', 'mode' => 'image' ) ) );
		$this->assertEquals( 'kirki-radio', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'radio' ) ) );
		$this->assertEquals( 'kirki-select', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'select' ) ) );
		$this->assertEquals( 'slider', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'slider' ) ) );
		$this->assertEquals( 'sortable', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'sortable' ) ) );
		$this->assertEquals( 'switch', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'switch' ) ) );
		$this->assertEquals( 'switch', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'checkbox', 'mode' => 'switch' ) ) );
		$this->assertEquals( 'kirki-text', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'text' ) ) );
		$this->assertEquals( 'kirki-textarea', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'textarea' ) ) );
		$this->assertEquals( 'toggle', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'toggle' ) ) );
		$this->assertEquals( 'toggle', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'checkbox', 'mode' => 'toggle' ) ) );
		$this->assertEquals( 'upload', Kirki_Field_Sanitize::sanitize_control_type( array( 'type' => 'upload' ) ) );

		$this->assertEquals( 'kirki-text', Kirki_Field_Sanitize::sanitize_control_type( array() ) );

	}

	public function test_sanitize_field() {
		$this->assertEquals(
			array(
				'settings' => 'foo',
				'section' => 'foo',
				'type' => 'kirki-text',
				'default' => '',
				'label' => '',
				'help' => '',
				'description' => '',
				'required' => null,
				'transport' => 'refresh',
				'option_type' => 'theme_mod',
				'priority' => 10,
				'choices' => array(),
				'output' => array(),
				'sanitize_callback' => 'esc_textarea',
				'js_vars' => array(),
				'id' => 'foo',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			),
			Kirki_Field_Sanitize::sanitize_field( array(
				'settings' => 'foo',
				'section' => 'foo',
				'type' => 'text',
			) ) );
	}

	public function test_sanitize_type() {
		$this->assertEquals( 'theme_mod', Kirki_Field_Sanitize::sanitize_type( array( 'option_type' => 'theme_mod' ) ) );
		$this->assertEquals( 'option', Kirki_Field_Sanitize::sanitize_type( array( 'option_type' => 'option' ) ) );
		$this->assertEquals( 'theme_mod', Kirki_Field_Sanitize::sanitize_type( array() ) );
		add_filter( 'kirki/config', function() {
			return array(
				'option_type' => 'option',
			);
		});
		$this->assertEquals( 'option', Kirki_Field_Sanitize::sanitize_type( array() ) );
	}

	public function test_sanitize_active_callback() {
		$field = Kirki_Field_Sanitize::sanitize_field( array( 'active_callback' => '__return_true' ) );
		$this->assertEquals( '__return_true', $field['active_callback'] );
		$field = Kirki_Field_Sanitize::sanitize_field( array() );
		$this->assertEquals( '__return_true', $field['active_callback'] );
		$field = Kirki_Field_Sanitize::sanitize_field( array( 'required' => array() ) );
		$this->assertEquals( array( 'Kirki_Active_Callback', 'evaluate' ), $field['active_callback'] );
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
			$this->assertEquals( $capability, Kirki_Field_Sanitize::sanitize_capability( array( 'capability' => $capability ) ) );
		}

		$this->assertEquals( 'edit_theme_options', Kirki_Field_Sanitize::sanitize_capability( array() ) );

		add_filter( 'kirki/config', function() {
			return array(
				'capability' => 'activate_plugins',
			);
		});
		$this->assertEquals( 'activate_plugins', Kirki_Field_Sanitize::sanitize_capability( array() ) );
	}

	public function test_sanitize_settings() {
		$this->assertEquals( 'foo', Kirki_Field_Sanitize::sanitize_settings( array( 'settings' => 'foo' ) ) );
		$this->assertEquals( 'foo[bar]', Kirki_Field_Sanitize::sanitize_settings( array( 'settings' => 'bar', 'option_type' => 'option', 'option_name' => 'foo' ) ) );
		$this->assertEquals( 'foo[bar]', Kirki_Field_Sanitize::sanitize_settings( array( 'settings' => 'foo[bar]' ) ) );
	}

	public function test_sanitize_id() {
		$this->assertEquals( 'foo', Kirki_Field_Sanitize::sanitize_id( array( 'settings' => 'foo' ) ) );
		$this->assertEquals( 'foo-bar', Kirki_Field_Sanitize::sanitize_id( array( 'settings' => 'foo[bar]' ) ) );
		$this->assertEquals( 'foo-bar', Kirki_Field_Sanitize::sanitize_id( array( 'settings' => 'foo[ bar ]' ) ) );
	}

	public function test_sanitize_callback() {
		$this->assertEquals( '__return_true', Kirki_Field_Sanitize::sanitize_callback( array( 'sanitize_callback' => '__return_true' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'checkbox' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'checkbox' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'color' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'color-alpha' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'color' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'color' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'unfiltered' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'custom' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'dropdown_pages' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'dropdown-pages' ) ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'editor' ) ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'image' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'multicheck' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'multicheck' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'number' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'number' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'palette' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'radio-buttonset' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'radio-image' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'radio' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'unfiltered' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'select' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'number' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'slider' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'sortable' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'sortable' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'checkbox' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'switch' ) ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'text' ) ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'textarea' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'checkbox' ), Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'toggle' ) ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field_Sanitize::sanitize_callback( array( 'type' => 'upload' ) ) );
	}

	public function test_fallback_callback() {
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'checkbox' ), Kirki_Field_Sanitize::fallback_callback( 'checkbox' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'color' ), Kirki_Field_Sanitize::fallback_callback( 'color-alpha' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'color' ), Kirki_Field_Sanitize::fallback_callback( 'color' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'unfiltered' ), Kirki_Field_Sanitize::fallback_callback( 'custom' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'dropdown_pages' ), Kirki_Field_Sanitize::fallback_callback( 'dropdown-pages' ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field_Sanitize::fallback_callback( 'editor' ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field_Sanitize::fallback_callback( 'image' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'multicheck' ), Kirki_Field_Sanitize::fallback_callback( 'multicheck' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'number' ), Kirki_Field_Sanitize::fallback_callback( 'number' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::fallback_callback( 'palette' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::fallback_callback( 'radio-buttonset' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::fallback_callback( 'radio-image' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field_Sanitize::fallback_callback( 'radio' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'unfiltered' ), Kirki_Field_Sanitize::fallback_callback( 'select' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'number' ), Kirki_Field_Sanitize::fallback_callback( 'slider' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'sortable' ), Kirki_Field_Sanitize::fallback_callback( 'sortable' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'checkbox' ), Kirki_Field_Sanitize::fallback_callback( 'switch' ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field_Sanitize::fallback_callback( 'text' ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field_Sanitize::fallback_callback( 'textarea' ) );
		$this->assertEquals( array( 'Kirki_Sanitize_Values', 'checkbox' ), Kirki_Field_Sanitize::fallback_callback( 'toggle' ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field_Sanitize::fallback_callback( 'upload' ) );
	}

}
