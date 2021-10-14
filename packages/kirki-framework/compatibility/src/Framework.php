<?php
/**
 * The main Kirki object
 *
 * @package     Kirki
 * @category    Core
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2020, David Vongries
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

namespace Kirki\Compatibility;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Singleton class
 */
final class Framework {

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
	 * @return Kirki\Compatibility\Framework
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
