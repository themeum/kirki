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
class Kirki_Field_Image extends Kirki_Field_Upload {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'upload';

	}

	/**
	 * Sets the button labels.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function set_button_labels() {

		// Simple sanitization.
		if ( ! empty( $this->button_labels ) ) {
			foreach ( $this->button_labels as $key => $value ) {
				$this->button_labels[ sanitize_key( $key ) ] = esc_attr( $value );
			}
		}
	}
}
