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
if ( class_exists( 'Kirki_Scripts_Frontend_Google_Fonts' ) ) {
	return;
}

class Kirki_Scripts_Frontend_Google_Fonts {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'google_font' ), 105 );
	}

	public function google_link() {

		// Get the array of fields
		$fields = Kirki::$fields;

		// Early exit if no fields are found.
		if ( empty( $fields ) ) {
			return;
		}

		$fonts = array();
		foreach ( $fields as $field ) {

			// Sanitize the field's output & settings_raw items.
			$field['output']       = Kirki_Field::sanitize_output( $field );
			$field['settings_raw'] = Kirki_Field::sanitize_settings_raw( $field );

			// Make sure output is properly formatted
			if ( isset( $field['output'] ) && is_array( $field['output'] ) ) {

				foreach ( $field['output'] as $output ) {

					if ( in_array( $output['property'], array( 'font-family', 'font-weight', 'font-subset' ) ) ) {
						// The value of this control
						$value = Kirki::get_option( $field['settings_raw'] );

						if ( 'font-family' == $output['property'] ) {
							// Add the font-family to the array
							$fonts[]['font-family'] = $value;
						} else if ( 'font-weight' == $output['property'] ) {
							// Add font-weight to the array
							$fonts[]['font-weight'] = $value;
						} else if ( 'font-subset' == $output['property'] ) {
							// add font subsets to the array
							$fonts[]['subsets'] = $value;
						}

					}

				}

			}

		}

		foreach ( $fonts as $font ) {

			// Do we have font-families?
			if ( isset( $font['font-family'] ) ) {

				$font_families   = ( ! isset( $font_families ) ) ? array() : $font_families;
				$font_families[] = $font['font-family'];

				if ( Kirki_Toolkit::fonts()->is_google_font( $font['font-family'] ) ) {
					$has_google_font = true;
				}

			}

			// Do we have font-weights?
			if ( isset( $font['font-weight'] ) ) {

				$font_weights   = ( ! isset( $font_weights ) ) ? array() : $font_weights;
				$font_weights[] = $font['font-weight'];

			}

			// Do we have font-subsets?
			if ( isset( $font['subsets'] ) ) {

				$font_subsets   = ( ! isset( $font_subsets ) ) ? array() : $font_subsets;
				$font_subsets[] = $font['subsets'];

			}

		}

		// Make sure there are no empty values and define defaults.
		$font_families = ( ! isset( $font_families ) || empty( $font_families ) ) ? false : $font_families;
		$font_weights  = ( ! isset( $font_weights ) || empty( $font_weights ) ) ? '400' : $font_weights;
		$font_subsets  = ( ! isset( $font_subsets ) || empty( $font_subsets ) ) ? 'all' : $font_subsets;

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
		if ( $this->google_link() ) {
			$google_link = str_replace( '%3A', ':', $this->google_link() );
			wp_enqueue_style( 'kirki_google_fonts', $google_link, array(), null );
		}
	}

}
