<?php

namespace Kirki;

use Kirki;

class Fields {

	/**
	 * Sanitizes the field
	 *
	 * @param array the field definition
	 * @return array
	 */
	public function sanitize( $field ) {

		$field['default']           = $this->sanitize_default( $field );
		$field['label']             = $this->sanitize_label( $field );
		$field['help']              = $this->sanitize_help( $field );
		$field['description']       = $this->sanitize_description( $field );
		$field['required']          = $this->sanitize_required( $field );
		$field['transport']         = $this->sanitize_transport( $field );
		$field['type']              = $this->sanitize_control_type( $field );
		$field['option_type']       = $this->sanitize_type( $field );
		$field['section']           = $this->sanitize_section( $field );
		$field['settings']          = $this->sanitize_settings( $field );
		$field['priority']          = $this->sanitize_priority( $field );
		$field['choices']           = $this->sanitize_choices( $field );
		$field['output']            = $this->sanitize_output( $field );
		$field['sanitize_callback'] = $this->sanitize_callback( $field );
		$field['js_vars']           = $this->sanitize_js_vars( $field );
		$field['id']                = $this->sanitize_id( $field );

		return $field;

	}

	/**
	 * Sanitizes the control type.
	 *
	 * @param array the field definition
	 * @return string. If not set, then defaults to text.
	 */
	public function sanitize_control_type( $field ) {
		return ( isset( $field['type'] ) ) ? $field['type'] : 'text';
	}

	/**
	 * Sanitizes the setting type.
	 *
	 * @param array the field definition
	 * @return string. (theme_mod|option)
	 */
	public function sanitize_type( $field ) {

		$config = Kirki::config()->get_all();
		if ( isset( $config['options_type'] ) && 'option' == $config['options_type'] ) {
			return 'option';
		} else {
			return 'theme_mod';
		}

	}

	/**
	 * Sanitizes the setting name
	 *
	 * @param array the field definition
	 * @return string.
	 */
	public function sanitize_settings( $field ) {

		/**
		 * Compatibility tweak
		 *
		 * Previous versions of the Kirki customizer used 'setting' istead of 'settings'.
		 */
		if ( ! isset( $field['settings'] ) && isset( $field['setting'] ) ) {
			$field['settings'] = $field['setting'];
		}
		return $field['settings'];

	}

	/**
	 * Sanitizes the control label.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public function sanitize_label( $field ) {
		return ( isset( $field['label'] ) ) ? esc_html( $field['label'] ) : '';
	}

	/**
	 * Sanitizes the control section
	 *
	 * @param array the field definition
	 * @return string
	 */
	public function sanitize_section( $field ) {
		return sanitize_key( $field['section'] );
	}

	/**
	 * Sanitizes the control id
	 *
	 * @param array the field definition
	 * @return string
	 */
	public function sanitize_id( $field ) {
		return sanitize_key( $field['settings'] );
	}

	/**
	 * Sanitizes the setting default value
	 *
	 * @param array the field definition
	 * @return mixed
	 */
	public function sanitize_default( $field ) {
		// If ['default'] is not set, set an empty value
		if ( ! isset( $field['default'] ) ) {
			$field['default'] = '';
		}

		/**
		 * Sortable controls need a serialized array as the default value.
		 * Since we're using normal arrays to set our defaults when defining the fields, we need to serialize that value here.
		 */
		if ( 'sortable' == $field['type'] && isset( $field['default'] ) && ! empty( $field['default'] ) ) {
			$field['default'] = maybe_serialize( $field['default'] );
		}

		return $field['default'];

	}

	/**
	 * Sanitizes the control description
	 *
	 * @param array the field definition
	 * @return string
	 */
	public function sanitize_description( $field ) {

		/**
		 * Compatibility tweak
		 *
		 * Previous verions of the Kirki Customizer had the 'description' field mapped to the new 'help'
		 * and instead of 'description' we were using 'subtitle'.
		 * This has been deprecated in favor of WordPress core's 'description' field that was recently introduced.
		 *
		 */
		if ( isset( $field['subtitle'] ) ) {
			$field['description'] = $field['subtitle'];
		}

		return ( isset( $field['description'] ) ) ? esc_html( $field['description'] ) : '';

	}

	/**
	 * Sanitizes the control help
	 *
	 * @param array the field definition
	 * @return string
	 */
	public function sanitize_help( $field ) {

		/**
		 * Compatibility tweak
		 *
		 * Previous verions of the Kirki Customizer had the 'description' field mapped to the new 'help'
		 * and instead of 'description' we were using 'subtitle'.
		 * This has been deprecated in favor of WordPress core's 'description' field that was recently introduced.
		 *
		 */
		if ( isset( $field['subtitle'] ) ) {
			// Use old arguments form.
			$field['help'] = ( isset( $field['description'] ) ) ? $field['description'] : '';
		}
		return isset( $field['help'] ) ? esc_html( $field['help'] ) : '';

	}

	/**
	 * Sanitizes the control choices.
	 *
	 * @param array the field definition
	 * @return array
	 */
	public function sanitize_choices( $field ) {
		return isset( $field['choices'] ) ? $field['choices'] : array();
	}

	/**
	 * Sanitizes the control output
	 *
	 * @param array the field definition
	 * @return array
	 */
	public function sanitize_output( $field ) {
		return isset( $field['output'] ) ? $field['output'] : null;
	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param array the field definition
	 * @return string postMessage|refresh (defaults to refresh)
	 */
	public function sanitize_transport( $field ) {
		return ( isset( $field['transport'] ) && 'postMessage' == $field['transport'] ) ? 'postMessage' : 'refresh';
	}

	/**
	 * Sanitizes the setting sanitize_callback
	 *
	 * @param array the field definition
	 * @return mixed the sanitization callback for this setting
	 */
	public function sanitize_callback( $field ) {

		if ( isset( $field['sanitize_callback'] ) && ! empty( $field['sanitize_callback'] ) ) {
			if ( ! is_array( $field['sanitize_callback'] ) && function_exists( $field['sanitize_callback'] ) ) {
				$exists = true;
			} elseif ( method_exists( $field['sanitize_callback'] ) ) {
				$exists = true;
			}
		}

		if ( isset( $exists ) ) {
			return $field['sanitize_callback'];
		} else {
			// Fallback callback
			return self::fallback_callback( $field['type'] );
		}
	}

	/**
	 * Sanitizes the control js_vars.
	 *
	 * @param array the field definition
	 * @return array
	 */
	public function sanitize_js_vars( $field ) {
		if ( isset( $field['js_vars'] ) ) {
			return $field['js_vars'];
		}
	}

	/**
	 * Sanitizes the control required argument.
	 *
	 * @param array the field definition
	 * @return array
	 */
	public function sanitize_required( $field ) {
		return isset( $field['required'] ) ? $field['required'] : array();
	}

	/**
	 * Sanitizes the control priority
	 *
	 * @param array the field definition
	 * @return int
	 */
	public function sanitize_priority( $field ) {

		if ( isset( $field['priority'] ) ) {
			return intval( $field['priority'] );
		} else {
			return 10;
		}

	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param string the control type
	 * @return string the function name of a sanitization callback
	 */
	public static function fallback_callback( $field_type ) {

		switch ( $field_type ) {
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
