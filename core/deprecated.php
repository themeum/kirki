<?php
/**
 * This file contains all the deprecated functions.
 * We could easily delete all these but they are kept for backwards-compatibility purposes.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// @codingStandardsIgnoreFile

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'kirki_get_option' ) ) {
	/**
	 * Get the value of a field.
	 * This is a deprecated function that we useD when there was no API.
	 * Please use the Kirki::get_option() method instead.
	 * Documentation is available for the new method on https://github.com/aristath/kirki/wiki/Getting-the-values
	 *
	 * @return mixed
	 */
	function kirki_get_option( $option = '' ) {
		_deprecated_function( __FUNCTION__, '1.0.0', esc_attr__( 'kirki_get_option detected. Please use get_theme_mod() or get_option() instead.', 'kirki' ) );
		return Kirki::get_option( '', $option );
	}
}

if ( ! function_exists( 'kirki_sanitize_hex' ) ) {
	function kirki_sanitize_hex( $color ) {
		_deprecated_function( __FUNCTION__, '1.0.0', esc_attr__( 'kirki_sanitize_hex detected. Please use the ariColor class instead. More info on http://aristath.github.io/ariColor/', 'kirki' ) );
		return Kirki_Color::sanitize_hex( $color );
	}
}

if ( ! function_exists( 'kirki_get_rgb' ) ) {
	function kirki_get_rgb( $hex, $implode = false ) {
		_deprecated_function( __FUNCTION__, '1.0.0', esc_attr__( 'kirki_get_rgb detected. Please use the ariColor class instead. More info on http://aristath.github.io/ariColor/', 'kirki' ) );
		return Kirki_Color::get_rgb( $hex, $implode );
	}
}

if ( ! function_exists( 'kirki_get_rgba' ) ) {
	function kirki_get_rgba( $hex = '#fff', $opacity = 100 ) {
		_deprecated_function( __FUNCTION__, '1.0.0', esc_attr__( 'kirki_get_rgba detected. Please use the ariColor class instead. More info on http://aristath.github.io/ariColor/', 'kirki' ) );
		return Kirki_Color::get_rgba( $hex, $opacity );
	}
}

if ( ! function_exists( 'kirki_get_brightness' ) ) {
	function kirki_get_brightness( $hex ) {
		_deprecated_function( __FUNCTION__, '1.0.0', esc_attr__( 'kirki_get_brightness detected. Please use the ariColor class instead. More info on http://aristath.github.io/ariColor/', 'kirki' ) );
		return Kirki_Color::get_brightness( $hex );
	}
}
