<?php

/**
 * Injects tooltips on controls.
 */
class Kirki_Scripts_Customizer_Tooltips extends Kirki_Scripts_Enqueue_Script {

	/**
	 * Add the help bubble
	 */
	function customize_controls_print_footer_scripts() {

		$fields = Kirki::fields()->get_all();

		$scripts = array();
		$script  = '';

		foreach ( $fields as $field ) {

			if ( ! empty( $field['help'] ) ) {
				$bubble_content = $field['help'];
				$content = "<a href='#' class='tooltip hint--left' data-hint='" . strip_tags( esc_html( $bubble_content ) ) . "'><span class='dashicons dashicons-info'></span></a>";
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

		echo Kirki_Scripts_Registry::prepare( $script );

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
