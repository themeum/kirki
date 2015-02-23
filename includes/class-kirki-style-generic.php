<?php

class Kirki_Style_Generic extends Kirki_Style {

	function __construct() {
		add_filter( 'kirki/styles', array( $this, 'styles' ), 150 );
	}

	function styles( $styles = array() ) {

		global $kirki;
		$controls = $kirki->get_controls();
		$config   = $kirki->get_config();

		foreach ( $controls as $control ) {
			/**
			 * Early exit if this control is a background or a color control.
			 * Background controls are handled in the Kirki_Style_Background class.
			 * Color controls are handled in the Kirki_Style_Color class.
			 */
			if ( 'color' != $control['type'] || 'background' != $control['type'] ) {
				// Only continue if 'output' is set and not an array.
				if ( isset( $control['output'] ) && array( $control['output'] ) ) {

					/**
					 * Only continue if this is not a font control.
					 * Font controls are hndled in the Kirki_Style_Fonts class
					 */
					if ( isset( $control['output']['property'] ) ) {
						$font_properties = array( 'font-family', 'font-size', 'font-weight', 'font-subset' );

						if ( ! in_array( $control['output']['property'], $font_properties ) ) {

							$value = get_theme_mod( $control['setting'], $control['default'] );

							// Do we have a unit specified?
							$units = ( isset( $control['output']['units'] ) ) ? $control['output']['units'] : null;
							// Generate the styles
							if ( isset( $control['output']['element'] ) ) {
								$styles[$control['output']['element']][$control['output']['property']] = $value . $units;
							}

						}

					}

				}

			}

		}

		return $styles;

	}

}
