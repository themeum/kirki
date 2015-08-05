<?php

class Test_Kirki_Field extends WP_UnitTestCase {

	public function test_sanitize_control_type() {

		$this->assertEquals( 'checkbox', Kirki_Field::sanitize_control_type( array( 'type' => 'checkbox' ) ) );

		$this->assertEquals( 'color-alpha', Kirki_Field::sanitize_control_type( array( 'type' => 'color-alpha' ) ) );
		$this->assertEquals( 'color-alpha', Kirki_Field::sanitize_control_type( array( 'type' => 'color_alpha' ) ) );
		$this->assertEquals( 'color-alpha', Kirki_Field::sanitize_control_type( array( 'type' => 'color', 'default' => 'rgba(0,0,0,1)' ) ) );
		$this->assertEquals( 'color', Kirki_Field::sanitize_control_type( array( 'type' => 'color' ) ) );
		$this->assertEquals( 'custom', Kirki_Field::sanitize_control_type( array( 'type' => 'custom' ) ) );
		$this->assertEquals( 'custom', Kirki_Field::sanitize_control_type( array( 'type' => 'group-title' ) ) );
		$this->assertEquals( 'custom', Kirki_Field::sanitize_control_type( array( 'type' => 'group_title' ) ) );
		$this->assertEquals( 'dropdown-pages', Kirki_Field::sanitize_control_type( array( 'type' => 'dropdown-pages' ) ) );
		$this->assertEquals( 'editor', Kirki_Field::sanitize_control_type( array( 'type' => 'editor' ) ) );
		$this->assertEquals( 'image', Kirki_Field::sanitize_control_type( array( 'type' => 'image' ) ) );
		$this->assertEquals( 'multicheck', Kirki_Field::sanitize_control_type( array( 'type' => 'multicheck' ) ) );
		$this->assertEquals( 'number', Kirki_Field::sanitize_control_type( array( 'type' => 'number' ) ) );
		$this->assertEquals( 'palette', Kirki_Field::sanitize_control_type( array( 'type' => 'palette' ) ) );
		$this->assertEquals( 'radio-buttonset', Kirki_Field::sanitize_control_type( array( 'type' => 'radio-buttonset' ) ) );
		$this->assertEquals( 'radio-buttonset', Kirki_Field::sanitize_control_type( array( 'type' => 'radio', 'mode' => 'buttonset' ) ) );
		$this->assertEquals( 'radio-image', Kirki_Field::sanitize_control_type( array( 'type' => 'radio-image' ) ) );
		$this->assertEquals( 'radio-image', Kirki_Field::sanitize_control_type( array( 'type' => 'radio', 'mode' => 'image' ) ) );
		$this->assertEquals( 'radio', Kirki_Field::sanitize_control_type( array( 'type' => 'radio' ) ) );
		$this->assertEquals( 'select', Kirki_Field::sanitize_control_type( array( 'type' => 'select' ) ) );
		$this->assertEquals( 'slider', Kirki_Field::sanitize_control_type( array( 'type' => 'slider' ) ) );
		$this->assertEquals( 'sortable', Kirki_Field::sanitize_control_type( array( 'type' => 'sortable' ) ) );
		$this->assertEquals( 'switch', Kirki_Field::sanitize_control_type( array( 'type' => 'switch' ) ) );
		$this->assertEquals( 'switch', Kirki_Field::sanitize_control_type( array( 'type' => 'checkbox', 'mode' => 'switch' ) ) );
		$this->assertEquals( 'text', Kirki_Field::sanitize_control_type( array( 'type' => 'text' ) ) );
		$this->assertEquals( 'textarea', Kirki_Field::sanitize_control_type( array( 'type' => 'textarea' ) ) );
		$this->assertEquals( 'toggle', Kirki_Field::sanitize_control_type( array( 'type' => 'toggle' ) ) );
		$this->assertEquals( 'toggle', Kirki_Field::sanitize_control_type( array( 'type' => 'checkbox', 'mode' => 'toggle' ) ) );
		$this->assertEquals( 'upload', Kirki_Field::sanitize_control_type( array( 'type' => 'upload' ) ) );

		$this->assertEquals( 'text', Kirki_Field::sanitize_control_type( array() ) );

	}

