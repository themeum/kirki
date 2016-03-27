<?php

if ( ! class_exists( 'Kirki_Field_Color' ) ) {

	class Kirki_Field_Color extends Kirki_Field_Color_Alpha {

		/**
		 * Sets the $choices
		 *
		 * @access protected
		 */
		protected function set_choices() {

			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}
			$this->choices['alpha'] = false;
			// If a default value of rgba() is defined for a color control then we need to enable the alpha channel.
			if ( false !== strpos( $this->default, 'rgba' ) ) {
				$this->choices['alpha'] = true;
			}

		}

	}

}
