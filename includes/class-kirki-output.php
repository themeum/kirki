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

	public static $settings    = null;
	public static $output      = array();
	public static $callback    = null;
	public static $option_name = null;

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
	public static function css( $field ) {
		/**
		 * Make sure the field is sanitized before proceeding any further.
		 */
		$field = Kirki_Field::sanitize_field( $field );
		/**
		 * Get the config ID used in the Kirki class.
		 */
		$config_id       = Kirki::get_config_id( $field );
		/**
		 * Set class vars
		 */
		self::$settings = $field['settings'];
		self::$output   = $field['output'];
		self::$callback = $field['sanitize_callback'];
		/**
		 * Get the value of this field
		 */
		if ( 'option' == Kirki::$config[ $config_id ]['option_type'] && '' != Kirki::$config[ $config_id ]['option_name'] ) {
			self::$value = Kirki::get_option( $config_id, str_replace( array( ']', Kirki::$config[ $config_id ]['option_name'].'[' ), '', $field['settings'] ) );
		} else {
			self::$value = Kirki::get_option( $config_id, $field['settings'] );
		}
		/**
		 * Returns the styles
		 */
		if ( ! is_array( self::$value ) ) {
			return self::styles();
		}

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
			return '';
		}
		foreach ( $css as $media_query => $styles ) {

			$final_css .= ( 'global' != $media_query ) ? $media_query . '{' : '';

			foreach ( $styles as $style => $style_array ) {
				$final_css .= $style . '{';
					foreach ( $style_array as $property => $value ) {
						$value = ( is_string( $value ) ) ? $value : '';
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
			/**
			 * Do we have units?
			 */
			$units  = ( isset( $output['units'] ) ) ? $output['units'] : '';
			/**
			 * Do we need to run this through a callback action?
			 */
			$value = ( '' != self::$callback ) ? call_user_func( self::$callback, self::$value ) : self::$value;
			/**
			 * Make sure the value is a string before proceeding
			 * If all is ok, then populate the array.
			 */
			if ( ! is_array( $value ) ) {
				$styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $value.$units;
			}
		}

		return $styles;

	}

	/**
	 * Add prefixes if necessary
	 */
	public static function add_prefixes( $css ) {

		if ( is_array( $css ) ) {
			foreach ( $css as $media_query => $elements ) {
				foreach ( $elements as $element => $style_array ) {
					foreach ( $style_array as $property => $value ) {
						/**
						 * border-radius
						 */
						if ( 'border-radius' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-border-radius'] = $value;
							$css[ $media_query ][ $element ]['-moz-border-radius'] = $value;
						}
						/**
						 * box-shadow
						 */
						if ( 'box-shadow' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-box-shadow'] = $value;
							$css[ $media_query ][ $element ]['-moz-box-shadow']    = $value;
						}
						/**
						 * box-sizing
						 */
						elseif ( 'box-sizing' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-box-sizing'] = $value;
							$css[ $media_query ][ $element ]['-moz-box-sizing']    = $value;
						}
						/**
						 * text-shadow
						 */
						elseif ( 'text-shadow' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-text-shadow'] = $value;
							$css[ $media_query ][ $element ]['-moz-text-shadow']    = $value;
						}
						/**
						 * transform
						 */
						elseif ( 'transform' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-transform'] = $value;
							$css[ $media_query ][ $element ]['-moz-transform']    = $value;
							$css[ $media_query ][ $element ]['-ms-transform']     = $value;
							$css[ $media_query ][ $element ]['-o-transform']      = $value;
						}
						/**
						 * background-size
						 */
						elseif ( 'background-size' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-background-size'] = $value;
							$css[ $media_query ][ $element ]['-moz-background-size']    = $value;
							$css[ $media_query ][ $element ]['-ms-background-size']     = $value;
							$css[ $media_query ][ $element ]['-o-background-size']      = $value;
						}
						/**
						 * transition
						 */
						elseif ( 'transition' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-transition'] = $value;
							$css[ $media_query ][ $element ]['-moz-transition']    = $value;
							$css[ $media_query ][ $element ]['-ms-transition']     = $value;
							$css[ $media_query ][ $element ]['-o-transition']      = $value;
						}
						/**
						 * transition-property
						 */
						elseif ( 'transition-property' == $property ) {
							$css[ $media_query ][ $element ]['-webkit-transition-property'] = $value;
							$css[ $media_query ][ $element ]['-moz-transition-property']    = $value;
							$css[ $media_query ][ $element ]['-ms-transition-property']     = $value;
							$css[ $media_query ][ $element ]['-o-transition-property']      = $value;
						}
					}
				}
			}
		}

		return $css;

	}

}
