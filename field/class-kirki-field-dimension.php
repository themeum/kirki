<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.3.2
 */

/**
 * Field overrides.
 */
class Kirki_Field_Dimension extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-dimension';

	}

	/**
	 * Sanitizes the value.
	 *
	 * @access public
	 * @param string $value The value.
	 * @return string
	 */
	public function sanitize( $value ) {
		return Kirki_Sanitize_Values::css_dimension( $value );
	}
}
