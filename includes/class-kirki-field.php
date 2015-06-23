<?php
/**
 * Sanitizes all variables from our fields and separates complex fields to their sub-fields.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Field' ) ) {
	return;
}

class Kirki_Field {

	/**
	 * Sanitizes the field
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_field( $field ) {

		$sanitized = array(
			'settings_raw'      => self::sanitize_settings_raw( $field ),
			'default'           => self::sanitize_default( $field ),
			'label'             => self::sanitize_label( $field ),
			'help'              => self::sanitize_help( $field ),
			'description'       => self::sanitize_description( $field ),
			'required'          => self::sanitize_required( $field ),
			'transport'         => self::sanitize_transport( $field ),
			'type'              => self::sanitize_control_type( $field ),
			'option_type'       => self::sanitize_type( $field ),
			'section'           => self::sanitize_section( $field ),
			'settings'          => self::sanitize_settings( $field ),
			'priority'          => self::sanitize_priority( $field ),
			'choices'           => self::sanitize_choices( $field ),
			'output'            => self::sanitize_output( $field ),
			'sanitize_callback' => self::sanitize_callback( $field ),
			'js_vars'           => self::sanitize_js_vars( $field ),
			'id'                => self::sanitize_id( $field ),
			'capability'        => self::sanitize_capability( $field ),
			'variables'         => self::sanitize_variables( $field ),
			'active_callback'   => self::sanitize_active_callback( $field )
		);

		return array_merge( $field, $sanitized );

	}

	/**
	 * Sanitizes the control type.
	 *
	 * @param array the field definition
	 * @return string If not set, then defaults to text.
	 */
	public static function sanitize_control_type( $field ) {

		if ( ! isset( $field['type'] ) ) {
			return 'text';
		}

		switch ( $field['type'] ) {

			case 'checkbox' :
				if ( isset( $field['mode'] ) && 'switch' == $field['mode'] ) {
					$field['type'] = 'switch';
				} elseif ( isset( $field['mode'] ) && 'toggle' == $field['mode'] ) {
					$field['type'] = 'toggle';
				}
				break;
			case 'radio' :
			 	if ( isset( $field['mode'] ) && 'buttonset' == $field['mode'] ) {
					$field['type'] = 'radio-buttonset';
				} elseif ( isset( $field['mode'] ) && 'image' == $field['mode'] ) {
					$field['type'] = 'radio-image';
				}
				break;
			case 'group-title' :
			case 'group_title' :
				$field['type'] = 'custom';
				break;
			case 'color_alpha' :
				$field['type'] = 'color-alpha';
				break;
			case 'color' :
				if ( isset( $field['default'] ) && false !== strpos( $field['default'], 'rgba' ) ) {
					$field['type'] = 'color-alpha';
				}
				break;
		}

		return esc_attr( $field['type'] );

	}

	/**
	 * Sanitizes the setting type.
	 *
	 * @param array the field definition
	 * @return string (theme_mod|option)
	 */
	public static function sanitize_type( $field ) {
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $field['option_type'] ) ) {
			return esc_attr( $field['option_type'] );
		} else {
			return ( isset( $config['option_type'] ) ) ? esc_attr( $config['option_type'] ) : 'theme_mod';
		}
	}

	/**
	 * Sanitizes the setting variables.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_variables( $field ) {
		return ( isset( $field['variables'] ) && is_array( $field['variables'] ) ) ? $field['variables'] : false;
	}

	/**
	 * Sanitizes the setting active callback.
	 *
	 * @param array the field definition
	 * @return string callable function name.
	 */
	public static function sanitize_active_callback( $field ) {
		if ( isset( $field['active_callback'] ) ) {
			return $field['active_callback'];
		} else {
			if ( isset( $field['required'] ) ) {
				return 'kirki_active_callback';
			} else {
				return '__return_true';
			}
		}
	}

	/**
	 * Sanitizes the setting permissions.
	 *
	 * @param array the field definition
	 * @return string (theme_mod|option)
	 */
	public static function sanitize_capability( $field ) {
		if ( ! isset( $field['capability'] ) ) {
			$config = apply_filters( 'kirki/config', array() );
			return isset( $config['capability'] ) ? esc_attr( $config['capability'] ) : 'edit_theme_options';
		} else {
			return esc_attr( $field['capability'] );
		}
	}

	/**
	 * Sanitizes the raw setting name.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_settings_raw( $field ) {

		/**
		 * Compatibility tweak
		 * Previous versions of the Kirki customizer used 'setting' istead of 'settings'.
		 */
		if ( ! isset( $field['settings'] ) && isset( $field['setting'] ) ) {
			$field['settings'] = $field['setting'];
		}

		// Sanitize the field's settings attribute.
		$field['settings'] = sanitize_key( $field['settings'] );

		return $field['settings'];

	}

	/**
	 * Sanitizes the setting name
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_settings( $field ) {

		// If the value of 'option_name' is not empty, then we're also using options instead of theme_mods.
		if ( ( isset( $field['option_name'] ) ) && ! empty( $field['option_name'] ) ) {
			$field['settings'] = esc_attr( $field['option_name'] ).'['.esc_attr( $field['settings'] ).']';
		}

		return $field['settings'];

	}

	/**
	 * Sanitizes the control label.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_label( $field ) {
		return ( isset( $field['label'] ) ) ? esc_html( $field['label'] ) : '';
	}

	/**
	 * Sanitizes the control section
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_section( $field ) {
		return sanitize_key( $field['section'] );
	}

	/**
	 * Sanitizes the control id.
	 * Sanitizing the ID should happen after the 'settings' sanitization.
	 * This way we can also properly handle cases where the option_type is set to 'option'
	 * and we're using an array instead of individual options.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_id( $field ) {
		$id = str_replace( '[', '-', str_replace( ']', '', $field['settings'] ) );
		return sanitize_key( $id );
	}

	/**
	 * Sanitizes the setting default value
	 *
	 * @param array the field definition
	 * @return mixed
	 */
	public static function sanitize_default( $field ) {

		if ( ! isset( $field['default'] ) ) {
			return '';
		} else {
			if ( is_array( $field['default'] ) ) {
				array_walk_recursive( $field['default'], array( 'Kirki_Field', 'sanitize_defaults_array' ) );
				return $field['default'];
			} else {
				if ( isset( $field['type'] ) && 'custom' != $field['type'] ) {
					return esc_textarea( $field['default'] );
				} else {
					// Return raw & unfiltered for custom controls
					return $field['default'];
				}
			}
		}

	}

	/**
	 * Sanitizes the defaults array.
	 * This is used as a callback function in the sanitize_default method.
	 */
	public static function sanitize_defaults_array( $value = '', $key = '' ) {
		$value = esc_textarea( $value );
		$key   = esc_attr( $key );
	}

	/**
	 * Sanitizes the control description
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_description( $field ) {

		if ( ! isset( $field['description'] ) && ! isset( $field['subtitle'] ) ) {
			return '';
		}

		/**
		 * Compatibility tweak
		 *
		 * Previous verions of the Kirki Customizer had the 'description' field mapped to the new 'help'
		 * and instead of 'description' we were using 'subtitle'.
		 * This has been deprecated in favor of WordPress core's 'description' field that was recently introduced.
		 *
		 */
		if ( isset( $field['subtitle'] ) ) {
			return wp_strip_all_tags( $field['subtitle'] );
		} else {
			return wp_strip_all_tags( $field['description'] );
		}

	}

	/**
	 * Sanitizes the control help
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_help( $field ) {

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
		return isset( $field['help'] ) ? wp_strip_all_tags( $field['help'] ) : '';

	}

	/**
	 * Sanitizes the control choices.
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_choices( $field ) {
		if ( ! isset( $field['choices'] ) ) {
			return array();
		} else {
			if ( is_array( $field['choices'] ) ) {
				array_walk_recursive( $field['choices'], array( 'Kirki_Field', 'sanitize_defaults_array' ) );
				return $field['choices'];
			} else {
				return esc_attr( $field['choices'] );
			}
		}
	}

	/**
	 * Sanitizes the control output
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_output( $field ) {
		if ( isset( $field['output'] ) ) {
			if ( is_array( $field['output'] ) ) {
				$output_sanitized = array();
				if ( isset( $field['output']['element'] ) ) {
					$field['output'] = array( $field['output'] );
				}
				foreach ( $field['output'] as $output ) {
					$output_sanitized[] = array(
						'element'  => ( isset( $output['element'] ) ) ? sanitize_text_field( $output['element'] ) : '',
						'property' => ( isset( $output['property'] ) ) ? sanitize_text_field( $output['property'] ) : '',
						'units'    => ( isset( $output['units'] ) ) ? sanitize_text_field( $output['units'] ) : '',
						'prefix'   => ( isset( $output['prefix'] ) ) ? sanitize_text_field( $output['prefix'] ) : '',
						'suffix'   => ( isset( $output['suffix'] ) ) ? sanitize_text_field( $output['suffix'] ) : '',
					);
				}
			} else {
				$output_sanitized = esc_attr( $field['output'] );
			}
		} else {
			$output_sanitized = null;
		}
		return $output_sanitized;
	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param array the field definition
	 * @return string postMessage|refresh (defaults to refresh)
	 */
	public static function sanitize_transport( $field ) {
		return ( isset( $field['transport'] ) && 'postMessage' == $field['transport'] ) ? 'postMessage' : 'refresh';
	}

	/**
	 * Sanitizes the setting sanitize_callback
	 *
	 * @param array the field definition
	 * @return mixed the sanitization callback for this setting
	 */
	public static function sanitize_callback( $field ) {

		if ( isset( $field['sanitize_callback'] ) && ! empty( $field['sanitize_callback'] ) ) {
			return $field['sanitize_callback'];
		} else { // Fallback callback
			return self::fallback_callback( $field['type'] );
		}

	}

	/**
	 * Sanitizes the control js_vars.
	 *
	 * @param array the field definition
	 * @return array|null
	 */
	public static function sanitize_js_vars( $field ) {
		if ( isset( $field['js_vars'] ) && is_array( $field['js_vars'] ) ) {
			$js_vars_sanitized = array();
			if ( isset( $field['js_vars']['element'] ) ) {
				$field['js_vars'] = array( $field['js_vars'] );
			}
			foreach ( $field['js_vars'] as $js_vars ) {
				$js_vars_sanitized[] = array(
					'element'  => ( isset( $js_vars['element'] ) ) ? sanitize_text_field( $js_vars['element'] ) : '',
					'function' => ( isset( $js_vars['function'] ) ) ? esc_js( $js_vars['function'] ) : '',
					'property' => ( isset( $js_vars['property'] ) ) ? esc_js( $js_vars['property'] ) : '',
					'units'    => ( isset( $js_vars['units'] ) ) ? esc_js( $js_vars['units'] ) : '',
				);
			}
		} else {
			$js_vars_sanitized = null;
		}
		return $js_vars_sanitized;
	}

	/**
	 * Sanitizes the control required argument.
	 *
	 * @param array the field definition
	 * @return array|null
	 */
	public static function sanitize_required( $field ) {
		if ( isset( $field['required'] ) && is_array( $field['required'] ) ) {
			$required_sanitized = array();
			if ( isset( $field['required']['setting'] ) ) {
				$field['required'] = array( $field['required'] );
			}
			foreach ( $field['required'] as $required ) {
				$required_sanitized[] = array(
					'setting'  => ( isset( $required['setting'] ) ) ? sanitize_text_field( $required['setting'] ) : '',
					'operator' => ( isset( $required['operator'] ) && in_array( $required['operator'], array( '==', '===', '!=', '!==', '>=', '<=', '>', '<' ) ) ) ? $required['operator'] : '==',
					'value'    => ( isset( $required['value'] ) ) ? sanitize_text_field( $required['value'] ) : true,
				);
			}
		} else {
			$required_sanitized = null;
		}
		return $required_sanitized;
	}

	/**
	 * Sanitizes the control priority
	 *
	 * @param array the field definition
	 * @return int
	 */
	public static function sanitize_priority( $field ) {

		if ( isset( $field['priority'] ) ) {
			$priority = intval( $field['priority'] );
		}

		if ( isset( $priority ) && '0' != $priority ) {
			return absint( $priority );
		} else {
			return 10;
		}

	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param string the control type
	 * @return string[]|string the function name of a sanitization callback
	 */
	public static function fallback_callback( $field_type ) {

		switch ( $field_type ) {
			case 'checkbox' :
			case 'toggle' :
			case 'switch' :
				$sanitize_callback = array( 'Kirki_Sanitize', 'checkbox' );
				break;
			case 'color' :
			case 'color-alpha' :
				$sanitize_callback = array( 'Kirki_Sanitize', 'color' );
				break;
			case 'image' :
			case 'upload' :
				$sanitize_callback = 'esc_url_raw';
				break;
			case 'radio' :
			case 'radio-image' :
			case 'radio-buttonset' :
			case 'select' :
			case 'palette' :
				$sanitize_callback = array( 'Kirki_Sanitize', 'choice' );
				break;
			case 'dropdown-pages' :
				$sanitize_callback = array( 'Kirki_Sanitize', 'dropdown_pages' );
				break;
			case 'slider' :
			case 'number' :
				$sanitize_callback = array( 'Kirki_Sanitize', 'number' );
				break;
			case 'text' :
			case 'textarea' :
			case 'editor' :
				$sanitize_callback = 'esc_textarea';
				break;
			case 'multicheck' :
				$sanitize_callback = array( 'Kirki_Sanitize', 'multicheck' );
				break;
			case 'sortable' :
				$sanitize_callback = array( 'Kirki_Sanitize', 'sortable' );
				break;
			default :
				$sanitize_callback = array( 'Kirki_Sanitize', 'unfiltered' );
				break;
		}

		return $sanitize_callback;

	}

}
