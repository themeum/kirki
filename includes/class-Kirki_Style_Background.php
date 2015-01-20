<?php

class Kirki_Style_Background {

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
		if ( 'background' != $control['type'] ) {
			return;
		}

		// Early exit if we have not set the 'output'.
		if ( is_null( $control['output'] ) ) {
			return;
		}

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

		// HTML Background
		$styles = $output_element . '{';
			$styles .= 'background-color:' . $bg_color . ';';

			if ( '' != $bg_image ) {
				$styles .= 'background-image: url("' . $bg_image . '");';
				$styles .= 'background-repeat: ' . $bg_repeat . ';';
				$styles .= 'background-size: ' . $bg_size . ';';
				$styles .= 'background-attachment: ' . $bg_attach . ';';
				$styles .= 'background-position: ' . str_replace( '-', ' ', $bg_position ) . ';';
			}

		$styles .= '}';

		return $styles;

	}

}
