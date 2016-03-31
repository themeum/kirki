<?php

if ( ! class_exists( 'Kirki_Field_Textarea' ) ) {

	class Kirki_Field_Textarea extends Kirki_Field_Kirki_Generic {

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

	}

}
