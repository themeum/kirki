<?php
/**
 * Injects tooltips to controls when the 'help' argument is used.
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
if ( class_exists( 'Kirki_Scripts_Customizer_Tooltips' ) ) {
	return;
}

class Kirki_Scripts_Customizer_Tooltips extends Kirki_Scripts_Enqueue_Script {

	/**
	 * Add the help bubble
	 */
	public function generate_script() {

		$fields = Kirki::$fields;

		$scripts = array();

		foreach ( $fields as $field ) {

			$field['help']     = Kirki_Field::sanitize_help( $field );
			$field['settings'] = Kirki_Field::sanitize_settings( $field );

			if ( ! empty( $field['help'] ) ) {
				$content   = "<a href='#' class='tooltip hint--left' data-hint='".strip_tags( esc_html( $field['help'] ) )."'><span class='dashicons dashicons-info'></span></a>";
				$scripts[] = '$( "'.$content.'" ).prependTo( "#customize-control-'.$field['settings'].'" );';
			}

		}

		// No need to echo anything if the script is empty
		if ( empty( $scripts ) ) {
			return;
		}

		// Make sure we don't add any duplicates
		$scripts = array_unique( $scripts );
		// Convert array to string
		$script = implode( '', $scripts );

		return $script;

	}

	public function customize_controls_print_footer_scripts() {
		$script = $this->generate_script();
		if ( '' != $script ) {
			echo Kirki_Scripts_Registry::prepare( $script );
		}
	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
