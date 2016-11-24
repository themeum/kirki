<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.3.2
 */

if ( ! class_exists( 'Kirki_Field_Color_Palette' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Color_Palette extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-color-palette';

		}
	}
}
