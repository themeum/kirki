<?php

if ( ! class_exists( 'Kirki_Field_Textarea' ) ) {

	class Kirki_Field_Textarea extends Kirki_Field {

	/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-generic';

		}


		/**
		 * Sets the $choices
		 *
		 * @access protected
		 */
		protected function set_choices() {

			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}
			$this->choices['element'] = 'textarea';
			$this->choices['rows']    = '5';

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
			$this->sanitize_callback = 'wp_kses_post';

		}

	}

}
