<?php

namespace Kirki;

class Setting {

	public $setting_type = null;
	public $capability   = null;

	/**
	 * The class construct
	 */
	public function __construct() {
		$this->setting_type = 'theme_mod';
		$this->capability   = 'edit_theme_options';
	}

	/**
	 * Add a setting
	 */
	public function add( $wp_customize, $control ) {

		if ( 'background' == $control['type'] ) {

			if ( isset( $control['default']['color'] ) ) {
				$this->add_setting( $wp_customize, $control, $control['settings'] . '_color', $control['default']['color'], $this->sanitize_callback( 'color' ) );
			}

			if ( isset( $control['default']['image'] ) ) {
				$this->add_setting( $wp_customize, $control, $control['settings'] . '_image', $control['default']['image'], $this->sanitize_callback( 'image' ) );
			}
			if ( isset( $control['default']['repeat'] ) ) {
				$this->add_setting( $wp_customize, $control, $control['settings'] . '_repeat', $control['default']['repeat'], 'kirki_sanitize_bg_repeat' );
			}

			if ( isset( $control['default']['size'] ) ) {
				$this->add_setting( $wp_customize, $control, $control['settings'] . '_size', $control['default']['size'], 'kirki_sanitize_bg_size' );
			}

			if ( isset( $control['default']['attach'] ) ) {
				$this->add_setting( $wp_customize, $control, $control['settings'] . '_attach', $control['default']['attach'], 'kirki_sanitize_bg_attach' );
			}

			if ( isset( $control['default']['position'] ) ) {
				$this->add_setting( $wp_customize, $control, $control['settings'] . '_position', $control['default']['position'], 'kirki_sanitize_bg_position' );
			}

			if ( isset( $control['default']['opacity'] ) && $control['default']['opacity'] ) {
				$this->add_setting( $wp_customize, $control, $control['settings'] . '_opacity', $control['default']['opacity'], 'absint' );
			}
		} else {
			$this->add_setting( $wp_customize, $control );
		}

	}

	/**
	 * Get the value of an option.
	 * If no value has been set then get the default value.
	 *
	 * For now we can only handle theme_mods
	 */
	public function get( $setting = '' ) {

		// Get the array of controls
		$controls = Kirki::controls()->get_all();
		foreach ( $controls as $control ) {
			$setting = $control['settings'];
			$default = ( isset( $control['default'] ) ) ? $control['default'] : '';
			// Get the theme_mod and pass the default value as well
			if ( $option == $setting ) {
				$value = get_theme_mod( $option, $default );
			}
		}

		if ( isset( $value ) ) {
			return $value;
		}

		// fallback to returning an empty string
		return '';

	}

	public function add_setting( $wp_customize, $control, $id_override = false, $default_override = false, $callback = false ) {

		$id       = ( $id_override ) ? $id_override : $control['settings'];
		$default  = ( $default_override ) ? $default_override : $control['default'];
		$callback = ( $callback ) ? $callback : $this->sanitize_callback( $control['type'] );

		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'type'              => $this->setting_type,
			'capability'        => $this->capability,
			'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : $callback,
		) );

	}

	/**
	 * Get the sanitize_callback based on the control type
	 */
	public function sanitize_callback( $control_type ) {

		switch ( $control_type ) {
			case 'checkbox' :
				$sanitize_callback = 'kirki_sanitize_checkbox';
				break;
			case 'color' :
				$sanitize_callback = 'sanitize_hex_color';
				break;
			case 'image' :
				$sanitize_callback = 'esc_url_raw';
				break;
			case 'radio' :
				// TODO: Find a way to handle these
				$sanitize_callback = 'kirki_sanitize_unfiltered';
				break;
			case 'select' :
				// TODO: Find a way to handle these
				$sanitize_callback = 'kirki_sanitize_unfiltered';
				break;
			case 'slider' :
				$sanitize_callback = 'kirki_sanitize_number';
				break;
			case 'text' :
				$sanitize_callback = 'esc_textarea';
				break;
			case 'textarea' :
				$sanitize_callback = 'esc_textarea';
				break;
			case 'upload' :
				$sanitize_callback = 'esc_url_raw';
				break;
			case 'number' :
				$sanitize_callback = 'kirki_sanitize_number';
				break;
			case 'multicheck' :
				$sanitize_callback = 'esc_attr';
				break;
			default :
				$sanitize_callback = 'kirki_sanitize_unfiltered';
		}

		return $sanitize_callback;

	}

}
