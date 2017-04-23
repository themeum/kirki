<?php
/**
 * Handles CSS output for background-image.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

/**
 * Output overrides.
 */
class Kirki_Output_Property_Background_Image extends Kirki_Output_Property {

	/**
	 * Modifies the value.
	 *
	 * @access protected
	 */
	protected function process_value() {

		if ( false === strrpos( $this->value, 'url(' ) ) {
			if ( empty( $this->value ) ) {
				return;
			}

			if ( preg_match( '/^\d+$/', $this->value ) ) {
				$this->value = 'url("' . wp_get_attachment_url( $this->value ) . '")';
			} else {
				$this->value = 'url("' . $this->value . '")';
			}
		}
	}
}
