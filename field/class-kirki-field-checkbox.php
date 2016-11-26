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

/**
 * Field overrides.
 */
class Kirki_Field_Checkbox extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'checkbox';
		// Tweaks for backwards-compatibility:
		// Prior to version 0.8 switch & toggle were part of the checkbox control.
		if ( in_array( $this->mode, array( 'switch', 'toggle' ), true ) ) {
			$this->type = $this->mode;
		}

	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		$this->sanitize_callback = array( 'Kirki_Field_Checkbox', 'sanitize' );

	}

	/**
	 * Sanitizes checkbox values.
	 *
	 * @static
	 * @access public
	 * @param bool|string $value The checkbox value.
	 * @return bool
	 */
	public static function sanitize( $value = null ) {

		if ( '0' === $value || 0 === $value || 'false' === $value ) {
			return false;
		}
		if ( '1' === $value || 1 === $value || 'true' === $value ) {
			return true;
		}

		return (bool) $value;

	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 */
	protected function set_default() {

		$this->default = ( 1 === $this->default || '1' === $this->default || true === $this->default || 'true' === $this->default || 'on' === $this->default );

	}
}
