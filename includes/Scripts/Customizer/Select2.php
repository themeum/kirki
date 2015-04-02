<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;

class Select2 extends EnqueueScript {

	/**
	 * Add the required script.
	 */
	function customize_controls_print_footer_scripts() {

		$fields = Kirki::fields()->get_all();

		// Early exit if no controls are defined
		if ( empty( $fields ) ) {
			return;
		}

		$script = '';

		foreach ( $fields as $field ) {
			// Uncomment next line to always enable select2
			// $field['select2'] = true;
			if ( 'select' == $field['type'] && isset( $field['select2'] ) && $field['select2'] ) {
				$script .= '$("#customize-control-' . $field['settings'] . ' select").select2();';
			}
		}

		// If there's a script then echo it wrapped.
		if ( ! empty( $script ) ) {
			echo '<script>jQuery(document).ready(function($) {' . $script . '});</script>';
		}

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
