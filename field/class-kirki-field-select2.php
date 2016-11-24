<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

if ( ! class_exists( 'Kirki_Field_Select2' ) ) {
	/**
	 * This is nothing more than an alias for the Kirki_Field_Select class.
	 * In older versions of Kirki there was a separate 'select2' field.
	 * This exists here just for compatibility purposes.
	 */
	class Kirki_Field_Select2 extends Kirki_Field_Select {}

}
