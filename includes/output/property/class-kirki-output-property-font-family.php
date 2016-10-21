<?php
/**
 * Handles CSS output for font-family.
 *
 * @package     XTKirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'XTKirki_Output_Property_Font_Family' ) ) {

	/**
	 * Output overrides.
	 */
	class XTKirki_Output_Property_Font_Family extends XTKirki_Output_Property {

		/**
		 * Modifies the value.
		 *
		 * @access protected
		 */
		protected function process_value() {

			$google_fonts_array = XTKirki_Fonts::get_google_fonts();
			$backup_fonts       = XTKirki_Fonts::get_backup_fonts();

			// Make sure the value is a string.
			// If not, then early exit.
			if ( ! is_string( $this->value ) ) {
				return;
			}

			// Hack for standard fonts.
			$this->value = str_replace( '&quot;', '"', $this->value );

			// Add backup font.
			if ( XTKirki_Fonts::is_google_font( $this->value ) ) {

				if ( isset( $google_fonts_array[ $this->value ] ) && isset( $google_fonts_array[ $this->value ]['category'] ) ) {
					if ( isset( $backup_fonts[ $google_fonts_array[ $this->value ]['category'] ] ) ) {

						// Add double quotes if needed.
						if ( false !== strpos( $this->value, ' ' ) && false === strpos( $this->value, '"' ) ) {
							$this->value = '"' . $this->value . '", ' . $backup_fonts[ $google_fonts_array[ $this->value ]['category'] ];
						} else {
							$this->value .= ', ' . $backup_fonts[ $google_fonts_array[ $this->value ]['category'] ];
						}
					}
				}
			} else {

				// Add double quotes if needed.
				if ( false !== strpos( $this->value, ' ' ) && false === strpos( $this->value, '"' ) ) {
					$this->value = '"' . $this->value . '"';
				}
			}
		}
	}
}