	public function test_sanitize_field() {
		$this->assertEquals(
			array(
				'settings' => 'foo',
				'section' => 'foo',
				'type' => 'text',
				'default' => '',
				'label' => '',
				'help' => '',
				'description' => '',
				'required' => null,
				'transport' => 'refresh',
				'option_type' => 'theme_mod',
				'priority' => 10,
				'choices' => array(),
				'output' => null,
				'sanitize_callback' => 'esc_textarea',
				'js_vars' => null,
				'id' => 'foo',
				'capability' => 'edit_theme_options',
				'variables' => null,
				'active_callback' => '__return_true',
				'option_name' => ''
			),
			Kirki_Field::sanitize_field( array(
				'settings' => 'foo',
				'section' => 'foo',
				'type' => 'text',
			) ) );
	}

	public function test_sanitize_type() {
		$this->assertEquals( 'theme_mod', Kirki_Field::sanitize_type( array( 'option_type' => 'theme_mod' ) ) );
		$this->assertEquals( 'option', Kirki_Field::sanitize_type( array( 'option_type' => 'option' ) ) );
		$this->assertEquals( 'theme_mod', Kirki_Field::sanitize_type( array() ) );
		add_filter( 'kirki/config', function() {
			return array(
				'option_type' => 'option',
			);
		});
		$this->assertEquals( 'option', Kirki_Field::sanitize_type( array() ) );
	}

	public function test_sanitize_variables() {
		$this->assertEquals( false, Kirki_Field::sanitize_variables( array() ) );
		$this->assertEquals( array(), Kirki_Field::sanitize_variables( array( 'variables' => array() ) ) );
	}

	public function test_sanitize_active_callback() {
		$this->assertEquals( '__return_true', Kirki_Field::sanitize_active_callback( array( 'active_callback' => '__return_true' ) ) );
		$this->assertEquals( '__return_true', Kirki_Field::sanitize_active_callback( array() ) );
		$this->assertEquals( 'kirki_active_callback', Kirki_Field::sanitize_active_callback( array( 'required' => array() ) ) );
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

		add_filter( 'kirki/config', function() {
			return array(
				'capability' => 'activate_plugins',
			);
		});
		$this->assertEquals( 'activate_plugins', Kirki_Field::sanitize_capability( array() ) );
	}

