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
			'type'              => 'kirki-text',
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
		 * If the 'required' argument is set then we'll need to auto-calculate things.
		 * Set 'active_callback' to 'Kirki_Active_Callback::evaluate'. ALl extra calculations will be handled there.
		 */
		if ( isset( $field['required'] ) ) {
			$field['active_callback'] = array( 'Kirki_Active_Callback', 'evaluate' );
		} elseif ( ! isset( $field['active_callback'] ) ) {
			$field['active_callback'] = '__return_true';
		}
		/**
		 * Get the right control type
		 */
		$field['type'] = self::sanitize_control_type( $field );
		/**
		 * Sanitize the settings argument
		 */
		$field['settings'] = self::sanitize_settings( $field );
		/**
		 * Sanitize the choices argument
		 */
		$field['choices'] = ( isset( $field['choices'] ) ) ? $field['choices'] : array();
		/**
		 * Sanitize the output argument
		 */
		$field['output'] = isset( $field['output'] ) ? $field['output'] : array();
		/**
		 * Sanitize the sanitize_callback argument
		 */
		$field['sanitize_callback'] = self::sanitize_callback( $field );
		/**
		 * Sanitize the id argument
		 */
		$field['id'] = self::sanitize_id( $field );
		/**
		 * Sanitize the capability argument
		 */
		$field['capability'] = self::sanitize_capability( $field );
		/**
		 * Sanitize the variables argument
		 */
		$field['variables'] = ( isset( $field['variables'] ) && is_array( $field['variables'] ) ) ? $field['variables'] : null;
		/**
		 * Make sure the "multiple" argument is properly formatted for <select> controls
		 */
		if ( 'kirki-select' == $field['type'] ) {
			$field['multiple'] = ( isset( $field['multiple'] ) ) ? intval( $field['multiple'] ) : 1;
		}

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
			return 'kirki-text';
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
			case 'text':
				$field['type'] = 'kirki-text';
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
			$field['settings'] = esc_attr( $field['option_name'] ) . '[' . esc_attr( $field['settings'] ) . ']';
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
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'checkbox' );
				break;
			case 'color':
			case 'color-alpha':
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'color' );
				break;
			case 'image':
			case 'upload':
				$sanitize_callback = 'esc_url_raw';
				break;
			case 'radio':
			case 'radio-image':
			case 'radio-buttonset':
			case 'palette':
				$sanitize_callback = 'esc_attr';
				break;
			case 'select':
			case 'select2':
			case 'select2-multiple':
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'unfiltered' );
				break;
			case 'dropdown-pages':
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'dropdown_pages' );
				break;
			case 'slider':
			case 'number':
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'number' );
				break;
			case 'text':
			case 'kirki-text':
			case 'textarea':
			case 'editor':
				$sanitize_callback = 'esc_textarea';
				break;
			case 'multicheck':
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'multicheck' );
				break;
			case 'sortable':
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'sortable' );
				break;
			default:
				$sanitize_callback = array( 'Kirki_Sanitize_Values', 'unfiltered' );
				break;
		}

		return $sanitize_callback;

	}

}
