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
	public function generate_script( $args = array() ) {

		$fields = Kirki::$fields;

		$scripts = array();

		/**
		 * The following control types already have the "help" argument in them
		 * and they don't need an extra implementation in order to be rendered.
		 * We're going to ignore these control-types and only process the rest.
		 */
		$ready_controls = array(
			'checkbox',
			'code',
			'color-alpha',
			'custom',
			'dimension',
			'editor',
			'multicheck',
			'number',
			'palette',
			'radio-buttonset',
			'radio-image',
			'radio',
			'kirki-radio',
			'repeater',
			'select',
			'kirki-select',
			'select2',
			'select2-multiple',
			'slider',
			'sortable',
			'spacing',
			'switch',
			'textarea',
			'toggle',
			'typography',
		);

		foreach ( $fields as $field ) {

			if ( isset( $field['type'] ) && in_array( $field['type'], $ready_controls ) ) {
				continue;
			}

			$field['help']     = isset( $field['help'] ) ? wp_strip_all_tags( $field['help'] ) : '';
			$field['settings'] = Kirki_Field_Sanitize::sanitize_settings( $field );

			if ( ! empty( $field['help'] ) ) {
				$content   = "<a href='#' class='tooltip hint--left' data-hint='" . strip_tags( esc_html( $field['help'] ) ) . "'><span class='dashicons dashicons-info'></span></a>";
				$scripts[] = '$( "' . $content . '" ).prependTo( "#customize-control-' . $field['settings'] . '" );';
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
