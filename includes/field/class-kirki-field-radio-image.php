<?php

if ( ! class_exists( 'Kirki_Fieeld_Radio_Image' ) ) {

	class Kirki_Fieeld_Radio_Image extends Kirki_Field_Radio {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'radio-image';

		}

	}

}
