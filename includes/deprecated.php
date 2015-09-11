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
		return Kirki::get_option( '', $option );
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
