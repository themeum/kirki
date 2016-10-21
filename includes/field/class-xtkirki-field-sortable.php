<?php
/**
 * Override field methods
 *
 * @package     XTKirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.3.2
 */

if ( ! class_exists( 'XTKirki_Field_Sortable' ) ) {

	/**
	 * Field overrides.
	 */
	class XTKirki_Field_Sortable extends XTKirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'xtkirki-sortable';

		}
	}
}
