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
if ( class_exists( 'Kirki_Styles_Output_CSS' ) ) {
	return;
}

class Kirki_Styles_Output_CSS {

	public static $settings    = null;
	public static $output      = array();
	public static $callback    = null;
	public static $option_name = null;
	public static $field_type  = null;

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
		$field_sanitized = Kirki_Field_Sanitize::sanitize_field( $field );
		/**
		 * Set class vars
		 */
		self::$settings   = $field_sanitized['settings'];
		self::$callback   = $field_sanitized['sanitize_callback'];
		self::$field_type = $field_sanitized['type'];
		self::$output     = $field_sanitized['output'];
		if ( ! is_array( self::$output ) ) {
			self::$output = array(
				array(
					'element'           => self::$output,
					'sanitize_callback' => null,
				),
			);
		}
		/**
		 * Get the value of this field
		 */
		self::$value = Kirki_Values::get_sanitized_field_value( $field_sanitized );
		/**
		 * Returns the styles
		 */
		return self::styles();

	}

	/**
	 * Gets the array of generated styles and creates the minimized, inline CSS
	 *
	 * @param array
	 * @return string	the generated CSS.
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
							$value = 'url("' . $value . '")';
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

		$google_fonts_array = Kirki()->font_registry->get_google_fonts();
		$backup_fonts       = Kirki()->font_registry->get_backup_fonts();

		$styles = array();

		foreach ( self::$output as $output ) {

			if ( ! isset( $output['element'] ) ) {
				continue;
			}
			/**
			 * Do we have units?
			 */
			$units = ( isset( $output['units'] ) ) ? $output['units'] : '';
			/**
			 * Do we have a prefix?
			 */
			$prefix = ( isset( $output['prefix'] ) ) ? $output['prefix'] : '';
			/**
			 * Do we have a suffix?
			 */
			$suffix = ( isset( $output['suffix'] ) ) ? $output['suffix'] : '';
			/**
			 * Accept "callback" as short for "sanitize_callback".
			 */
			if ( ! isset( $output['sanitize_callback'] ) && isset( $output['callback'] ) ) {
				$output['sanitize_callback'] = $output['callback'];
			}
			/**
			 * Do we have a "media_query" defined?
			 */
			if ( ! isset( $output['media_query'] ) ) {
				$output['media_query'] = 'global';
			} else {
				$output['media_query'] = esc_attr( $output['media_query'] );
			}
			/**
			 * Do we need to run this through a callback action?
			 */
			$value = ( '' != self::$callback ) ? call_user_func( self::$callback, self::$value ) : self::$value;
			if ( isset( $output['sanitize_callback'] ) && null !== $output['sanitize_callback'] ) {
				$value = call_user_func( $output['sanitize_callback'], $value );
			}
			/**
			 * Make sure the value is a string before proceeding
			 * If all is ok, then populate the array.
			 */
			$element = $output['element'];
			/**
			 * Allow using an array of elements
			 */
			if ( is_array( $output['element'] ) ) {
				/**
				 * Make sure our values are unique
				 */
				$elements = array_unique( $element );
				/**
				 * Sort elements alphabetically.
				 * This way all duplicate items will be merged in the final CSS array.
				 */
				sort( $elements );
				/**
				 * Implode items
				 */
				$element = implode( ',', $elements );
			}
			if ( ! is_array( $value ) ) {
				if ( ! isset( $output['property'] ) ) {
					continue;
				}
				if ( 'font-family' == $output['property'] ) {
					// Add backup font
					if ( Kirki()->font_registry->is_google_font( $value ) ) {
						if ( isset( $google_fonts_array[ $value ] ) && isset( $google_fonts_array[ $value ]['category'] ) ) {
							if ( isset( $backup_fonts[ $google_fonts_array[ $value ]['category'] ] ) ) {
								$value .= ', ' . $backup_fonts[ $google_fonts_array[ $value ]['category'] ];
							}
						}
					}
				}
				$styles[ $output['media_query'] ][ $element ][ $output['property'] ] = $prefix . $value . $units . $suffix;
			} else {
				/**
				 * Take care of typography controls output
				 */
				if ( 'typography' == self::$field_type ) {
					if ( isset( $value['bold'] ) && $value['bold'] ) {
						$styles[ $output['media_query'] ][ $element ]['font-weight'] = 'bold';
					}
					if ( isset( $value['italic'] ) && $value['italic'] ) {
						$styles[ $output['media_query'] ][ $element ]['font-style'] = 'italic';
					}
					if ( isset( $value['underline'] ) && $value['underline'] ) {
						$styles[ $output['media_query'] ][ $element ]['text-decoration'] = 'underline';
					}
					if ( isset( $value['strikethrough'] ) && $value['strikethrough'] ) {
						$styles[ $output['media_query'] ][ $element ]['text-decoration'] = 'strikethrough';
					}
					if ( isset( $value['font-family'] ) ) {
						$styles[ $output['media_query'] ][ $element ]['font-family'] = $value['font-family'];
						// Add backup font
						if ( Kirki()->font_registry->is_google_font( $value['font-family'] ) ) {
							if ( isset( $google_fonts_array[ $value['font-family'] ] ) && isset( $google_fonts_array[ $value['font-family'] ]['category'] ) ) {
								if ( isset( $backup_fonts[ $google_fonts_array[ $value['font-family'] ]['category'] ] ) ) {
									$styles[ $output['media_query'] ][ $element ]['font-family'] = $value['font-family'] . ', ' . $backup_fonts[ $google_fonts_array[ $value['font-family'] ]['category'] ];
								}
							}
						}
					}
					if ( isset( $value['font-size'] ) ) {
						$styles[ $output['media_query'] ][ $element ]['font-size'] = $value['font-size'];
					}
					if ( isset( $value['font-weight'] ) ) {
						$styles[ $output['media_query'] ][ $element ]['font-weight'] = $value['font-weight'];
					}
					if ( isset( $value['line-height'] ) ) {
						$styles[ $output['media_query'] ][ $element ]['line-height'] = $value['line-height'];
					}
					if ( isset( $value['letter-spacing'] ) ) {
						$styles[ $output['media_query'] ][ $element ]['letter-spacing'] = $value['letter-spacing'];
					}
				}
				/**
				 * Take care of "spacing" controls output
				 */
				if ( 'spacing' == self::$field_type && isset( $output['property'] ) ) {
					foreach ( $value as $key => $sub_value ) {
						if ( false !== strpos( $output['property'], '%%' ) ) {
							$property = str_replace( '%%', $key, $output['property'] );
						} else {
							$property = $output['property'] . '-' . $key;
						}
						$styles[ $output['media_query'] ][ $element ][ $property ] = $sub_value;
					}
				}
			}
		}

		return $styles;

	}

	/**
	 * Add prefixes if necessary.
	 *
	 * @param  $css array
	 * @return  array
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
