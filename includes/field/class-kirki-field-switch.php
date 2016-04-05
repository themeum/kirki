<?php

if ( ! class_exists( 'Kirki_Field_Switch' ) ) {

	class Kirki_Field_Switch extends Kirki_Field_Checkbox {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'switch';

		}

	}

}
