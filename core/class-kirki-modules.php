<?php
/**
 * Handles modules loading.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
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
	 * @since 3.0.0
	 * @var array
	 */
	private static $modules = array();

	/**
	 * An array of active modules (objects).
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private static $active_modules = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {

		$this->default_modules();
		$this->init();

	}

	/**
	 * Set the default modules and apply the 'kirki/modules' filter.
	 *
	 * @access private
	 * @since 3.0.0
	 */
	private function default_modules() {

		self::$modules = apply_filters(
			'kirki/modules', array(
				'css'                => 'Kirki_Modules_CSS',
				'customizer-styling' => 'Kirki_Modules_Customizer_Styling',
				'icons'              => 'Kirki_Modules_Icons',
				'loading'            => 'Kirki_Modules_Loading',
				'tooltips'           => 'Kirki_Modules_Tooltips',
				'branding'           => 'Kirki_Modules_Customizer_Branding',
				'postMessage'        => 'Kirki_Modules_PostMessage',
				// 'post_meta'          => 'Kirki_Modules_Post_Meta',
				'selective-refresh'  => 'Kirki_Modules_Selective_Refresh',
				'field-dependencies' => 'Kirki_Modules_Field_Dependencies',
				'custom-sections'    => 'Kirki_Modules_Custom_Sections',
				// 'collapsible'        => 'Kirki_Modules_Collapsible',
				'webfonts'           => 'Kirki_Modules_Webfonts',
			)
		);

	}

	/**
	 * Instantiates the modules.
	 *
	 * @access private
	 * @since 3.0.0
	 */
	private function init() {

		foreach ( self::$modules as $key => $module_class ) {
			if ( class_exists( $module_class ) ) {
				// Use this syntax instead of $module_class::get_instance()
				// for PHP 5.2 compatibility.
				self::$active_modules[ $key ] = call_user_func( array( $module_class, 'get_instance' ) );
			}
		}
	}

	/**
	 * Add a module.
	 *
	 * @static
	 * @access public
	 * @param string $module The classname of the module to add.
	 * @since 3.0.0
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
	 * @since 3.0.0
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
	 * @since 3.0.0
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
	 * @since 3.0.0
	 * @return array
	 */
	public static function get_active_modules() {

		return self::$active_modules;

	}
}
