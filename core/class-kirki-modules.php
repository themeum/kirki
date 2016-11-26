<?php
/**
 * Handles modules loading.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.4.0
 */

/**
 * The Kirki_Modules class.
 */
class Kirki_Modules {

	/**
	 * An array of available modules.
	 *
	 * @static
	 * @access private
	 * @since 2.4.0
	 * @var array
	 */
	private static $modules = array();

	/**
	 * An array of active modules (objects).
	 *
	 * @static
	 * @access private
	 * @since 2.4.0
	 * @var array
	 */
	private static $active_modules = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.4.0
	 */
	public function __construct() {

		$this->default_modules();
		$this->init();

	}

	/**
	 * Set the default modules and apply the 'kirki/modules' filter.
	 *
	 * @access private
	 * @since 2.4.0
	 */
	private function default_modules() {

		self::$modules = apply_filters( 'kirki/modules', array(
			'Kirki_Modules_CSS_Output',
			'Kirki_Modules_Customizer_Styling',
			'Kirki_Modules_Icons',
			'Kirki_Modules_Loading',
			'Kirki_Modules_Reset',
			'Kirki_Modules_Tooltips',
			'Kirki_Modules_Customizer_Branding',
		) );

	}

	/**
	 * Instantiates the modules.
	 *
	 * @access private
	 * @since 2.4.0
	 */
	private function init() {

		foreach ( self::$modules as $module ) {
			self::$active_modules[ $module ] = new $module();
		}

	}

	/**
	 * Add a module.
	 *
	 * @static
	 * @access public
	 * @param string $module The classname of the module to add.
	 * @since 2.4.0
	 */
	public static function add_module( $module ) {

		if ( ! in_array( $module, self::$modules, true ) ) {
			self::$modules[] = $module;
		}

	}

	/**
	 * Remove a module.
	 *
	 * @static
	 * @access public
	 * @param string $module The classname of the module to add.
	 * @since 2.4.0
	 */
	public static function remove_module( $module ) {

		$key = array_search( $module, self::$modules, true );
		if ( false !== $key ) {
			unset( self::$modules[ $key ] );
		}
	}

	/**
	 * Get the modules array.
	 *
	 * @static
	 * @access public
	 * @since 2.4.0
	 * @return array
	 */
	public static function get_modules() {

		return self::$modules;

	}

	/**
	 * Get the array of active modules (objects).
	 *
	 * @static
	 * @access public
	 * @since 2.4.0
	 * @return array
	 */
	public static function get_active_modules() {

		return self::$active_modules;

	}
}
