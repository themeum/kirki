<?php

class Kirki_Style_Fonts {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'get_css' ), 150 );
		add_action( 'wp_enqueue_scripts', array( $this, 'google_font' ), 105 );
	}

	function font_builder( $context = 'styles' ) {

		// Get the global config and controls
		global $kirki;
		$controls = $kirki->get_controls();
		$config   = $kirki->get_config();

		// Get an array of all the google fonts
		$google_fonts = Kirki_Fonts::get_google_fonts();

		$css   = '';
		$fonts = array();
		foreach ( $controls as $control ) {

			// The value of this control
			$value = get_theme_mod( $control['setting'], $control['default'] );

			// Early exit if 'output' is not set or not an array.
			if ( ! isset( $control['output'] ) || ! array( $control['output'] ) ) {
				return;
			}

			// Check if this is a font-family control
			$is_font_family = ( strpos( strrev( $control['setting'] ), '_font_family' ) === 0 ) ? true : false;
			// Check if this is a font-size control
			$is_font_size   = ( strpos( strrev( $control['setting'] ), '_font_size' )   === 0 ) ? true : false;
			// Check if this is a font-weight control
			$is_font_weight = ( strpos( strrev( $control['setting'] ), '_font_weight' ) === 0 ) ? true : false;
			// Check if this is a font subset control
			$is_font_subset = ( strpos( strrev( $control['setting'] ), '_font_subset' ) === 0 ) ? true : false;

			if ( $is_font_family ) {

				$control['output']['property'] = ( isset( $control['output']['property'] ) ) ? $control['output']['property'] : 'font-family';

				$control_stripped_property = str_replace( '_font_family', '', $control['setting'] );
				$fonts[$$control_stripped_property]['_font_family'] = $value;
				$css .= $control['output']['element'] . '{' . $control['output']['property'] . 'font-family:' . $value . ';}';

			} else if ( $is_font_size ) {

				$control['output']['property'] = ( isset( $control['output']['property'] ) ) ? $control['output']['property'] : 'font-size';

				// Get the unit we're going to use for the font-size.
				$units = isset( $control['output']['units'] ) ? $control['output']['units'] : 'px';

				$control_stripped_property = str_replace( '_font_size', '', $control['setting'] );
				$fonts[$$control_stripped_property]['_font_size'] = $value;
				$css .= $control['output']['element'] . '{' . $control['output']['property'] . 'font-family:' . $value . ';}';

			} else if ( $is_font_weight ) {

				$control['output']['property'] = ( isset( $control['output']['property'] ) ) ? $control['output']['property'] : 'font-weight';

				$control_stripped_property = str_replace( '_font_weight', '', $control['setting'] );
				$fonts[$$control_stripped_property]['_font_weight'] = $value;
				$css .= $control['output']['element'] . '{' . $control['output']['property'] . 'font-family:' . $value . ';}';

			} else if ( $is_font_subset ) {

				$control_stripped_property = str_replace( '_font_subset', '', $control['setting'] );
				$fonts[$$control_stripped_property]['_font_subset'] = $value;

			}

		}

		$font_families = array();
		$font_weights  = array();
		$font_subsets  = array();

		foreach ( $fonts as $font ) {

			$font_family = isset( $font['_font_family'] ) ? $font['_font_family'] : false;

			if ( Kirki_Fonts::is_google_font( $value ) ) {

				$font_families[] = $font['_font_family'];
				if ( isset( $font_family['_font_weight'] ) ) { $font_weights[] = $font['_font_weight']; }
				if ( isset( $font_family['_font_subset'] ) ) { $font_subsets[] = $font['_font_subset']; }

			}

		}

		$font_families = ( ! empty( $font_families ) ) ? $font_families : false;
		$font_weights  = ( ! empty( $font_weights ) )  ? $font_weights  : 400;
		$font_subsets  = ( ! empty( $font_subsets ) )  ? $font_subsets  : 'all';

		if ( 'styles' == $context ) {
			return $css;
		} else if ( 'google_link' == $context ) {
			return ( $font_families ) ? Kirki_Fonts::get_google_font_uri( $font_families, $font_weights, $font_subsets ) : false;
		}

	}

	function get_css() {

		global $kirki;
		$config = $kirki->get_config();

		$css = $this->font_builder( 'styles' );

		wp_add_inline_style( $config['stylesheet_id'], $css );

	}

	/**
	 * Enqueue Google fonts if necessary
	 */
	function google_font() {

		$google_link = $this->font_builder( 'google_link' );

		if ( $gogle_link ) {
			wp_register_style( 'kirki_google_fonts', $google_link );
			wp_enqueue_style( 'kirki_google_fonts' );
		}

	}

}
