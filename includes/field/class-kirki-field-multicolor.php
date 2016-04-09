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

if ( ! class_exists( 'Kirki_Field_Color_Alpha' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Color_Alpha extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'multicolor';

		}

		/**
		 * Sets the $choices
		 *
		 * @access protected
		 */
		protected function set_choices() {

			// Make sure choices are defined as an array.
			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}

			// Properly format the 'alpha' choice as a boolean.
			if ( ! isset( $this->choices['alpha'] ) ) {
				$this->choices['alpha'] = true;
			}
			$this->choices['alpha'] = (bool) $this->choices['alpha'];

			// Make sure we have more than 2 colors, and we're using an integer.
			if ( ! isset( $this->choices['colors'] ) ) {
				$this->choices['colors'] = 2;
			}
			$this->choices['colors'] = absint( $this->choices['colors'] );
			$this->choices['colors'] = min( 2, $this->choices['colors'] );

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
		 * Sets the default values
		 *
		 * @access protected
		 */
		protected function set_default() {

			// Make sure we've already processed the set_choices() method.
			// This way we know how many colors we're dealing with.
			$this->set_choices();

			// Define a default array using #FFFFFF.
			$defaults = array_fill( 0, $this->choices['colors'], '#FFFFFF' );

			// If we're using rgba, define default as rgba(255,255,255,0).
			if ( $this->choices['colors'] ) {
				$defaults = array_fill( 0, $this->choices['colors'], 'rgba(255,255,255,0)' );
			}

			// Make sure defaults are defined as an array.
			if ( ! is_array( $this->default ) ) {
				$this->default = array();
			}

			// Merge our arrays.
			$this->default = wp_parse_args( $this->default, $defaults );

		}

		/**
		 * The method that will be used as a `sanitize_callback`.
		 *
		 * @param array $value The value to be sanitized.
		 * @return array The value.
		 */
		public function sanitize( $value ) {

			return $value;

		}
	}
}
