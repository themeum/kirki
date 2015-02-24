<?php

class Kirki_Style_Background {

	function styles( $control, $styles = array() ) {

		// Add support for previous syntax for output (string instead of array)
		$output_element = is_array( $control['output'] ) ? $control['output']['element'] : $control['output'];

		$bg_color    = Kirki_Color::sanitize_hex( get_theme_mod( $control['setting'] . '_color', $control['default']['color'] ) );
		$bg_image    = get_theme_mod( $control['setting'] . '_image', $control['default']['image'] );
		$bg_repeat   = get_theme_mod( $control['setting'] . '_repeat', $control['default']['repeat'] );
		$bg_size     = get_theme_mod( $control['setting'] . '_size', $control['default']['size'] );
		$bg_attach   = get_theme_mod( $control['setting'] . '_attach', $control['default']['attach'] );
		$bg_position = get_theme_mod( $control['setting'] . '_position', $control['default']['position'] );
		$bg_opacity  = get_theme_mod( $control['setting'] . '_opacity', $control['default']['opacity'] );

		if ( false != $control['default']['opacity'] ) {

			$bg_position = get_theme_mod( $control['setting'] . '_opacity', $control['default']['opacity'] );

			// If we're using an opacity other than 100, then convert the color to RGBA.
			if ( 100 != $bg_opacity ) {
				$bg_color = Kirki_Color::get_rgba( $bg_color, $bg_opacity );
			}

		}

		$styles[$output_element]['background-color'] = $bg_color;
		if ( '' != $bg_image ) {
			$styles[$output_element]['background-image']      = url("' . $bg_image . '");
			$styles[$output_element]['background-repeat']     = $bg_repeat;
			$styles[$output_element]['background-size']       = $bg_size;
			$styles[$output_element]['background-attachment'] = $bg_attach;
			$styles[$output_element]['background-position']   = str_replace( '-', ' ', $bg_position );
		}

		return $styles;

	}

}
