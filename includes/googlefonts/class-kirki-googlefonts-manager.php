<?php

class Kirki_GoogleFonts_Manager {

	/**
	 * The one true instance of this object
	 */
	private static $instance = null;

	/**
	 * All google fonts
	 */
	private static $google_fonts;

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

	private function __construct() {
		self::$google_fonts = Kirki()->font_registry->get_google_fonts();
	}

	/**
	 * adds a font and specifies its properties
	 */
	public static function add_font( $family = '', $weight = 400, $style = '', $subsets = array( 'latin' ) ) {
		// Early exit if font-family is empty
		if ( '' == $family ) {
			return;
		}
		$family = esc_attr( $family );

		// Determine if this is indeed a google font or not.
		$is_google_font = false;
		if ( array_key_exists( $family, self::$google_fonts ) ) {
			$is_google_font = true;
		}

		// If we're not dealing with a valid google font then we can exit.
		if ( ! $is_google_font ) {
			return;
		}

		// Get all valid font variants for this font
		$font_variants = array();
		if ( isset( self::$google_fonts[ $family ]['variants'] ) ) {
			$font_variants = self::$google_fonts[ $family ]['variants'];
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
		if ( isset( self::$google_fonts[ $family ]['subsets'] ) ) {
			$font_subsets = self::$google_fonts[ $family ]['subsets'];
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
		if ( $variant_is_valid ) {
			self::$fonts[ $family ]['variants'][] =$requested_variant;
		}

	}

	public static function get_all_subsets() {
		$i18n = Kirki_Toolkit::i18n();
		return array(
			'all'          => $i18n['all'],
			'cyrillic'     => $i18n['cyrillic'],
			'cyrillic-ext' => $i18n['cyrillic-ext'],
			'devanagari'   => $i18n['devanagari'],
			'greek'        => $i18n['greek'],
			'greek-ext'    => $i18n['greek-ext'],
			'khmer'        => $i18n['khmer'],
			'latin'        => $i18n['latin'],
			'latin-ext'    => $i18n['latin-ext'],
			'vietnamese'   => $i18n['vietnamese'],
			'hebrew'       => $i18n['hebrew'],
			'arabic'       => $i18n['arabic'],
			'bengali'      => $i18n['bengali'],
			'gujarati'     => $i18n['gujarati'],
			'tamil'        => $i18n['tamil'],
			'telugu'       => $i18n['telugu'],
			'thai'         => $i18n['thai'],
		);
	}

	/**
	 * Return an array of backup fonts based on the font-category
	 *
	 * @return array
	 */
	public static function get_backup_fonts() {

		$backup_fonts = array(
			'sans-serif'  => 'Helvetica, Arial, sans-serif',
			'serif'       => 'Georgia, serif',
			'display'     => '"Comic Sans MS", cursive, sans-serif',
			'handwriting' => '"Comic Sans MS", cursive, sans-serif',
			'monospace'   => '"Lucida Console", Monaco, monospace',
		);
		return apply_filters( 'kirki/fonts/backup_fonts', $backup_fonts );

	}

}
