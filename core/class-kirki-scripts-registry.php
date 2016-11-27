<?php
/**
 * Instantiates all other needed scripts.
 *
 * @package     Kirki
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

/**
 * Instantiates dependent classes
 */
class Kirki_Scripts_Registry {

	/**
	 * Dependencies
	 *
	 * @access public
	 * @var object Kirki_Enqueue.
	 */
	public $dependencies;

	/**
	 * The main class constructor.
	 * Instantiates secondary classes.
	 */
	public function __construct() {

		$this->dependencies = new Kirki_Enqueue();

	}

	/**
	 * Prepares a script for echoing.
	 * Wraps it in <script> and jQuery.
	 *
	 * @param string $script The contents of the script.
	 * @return string
	 */
	public static function prepare( $script ) {
		return '<script>jQuery(document).ready(function($) { "use strict"; ' . $script . '});</script>';
	}
}
