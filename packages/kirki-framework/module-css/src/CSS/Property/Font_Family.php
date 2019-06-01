<?php
/**
 * Handles CSS output for font-family.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

namespace Kirki\Module\CSS\Property;

use Kirki\Module\CSS\Property;
use Kirki\Module\Webfonts\Fonts;

/**
 * Output overrides.
 */
class Font_Family extends Property {

	/**
	 * Modifies the value.
	 *
	 * @access protected
	 */
	protected function process_value() {
		$google_fonts_array = Fonts::get_google_fonts();
		$backup_fonts       = Fonts::get_backup_fonts();

		$family = $this->value;
		$backup = '';
		if ( is_array( $this->value ) && isset( $this->value[0] ) && isset( $this->value[1] ) ) {
			$family = $this->value[0];
			$backup = $this->value[1];
		}

		// Make sure the value is a string.
		// If not, then early exit.
		if ( ! is_string( $family ) ) {
			return;
		}

		// Hack for standard fonts.
		$family = str_replace( '&quot;', '"', $family );

		// Add backup font.
		if ( Fonts::is_google_font( $family ) ) {

			if ( '' === $backup && isset( $google_fonts_array[ $family ] ) && isset( $backup_fonts[ $google_fonts_array[ $family ]['category'] ] ) ) {
				$backup = $backup_fonts[ $google_fonts_array[ $family ]['category'] ];
			}

			// Add double quotes if needed.
			if ( false !== strpos( $family, ' ' ) && false === strpos( $family, '"' ) ) {
				$this->value = '"' . $family . '", ' . $backup;
				return;
			}
			$this->value = $family . ', ' . $backup;
			return;
		}

		// Add double quotes if needed.
		if ( false !== strpos( $family, ' ' ) && false === strpos( $family, '"' ) ) {
			$this->value = '"' . $family . '"';
		}
		$this->value = html_entity_decode( $family, ENT_QUOTES );
	}
}
