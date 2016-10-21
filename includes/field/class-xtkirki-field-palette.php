<?php
/**
 * Override field methods
 *
 * @package     XTKirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

if ( ! class_exists( 'XTKirki_Field_Palette' ) ) {

	/**
	 * Field overrides.
	 */
	class XTKirki_Field_Palette extends XTKirki_Field_Radio {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'xtkirki-palette';

		}
	}
}
