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

if ( ! class_exists( 'Kirki_Field_Multicheck' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Multicheck extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-multicheck';

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
		 * The sanitize method that will be used as a falback
		 *
		 * @param string|array $value The control's value.
		 */
		public function sanitize( $value ) {

			$value = ( ! is_array( $value ) ) ? explode( ',', $value ) : $value;
			return ( ! empty( $value ) ) ? array_map( 'sanitize_text_field', $value ) : array();

		}
	}
}
