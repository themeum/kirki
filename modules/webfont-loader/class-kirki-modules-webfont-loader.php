<?php
/**
 * WebFont-Loader Module.
 *
 * @see       https://github.com/typekit/webfontloader
 * @package   Kirki
 * @category  Modules
 * @author    Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license  https://opensource.org/licenses/MIT
 * @since     3.0.26
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds script for tooltips.
 */
class Kirki_Modules_Webfont_Loader {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.26
	 * @var object
	 */
	private static $instance;

	/**
	 * Only load the webfont script if this is true.
	 *
	 * @static
	 * @access public
	 * @since 3.0.26
	 * @var bool
	 */
	public static $load = false;

	/**
	 * The class constructor
	 *
	 * @access protected
	 * @since 3.0.26
	 */
	protected function __construct() {
		add_action( 'wp_head', array( $this, 'enqueue_scripts' ), 20 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.26
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 * @since 3.0.26
	 * @return void
	 */
	public function enqueue_scripts() {
		global $wp_customize;
		if ( self::$load || $wp_customize || is_customize_preview() ) {
			wp_enqueue_script( 'webfont-loader', trailingslashit( Kirki::$url ) . 'modules/webfont-loader/vendor-typekit/webfontloader.js', array(), '3.0.28', true );
		}
	}

	/**
	 * Set the $load property of this object.
	 *
	 * @access public
	 * @since 3.0.35
	 * @param bool $load Set to false to disable loading.
	 * @return void
	 */
	public function set_load( $load ) {
		self::$load = $load;
	}
}
