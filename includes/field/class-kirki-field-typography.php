<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

if ( ! class_exists( 'Kirki_Field_Typography' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Typography extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-typography';

		}

		/**
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function set_sanitize_callback() {

			// If a custom sanitize_callback has been defined,
			// then we don't need to proceed any further.
			if ( ! empty( $this->sanitize_callback ) ) {
				return;
			}
			$this->sanitize_callback = array( $this, 'sanitize' );

		}

		/**
		 * Sanitizes typography controls
		 *
		 * @since 2.2.0
		 * @param array $value The value.
		 * @return array
		 */
		public static function sanitize( $value ) {

			if ( ! is_array( $value ) ) {
				return array();
			}

			// Escape the font-family.
			if ( isset( $value['font-family'] ) ) {
				$value['font-family'] = esc_attr( $value['font-family'] );
			}

			// Make sure we're using a valid variant.
			// We're adding checks for font-weight as well for backwards-compatibility
			// Versions 2.0 - 2.2 were using an integer font-weight.
			if ( isset( $value['variant'] ) || isset( $value['font-weight'] ) ) {
				if ( isset( $value['font-weight'] ) && ! empty( $value['font-weight'] ) ) {
					if ( ! isset( $value['variant'] ) || empty( $value['variant'] ) ) {
						$value['variant'] = $value['font-weight'];
					}
					unset( $value['font-weight'] );
				}
				$valid_variants = Kirki_Fonts::get_all_variants();
				if ( ! array_key_exists( $value['variant'], $valid_variants ) ) {
					$value['variant'] = 'regular';
				}
			}

			// Make sure the saved value is "subsets" (plural) and not "subset".
			// This is for compatibility with older versions.
			if ( isset( $value['subset'] ) ) {
				if ( ! empty( $value['subset'] ) ) {
					if ( ! isset( $value['subsets'] ) || empty( $value['subset'] ) ) {
						$value['subsets'] = $value['subset'];
					}
				}
				unset( $value['subset'] );
			}

			// Make sure we're using a valid subset.
			if ( isset( $value['subsets'] ) ) {
				$valid_subsets = Kirki_Fonts::get_google_font_subsets();
				$subsets_ok = array();
				if ( is_array( $value['subsets'] ) ) {
					foreach ( $value['subsets'] as $subset ) {
						if ( array_key_exists( $subset, $valid_subsets ) ) {
							$subsets_ok[] = $subset;
						}
					}
					$value['subsets'] = $subsets_ok;
				}
			}

			// Sanitize the font-size.
			if ( isset( $value['font-size'] ) && ! empty( $value['font-size'] ) ) {
				$value['font-size'] = Kirki_Sanitize_Values::css_dimension( $value['font-size'] );
				if ( is_numeric( $value['font-size'] ) ) {
					$value['font-size'] .= 'px';
				}
			}

			// Sanitize the line-height.
			if ( isset( $value['line-height'] ) && ! empty( $value['line-height'] ) ) {
				$value['line-height'] = Kirki_Sanitize_Values::css_dimension( $value['line-height'] );
			}

			// Sanitize the letter-spacing.
			if ( isset( $value['letter-spacing'] ) && ! empty( $value['letter-spacing'] ) ) {
				$value['letter-spacing'] = Kirki_Sanitize_Values::css_dimension( $value['letter-spacing'] );
				if ( is_numeric( $value['letter-spacing'] ) ) {
					$value['letter-spacing'] .= 'px';
				}
			}

			// Sanitize the text-align.
			if ( isset( $value['text-align'] ) && ! empty( $value['text-align'] ) ) {
				if ( ! in_array( $value['text-align'], array( 'inherit', 'left', 'center', 'right', 'justify' ) ) ) {
					$value['text-align'] = 'inherit';
				}
			}

			// Sanitize the text-transform.
			if ( isset( $value['text-transform'] ) && ! empty( $value['text-transform'] ) ) {
				if ( ! in_array( $value['text-transform'], array( 'none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit' ) ) ) {
					$value['text-transform'] = 'none';
				}
			}

			// Sanitize the color.
			if ( isset( $value['color'] ) && ! empty( $value['color'] ) ) {
				$color = ariColor::newColor( $value['color'] );
				$value['color'] = $color->toCSS( 'hex' );
			}

			return $value;

		}
	}
}
