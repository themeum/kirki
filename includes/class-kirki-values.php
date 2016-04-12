<?php
/**
 * Hekoers to get the values of a field.
 * WARNING: PLEASE DO NOT USE THESE.
 * we only have these for backwards-compatibility purposes.
 * please use get_option() & get_theme_mod() instead.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_Values' ) ) {

	/**
	 * Wrapper class for static methods.
	 */
	class Kirki_Values {

		/**
		 * Get the value of a field.
		 *
		 * @static
		 * @access public
		 * @param string $config_id The configuration ID. @see Kirki_Config.
		 * @param string $field_id  The field ID.
		 * @return string|array
		 */
		public static function get_value( $config_id = '', $field_id = '' ) {

			// Make sure value is defined.
			$value = '';

			// This allows us to skip the $config_id argument.
			// If we skip adding a $config_id, use the 'global' configuration.
			if ( ( '' === $field_id ) && '' !== $config_id ) {
				$field_id  = $config_id;
				$config_id = 'global';
			}

			// If $config_id is empty, set it to 'global'.
			$config_id = ( '' === $config_id ) ? 'global' : $config_id;

			// Fallback to 'global' if $config_id is not found.
			if ( ! isset( Kirki::$config[ $config_id ] ) ) {
				$config_id = 'global';
			}

			if ( 'theme_mod' === Kirki::$config[ $config_id ]['option_type'] ) {

				// We're using theme_mods so just get the value using get_theme_mod.
				$default_value = null;
				if ( isset( Kirki::$fields[ $field_id ] ) && isset( Kirki::$fields[ $field_id ]['default'] ) ) {
					$default_value = Kirki::$fields[ $field_id ]['default'];
				}
				$value = get_theme_mod( $field_id, $default_value );

				// If the field is a background field, then get the sub-fields
				// and return an array of the values.
				if ( isset( Kirki::$fields[ $field_id ] ) && isset( Kirki::$fields[ $field_id ]['type'] ) && 'background' === Kirki::$fields[ $field_id ]['type'] ) {
					$value = array();
					if ( null === $default_value ) {
						$default_value = array();
					}
					foreach ( $default_value as $property_key => $property_default ) {
						$value[ $property_key ] = get_theme_mod( $field_id . '_' . $property_key, $property_default );
					}
				}
			} elseif ( 'option' === Kirki::$config[ $config_id ]['option_type'] ) {

				// We're using options.
				if ( '' !== Kirki::$config[ $config_id ]['option_name'] ) {

					// Options are serialized as a single option in the db.
					// We'll have to get the option and then get the item from the array.
					$options = get_option( Kirki::$config[ $config_id ]['option_name'] );

					if ( ! isset( Kirki::$fields[ $field_id ] ) && isset( Kirki::$fields[ Kirki::$config[ $config_id ]['option_name'] . '[' . $field_id . ']' ] ) ) {
						$field_id = Kirki::$config[ $config_id ]['option_name'] . '[' . $field_id . ']';
					}
					$setting_modified = str_replace( ']', '', str_replace( Kirki::$config[ $config_id ]['option_name'] . '[', '', $field_id ) );

					// If this is a background field, get the individual sub-fields and return an array.
					if ( 'background' === Kirki::$fields[ $field_id ]['type'] ) {
						$value = array();

						foreach ( Kirki::$fields[ $field_id ]['default'] as $property => $property_default ) {

							if ( isset( $options[ $setting_modified . '_' . $property ] ) ) {
								$value[ $property ] = $options[ $setting_modified . '_' . $property ];
							} else {
								$value[ $property ] = $property_default;
							}
						}
					} else {

						// This is not a background field so continue and get the value.
						$value = ( isset( $options[ $setting_modified ] ) ) ? $options[ $setting_modified ] : Kirki::$fields[ $field_id ]['default'];
						$value = maybe_unserialize( $value );
					}
				} else {

					// Each option separately saved in the db.
					$value = get_option( $field_id, Kirki::$fields[ $field_id ]['default'] );

					// If the field is a background field, then get the sub-fields.
					// and return an array of the values.
					if ( 'background' === Kirki::$fields[ $field_id ]['type'] ) {
						$value = array();
						foreach ( Kirki::$fields[ $field_id ]['default'] as $property_key => $property_default ) {
							$value[ $property_key ] = get_option( $field_id . '_' . $property_key, $property_default );
						}
					}
				}
			}

			return apply_filters( 'kirki/values/get_value', $value, $field_id );

		}

		/**
		 * Gets the value or fallsback to default.
		 *
		 * @static
		 * @access public
		 * @param array $field The field aruments.
		 * @return string|array
		 */
		public static function get_sanitized_field_value( $field ) {
			$value = $field['default'];
			if ( isset( $field['option_type'] ) && 'theme_mod' === $field['option_type'] ) {
				$value = get_theme_mod( $field['settings'], $field['default'] );
			} else if ( isset( $field['option_type'] ) && 'option' === $field['option_type'] ) {
				if ( isset( $field['option_name'] ) && '' !== $field['option_name'] ) {
					$all_values = get_option( $field['option_name'], array() );
					$sub_setting_id = str_replace( array( ']', $field['option_name'] . '[' ), '', $field['settings'] );
					if ( isset( $all_values[ $sub_setting_id ] ) ) {
						$value = $all_values[ $sub_setting_id ];
					}
				} else {
					$value = get_option( $field['settings'], $field['default'] );
				}
			}

			return $value;

		}
	}
}
