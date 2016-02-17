<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Enqueue' ) ) {
	class Kirki_Enqueue {

		public function __construct() {
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ) );
		}

		public function customize_controls_enqueue_scripts() {

			wp_enqueue_script( 'kirki-tooltip', trailingslashit( Kirki::$url ) . 'assets/js/kirki-tooltip.js', array( 'jquery', 'customize-controls' ) );
			wp_enqueue_script( 'serialize-js', trailingslashit( Kirki::$url ) . 'assets/js/vendor/serialize.js' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( 'jquery-stepper-min-js' );
			wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/js/vendor/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2' );
			wp_enqueue_style( 'wp-color-picker' );

		}

	}
}
