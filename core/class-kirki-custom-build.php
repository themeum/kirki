<?php
/**
 * Handles enqueueing scripts & styles for custom builds.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since 3.0.0
 */

/**
 * Our main Kirki_Control object
 */
class Kirki_Custom_Build {

	/**
	 * Is this a custom build?
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var bool|null
	 */
	private static $is_custom_build = null;

	/**
	 * An array of dependencies for the script.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private static $dependencies = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {
		if ( ! self::is_custom_build() ) {
			return;
		}
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 500 );
	}

	/**
	 * Figure out if this is a custom build or not.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return bool
	 */
	public static function is_custom_build() {
		if ( null === self::$is_custom_build ) {
			if ( file_exists( Kirki::$path . '/build.min.js' ) && file_exists( Kirki::$path . '/build.min.css' ) ) {
				self::$is_custom_build = true;
				return true;
			}
			self::$is_custom_build = false;
			return false;
		}
		return self::$is_custom_build;
	}

	/**
	 * Registers a dependency for the custom build JS.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @param string $dependency The script's identifier.
	 */
	public static function register_dependency( $dependency ) {
		if ( in_array( $dependency, self::$dependencies, true ) ) {
			return;
		}
		self::$dependencies[] = $dependency;
	}

	/**
	 * Enqueues the scripts and styles we need.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function customize_controls_enqueue_scripts() {

		wp_enqueue_script( 'kirki-build', trailingslashit( Kirki::$url ) . 'build.min.js', self::$dependencies );
		wp_enqueue_style( 'kirki-build', trailingslashit( Kirki::$url ) . 'build.min.css', null );

	}
}
