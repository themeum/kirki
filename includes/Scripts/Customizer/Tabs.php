<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;
use Kirki\Scripts\ScriptRegistry;

class Tabs extends EnqueueScript {

	/**
	 * Add the required script.
	 */
	function customize_controls_print_footer_scripts() {

		$fields = Kirki::fields()->get_all();

		// Early exit if no controls are defined
		// if ( empty( $fields ) ) {
		// 	return;
		// }

		$script = '';

		foreach ( $fields as $field ) {

			if ( 'tab' == $field['type'] ) {

				$choices = $field['choices'];
				foreach ( $choices as $choice ) {

					foreach ( $choice['fields'] as $item ) {
						$source      = '#customize-control-' . $item;
						$destination = 'div#tab-' . $field['id'] . '-' . sanitize_key( $choice['label'] );
						$script     .= '$("' . $source . '").appendTo("' . $destination . '");';
					}

				}

			}

		}

		// If there's a script then echo it wrapped.
		if ( ! empty( $script ) ) {
			$script = '$( "kirki-tabs-wrapper" ).tabs();' . $script;
			echo ScriptRegistry::prepare( $script );
		}

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
