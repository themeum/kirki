<?php
/**
 * Generates the styles for the frontend.
 * Handles the 'output' argument of fields
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
if ( class_exists( 'Kirki_Output' ) ) {
	return;
}

class Kirki_Output {

	public static $settings = null;
	public static $type     = 'theme_mod';
	public static $output   = array();
	public static $callback = null;

	public static $css;

	public static $value = null;

	/**
	 * The class constructor.
	 *
	 * @var 	string		the setting ID.
	 * @var 	string		theme_mod / option
	 * @var 	array 		an array of arrays of the output arguments.
	 * @var 	mixed		a callable function.
	 */
	public static function css( $setting = '', $type = 'theme_mod', $output = array(), $callback = '' ) {

		// No need to proceed any further if we don't have the required arguments.
		if ( '' == $setting || empty( $output ) ) {
			return;
		}

		// Are we dealing with a single style or multiple styles?
		$multiple_styles = isset( $output[0]['element'] ) ? true : false;

		self::$settings = $setting;
		self::$type     = $type;

		if ( $multiple_styles ) { // Single style
			self::$output = $output;
		} else { // Multiple styles
			self::$output[0] = $output;
		}
		// Set the value
		self::$value = self::get_value();

		return self::styles_parse();

	}

	/**
	 * Gets the value
	 */
	public static function get_value() {

		// Get the default value
		$default = '';
		if ( isset( Kirki::$fields[ self::$settings ] ) && isset( Kirki::$fields[ self::$settings ]['default'] ) ) {
			if ( ! is_array( Kirki::$fields[ self::$settings ]['default'] ) ) {
				$default = Kirki::$fields[ self::$settings ]['default'];
			}
		}

		if ( 'theme_mod' == self::$type ) { // This is a theme_mod
			$value = get_theme_mod( self::$settings, $default );
		} else { // This is an option
			$value = get_option( self::$settings, $default );
		}

		// Do we need to run this through a callback action?
		if ( '' != self::$callback ) {
			$value = call_user_func( self::$callback, $value );
		}

		return $value;

	}

	/**
	 * Gets the array of generated styles and creates the minimized, inline CSS
	 *
	 * @return string|null	the generated CSS.
	 */
	public static function styles_parse() {

		$styles = self::styles();

		$css = '';

		// Early exit if styles are empty or not an array
		if ( empty( $styles ) || ! is_array( $styles ) ) {
			return;
		}

		foreach ( $styles as $style => $style_array ) {
			$css .= $style.'{';
			foreach ( $style_array as $property => $value ) {
				// Take care of formatting the URL for background-image statements.
				if ( 'background-image' == $property || 'background' == $property && false !== filter_var( $value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED ) ) {
					$value = 'url("'.$value.'")';
				}
				// Make sure the background-position property is properly formatted
				if ( 'background-position' == $property ) {
					$value = str_replace( array( '_', '-' ), ' ', $value );
				}
				$css .= $property.':'.$value.';';
			}
			$css .= '}';
		}

		return $css;

	}

	/**
	 * Get the styles as an array.
	 */
	public static function styles() {

		$styles = array();

		foreach ( self::$output as $output ) {
			// do we have a prefix?
			$prefix = ( isset( $output['prefix'] ) ) ? $output['prefix'] : '';
			// Do we have units?
			$units  = ( isset( $output['units'] ) ) ? $output['units'] : '';
			if ( isset( $output['element'] ) && isset( $output['property'] ) ) {
				$styles[ $prefix.$output['element'] ][ $output['property'] ] = self::$value.$units;
			}
		}

		return $styles;

	}

}
