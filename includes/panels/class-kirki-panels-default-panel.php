<?php
/**
 * The default panel.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'Kirki_Panels_Default_Panel' ) ) {

	/**
	 * Default Panel.
	 */
	class Kirki_Panels_Default_Panel extends WP_Customize_Panel {

		/**
		 * The panel type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-default';

	}

}
