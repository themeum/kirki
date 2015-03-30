<?php

namespace Kirki;

class Setting {

	public $setting_type = null;
	public $capability   = null;
	public $option_name  = null;

	/**
	 * The class construct
	 */
	public function __construct() {
		$this->setting_type = 'theme_mod';
		$this->option_name  = 'kirki';
		$this->capability   = 'edit_theme_options';
	}

	/**
	 * Add a setting
	 */
	public function add( $wp_customize, $control ) {

		if ( 'option' == $this->setting_type ) {
			$control['settings'] = $this->option_name . '[' . $control['settings'] . ']';
		}

		if ( 'background' == $control['type'] ) {

			if ( isset( $control['default']['color'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $control['settings'] . '_color]' : $control['settings'] . '_color';
				$this->add_setting( $wp_customize, $control, $option_name, $control['default']['color'], 'sanitize_hex_color' );
			}

			if ( isset( $control['default']['image'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $control['settings'] . '_image]' : $control['settings'] . '_image';
				$this->add_setting( $wp_customize, $control, $option_name, $control['default']['image'], 'esc_url_raw' );
			}
			if ( isset( $control['default']['repeat'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $control['settings'] . '_repeat]' : $control['settings'] . '_repeat';
				$this->add_setting( $wp_customize, $control, $option_name, $control['default']['repeat'], 'kirki_sanitize_bg_repeat' );
			}

			if ( isset( $control['default']['size'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $control['settings'] . '_size]' : $control['settings'] . '_size';
				$this->add_setting( $wp_customize, $control, $option_name, $control['default']['size'], 'kirki_sanitize_bg_size' );
			}

			if ( isset( $control['default']['attach'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $control['settings'] . '_attach]' : $control['settings'] . '_attach';
				$this->add_setting( $wp_customize, $control, $option_name, $control['default']['attach'], 'kirki_sanitize_bg_attach' );
			}

			if ( isset( $control['default']['position'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $control['settings'] . '_position]' : $control['settings'] . '_position';
				$this->add_setting( $wp_customize, $control, $option_name, $control['default']['position'], 'kirki_sanitize_bg_position' );
			}

			if ( isset( $control['default']['opacity'] ) && $control['default']['opacity'] ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $control['settings'] . '_opacity]' : $control['settings'] . '_opacity';
				$this->add_setting( $wp_customize, $control, $option_name, $control['default']['opacity'], 'absint' );
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

				if ( 'theme_mod' == $this->setting_type ) {
					$value = get_theme_mod( $option, $default );
				} elseif ( 'option' == $this->setting_type ) {
					$value = get_option( $option, $default );
				}

			}

		}

		if ( isset( $value ) ) {
			return $value;
		}

		// fallback to returning an empty string
		return '';

	}

	public function add_setting( $wp_customize, $control, $id_override = null, $default_override = null, $callback = null ) {

		$id       = ( ! is_null( $id_override ) )      ? $id_override      : $control['settings'];
		$default  = ( ! is_null( $default_override ) ) ? $default_override : $control['default'];
		$callback = ( ! is_null( $callback ) )         ? $callback         : $this->sanitize_callback( $control['type'] );

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
				$sanitize_callback = 'kirki_sanitize_choice';
				break;
			case 'radio-image' :
				$sanitize_callback = 'kirki_sanitize_choice';
				break;
			case 'radio-buttonset' :
				$sanitize_callback = 'kirki_sanitize_choice';
				break;
			case 'toggle' :
				$sanitize_callback = 'kirki_sanitize_checkbox';
				break;
			case 'switch' :
				$sanitize_callback = 'kirki_sanitize_checkbox';
				break;
			case 'select' :
				$sanitize_callback = 'kirki_sanitize_choice';
				break;
			case 'dropdown-pages' :
				$sanitize_callback = 'kirki_sanitize_choice';
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
			case 'editor' :
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
			case 'sortable' :
				$sanitize_callback = 'esc_attr';
				break;
			case 'palette' :
				$sanitize_callback = 'kirki_sanitize_choice';
				break;
			default :
				$sanitize_callback = 'kirki_sanitize_unfiltered';
		}

		return $sanitize_callback;

	}

}
