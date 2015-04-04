<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;
use Kirki\Scripts\ScriptRegistry;

class Tooltips extends EnqueueScript {

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

		echo ScriptRegistry::prepare( $script );

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
