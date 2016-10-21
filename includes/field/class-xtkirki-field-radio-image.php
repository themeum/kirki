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

if ( ! class_exists( 'XTKirki_Field_Radio_Image' ) ) {

	/**
	 * Field overrides.
	 */
	class XTKirki_Field_Radio_Image extends XTKirki_Field_Radio {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'xtkirki-radio-image';

		}
	}
}
