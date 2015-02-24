<?php

class Kirki_Style_Color {

	function styles( $control, $styles = array() ) {

		$color = Kirki_Color::sanitize_hex( get_theme_mod( $control['setting'], $control['default'] ) );
		$styles[$control['output']['element']][$control['output']['property']] = $color;

		return $styles;

	}

}
