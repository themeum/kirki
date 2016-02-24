<?php

class Kirki_GoogleFonts_Manager {

	/**
	 * The one true instance of this object
	 */
	private static $instance = null;

	/**
	 * All requested subsets
	 */
	public static $subsets = array();

	/**
	 * The font-families including their font-weights and subsets
	 */
	protected static $fonts = array();

	/**
	 * Get the one, true instance of this class.
	 * If the class has not yet been instantiated then we create a new instance.
	 *
	 * @return Kirki_Google_Fonts_Manager object
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;

	}

	/**
	 * adds a font and specifies its properties
	 */
	public static function add_font( $family = '', $weight = 400, $style = '', $subsets = array( 'latin' ) ) {
		// Early exit if font-family is empty
		if ( '' == $family ) {
			return;
		}

		$google_fonts = Kirki_Fonts::get_google_fonts();

		// Make sure the class is instantiated
		self::get_instance();

		$family = esc_attr( $family );

		// Determine if this is indeed a google font or not.
		$is_google_font = false;
		if ( array_key_exists( $family, $google_fonts ) ) {
			$is_google_font = true;
		}

		// If we're not dealing with a valid google font then we can exit.
		if ( ! $is_google_font ) {
			return;
		}

		// Get all valid font variants for this font
		$font_variants = array();
		if ( isset( $google_fonts[ $family ]['variants'] ) ) {
			$font_variants = $google_fonts[ $family ]['variants'];
		}

		// format the requested variant
		$requested_variant = $weight . $style;

		// Is this a valid variant for this font?
		$variant_is_valid = false;
		if ( in_array( $requested_variant, $font_variants ) ) {
			$variant_is_valid = true;
		}

		// Get all available subsets for this font
		$font_subsets = array();
		if ( isset( $google_fonts[ $family ]['subsets'] ) ) {
			$font_subsets = $google_fonts[ $family ]['subsets'];
		}

		// Get the valid subsets for this font
		$requested_subsets = array_intersect( $subsets, $font_subsets );

		// If this font only has 1 subset, then use it.
		if ( 1 == count( $font_subsets ) ) {
			$requested_subsets = $font_subsets;
		}

		self::$fonts[ $family ] = array(
			'subsets' => $requested_subsets,
		);
		if ( ! isset( self::$fonts[ $family ]['variants'] ) ) {
			self::$fonts[ $family ]['variants'] = array();
		}
		if ( $variant_is_valid ) {
			self::$fonts[ $family ]['variants'][] =$requested_variant;
		}

	}

}
