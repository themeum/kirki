<?php

class Kirki_Style {

	public $style_color;
	public $style_background;
	public $style_font;

	function __construct() {

		$this->style_color      = new Kirki_Style_Color();
		$this->style_background = new Kirki_Style_Background();
		$this->style_font       = new Kirki_Style_Fonts();

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 150 );

	}

	function loop_controls() {

		$controls = apply_filters( 'kirki/controls', array() );
		$styles   = array();

		foreach ( $controls as $control ) {

			// Early exit if 'output' is not defined
			if ( isset( $control['output'] ) ) {

				// Color controls
				if ( 'color' == $control['type'] && is_array( $control['output'] ) ) {
					$styles = $this->style_color->styles( $control, $styles );
				}
				// Background Controls
				elseif ( 'background' == $control['type'] && ! is_null( $control['output'] ) ) {
					$styles = $this->style_background->styles( $control, $styles );
				}
				// Font controls
				elseif ( array( $control['output'] ) && isset( $control['output']['property'] ) && in_array( $control['output']['property'], array( 'font-family', 'font-size', 'font-weight' ) ) ) {
					$styles = $this->style_font->styles( $control, $styles );
				}
				// Generic styles
				elseif ( array( $control['output'] ) ) {

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

		return $styles;

	}

	function enqueue() {

		global $kirki;
		$config = $kirki->get_config();
		wp_add_inline_style( $config['stylesheet_id'], $this->parse() );

	}

	function parse() {

		$styles = $this->loop_controls();
		$css = '';

		// Early exit if styles are empty or not an array
		if ( empty( $styles ) || ! is_array( $styles ) ) {
			return;
		}

		foreach ( $styles as $style => $style_array ) {
			$css .= $style . '{';
			foreach ( $style_array as $property => $value ) {
				$css .= $property . ':' . $value . ';';
			}
			$css .= '}';
		}

		return $css;

	}

}
