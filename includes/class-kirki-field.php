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

		/**
		 * Sanitize each property of the field separately.
		 */
		$sanitized = array(
			'default'           => self::sanitize_default( $field ),
			'label'             => self::sanitize_label( $field ),
			'help'              => self::sanitize_help( $field ),
			'description'       => self::sanitize_description( $field ),
			'required'          => self::sanitize_required( $field ),
			'transport'         => self::sanitize_transport( $field ),
			'type'              => self::sanitize_control_type( $field ),
			'option_type'       => self::sanitize_type( $field ),
			'option_name'       => self::sanitize_option_name( $field ),
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

		/**
		 * Return a merged array so any extra custom properties are parse as well (but not sanitized)
		 */
		return array_merge( $field, $sanitized );

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
	 * Sanitizes the setting variables.
	 *
	 * @param array the field definition
	 * @return mixed
	 */
	public static function sanitize_variables( $field ) {

		/**
		 * Return null if no value has been defined
		 * or if not properly formatted as an array.
		 */
		if ( ! isset( $field['variables'] ) || ! is_array( $field['variables'] ) ) {
			return null;
		}
		return $field['variables'];

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
		 * If we're using options & option_name is set, then we need to modify the setting.
		 */
		if ( 'option' == self::sanitize_type( $field ) && '' != self::sanitize_option_name( $field ) ) {
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

		/**
		 * If a label has been defined then we need to sanitize it and then return it.
		 * Sanitization here will be done using the 'wp_strip_all_tags' function.
		 */
		if ( isset( $field['label'] ) ) {
			return wp_strip_all_tags( $field['label'] );
		}

		/**
		 * If no label has been defined then we're returning an empty value.
		 * This is simply done to prevent any 'undefined index' PHP notices.
		 */
		return '';

	}

	/**
	 * Sanitizes the control section
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_section( $field ) {

		/**
		 * If no section is defined then make sure we add the one section that is ALWAYS present: 'title_tagline'
		 * Though it's wrong to use a section arbitrarily, at least this way we're making sure that the control will be rendered,
		 * even if you forget to add a section argument.
		 */
		if ( ! isset( $field['section'] ) ) {
			return 'title_tagline';
		}

		/**
		 * Sanitize the section name and return it.
		 */
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
		return sanitize_key( str_replace( '[', '-', str_replace( ']', '', $field['settings'] ) ) );
	}

	/**
	 * Sanitizes the setting default value
	 *
	 * @param array the field definition
	 * @return mixed
	 */
	public static function sanitize_default( $field ) {

		/**
		 * make sure a default value is defined.
		 */
		if ( ! isset( $field['default'] ) ) {
			return '';
		}

		/**
		 * If an array then sanitize the array items separately
		 * TODO: the array_walk_recursive that we used was over-sanitizing things causing malfunctions.
		 * We've commented this out and will revisit this in a future release.
		 */
		if ( is_array( $field['default'] ) ) {
			// array_walk_recursive( $field['default'], array( 'Kirki_Field', 'sanitize_defaults_array' ) );
			return $field['default'];
		}

		/**
		 * Return raw & unfiltered for custom controls
		 */
		if ( isset( $field['type'] ) && 'custom' == $field['type'] ) {
			return $field['default'];
		}

		/**
		 * fallback to escaping the default value.
		 */
		return esc_textarea( $field['default'] );

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
		}
		return wp_strip_all_tags( $field['description'] );

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
			if ( isset( $field['description'] ) ) {
				return wp_strip_all_tags( $field['description'] );
			}
			return '';
		}

		/**
		 * Return empty string if not set.
		 */
		if ( ! isset( $field['help'] ) ) {
			return '';
		}

		/**
		 * Fallback to stripping all tags and returning.
		 */
		return wp_strip_all_tags( $field['help'] );

	}

	/**
	 * Sanitizes the control choices.
	 *
	 * @param array the field definition
	 * @return array|string
	 */
	public static function sanitize_choices( $field ) {

		/**
		 * If not set then return an empty array.
		 * This will prevent PHP 'undefined index' notices.
		 */
		if ( ! isset( $field['choices'] ) ) {
			return array();
		}

		/**
		 * If an array then sanitize the array items separately
		 * TODO: the array_walk_recursive that we used was over-sanitizing things causing malfunctions.
		 * We've commented this out and will revisit this in a future release.
		 */
		if ( is_array( $field['choices'] ) ) {
			// array_walk_recursive( $field['choices'], array( 'Kirki_Field', 'sanitize_defaults_array' ) );
			return $field['choices'];
		}

		/**
		 * This is a string so fallback to escaping the value and return.
		 */
		return esc_attr( $field['choices'] );

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
			);
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

		if ( isset( $field['transport'] ) && 'postMessage' == $field['transport'] ) {
			return 'postMessage';
		}

		/**
		 * fallback to 'refresh'
		 */
		return 'refresh';

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
				);
			}
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

		$required_sanitized = null;
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

		if ( ! isset( $field['priority'] ) || '0' == absint( intval( $field['priority'] ) ) ) {
			return 10;
		}
		return absint( intval( $field['priority'] ) );

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
				$sanitize_callback = 'esc_attr';
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

	/**
	 * Sanitizes the defaults array.
	 * This is used as a callback function in the sanitize_default method.
	 */
	public static function sanitize_defaults_array( $value = '', $key = '' ) {

		$value = esc_textarea( $value );
		$key   = esc_attr( $key );

	}

}
