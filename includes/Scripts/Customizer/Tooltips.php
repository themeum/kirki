<?php

namespace Kirki\Scripts\Customizer;

use Kirki;

class Tooltips {

	function __construct() {
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'help_tooltip_script' ), 999 );
	}

	/**
	 * Add the help bubble
	 */
	function help_tooltip_script() {

		$controls = Kirki::controls()->get_all();

		$scripts = array();
		$script  = '';

		foreach ( $controls as $control ) {

			if ( ! empty( $control['help'] ) ) {
				$bubble_content = $control['help'];
				$content = "<a href='#' class='button tooltip hint--left' data-hint='" . strip_tags( esc_html( $bubble_content ) ) . "'>?</a>";
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

}
