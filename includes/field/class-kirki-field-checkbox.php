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

if ( ! class_exists( 'Kirki_Field_Checkbox' ) ) {

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

			$this->type = 'kirki-checkbox';
			// Tweaks for backwards-compatibility:
			// Prior to version 0.8 switch & toggle were part of the checkbox control.
			if ( in_array( $this->mode, array( 'switch', 'toggle' ) ) ) {
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

			// If the value is not set, return false.
			if ( is_null( $value ) ) {
				return '0';
			}

			// Check for checked values.
			if ( 1 === $value || '1' === $value || true === $value || 'true' === $value || 'on' === $value ) {
				return '1';
			}

			// Fallback to false.
			return '0';

		}

		/**
		 * Sets the default value.
		 *
		 * @access protected
		 */
		protected function set_default() {

			if ( 1 === $this->default || '1' === $this->default || true === $this->default || 'true' === $this->default || 'on' === $this->default ) {
				$this->default = '1';
			} else {
				$this->default = '0';
			}
		}
	}
}
