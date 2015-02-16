<?php

class Kirki_Style_Color {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_css' ), 150 );
	}

	function add_css() {

		global $kirki;
		$controls = $kirki->get_controls();
		$config   = $kirki->get_config();

		$css = '';
		foreach ( $controls as $control ) {
			$css .= $this->control_css( $control );
		}

		wp_add_inline_style( $config['stylesheet_id'], $css );

	}

	/**
	* Apply custom backgrounds to our page.
	*/
	function control_css( $control ) {

		// Early exit if this is not a background control
		if ( 'color' != $control['type'] ) {
			return;
		}

		// Early exit if 'output' is not set or not an array.
		if ( ! isset( $control['output'] ) || ! array( $control['output'] ) ) {
			return;
		}

		$color    = Kirki_Color::sanitize_hex( get_theme_mod( $control['setting'], $control['default'] ) );

		// Generate the styles
		$styles = $control['output']['element'] . '{' . $control['output']['property'] . ':' . $color . ';}';
		return $styles;

	}

}
