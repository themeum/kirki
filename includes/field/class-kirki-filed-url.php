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

if ( ! class_exists( 'Kirki_Field_Url' ) ) {

	/**
	 * This is simply an alias for the Kirki_Field_Link class.
	 */
	class Kirki_Field_Url extends Kirki_Field_Link {}
}
