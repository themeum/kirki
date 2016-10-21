<?php
/**
 * The main XTKirki object
 *
 * @package     XTKirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'XTKirki_Toolkit' ) ) {

	/**
	 * Singleton class
	 */
	final class XTKirki_Toolkit {

		/**
		 * Holds the one, true instance of this object.
		 *
		 * @static
		 * @access protected
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Access the single instance of this class.
		 *
		 * @static
		 * @access public
		 * @return object XTKirki_Toolkit.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}
}
