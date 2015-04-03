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

		if ( 'background' == $field['type'] ) {
			// Do nothing.
			// The 'background' field is just the sum of its sub-fields
			// which are created individually.
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
		$callback = ( ! is_null( $callback ) )         ? $callback         : $field['sanitize_callback'];

		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'type'              => $field['option_type'],
			'capability'        => $this->capability,
			'transport'         => $field['transport'],
			'sanitize_callback' => $callback,
		) );

	}

}
