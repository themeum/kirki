<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
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
	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {
		if ( ! $this->sanitize_callback ) {
			$this->sanitize_callback = array( $this, 'sanitize' );
		}
	}

	/**
	 * Sanitizes checkbox values.
	 *
	 * @access public
	 * @param boolean|integer|string|null $value The checkbox value.
	 * @return bool
	 */
	public function sanitize( $value = null ) {
		return ( '0' === $value || 'false' === $value ) ? false : (bool) $value;
	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 */
	protected function set_default() {
		$this->default = (bool) ( 1 === $this->default || '1' === $this->default || true === $this->default || 'true' === $this->default || 'on' === $this->default );
	}
}
