<?php

if ( ! class_exists( 'Kirki_Field_Checkbox' ) ) {

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
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function set_sanitize_callback() {

			$this->sanitize_callback = array( 'Kirki_Sanitize_Values', 'checkbox' );

		}

		/**
		 * Sets the default value
		 *
		 * @access protected
		 */
		protected function set_default() {

			if ( false === $this->default || 0 === $this->default ) {
				$this->default = '0';
			}

			if ( true === $this->default || 1 === $this->default ) {
				$this->default = '1';
			}

		}

	}

}
