<?php

if ( ! class_exists( 'Kirki_Field_Group_Title' ) ) {

	/**
	 * Prior to version 0.8 there was a separate 'group-title' field.
	 * This exists here just for compatibility purposes.
	 */
	class Kirki_Field_Group_Title extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'custom';

		}

	}

}
