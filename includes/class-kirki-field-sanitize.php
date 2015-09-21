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
if ( class_exists( 'Kirki_Field_Sanitize' ) ) {
	return;
}

class Kirki_Field_Sanitize {

	/**
	 * Sanitizes the field
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_field( $field ) {

		$defaults = array(
			'default'           => '',
			'label'             => '',
			'help'              => '',
			'description'       => '',
			'required'          => null,
			'transport'         => 'refresh',
			'type'              => 'text',
			'option_type'       => 'theme_mod',
			'option_name'       => '',
			'section'           => 'title_tagline',
			'settings'          => '',
			'priority'          => 10,
			'choices'           => array(),
			'output'            => array(),
			'sanitize_callback' => '',
			'js_vars'           => array(),
			'id'                => '',
			'capability'        => 'edit_theme_options',
			'variables'         => null,
			'active_callback'   => '__return_true',
			'multiple'          => 1,
		);
		/**
		 * Field type has to run before the others to accomodate older implementations
		 * If we don't do this then kirki/config filters won't work properly.
		 */
		$field['option_type'] = self::sanitize_type( $field );
		$field['option_name'] = self::sanitize_option_name( $field );
		/**
		 * Merge defined args with defaults
		 */
		$field = wp_parse_args( $field, $defaults );
		/**
		 * Strip all HTML from help messages
		 */
		$field['help'] = wp_strip_all_tags( $field['help'] );
		/**
		 * Get the right control type
		 */
		$field['type']              = self::sanitize_control_type( $field );
		$field['settings']          = self::sanitize_settings( $field );
		$field['choices']           = ( isset( $field['choices'] ) ) ? $field['choices'] : array();
		$field['output']            = self::sanitize_output( $field );
		$field['sanitize_callback'] = self::sanitize_callback( $field );
		$field['js_vars']           = self::sanitize_js_vars( $field );
		$field['id']                = self::sanitize_id( $field );
		$field['capability']        = self::sanitize_capability( $field );
		$field['variables']         = ( isset( $field['variables'] ) && is_array( $field['variables'] ) ) ? $field['variables'] : null;
		$field['active_callback']   = self::sanitize_active_callback( $field );
		$field['multiple']          = ( isset( $field['multiple'] ) ) ? intval( $field['multiple'] ) : 1;

