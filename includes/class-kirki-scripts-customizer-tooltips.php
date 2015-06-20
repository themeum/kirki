<?php

/**
 * Injects tooltips on controls.
 */
class Kirki_Scripts_Customizer_Tooltips extends Kirki_Scripts_Enqueue_Script {

	/**
	 * Add the help bubble
	 */
	public function customize_controls_print_footer_scripts() {

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

		echo Kirki_Scripts_Registry::prepare( $script );

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
