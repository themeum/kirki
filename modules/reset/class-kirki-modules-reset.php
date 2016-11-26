<?php
/**
 * Handles the resrt buttons on sections.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.4.0
 */

/**
 * The Kirki_Modules_Reset object.
 */
class Kirki_Modules_Reset {

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 20 );

	}

	/**
	 * Enqueue scripts
	 *
	 * @access public
	 * @since 2.4.0
	 */
	public function customize_controls_enqueue_scripts() {

		// Enqueue the reset script.
		wp_enqueue_script( 'kirki-set-setting-value', trailingslashit( Kirki::$url ) . 'modules/reset/set-setting-value.js', array( 'jquery', 'customize-base', 'customize-controls' ) );
		wp_enqueue_script( 'kirki-reset', trailingslashit( Kirki::$url ) . 'modules/reset/reset.js', array( 'jquery', 'customize-base', 'customize-controls', 'kirki-set-setting-value' ) );
		wp_enqueue_style( 'kirki-reset', trailingslashit( Kirki::$url ) . 'modules/reset/reset.css', null );

	}
}
