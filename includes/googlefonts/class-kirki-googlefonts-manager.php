<?php

class Kirki_GoogleFonts_Manager {

	/**
	 * The one true instance of this object
	 */
	private static $instance = null;

	/**
	 * All google fonts
	 */
	private static $google_fonts = null;

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

	private function __construct() {
		$this->set_google_fonts();
	}

	/**
	 * adds a font and specifies its properties
	 */
	public static function add_font( $family = '', $weight = 400, $style = '', $subsets = array( 'latin' ) ) {
		// Early exit if font-family is empty
		if ( '' == $family ) {
			return;
		}

		// Make sure the class is instantiated
		self::get_instance();

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
		if ( ! isset( self::$fonts[ $family ]['variants'] ) ) {
			self::$fonts[ $family ]['variants'] = array();
		}
		if ( $variant_is_valid ) {
			self::$fonts[ $family ]['variants'][] =$requested_variant;
		}

	}

	/**
	 * Return an array of all available Google Fonts.
	 *
	 * @return array    All Google Fonts.
	 */
	public static function get_google_fonts() {
		return self::$google_fonts;
	}

	/**
	 * Sets the $google_fonts property
	 */
	private function set_google_fonts() {

		global $wp_filesystem;
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if ( empty( $wp_filesystem ) ) {
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		if ( null == self::$google_fonts ) {

			$json_path = wp_normalize_path( dirname( dirname( dirname( __FILE__ ) ) ) . '/assets/json/webfonts.json' );
			$json      = $wp_filesystem->get_contents( $json_path );
			// Get the list of fonts from our json file and convert to an array
			$fonts = json_decode( $json, true );

			$google_fonts = array();
			if ( is_array( $fonts ) ) {
				foreach ( $fonts['items'] as $font ) {
					$google_fonts[ $font['family'] ] = array(
						'label'    => $font['family'],
						'variants' => $font['variants'],
						'subsets'  => $font['subsets'],
						'category' => $font['category'],
					);
				}
			}

		}

		self::$google_fonts = apply_filters( 'kirki/fonts/google_fonts', $google_fonts );

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

}
