<?php

if ( ! class_exists( 'Kirki_Field_Switch' ) ) {

	class Kirki_Field_Switch extends Kirki_Field {

		/**
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function set_sanitize_callback() {
			return array( 'Kirki_Sanitize_Values', 'checkbox' );
		}

	}

}
