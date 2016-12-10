<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
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
 * Enqueues JS & CSS assets
 */
class Kirki_Enqueue {

	/**
	 * The class constructor.
	 * Adds actions to enqueue our assets.
	 */
	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 7 );
	}

	/**
	 * Assets that have to be enqueued in 'customize_controls_enqueue_scripts'.
	 */
	public function customize_controls_enqueue_scripts() {

		// Register selectize.
		wp_register_script( 'selectize', trailingslashit( Kirki::$url ) . 'assets/js/vendor/selectize.js', array( 'jquery' ) );

	}
}
