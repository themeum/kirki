<?php
/**
 * Handles modules loading.
 *
 * @package     Kirki
 * @category    Core
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

namespace Kirki\Core;

/**
 * The Modules class.
 */
class Modules {

	/**
	 * An array of available modules.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private static $modules = [];

	/**
	 * An array of active modules (objects).
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private static $active_modules = [];

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'setup_default_modules' ], 10 );
		add_action( 'after_setup_theme', [ $this, 'init' ], 11 );
	}

	/**
	 * Set the default modules and apply the 'kirki_modules' filter.
	 * In v3.0.35 this method was renamed from default_modules to setup_default_modules,
	 * and its visibility changed from private to public to fix https://github.com/aristath/kirki/issues/2023
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function setup_default_modules() {
		self::$modules = apply_filters(
			'kirki_modules',
			[
				'css'                => '\Kirki\Modules\CSS\Module',
				'icons'              => '\Kirki_Modules_Icons',
				'loading'            => '\Kirki\Modules\Loading\Module',
				'postMessage'        => '\Kirki\Modules\Postmessage\Module',
				'selective-refresh'  => '\Kirki\Modules\Selective_Refresh\Module',
				'field-dependencies' => '\Kirki\Modules\Field_Dependencies\Module',
				'custom-sections'    => '\Kirki\Modules\Custom_Sections\Module',
				'webfonts'           => '\Kirki\Modules\Webfonts\Module',
				'webfont-loader'     => '\Kirki\Modules\Webfont_Loader\Module',
				'preset'             => '\Kirki\Modules\Preset\Module',
				'gutenberg'          => '\Kirki\Modules\Editor_Styles\Module',
			]
		);
	}

	/**
	 * Instantiates the modules.
	 * In v3.0.35 the visibility for this method was changed
	 * from private to public to fix https://github.com/aristath/kirki/issues/2023
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function init() {
		foreach ( self::$modules as $key => $module_class ) {
			if ( class_exists( $module_class ) ) {
				// Use this syntax instead of $module_class::get_instance()
				// for PHP 5.2 compatibility.
				self::$active_modules[ $key ] = call_user_func( [ $module_class, 'get_instance' ] );
			}
		}

		new \Kirki\Module\Tooltips();
		new \Kirki\Module\CSS_Vars();
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
