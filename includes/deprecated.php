<?php
/**
 * This file contains all the deprecated functions.
 * We could easily delete all these but they are kept for backwards-compatibility purposes.
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

if ( ! function_exists( 'kirki_get_option' ) ) {
	/**
	 * Get the value of a field.
	 * This is a deprecated function that we in use when there was no API.
	 * Please use the Kirki::get_option() method instead.
	 * Documentation is available for the new method on https://github.com/aristath/kirki/wiki/Getting-the-values
	 *
	 * @return mixed
	 */
	function kirki_get_option( $option = '' ) {

		// Make sure the class is instanciated
		Kirki_Toolkit::get_instance();

		$values = array();

		// Get the array of all the fields.
		$fields = Kirki::$fields;
		// Get the config.
		$config = apply_filters( 'kirki/config', array() );
		$config['option_type'] = ( isset( $config['option_type'] ) ) ? esc_attr( $config['option_type'] ) : 'theme_mod';
		$config['option_name'] = ( isset( $config['option_name'] ) ) ? esc_attr( $config['option_name'] ) : '';

		// If we're using options instead of theme_mods,
		// then first we'll have to get the array of all options.
		if ( 'option' == $config['option_type'] ) {
			if ( '' == $config['option_name'] ) {
				// No option name is defined.
				// Each options is saved separately in the db, so we'll manually build the array here.
				foreach ( $fields as $field ) {
					$values[ Kirki_Field::sanitize_settings( $field ) ] = get_option( Kirki_Field::sanitize_settings( $field ), Kirki_Field::sanitize_default( $field ) );
				}
			} else {
				// An option_name has been defined so our options are all saved in an array there.
				$values = get_option( $config['option_name'] );
				foreach ( $fields as $field ) {
					if ( ! isset( $values[ Kirki_Field::sanitize_settings( $field ) ] ) ) {
						$values[ Kirki_Field::sanitize_settings( $field ) ] = maybe_unserialize( Kirki_Field::sanitize_default( $field ) );
					}
				}
			}
		}

		if ( '' == $option ) {
			// No option has been defined so we'll get all options and return an array
			// If we're using options then we already have the $values set above.
			// All we need here is a fallback for theme_mods
			if ( 'option' != $config['option_type'] ) {
				// We're using theme_mods
				$values = get_theme_mods();
			}

			// Early exit and return the array of all values
			return $values;

		}

		// If a value has been defined then we proceed.

		// Early exit if this option does not exist
		$field_id = ( 'option' == $config['option_type'] && '' != $config['option_name'] ) ? $config['option_name'].'['.$option.']' : $option;
		if ( ! isset( $fields[ $field_id ] ) ) {
			return;
		}

		if ( 'option' == $config['option_type'] ) {
			// We're using options instead of theme_mods.
			// We already have the array of values set from above so we'll use that.
			$value = ( isset( $values[ $option ] ) ) ? $values[ $option ] : $fields[ $option ]['default'];

		} else {
			// We're using theme_mods
			$value = get_theme_mod( $option, $fields[ $option ]['default'] );

		}

		// Combine background options to a single array
		if ( 'background' == $fields[ $field_id ]['type'] ) {
			if ( 'option' == $config['option_type'] ) {
				$value = array(
					'background-color'      => isset( $values[ $option.'_color' ] ) ? $values[ $option.'_color' ] : null,
					'background-repeat'     => isset( $values[ $option.'_repeat' ] ) ? $values[ $option.'_repeat' ] : null,
					'background-attachment' => isset( $values[ $option.'_attach' ] ) ? $values[ $option.'_attach' ] : null,
					'background-image'      => isset( $values[ $option.'_image' ] ) ? $values[ $option.'_image' ] : null,
					'background-position'   => isset( $values[ $option.'_position' ] ) ? $values[ $option.'_position' ] : null,
					'background-clip'       => isset( $values[ $option.'_clip' ] ) ? $values[ $option.'_clip' ] : null,
					'background-size'       => isset( $values[ $option.'_size' ] ) ? $values[ $option.'_size' ] : null,
				);
			} else {
				$value = array(
					'background-color'      => isset( $fields[ $field_id ]['default']['color'] ) ? get_theme_mod( $option.'_color', $fields[ $field_id ]['default']['color'] ) : null,
					'background-repeat'     => isset( $fields[ $field_id ]['default']['repeat'] ) ? get_theme_mod( $option.'_repeat', $fields[ $field_id ]['default']['repeat'] ) : null,
					'background-attachment' => isset( $fields[ $field_id ]['default']['attach'] ) ? get_theme_mod( $option.'_attach', $fields[ $field_id ]['default']['attach'] ) : null,
					'background-image'      => isset( $fields[ $field_id ]['default']['image'] ) ? get_theme_mod( $option.'_image', $fields[ $field_id ]['default']['image'] ) : null,
					'background-position'   => isset( $fields[ $field_id ]['default']['position'] ) ? get_theme_mod( $option.'_position', $fields[ $field_id ]['default']['position'] ) : null,
					'background-clip'       => isset( $fields[ $field_id ]['default']['clip'] ) ? get_theme_mod( $option.'_clip', $fields[ $field_id ]['default']['clip'] ) : null,
					'background-size'       => isset( $fields[ $field_id ]['default']['size'] ) ? get_theme_mod( $option.'_size', $fields[ $field_id ]['default']['size'] ) : null,
				);
			}
		}

		// Return the single value.
		// Pass it through maybe_unserialize so we're sure we get a proper value.
		return maybe_unserialize( $value );

	}
}

if ( ! function_exists( 'kirki_sanitize_hex' ) ) {
	function kirki_sanitize_hex( $color ) {
		return Kirki_Color::sanitize_hex( $color );
	}
}

if ( ! function_exists( 'kirki_get_rgb' ) ) {
	function kirki_get_rgb( $hex, $implode = false ) {
		return Kirki_Color::get_rgb( $hex, $implode );
	}
}

if ( ! function_exists( 'kirki_get_rgba' ) ) {
	function kirki_get_rgba( $hex = '#fff', $opacity = 100 ) {
		return Kirki_Color::get_rgba( $hex, $opacity );
	}
}

if ( ! function_exists( 'kirki_get_brightness' ) ) {
	function kirki_get_brightness( $hex ) {
		return Kirki_Color::get_brightness( $hex );
	}
}

if ( ! class_exists( 'Kirki_Fonts' ) ) {

	class Kirki_Fonts {

		public static function get_all_fonts() {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->get_all_fonts();
		}

		public static function get_font_choices() {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->get_font_choices();
		}

		public static function is_google_font( $font ) {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->is_google_font( $font );
		}

		public static function get_google_font_uri( $fonts, $weight = 400, $subset = 'all' ) {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->get_google_font_uri( $fonts, $weight, $subset );
		}

		public static function get_google_font_subsets() {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->get_google_font_subsets();
		}

		public static function choose_google_font_variants( $font, $variants = array() ) {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->choose_google_font_variants( $font, $variants );
		}

		public static function get_standard_fonts() {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->get_standard_fonts();
		}

		public static function get_font_stack( $font ) {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->get_font_stack( $font );
		}

		public static function sanitize_font_choice( $value ) {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->sanitize_font_choice( $value );
		}

		public static function get_google_fonts() {
			$font_registry = Kirki_Toolkit::fonts();
			return $font_registry->get_google_fonts();
		}

	}

}
