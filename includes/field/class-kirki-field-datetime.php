<?php

if ( ! class_exists( 'Kirki_Field_Datetime' ) ) {

	class Kirki_Field_Datetime extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-datetime';

		}

	}

}
