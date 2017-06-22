<?php
/**
 * Allows resizing the customizer pane.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * The Kirki_Modules_Resize object.
 */
class Kirki_Modules_Resize {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		add_action( 'customize_controls_print_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
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
	 * @since 3.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'kirki-customizer-resize', trailingslashit( Kirki::$url ) . 'modules/resize/resize.js', array( 'jquery-ui-resizable' ) );
		wp_enqueue_style( 'kirki-customizer-resize', trailingslashit( Kirki::$url ) . 'modules/resize/resize.css' );
	}
}
