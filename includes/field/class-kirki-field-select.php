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

if ( ! class_exists( 'Kirki_Field_Select' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Select extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-select';

		}

		/**
		 * Sets the $multiple
		 *
		 * @access protected
		 */
		protected function set_multiple() {

			$this->multiple = absint( $this->multiple );

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
		 * Sanitizes select control values.
		 *
		 * @since 2.2.8
		 * @access public
		 * @param array $value The value.
		 * @return string|array
		 */
		public function sanitize( $value ) {

			if ( is_array( $value ) ) {
				foreach ( $value as $key => $subvalue ) {
					$value[ $key ] = esc_attr( $subvalue );
				}
				return $value;
			}
			return esc_attr( $value );

		}
	}
}
