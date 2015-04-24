<?php

/**
 * Adds the stepper script for number controls.
 * See http://classic.formstone.it/components/stepper for details.
 */
class Kirki_Scripts_Customizer_Stepper extends Kirki_Scripts_Enqueue_Script {

	/**
	 * Add the script to the footer
	 */
	function customize_controls_print_footer_scripts() {

		$fields = Kirki::fields()->get_all();
		$scripts = array();

		foreach ( $fields as $field ) {

			if ( 'number' == $field['type'] ) {
				$scripts[] = '$( "#customize-control-' . $field['settings'] . ' input[type=\'number\']").stepper();';
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
