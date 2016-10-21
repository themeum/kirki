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

if ( ! class_exists( 'XTKirki_Field_Url' ) ) {

	/**
	 * This is simply an alias for the XTKirki_Field_Link class.
	 */
	class XTKirki_Field_Url extends XTKirki_Field_Link {}
}
