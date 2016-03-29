<?php
/**
 * The main Kirki object
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Toolkit' ) ) {
	final class Kirki_Toolkit {

		/**
		 * @static
		 * @access protected
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Access the single instance of this class
		 *
		 * @static
		 * @access public
		 * @return Kirki_Toolkit
		 */
		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Return true if we are debugging Kirki
		 *
		 * @access public
		 * @return bool
		 */
		public static function is_debug() {
			return (bool) ( ( defined( 'KIRKI_DEBUG' ) && KIRKI_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) );
		}

	}

}