		return $field;

	}

	/**
	 * Sanitizes the control type.
	 *
	 * @param array the field definition
	 * @return string If not set, then defaults to text.
	 */
	public static function sanitize_control_type( $field ) {

		// If no field type has been defined then fallback to text
		if ( ! isset( $field['type'] ) ) {
			return 'text';
		}

		switch ( $field['type'] ) {

			case 'checkbox':
				/**
				 * Tweaks for backwards-compatibility:
				 * Prior to version 0.8 switch & toggle were part of the checkbox control.
				 */
				if ( isset( $field['mode'] ) && 'switch' == $field['mode'] ) {
					$field['type'] = 'switch';
				} elseif ( isset( $field['mode'] ) && 'toggle' == $field['mode'] ) {
					$field['type'] = 'toggle';
				} else {
					$field['type'] = 'kirki-checkbox';
				}
				break;
			case 'radio':
				/**
				 * Tweaks for backwards-compatibility:
				 * Prior to version 0.8 radio-buttonset & radio-image were part of the checkbox control.
				 */
			 	if ( isset( $field['mode'] ) && 'buttonset' == $field['mode'] ) {
					$field['type'] = 'radio-buttonset';
				} elseif ( isset( $field['mode'] ) && 'image' == $field['mode'] ) {
					$field['type'] = 'radio-image';
				} else {
					$field['type'] = 'kirki-radio';
				}
				break;
			case 'group-title':
			case 'group_title':
				/**
				 * Tweaks for backwards-compatibility:
				 * Prior to version 0.8 there was a group-title control.
				 */
				$field['type'] = 'custom';
				break;
			case 'color_alpha':
				// Just making sure that common mistakes will still work.
				$field['type'] = 'color-alpha';
				break;
			case 'color':
				// If a default value of rgba() is defined for a color control then use color-alpha instead.
				if ( isset( $field['default'] ) && false !== strpos( $field['default'], 'rgba' ) ) {
					$field['type'] = 'color-alpha';
				}
				break;
			case 'select':
			case 'select2':
			case 'select2-multiple':
				$field['type'] = 'kirki-select';
				break;
			case 'textarea':
				$field['type'] = 'kirki-textarea';
				break;
		}

		/**
		 * sanitize using esc_attr and return the value.
		 */
		return esc_attr( $field['type'] );

	}

	/**
	 * Sanitizes the setting type.
	 *
	 * @param array the field definition
	 * @return string (theme_mod|option)
	 */
	public static function sanitize_type( $field ) {

		/**
		 * If we've set an 'option_type' in the field properties
		 * then sanitize the value using esc_attr and return it.
		 */
		if ( isset( $field['option_type'] ) ) {
			return esc_attr( $field['option_type'] );
		}

		/**
		 * If no 'option_type' has been defined
		 * then try to get the option from the kirki/config filter.
		 */
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $config['option_type'] ) ) {
			return esc_attr( $config['option_type'] );
		}

		/**
		 * If all else fails, fallback to theme_mod
		 */
		return 'theme_mod';

	}

	/**
	 * Sanitizes the setting name.
	 *
	 * @param array the field definition
	 * @return string (theme_mod|option)
	 */
	public static function sanitize_option_name( $field ) {

		if ( isset( $field['option_name'] ) ) {
			return esc_attr( $field['option_name'] );
		}

		/**
		 * If no 'option_type' has been defined
		 * then try to get the option from the kirki/config filter.
		 */
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $config['option_name'] ) ) {
			return esc_attr( $config['option_type'] );
		}

		/**
		 * If all else fails, return empty.
		 */
		return '';

	}

	/**
	 * Sanitizes the setting active callback.
	 *
	 * @param array the field definition
	 * @return string callable function name.
	 */
	public static function sanitize_active_callback( $field ) {

		/**
		 * If a custom 'active_callback' has been defined then return that.
		 */
		if ( isset( $field['active_callback'] ) ) {
			return $field['active_callback'];
		}

		/**
		 * If the 'required' argument is set then we'll need to auto-calculate things.
		 * Set 'active_callback' to 'kirki_active_callback'. ALl extra calculations will be handled there.
		 */
		if ( isset( $field['required'] ) ) {
			return 'kirki_active_callback';
		}

		/**
		 * If all else fails, then fallback to __return_true
		 * This way the control is always shown.
		 */
		return '__return_true';

	}

	/**
	 * Sanitizes the setting permissions.
	 *
	 * @param array the field definition
	 * @return string (theme_mod|option)
	 */
	public static function sanitize_capability( $field ) {

		/**
		 * If we have not set a custom 'capability' then we'll need to figure it out.
		 */
		if ( ! isset( $field['capability'] ) ) {

			/**
			 * If there's a global configuration then perhaps we're defining a capability there.
			 * Use the 'kirki/config' filter to figure it out.
			 */
			$config = apply_filters( 'kirki/config', array() );
			if ( isset( $config['capability'] ) ) {
				return esc_attr( $config['capability'] );
			}

			/**
			 * No capability has been found, fallback to edit_theme_options
			 */
			return 'edit_theme_options';

		}

		/**
		 * All good, a capability has been defined so return that escaped.
		 */
		return esc_attr( $field['capability'] );

	}

	/**
	 * Sanitizes the setting name
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_settings( $field ) {

		/**
		 * If an array, we must process each setting separately
		 */
		if ( is_array( $field['settings'] ) ) {
			$settings = array();
			foreach ( $field['settings'] as $setting_key => $setting_value ) {
				if ( 'option' == self::sanitize_type( $field ) && '' != self::sanitize_option_name( $field ) ) {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $field['option_name'] ).'['.esc_attr( $setting_value ).']';
				} else {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $setting_value );
				}
			}
			return $settings;
		}

		/**
		 * If we're using options & option_name is set, then we need to modify the setting.
		 */
		if ( 'option' == self::sanitize_type( $field ) && '' != self::sanitize_option_name( $field ) ) {
			$field['settings'] = esc_attr( $field['option_name'] ).'['.esc_attr( $field['settings'] ).']';
		}

		return $field['settings'];

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
		return sanitize_key( str_replace( '[', '-', str_replace( ']', '', $field['settings'] ) ) );
	}

	/**
	 * Sanitizes the control output
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_output( $field ) {

		/**
		 * Early exit and return a NULL value if output is not set
		 */
		if ( ! isset( $field['output'] ) ) {
			return null;
		}

		/**
		 * sanitize using esc_attr if output is string.
		 */
		if ( ! is_array( $field['output'] ) ) {
			return esc_attr( $field['output'] );
		}
		$output_sanitized = array();

		/**
		 * convert to multidimentional array if necessary
		 */
		if ( isset( $field['output']['element'] ) ) {
			$field['output'] = array( $field['output'] );
		}

		/**
		 * sanitize array items individually
		 */
		foreach ( $field['output'] as $output ) {
			if ( ! isset( $output['media_query'] ) ) {
				if ( isset( $output['prefix'] ) && ( false !== strpos( $output['prefix'], '@media' ) ) ) {
					$output['media_query'] = $output['prefix'];
					$output['prefix']      = '';
					$output['suffix']      = '';
				} else {
					$output['media_query'] = 'global';
				}
			}
			$output_sanitized[] = array(
				'element'           => ( isset( $output['element'] ) ) ? sanitize_text_field( $output['element'] ) : '',
				'property'          => ( isset( $output['property'] ) ) ? sanitize_text_field( $output['property'] ) : '',
				'units'             => ( isset( $output['units'] ) ) ? sanitize_text_field( $output['units'] ) : '',
				'sanitize_callback' => ( isset( $output['sanitize_callback'] ) ) ? $output['sanitize_callback'] : null,
				'media_query'       => trim( sanitize_text_field( str_replace( '{', '', $output['media_query'] ) ) ),
				'prefix'            => ( isset( $output['prefix'] ) ) ? sanitize_text_field( $output['prefix'] ) : '',
			);
		}

		return $output_sanitized;

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
		}
		// Fallback callback
		return self::fallback_callback( $field['type'] );

	}

	/**
	 * Sanitizes the control js_vars.
	 *
	 * @param array the field definition
	 * @return array|null
	 */
	public static function sanitize_js_vars( $field ) {

		$js_vars_sanitized = null;
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
					'prefix'   => ( isset( $js_vars['prefix'] ) ) ? esc_js( $js_vars['prefix'] ) : '',
				);
			}
		}
		return $js_vars_sanitized;

	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param string the control type
	 * @return string|string[] the function name of a sanitization callback
	 */
	public static function fallback_callback( $field_type ) {

		switch ( $field_type ) {
			case 'checkbox':
			case 'toggle':
			case 'switch':
				$sanitize_callback = array( 'Kirki_Sanitize', 'checkbox' );
				break;
			case 'color':
			case 'color-alpha':
				$sanitize_callback = array( 'Kirki_Sanitize', 'color' );
				break;
			case 'image':
			case 'upload':
				$sanitize_callback = 'esc_url_raw';
				break;
			case 'radio':
			case 'radio-image':
			case 'radio-buttonset':
			case 'select':
			case 'select2':
			case 'palette':
				$sanitize_callback = array( 'Kirki_Sanitize', 'unfiltered' );
				break;
			case 'dropdown-pages':
				$sanitize_callback = array( 'Kirki_Sanitize', 'dropdown_pages' );
				break;
			case 'slider':
			case 'number':
				$sanitize_callback = array( 'Kirki_Sanitize', 'number' );
				break;
			case 'text':
			case 'textarea':
			case 'editor':
				$sanitize_callback = 'esc_textarea';
				break;
			case 'multicheck':
				$sanitize_callback = array( 'Kirki_Sanitize', 'multicheck' );
				break;
			case 'sortable':
				$sanitize_callback = array( 'Kirki_Sanitize', 'sortable' );
				break;
			default:
				$sanitize_callback = array( 'Kirki_Sanitize', 'unfiltered' );
				break;
		}

		return $sanitize_callback;

	}

}
