<?php

if ( ! class_exists( 'Kirki_Field_Toggle' ) ) {

	class Kirki_Field_Toggle extends Kirki_Field_Checkbox {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'toggle';

		}

	}

}
