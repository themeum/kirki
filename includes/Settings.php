<?php

namespace Kirki;

class Settings {

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
	public function add( $wp_customize, $field ) {

		if ( 'option' == $this->setting_type ) {
			$field['settings'] = $this->option_name . '[' . $field['settings'] . ']';
		}

		if ( 'background' == $field['type'] ) {

			if ( isset( $field['default']['color'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $field['settings'] . '_color]' : $field['settings'] . '_color';
				$this->add_setting( $wp_customize, $field, $option_name, $field['default']['color'], 'sanitize_hex_color' );
			}

			if ( isset( $field['default']['image'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $field['settings'] . '_image]' : $field['settings'] . '_image';
				$this->add_setting( $wp_customize, $field, $option_name, $field['default']['image'], 'esc_url_raw' );
			}
			if ( isset( $field['default']['repeat'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $field['settings'] . '_repeat]' : $field['settings'] . '_repeat';
				$this->add_setting( $wp_customize, $field, $option_name, $field['default']['repeat'], 'kirki_sanitize_bg_repeat' );
			}

			if ( isset( $field['default']['size'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $field['settings'] . '_size]' : $field['settings'] . '_size';
				$this->add_setting( $wp_customize, $field, $option_name, $field['default']['size'], 'kirki_sanitize_bg_size' );
			}

			if ( isset( $field['default']['attach'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $field['settings'] . '_attach]' : $field['settings'] . '_attach';
				$this->add_setting( $wp_customize, $field, $option_name, $field['default']['attach'], 'kirki_sanitize_bg_attach' );
			}

			if ( isset( $field['default']['position'] ) ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $field['settings'] . '_position]' : $field['settings'] . '_position';
				$this->add_setting( $wp_customize, $field, $option_name, $field['default']['position'], 'kirki_sanitize_bg_position' );
			}

			if ( isset( $field['default']['opacity'] ) && $field['default']['opacity'] ) {
				$option_name = ( 'option' == $this->setting_type ) ? $this->option_name . '[' . $field['settings'] . '_opacity]' : $field['settings'] . '_opacity';
				$this->add_setting( $wp_customize, $field, $option_name, $field['default']['opacity'], 'absint' );
			}
		} else {
			$this->add_setting( $wp_customize, $field );
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
		$fields = Kirki::fields()->get_all();
		foreach ( $fields as $field ) {

			$setting = $field['settings'];
			$default = ( isset( $field['default'] ) ) ? $field['default'] : '';
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

	public function add_setting( $wp_customize, $field, $id_override = null, $default_override = null, $callback = null ) {

		$id       = ( ! is_null( $id_override ) )      ? $id_override      : $field['settings'];
		$default  = ( ! is_null( $default_override ) ) ? $default_override : $field['default'];
		$callback = ( ! is_null( $callback ) )         ? $callback         : $field['type'];

		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'type'              => $field['option_type'],
			'capability'        => $this->capability,
			'transport'         => $field['transport'],
			'sanitize_callback' => $callback,
		) );

	}

}
