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

// Early exit if the class already exists
if ( class_exists( 'Kirki_Scripts_Customizer_Default_Scripts' ) ) {
	return;
}

class Kirki_Scripts_Customizer_Default_Scripts extends Kirki_Scripts_Enqueue_Script {

	public function generate_script() {}
		
	/**
	 * Enqueue the scripts required.
	 */
	public function customize_controls_enqueue_scripts() {

		wp_enqueue_script( 'kirki-tooltip', trailingslashit( kirki_url() ).'assets/js/kirki-tooltip.js', array( 'jquery', 'customize-controls' ) );
		wp_enqueue_script( 'serialize-js', trailingslashit( kirki_url() ).'assets/js/serialize.js' );
		wp_enqueue_script( 'jquery-select2', trailingslashit( kirki_url() ).'assets/js/select2.full.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		wp_enqueue_script( 'jquery-stepper-min-js' );

		wp_enqueue_style( 'css-select2', trailingslashit( kirki_url() ).'assets/css/select2.min.css' );
	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_print_footer_scripts() {}

	public function wp_footer() {}

}
