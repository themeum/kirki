<?php

class Kirki_Style_Color extends Kirki_Style {

	function __construct() {
		add_filter( 'kirki/styles', array( $this, 'styles' ), 150 );
	}

	function styles( $styles = array() ) {

		global $kirki;
		$controls = $kirki->get_controls();
		$config   = $kirki->get_config();

		foreach ( $controls as $control ) {
			if ( 'color' == $control['type'] && isset( $control['output'] ) && is_array( $control['output'] ) ) {
				$color = Kirki_Color::sanitize_hex( get_theme_mod( $control['setting'], $control['default'] ) );

				$styles[$control['output']['element']][$control['output']['property']] = $color;

			}
		}

		return $styles;

	}

}
