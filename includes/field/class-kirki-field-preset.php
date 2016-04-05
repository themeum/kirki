<?php

if ( ! class_exists( 'Kirki_Field_Preset' ) ) {

	class Kirki_Field_Preset extends Kirki_Field_Select {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'preset';

		}

		/**
		 * Sets the $multiple
		 *
		 * @access protected
		 */
		protected function set_multiple() {

			$this->multiple = '1';

		}

	}

}
