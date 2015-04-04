<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;
use Kirki\Scripts\ScriptRegistry;

class Stepper extends EnqueueScript {

	/**
	 * Add the help bubble
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

		echo ScriptRegistry::prepare( $script );

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
