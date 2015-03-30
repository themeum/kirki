<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;

class Tooltips extends EnqueueScript {

	/**
	 * Add the help bubble
	 */
	function customize_controls_print_footer_scripts() {

		$controls = Kirki::controls()->get_all();

		$scripts = array();
		$script  = '';

		foreach ( $controls as $control ) {

			if ( ! empty( $control['help'] ) ) {
				$bubble_content = $control['help'];
				$content = "<a href='#' class='tooltip hint--left' data-hint='" . strip_tags( esc_html( $bubble_content ) ) . "'><span class='dashicons dashicons-info'></span></a>";
				$scripts[] = '$( "' . $content . '" ).prependTo( "#customize-control-' . $control['settings'] . '" );';
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

		echo '<script type="text/javascript">jQuery(document).ready(function( $ ) {' . $script . '});</script>';

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
