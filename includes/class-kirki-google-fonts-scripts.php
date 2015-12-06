<?php
/**
 * Creates the google-fonts link.
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
if ( class_exists( 'Kirki_Google_Fonts_Scripts' ) ) {
	return;
}

class Kirki_Google_Fonts_Scripts {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'google_font' ), 105 );
	}

	public function google_link() {

		/**
		 * Get the array of fields from the Kirki object.
		 */
		$fields = Kirki::$fields;
		/**
		 * Early exit if no fields are found.
		 */
		if ( empty( $fields ) ) {
			return;
		}

		$fonts = array();
		/**
		 * Run a loop for our fields
		 */
		foreach ( $fields as $field ) {
			/**
			 * Sanitize the field
			 */
			$field = Kirki_Field_Sanitize::sanitize_field( $field );
			/**
			 * No reason to proceed any further if no 'output' has been defined
			 * or if it's not defined as an array.
			 */
			if ( ! isset( $field['output'] ) || ! is_array( $field['output'] ) ) {
				continue;
			}
			/**
			 * Run through each of our "output" items in the array separately.
			 */
			foreach ( $field['output'] as $output ) {
				$valid = false;
				/**
				 * If the field-type exists and is set to "typography"
				 * then we need some extra checks to figure out if we need to proceed.
				 */
				if ( isset( $field['type'] ) && 'typography' == $field['type'] ) {
					if ( isset( $field['choices'] ) && isset( $field['choices']['font-family'] ) && $field['choices']['font-family'] ) {
						$valid = true;
					}
				}
				/**
				 * Check if the "property" of this item is related to typography.
				 */
				if ( isset( $output['property'] ) && in_array( $output['property'], array( 'font-family', 'font-weight', 'font-subset' ) ) ) {
					$valid = true;
				}
				/**
				 * If the $valid var is not true, then we don't need to proceed.
				 * Continue to the next item in the array.
				 */
				if ( ! $valid ) {
					continue;
				}

				/**
		 		 * Get the value of this field
		 		 */
		 		$value = Kirki_Values::get_sanitized_field_value( $field );
				/**
				 * Typography fields arew a bit more complex than usual fields.
				 * We need to get the sub-items of the array
				 * and then base our calculations on these.
				 */
				if ( 'typography' == $field['type'] ) {
					/**
					 * Add the font-family to the array
					 */
					if ( isset( $value['font-family'] ) ) {
						$fonts[]['font-family'] = $value['font-family'];
					}
					/**
					 * Add the font-weight to the array
					 */
					if ( isset( $value['font-weight'] ) ) {
						$fonts[]['font-weight'] = $value['font-weight'];
					}
				}
				/**
				 * This is not a typography field so we can proceed.
				 * This is a lot simple. :)
				 */
				 else {

					 if ( 'font-family' == $output['property'] ) {
						 /**
						  * Add the font-family to the array
						  */
						 $fonts[]['font-family'] = $value;
					} else if ( 'font-weight' == $output['property'] ) {
						/**
						 * Add font-weight to the array
						 */
						$fonts[]['font-weight'] = $value;
					} else if ( 'font-subset' == $output['property'] ) {
						/**
						 * add font subsets to the array
						 */
						$fonts[]['subsets'] = $value;

					}

				}

			}

		}
		/**
		 * Start going through all the items in the $fonts array.
		 */
		foreach ( $fonts as $font ) {
			/**
			 * Do we have font-families?
			 */
			if ( isset( $font['font-family'] ) ) {
				$font_families   = ( ! isset( $font_families ) ) ? array() : $font_families;
				$font_families[] = $font['font-family'];
				/**
				 * Determine if we need to create a google-fonts link or not.
				 */
				if ( ! isset( $has_google_font ) ) {
					if ( Kirki_Toolkit::fonts()->is_google_font( $font['font-family'] ) ) {
						$has_google_font = true;
					}
				}
			}
			/**
			 * Do we have font-weights?
			 */
			if ( isset( $font['font-weight'] ) ) {
				$font_weights   = ( ! isset( $font_weights ) ) ? array() : $font_weights;
				$font_weights[] = $font['font-weight'];
			}
			/**
			 * Do we have font-subsets?
			 */
			if ( isset( $font['subsets'] ) ) {
				$font_subsets   = ( ! isset( $font_subsets ) ) ? array() : $font_subsets;
				$font_subsets[] = $font['subsets'];
			}

		}
		/**
		 * Make sure there are no empty values and define some sane defaults.
		 */
		$font_families = ( ! isset( $font_families ) || empty( $font_families ) ) ? false : $font_families;
		$font_weights  = ( ! isset( $font_weights ) || empty( $font_weights ) ) ? array( '400' ) : $font_weights;
		$font_subsets  = ( ! isset( $font_subsets ) || empty( $font_subsets ) ) ? array( 'all' ) : $font_subsets;
		/**
		 * Get rid of duplicate values
		 */
		if ( is_array( $font_families ) && ! empty( $font_families ) ) {
			$font_families = array_unique( $font_families );
		}
		if ( is_array( $font_weights ) && ! empty( $font_weights ) ) {
			$font_weights  = array_unique( $font_weights );
		}
		if ( is_array( $font_subsets ) && ! empty( $font_subsets ) ) {
			$font_subsets  = array_unique( $font_subsets );
		}

		if ( ! isset( $has_google_font ) || ! $has_google_font ) {
			$font_families = false;
		}

		// Return the font URL.
		return ( $font_families ) ? Kirki_Toolkit::fonts()->get_google_font_uri( $font_families, $font_weights, $font_subsets ) : false;

	}

	/**
	 * Enqueue Google fonts if necessary
	 */
	public function google_font() {

		$config = apply_filters( 'kirki/config', array() );

		/**
		 * If we have set $config['disable_google_fonts'] to true
		 * then do not proceed any further.
		 */
		if ( isset( $config['disable_google_fonts'] ) && true == $config['disable_google_fonts'] ) {
			return;
		}

		if ( $this->google_link() ) {
			$google_link = str_replace( '%3A', ':', $this->google_link() );
			wp_enqueue_style( 'kirki_google_fonts', $google_link, array(), null );
		}
	}

}
