<?php
/**
 * Generates the styles for the frontend.
 * Handles the 'output' argument of fields
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Styles_Output_CSS' ) ) {
	final class Kirki_Styles_Output_CSS {

		public static $instance = null;

		public static $settings    = null;
		public static $output      = array();
		public static $callback    = null;
		public static $option_name = null;
		public static $field_type  = null;

		public static $google_fonts = null;
		public static $backup_fonts = null;

		public static $css;

		public static $value = null;

		/**
		 * The class constructor.
		 */
		private function __construct() {
			if ( is_null( self::$google_fonts ) ) {
				self::$google_fonts = Kirki_Fonts::get_google_fonts();
			}
			if ( is_null( self::$backup_fonts ) ) {
				self::$backup_fonts = Kirki_Fonts::get_backup_fonts();
			}
		}

		/**
		 * Get a single instance of this class
		 *
		 * @return object
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new Kirki_Styles_Output_CSS();
			}
			return self::$instance;
		}

		/**
		 * get the CSS for a field
		 *
		 * @var 	string		the setting ID.
		 * @var 	string		theme_mod / option
		 * @var 	array 		an array of arrays of the output arguments.
		 * @var 	mixed		a callable function.
		 */
		public static function css( $field ) {
			/**
			 * Set class vars
			 */
			self::$settings   = $field['settings'];
			self::$callback   = $field['sanitize_callback'];
			self::$field_type = $field['type'];
			self::$output     = $field['output'];
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
			self::$value = Kirki_Values::get_sanitized_field_value( $field );
			/**
			 * Array of fields that have their own output class
			 */
			$field_output_classes = array(
				'color-alpha'     => 'Kirki_Output_Control_Color',
				'dimension'       => 'Kirki_Output_Control_Dimension',
				'kirki-generic'   => 'Kirki_Output_Control_Generic',
				'number'          => 'Kirki_Output_Control_Number',
				'radio-buttonset' => 'Kirki_Output_Control_Radio_Buttonset',
				'radio-image'     => 'Kirki_Output_Control_Radio_Image',
				'kirki-radio'     => 'Kirki_Output_Control_Radio',
				'kirki-select'    => 'Kirki_Output_Control_Select',
				'slider'          => 'Kirki_Output_Control_Slider',
				'spacing'         => 'Kirki_Output_Control_Spacing',
				'typography'      => 'Kirki_Output_Control_Typography',
			);
			if ( array_key_exists( self::$field_type, $field_output_classes ) ) {
				$classname = $field_output_classes[ self::$field_type ];
				$obj = new $classname( self::$output, self::$value );
				return $obj->get_styles();
			}

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

			$google_fonts_array = self::$google_fonts;
			$backup_fonts       = self::$backup_fonts;

			$styles = array();

			foreach ( self::$output as $output ) {
				$skip = false;
				// Do we need to run this through a callback action?
				$value = ( '' != self::$callback ) ? call_user_func( self::$callback, self::$value ) : self::$value;
				// No need to proceed this if the current value is the same as in the "exclude" value.
				if ( false !== $output['exclude'] && is_array( $output['exclude'] ) ) {
					foreach ( $output['exclude'] as $exclude ) {
						if ( $skip ) {
							continue;
						}
						if ( $exclude == $value ) {
							$skip = true;
						}
					}
				}
				if ( $skip ) {
					continue;
				}
				if ( isset( $output['sanitize_callback'] ) && null !== $output['sanitize_callback'] ) {
					$value = call_user_func( $output['sanitize_callback'], $value );
				}
				// Make sure the value is a string before proceeding
				// If all is ok, then populate the array.
				$element = $output['element'];
				// Allow using an array of elements
				if ( is_array( $output['element'] ) ) {
					// Make sure our values are unique
					$elements = array_unique( $element );
					// Sort elements alphabetically.
					// This way all duplicate items will be merged in the final CSS array.
					sort( $elements );
					// Implode items
					$element = implode( ',', $elements );
				}
				if ( ! is_array( $value ) ) {
					if ( ! isset( $output['property'] ) ) {
						continue;
					}
					if ( 'font-family' == $output['property'] ) {
						// Add backup font
						if ( Kirki_Fonts::is_google_font( $value ) ) {
							if ( isset( $google_fonts_array[ $value ] ) && isset( $google_fonts_array[ $value ]['category'] ) ) {
								if ( isset( $backup_fonts[ $google_fonts_array[ $value ]['category'] ] ) ) {
									// add double quotes if needed
									if ( false !== strpos( $value, ' ' ) && false === strpos( $value, '"' ) ) {
										$value = '"' . $value . '", ' . $backup_fonts[ $google_fonts_array[ $value ]['category'] ];
									} else {
										$value .= ', ' . $backup_fonts[ $google_fonts_array[ $value ]['category'] ];
									}
								}
							}
						}
					}
					$styles[ $output['media_query'] ][ $element ][ $output['property'] ] = $output['prefix'] . $value . $output['units'] . $output['suffix'];
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
							 * Add -webkit-* and -mod-*
							 */
							if ( is_string( $property ) && in_array( $property, array(
								'border-radius',
								'box-shadow',
								'box-sizing',
								'text-shadow',
								'transform',
								'background-size',
								'transition',
								'transition-property',
							) ) ) {
								$css[ $media_query ][ $element ][ '-webkit-' . $property ] = $value;
								$css[ $media_query ][ $element ][ '-moz-' . $property ]    = $value;
							}
							/**
							 * Add -ms-* and -o-*
							 */
							if ( is_string( $property ) && in_array( $property, array(
								'transform',
								'background-size',
								'transition',
								'transition-property',
							) ) ) {
								$css[ $media_query ][ $element ][ '-ms-' . $property ] = $value;
								$css[ $media_query ][ $element ][ '-o-' . $property ]  = $value;
							}
						}
					}
				}
			}

			return $css;

		}

	}
}
