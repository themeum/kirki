<?php
/**
 * typography Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Typography_Control' ) ) {
	return;
}

class Kirki_Controls_Typography_Control extends WP_Customize_Control {

	public $type = 'typography';

	public function enqueue() {

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-typography', trailingslashit( kirki_url() ) . 'includes/controls/typography/style.css' );
		}
		wp_enqueue_script( 'kirki-typography', trailingslashit( kirki_url() ) . 'includes/controls/typography/kirki-dimension.js', array( 'jquery' ) );

	}

	public function render_content() {}

	public function get_standard_fonts() {}

	public function get_google_fonts() {}

	public function get_all_fonts() {}

}
