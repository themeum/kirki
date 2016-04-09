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

if ( ! class_exists( 'Kirki_Field_Radio' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Radio extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-radio';
			// Tweaks for backwards-compatibility:
			// Prior to version 0.8 radio-buttonset & radio-image were part of the radio control.
			if ( in_array( $this->mode, array( 'buttonset', 'image' ) ) ) {
				$this->type = 'radio-' . $this->mode;
			}

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
			$this->sanitize_callback = 'esc_attr';

		}
	}
}
