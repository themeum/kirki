<?php
/**
 * This file contains all the deprecated functions.
 * We could easily delete all these but they are kept for backwards-compatibility purposes.
 *
 * @package     XTKirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'xtkirki_get_option' ) ) {
	/**
	 * Get the value of a field.
	 * This is a deprecated function that we in use when there was no API.
	 * Please use the XTKirki::get_option() method instead.
	 * Documentation is available for the new method on https://github.com/aristath/xtkirki/wiki/Getting-the-values
	 *
	 * @return mixed
	 */
	function xtkirki_get_option( $option = '' ) {
		return XTKirki::get_option( '', $option );
	}
}

if ( ! function_exists( 'xtkirki_sanitize_hex' ) ) {
	function xtkirki_sanitize_hex( $color ) {
		return XTKirki_Color::sanitize_hex( $color );
	}
}

if ( ! function_exists( 'xtkirki_get_rgb' ) ) {
	function xtkirki_get_rgb( $hex, $implode = false ) {
		return XTKirki_Color::get_rgb( $hex, $implode );
	}
}

if ( ! function_exists( 'xtkirki_get_rgba' ) ) {
	function xtkirki_get_rgba( $hex = '#fff', $opacity = 100 ) {
		return XTKirki_Color::get_rgba( $hex, $opacity );
	}
}

if ( ! function_exists( 'xtkirki_get_brightness' ) ) {
	function xtkirki_get_brightness( $hex ) {
		return XTKirki_Color::get_brightness( $hex );
	}
}

/**
 * Class was deprecated in 2.2.7
 *
 * @see https://github.com/aristath/xtkirki/commit/101805fd689fa8828920b789347f13efc378b4a7
 */
if ( ! class_exists( 'XTKirki_Colourlovers' ) ) {
	/**
	 * Deprecated.
	 */
	class XTKirki_Colourlovers {
		public static function get_palettes( $palettes_nr = 5 ) {
			return array();
		}
	}
}
