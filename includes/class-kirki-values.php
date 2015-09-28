<?php

class Kirki_Values {

	public static function get_value( $config_id = '', $field_id = '' ) {
		/**
		 * Make sure value is defined
		 */
		$value = '';

		/**
		 * This allows us to skip the $config_id argument.
		 * If we skip adding a $config_id, use the 'global' configuration.
		 */
		if ( ( '' == $field_id ) && '' != $config_id ) {
			$field_id  = $config_id;
			$config_id = 'global';
		}

		/**
		 * If $config_id is empty, set it to 'global'.
		 */
		$config_id = ( '' == $config_id ) ? 'global' : $config_id;

		if ( 'theme_mod' == Kirki::$config[ $config_id ]['option_type'] ) {
			/**
			 * We're using theme_mods.
			 * so just get the value using get_theme_mod
			 */
			$value = get_theme_mod( $field_id, Kirki::$fields[ $field_id ]['default'] );

			/**
			 * If the field is a background field, then get the sub-fields
			 * and return an array of the values.
			 */
			if ( 'background' == Kirki::$fields[ $field_id ]['type'] ) {
				$value = array();
				foreach ( Kirki::$fields[ $field_id ]['default'] as $property_key => $property_default ) {
					$value[ $property_key ] = get_theme_mod( $field_id.'_'.$property_key, $property_default );
				}
			}

		} elseif ( 'option' == Kirki::$config[ $config_id ]['option_type'] ) {
			/**
			 * We're using options.
			 */
			if ( '' != Kirki::$config[ $config_id ]['option_name'] ) {
				/**
				 * Options are serialized as a single option in the db.
				 * We'll have to get the option and then get the item from the array.
				 */
				$options = get_option( Kirki::$config[ $config_id ]['option_name'] );

				if ( ! isset( Kirki::$fields[ $field_id ] ) && isset( Kirki::$fields[ Kirki::$config[ $config_id ]['option_name'].'['.$field_id.']' ] ) ) {
					$field_id = Kirki::$config[ $config_id ]['option_name'].'['.$field_id.']';
				}
				$setting_modified = str_replace( ']', '', str_replace( Kirki::$config[ $config_id ]['option_name'].'[', '', $field_id ) );

				/**
				 * If this is a background field, get the individual sub-fields and return an array.
				 */
				if ( 'background' == Kirki::$fields[ $field_id ]['type'] ) {
					$value = array();

					foreach ( Kirki::$fields[ $field_id ]['default'] as $property => $property_default ) {

						if ( isset( $options[ $setting_modified.'_'.$property ] ) ) {
							$value[ $property ] = $options[ $setting_modified.'_'.$property ];
						} else {
							$value[ $property ] = $property_default;
						}
					}
				} else {
					/**
					 * This is not a background field so continue and get the value.
					 */
					$value = ( isset( $options[ $setting_modified ] ) ) ? $options[ $setting_modified ] : Kirki::$fields[ $field_id ]['default'];
					$value = maybe_unserialize( $value );
				}

			} else {
				/**
				 * Each option separately saved in the db
				 */
				$value = get_option( $field_id, Kirki::$fields[ $field_id ]['default'] );

				/**
				 * If the field is a background field, then get the sub-fields
				 * and return an array of the values.
				 */
				if ( 'background' == Kirki::$fields[ $field_id ]['type'] ) {
					$value = array();
					foreach ( Kirki::$fields[ $field_id ]['default'] as $property_key => $property_default ) {
						$value[ $property_key ] = get_option( $field_id.'_'.$property_key, $property_default );
					}
				}

			}

		}

		/**
		 * reduxframework compatibility tweaks.
		 * If KIRKI_REDUX_COMPATIBILITY is defined as true then modify the output of the values
		 * and make them compatible with Redux.
		 */
		if ( defined( 'KIRKI_REDUX_COMPATIBILITY' ) && KIRKI_REDUX_COMPATIBILITY ) {

			switch ( Kirki::$fields[ $field_id ]['type'] ) {

				case 'image':
					$value = Kirki_Helper::get_image_from_url( $value );
					break;
			}

		}

		return $value;

	}

}
