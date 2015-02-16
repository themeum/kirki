<?php

class Kirki_Style_Generic {

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
	* Apply custom CSS to our page.
	*/
	function control_css( $control ) {

		/**
		 * Early exit if this control is a background or a color control.
		 * Background controls are handled in the Kirki_Style_Background class.
		 * Color controls are handled in the Kirki_Style_Color class.
		 */
		if ( 'color' != $control['type'] && 'background' != $control['type'] ) {
			return;
		}

		// Early exit if 'output' is not set or not an array.
		if ( ! isset( $control['output'] ) || ! array( $control['output'] ) ) {
			return;
		}

		/**
		 * Early exit if this is a font control.
		 * Font controls are hndled in the Kirki_Style_Fonts class
		 */
		if ( isset( $control['output']['property'] ) ) {
			$font_properties = array( 'font-family', 'font-size', 'font-weight', 'font-subset' );

			if ( in_array( $control['output']['property'], $font_properties ) ) {
				return;
			}

		}

		$value = get_theme_mod( $control['setting'], $control['default'] );

		// Do we have a unit specified?
		$units = ( isset( $control['output']['units'] ) ) ? $control['output']['units'] : null;
		// Generate the styles
		if ( isset( $control['output']['element'] ) ) {
			return $control['output']['element'] . '{' . $control['output']['property'] . ':' . $value . $units . ';}';
		} else {
			return null;
		}

	}

}
