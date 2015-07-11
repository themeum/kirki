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
	public static function css( $setting = '', $type = 'theme_mod', $output = array(), $callback = '', $return_array = false ) {

		// No need to proceed any further if we don't have the required arguments.
		if ( '' == $setting || empty( $output ) ) {
			return;
		}

		self::$settings = $setting;
		self::$type     = $type;
		self::$output   = Kirki_Field::sanitize_output( array( 'output' => $output ) );
		self::$value    = self::get_value();
		self::$callback = $callback;

		return ( true === $return_array ) ? self::styles() : self::styles_parse( self::add_prefixes( self::styles() ) );

	}

	/**
	 * Gets the value
	 *
	 * @return mixed
	 */
	public static function get_value() {

		/**
		 * Get the default value
		 */
		$default = '';
		if ( isset( Kirki::$fields[ self::$settings ] ) && isset( Kirki::$fields[ self::$settings ]['default'] ) ) {
			if ( ! is_array( Kirki::$fields[ self::$settings ]['default'] ) ) {
				$default = Kirki::$fields[ self::$settings ]['default'];
			}
		}

		if ( 'theme_mod' == self::$type ) {
			/**
			 * This is a theme_mod.
			 * All we have to do is use the get_theme_mod function to get the value
			 */
			$value = get_theme_mod( self::$settings, $default );
		} else {
			/**
			 * This is an option.
			 */
			if ( false !== strpos( self::$settings, '[' ) ) {
				$setting_parts = explode( '[', self::$settings );
				$option_name   = str_replace( array( '[', ']' ), '', $setting_parts[0] );
				/**
				 * We're using serialized options.
				 * First we'll need to get the option defined by the $option_name
				 * and then get the value of the specific setting from the array of options.
				 */
				$option_value     = get_option( $option_name );
				$setting_stripped = str_replace( $option_name.'[', '', str_replace( ']', '', self::$settings ) );
				if ( isset( $option_value[ $setting_stripped ] ) ) {
					/**
					 * An option is set, so use that value.
					 */
					$value = $option_value[ $setting_stripped ];
				} else {
					/**
					 * Option is not set, fallback to the default value.
					 */
					$value = $default;
				}
			} else {
				/**
				 * Options are not serialized, all we need to do is get the option value here.
				 */
				$value = get_option( self::$settings, $default );
			}
		}

		return $value;

	}

	/**
	 * Gets the array of generated styles and creates the minimized, inline CSS
	 *
	 * @param array
	 * @return string|null	the generated CSS.
	 */
	public static function styles_parse( $css = array() ) {

		/**
		 * Process the array of CSS properties and produce the final CSS
		 */
		$final_css = '';
		if ( ! is_array( $css ) || empty( $css ) ) {
			return;
		}
		foreach ( $css as $media_query => $styles ) {

			$final_css .= ( 'global' != $media_query ) ? $media_query . '{' : '';

			foreach ( $styles as $style => $style_array ) {
				$final_css .= $style . '{';
					foreach ( $style_array as $property => $value ) {
						// Take care of formatting the URL for background-image statements.
						if ( 'background-image' == $property || 'background' == $property && false !== filter_var( $value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED ) ) {
							$value = 'url("'.$value.'")';
						}
						// Make sure the background-position property is properly formatted
						if ( 'background-position' == $property ) {
							$value = str_replace( array( '_', '-' ), ' ', $value );
						}
						$final_css .= $property . ':' . $value . ';';
					}
				$final_css .= '}';
			}

			$final_css .= ( 'global' != $media_query ) ? '}' : '';

		}


		return $final_css;

	}

	/**
	 * Get the styles as an array.
	 */
	public static function styles() {

		$styles = array();

		foreach ( self::$output as $output ) {
			// Do we have units?
			$units  = ( isset( $output['units'] ) ) ? $output['units'] : '';
			// Do we need to run this through a callback action?
			$value = ( '' != self::$callback ) ? call_user_func( self::$callback, self::$value ) : self::$value;

			$styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $value.$units;
		}

		return $styles;

	}

	/**
	 * Add prefixes if necessary
	 */
	public static function add_prefixes( $css ) {

		if ( ! is_array( $css ) ) {
			return;
		}

		foreach ( $css as $media_query => $elements ) {

			foreach ( $elements as $element => $style_array ) {

				foreach ( $style_array as $property => $value ) {

					// border-radius
					if ( 'border-radius' == $property ) {
						$css[$media_query][$element]['-webkit-border-radius'] = $value;
						$css[$media_query][$element]['-moz-border-radius'] = $value;
					}
					// box-shadow
					if ( 'box-shadow' == $property ) {
						$css[$media_query][$element]['-webkit-box-shadow'] = $value;
						$css[$media_query][$element]['-moz-box-shadow']    = $value;
					}
					// box-sizing
					elseif ( 'box-sizing' == $property ) {
						$css[$media_query][$element]['-webkit-box-sizing'] = $value;
						$css[$media_query][$element]['-moz-box-sizing']    = $value;
					}
					// text-shadow
					elseif ( 'text-shadow' == $property ) {
						$css[$media_query][$element]['-webkit-text-shadow'] = $value;
						$css[$media_query][$element]['-moz-text-shadow']    = $value;
					}
					// transform
					elseif ( 'transform' == $property ) {
						$css[$media_query][$element]['-webkit-transform'] = $value;
						$css[$media_query][$element]['-moz-transform']    = $value;
						$css[$media_query][$element]['-ms-transform']     = $value;
						$css[$media_query][$element]['-o-transform']      = $value;
					}
					// background-size
					elseif ( 'background-size' == $property ) {
						$css[$media_query][$element]['-webkit-background-size'] = $value;
						$css[$media_query][$element]['-moz-background-size']    = $value;
						$css[$media_query][$element]['-ms-background-size']     = $value;
						$css[$media_query][$element]['-o-background-size']      = $value;
					}
					// transition
					elseif ( 'transition' == $property ) {
						$css[$media_query][$element]['-webkit-transition'] = $value;
						$css[$media_query][$element]['-moz-transition']    = $value;
						$css[$media_query][$element]['-ms-transition']     = $value;
						$css[$media_query][$element]['-o-transition']      = $value;
					}
					// transition-property
					elseif ( 'transition-property' == $property ) {
						$css[$media_query][$element]['-webkit-transition-property'] = $value;
						$css[$media_query][$element]['-moz-transition-property']    = $value;
						$css[$media_query][$element]['-ms-transition-property']     = $value;
						$css[$media_query][$element]['-o-transition-property']      = $value;
					}

				}

			}

		}

		return $css;

	}

}
