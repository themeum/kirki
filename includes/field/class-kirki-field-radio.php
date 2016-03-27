<?php

if ( ! class_exists( 'Kirki_Fieeld_Radio' ) ) {

	class Kirki_Field_Radio extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-radio';
			// Tweaks for backwards-compatibility:
			// Prior to version 0.8 radio-buttonset & radio-image were part of the radio control.
			if ( in_array( $this->mode, array( 'buttonset', 'image' ) ) ) {
				$this->type = 'radio-' . $this->mode;
			}

		}

	}

}