	public function test_sanitize_settings() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_settings( array( 'settings' => 'foo' ) ) );
		$this->assertEquals( 'foo[bar]', Kirki_Field::sanitize_settings( array( 'settings' => 'bar', 'option_type' => 'option', 'option_name' => 'foo' ) ) );
		$this->assertEquals( 'foo[bar]', Kirki_Field::sanitize_settings( array( 'settings' => 'foo[bar]' ) ) );
	}

	public function test_sanitize_label() {
		$this->assertEquals( 'This is my LABEL', Kirki_Field::sanitize_label( array( 'label' => 'This is my LABEL' ) ) );
	}

	public function test_sanitize_section() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_section( array( 'section' => 'foo' ) ) );
		$this->assertEquals( 'title_tagline', Kirki_Field::sanitize_section( array() ) );
	}

	public function test_sanitize_id() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_id( array( 'settings' => 'foo' ) ) );
		$this->assertEquals( 'foo-bar', Kirki_Field::sanitize_id( array( 'settings' => 'foo[bar]' ) ) );
		$this->assertEquals( 'foo-bar', Kirki_Field::sanitize_id( array( 'settings' => 'foo[ bar ]' ) ) );
	}

	public function test_sanitize_default() {
		$this->assertEquals( '<div class="foo">bar</div>', Kirki_Field::sanitize_default( array( 'type' => 'custom', 'default' => '<div class="foo">bar</div>' ) ) );
		$this->assertEquals( 'foo', Kirki_Field::sanitize_default( array( 'default' => 'foo' ) ) );
		$this->assertEquals( array( 'foo', 'bar' ), Kirki_Field::sanitize_default( array( 'default' => array( 'foo', 'bar' ) ) ) );
		$this->assertEquals( 'rgba(0,0,0,0)', Kirki_Field::sanitize_default( array( 'default' => 'rgba(0,0,0,0)' ) ) );
		$this->assertEquals( 'foo', Kirki_Field::sanitize_default( array( 'type' => 'text', 'default' => 'foo', ) ) );
	}

	public function test_sanitize_description() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_description( array( 'description' => 'foo' ) ) );
		$this->assertEquals( 'foo', Kirki_Field::sanitize_description( array( 'subtitle' => 'foo' ) ) );
		$this->assertEquals( 'bar', Kirki_Field::sanitize_description( array( 'description' => '<div class="foo">bar</div>' ) ) );
		$this->assertEquals( '', Kirki_Field::sanitize_description( array() ) );
	}

	public function test_sanitize_help() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_help( array( 'help' => 'foo' ) ) );
		$this->assertEquals( 'bar', Kirki_Field::sanitize_help( array( 'subtitle' => 'foo', 'description' => 'bar' ) ) );
		$this->assertEquals( 'bar', Kirki_Field::sanitize_help( array( 'help' => '<div class="foo">bar</div>' ) ) );
		$this->assertEquals( '', Kirki_Field::sanitize_help( array( 'subtitle' => 'foo' ) ) );
	}

	public function test_sanitize_choices() {
		$this->assertEquals(
			array( 'min' => -10, 'max' => 999, 'step' => 3 ),
			Kirki_Field::sanitize_choices(
				array( 'choices' => array( 'min' => -10, 'max' => 999, 'step' => 3 ) )
			)
		);
		$this->assertEquals(
			array( 'foo', 'bar' ),
			Kirki_Field::sanitize_choices( array( 'choices' => array( 'foo', 'bar' ) ) )
		);
		$this->assertEquals( array(), Kirki_Field::sanitize_choices( array() ) );

		$this->assertEquals( 'foo', Kirki_Field::sanitize_choices( array( 'choices' => 'foo' ) ) );
	}

	public function test_sanitize_output() {
		$this->assertEquals( 'foo', Kirki_Field::sanitize_output( array( 'output' => 'foo' ) ) );
		$this->assertEquals(
			array(
				array(
					'element' => 'body > #main',
					'property' => 'font-family',
					'units' => '',
					'media_query' => 'global',
					'sanitize_callback' => null
				)
			),
			Kirki_Field::sanitize_output( array( 'output' => array(
				'element' => 'body > #main',
				'property' => 'font-family',
			) ) )
		);
		$this->assertEquals(
			array(
				array(
					'element' => 'body > #main',
					'property' => 'font-size',
					'units' => 'px !important',
					'media_query' => '@media (min-width: 700px) and (orientation: landscape)',
					'sanitize_callback' => null,
				)
			),
			Kirki_Field::sanitize_output( array( 'output' => array(
				array(
					'element' => 'body > #main',
					'property' => 'font-size',
					'units' => 'px !important',
					'prefix' => '@media (min-width: 700px) and (orientation: landscape) {',
					'suffix' => '}',
				)
			) ) )
		);
	}

	public function test_sanitize_transport() {
		$this->assertEquals( 'refresh', Kirki_Field::sanitize_transport( array() ) );
		$this->assertEquals( 'refresh', Kirki_Field::sanitize_transport( array( 'transport' => '' ) ) );
		$this->assertEquals( 'refresh', Kirki_Field::sanitize_transport( array( 'transport' => 'invalid' ) ) );
		$this->assertEquals( 'postMessage', Kirki_Field::sanitize_transport( array( 'transport' => 'postMessage' ) ) );
	}

	public function test_sanitize_callback() {
		$this->assertEquals( '__return_true', Kirki_Field::sanitize_callback( array( 'sanitize_callback' => '__return_true' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'checkbox' ), Kirki_Field::sanitize_callback( array( 'type' => 'checkbox' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'color' ), Kirki_Field::sanitize_callback( array( 'type' => 'color-alpha' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'color' ), Kirki_Field::sanitize_callback( array( 'type' => 'color' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'unfiltered' ), Kirki_Field::sanitize_callback( array( 'type' => 'custom' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'dropdown_pages' ), Kirki_Field::sanitize_callback( array( 'type' => 'dropdown-pages' ) ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field::sanitize_callback( array( 'type' => 'editor' ) ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field::sanitize_callback( array( 'type' => 'image' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'multicheck' ), Kirki_Field::sanitize_callback( array( 'type' => 'multicheck' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'number' ), Kirki_Field::sanitize_callback( array( 'type' => 'number' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::sanitize_callback( array( 'type' => 'palette' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::sanitize_callback( array( 'type' => 'radio-buttonset' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::sanitize_callback( array( 'type' => 'radio-image' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::sanitize_callback( array( 'type' => 'radio' ) ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::sanitize_callback( array( 'type' => 'select' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'number' ), Kirki_Field::sanitize_callback( array( 'type' => 'slider' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'sortable' ), Kirki_Field::sanitize_callback( array( 'type' => 'sortable' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'checkbox' ), Kirki_Field::sanitize_callback( array( 'type' => 'switch' ) ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field::sanitize_callback( array( 'type' => 'text' ) ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field::sanitize_callback( array( 'type' => 'textarea' ) ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'checkbox' ), Kirki_Field::sanitize_callback( array( 'type' => 'toggle' ) ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field::sanitize_callback( array( 'type' => 'upload' ) ) );
	}

	public function test_sanitize_js_vars() {
		$this->assertEquals( null, Kirki_Field::sanitize_js_vars( array() ) );
		$this->assertEquals( null, Kirki_Field::sanitize_js_vars( array( 'js_vars' => 'foo' ) ) );
		$this->assertEquals(
			array(
				array(
					'element' => '#main',
					'function' => 'css',
					'property' => 'color',
					'units' => '',
				)
			),
			Kirki_Field::sanitize_js_vars( array( 'js_vars' => array(
				'element' => '#main',
				'function' => 'css',
				'property' => 'color',
			) ) )
		);
		$this->assertEquals(
			array(
				array(
					'element' => 'body > #main',
					'function' => 'css',
					'property' => 'font-size',
					'units' => 'px'
				)
			),
			Kirki_Field::sanitize_js_vars( array( 'js_vars' => array(
				array(
					'element' => 'body > #main',
					'function' => 'css',
					'property' => 'font-size',
					'units' => 'px'
				)
			) ) )
		);
	}

	public function test_sanitize_required() {
		$this->assertEquals(
			array(
				array(
					'setting' => 'my-setting',
					'operator' => '==',
					'value' => '1',
				)
			),
			Kirki_Field::sanitize_required( array( 'required' => array(
				'setting' => 'my-setting',
			) ) )
		);
		$this->assertEquals(
			array(
				array(
					'setting' => 'my-setting',
					'operator' => '>=',
					'value' => '#333ff2'
				)
			),
			Kirki_Field::sanitize_required( array( 'required' => array(
				array(
					'setting' => 'my-setting',
					'operator' => '>=',
					'value' => '#333ff2'
				)
			) ) )
		);

		$this->assertEquals( null, Kirki_Field::sanitize_required( array() ) );
	}

	public function test_sanitize_priority() {
		$this->assertEquals( 10, Kirki_Field::sanitize_priority( array() ) );
		$this->assertEquals( 10, Kirki_Field::sanitize_priority( array( 'priority' => 'invalid priority' ) ) );
		$this->assertEquals( 20, Kirki_Field::sanitize_priority( array( 'priority' => '-20' ) ) );
		$this->assertEquals( 20, Kirki_Field::sanitize_priority( array( 'priority' => -20 ) ) );
		$this->assertEquals( 20, Kirki_Field::sanitize_priority( array( 'priority' => 20 ) ) );
		$this->assertEquals( 20, Kirki_Field::sanitize_priority( array( 'priority' => 20.356 ) ) );
		$this->assertEquals( 20, Kirki_Field::sanitize_priority( array( 'priority' => '20.356' ) ) );
	}

	public function test_fallback_callback() {
		$this->assertEquals( array( 'Kirki_Sanitize', 'checkbox' ), Kirki_Field::fallback_callback( 'checkbox' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'color' ), Kirki_Field::fallback_callback( 'color-alpha' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'color' ), Kirki_Field::fallback_callback( 'color' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'unfiltered' ), Kirki_Field::fallback_callback( 'custom' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'dropdown_pages' ), Kirki_Field::fallback_callback( 'dropdown-pages' ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field::fallback_callback( 'editor' ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field::fallback_callback( 'image' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'multicheck' ), Kirki_Field::fallback_callback( 'multicheck' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'number' ), Kirki_Field::fallback_callback( 'number' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::fallback_callback( 'palette' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::fallback_callback( 'radio-buttonset' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::fallback_callback( 'radio-image' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::fallback_callback( 'radio' ) );
		$this->assertEquals( 'esc_attr', Kirki_Field::fallback_callback( 'select' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'number' ), Kirki_Field::fallback_callback( 'slider' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'sortable' ), Kirki_Field::fallback_callback( 'sortable' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'checkbox' ), Kirki_Field::fallback_callback( 'switch' ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field::fallback_callback( 'text' ) );
		$this->assertEquals( 'esc_textarea', Kirki_Field::fallback_callback( 'textarea' ) );
		$this->assertEquals( array( 'Kirki_Sanitize', 'checkbox' ), Kirki_Field::fallback_callback( 'toggle' ) );
		$this->assertEquals( 'esc_url_raw', Kirki_Field::fallback_callback( 'upload' ) );
	}

}
