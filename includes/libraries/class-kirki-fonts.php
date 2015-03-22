<?php
/**
 * Theme Customizer Fonts
 *
 * @package 	Customizer_Library
 * @author		The Theme Foundry
 */


class Kirki_Fonts {

	/**
	 * Compile font options from different sources.
	 *
	 * @return array    All available fonts.
	 */
	public static function get_all_fonts() {

		$standard_fonts = self::get_standard_fonts();
		$google_fonts   = self::get_google_fonts();

		return apply_filters( 'kirki/fonts/all', array_merge( $standard_fonts, $google_fonts ) );

	}

	/**
	 * Packages the font choices into value/label pairs for use with the customizer.
	 *
	 * @return array    The fonts in value/label pairs.
	 */
	public static function get_font_choices() {

		$fonts   = self::get_all_fonts();
		$choices = array();

		// Repackage the fonts into value/label pairs
		foreach ( $fonts as $key => $font ) {

			$choices[ $key ] = $font['label'];

		}

		return $choices;

	}

	/**
	 * Detect if this is a google font or not.
	 *
	 * @return boolean
	 */
	public static function is_google_font( $font ) {

		$allowed_fonts = self::get_google_fonts();
		return ( array_key_exists( $font, $allowed_fonts ) ) ? true : false;

	}


	/**
	 * Build the HTTP request URL for Google Fonts.
	 *
	 * @return string    The URL for including Google Fonts.
	 */
	public static function get_google_font_uri( $fonts, $weight = 400, $subset = 'all' ) {

		// De-dupe the fonts
		$fonts         = array_unique( $fonts );
		$allowed_fonts = self::get_google_fonts();
		$family        = array();

		// Validate each font and convert to URL format
		foreach ( $fonts as $font ) {

			$font = trim( $font );

			// Verify that the font exists
			if ( self::is_google_font( $font ) ) {
				// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
				$family[] = urlencode( $font . ':' . join( ',', self::choose_google_font_variants( $font, $allowed_fonts[ $font ]['variants'] ) ) );
			}
		}

		// Convert from array to string
		if ( empty( $family ) ) {

			return '';

		} else {

			$request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );

		}

		// load the font weight
		$weight = ( is_array( $weight ) ) ? implode( ',', $weight ) : $weight;
		$request .= $weight;

		// Load the font subset
		if ( 'all' === $subset ) {

			$subsets_available = self::get_google_font_subsets();
			// Remove the all set
			unset( $subsets_available['all'] );
			// Build the array
			$subsets = array_keys( $subsets_available );

		} else {

			$subsets = (array)$subset;

		}

		// Append the subset string
		$request .= ( ! empty( $subsets ) ) ? '&subset=' . join( ',', $subsets ) : '';

		return esc_url( $request );

	}

	/**
	 * Retrieve the list of available Google font subsets.
	 *
	 * @return array    The available subsets.
	 */
	public static function get_google_font_subsets() {

		return array(
			'all'          => __( 'All', 'kirki' ),
			'cyrillic'     => __( 'Cyrillic', 'kirki' ),
			'cyrillic-ext' => __( 'Cyrillic Extended', 'kirki' ),
			'devanagari'   => __( 'Devanagari', 'kirki' ),
			'greek'        => __( 'Greek', 'kirki' ),
			'greek-ext'    => __( 'Greek Extended', 'kirki' ),
			'khmer'        => __( 'Khmer', 'kirki' ),
			'latin'        => __( 'Latin', 'kirki' ),
			'latin-ext'    => __( 'Latin Extended', 'kirki' ),
			'vietnamese'   => __( 'Vietnamese', 'kirki' ),
		);

	}

	/**
	 * Given a font, chose the variants to load for the theme.
	 *
	 * Attempts to load regular, italic, and 700. If regular is not found, the first variant in the family is chosen. italic
	 * and 700 are only loaded if found. No fallbacks are loaded for those fonts.
	 *
	 * @param  string    $font        The font to load variants for.
	 * @param  array     $variants    The variants for the font.
	 * @return array                  The chosen variants.
	 */
	public static function choose_google_font_variants( $font, $variants = array() ) {

		$chosen_variants = array();

		if ( empty( $variants ) ) {

			$fonts = self::get_google_fonts();
			if ( array_key_exists( $font, $fonts ) ) {
				$variants = $fonts[ $font ]['variants'];
			}

		}

		// If a "regular" variant is not found, get the first variant
		if ( ! in_array( 'regular', $variants ) ) {
			$chosen_variants[] = $variants[0];
		} else {
			$chosen_variants[] = 'regular';
		}

		// Only add "italic" if it exists
		if ( in_array( 'italic', $variants ) ) {
			$chosen_variants[] = 'italic';
		}

		// Only add "700" if it exists
		if ( in_array( '700', $variants ) ) {
			$chosen_variants[] = '700';
		}

		return apply_filters( 'kirki/font/variants', array_unique( $chosen_variants ), $font, $variants );

	}

	/**
	 * Return an array of standard websafe fonts.
	 *
	 * @return array    Standard websafe fonts.
	 */
	public static function get_standard_fonts() {

		return array(
			'serif' => array(
				'label' => _x( 'Serif', 'font style', 'kirki' ),
				'stack' => 'Georgia,Times,"Times New Roman",serif'
			),
			'sans-serif' => array(
				'label' => _x( 'Sans Serif', 'font style', 'kirki' ),
				'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif'
			),
			'monospace' => array(
				'label' => _x( 'Monospaced', 'font style', 'kirki' ),
				'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'
			)
		);

	}


	/**
	 * Validate the font choice and get a font stack for it.
	 *
	 * @param  string    $font    The 1st font in the stack.
	 * @return string             The full font stack.
	 */
	public static function get_font_stack( $font ) {

		$all_fonts = get_all_fonts();

		// Sanitize font choice
		$font = self::sanitize_font_choice( $font );

		$sans = '"Helvetica Neue",sans-serif';
		$serif = 'Georgia, serif';

		// Use stack if one is identified
		if ( isset( $all_fonts[ $font ]['stack'] ) && ! empty( $all_fonts[ $font ]['stack'] ) ) {

			$stack = $all_fonts[ $font ]['stack'];

		} else {

			$stack = '"' . $font . '",' . $sans;

		}

		return $stack;

	}


	/**
	 * Sanitize a font choice.
	 *
	 * @param  string    $value    The font choice.
	 * @return string              The sanitized font choice.
	 */
	public static function sanitize_font_choice( $value ) {

		if ( is_int( $value ) ) {

			// The array key is an integer, so the chosen option is a heading, not a real choice
			return '';

		} else if ( array_key_exists( $value, self::get_font_choices() ) ) {

			return $value;

		} else {

			return '';

		}

	}


	/**
	 * Return an array of all available Google Fonts.
	 *
	 * @return array    All Google Fonts.
	 */
	public static function get_google_fonts() {

		// Get the list of fonts from our json file and convert to an array
		$fonts = json_decode( file_get_contents( KIRKI_PATH . '/assets/json/webfonts.json'), true );

		$googlefonts = array();

		foreach ( $fonts['items'] as $font ) {
			$googlefonts[$font['family']] = array(
				'label'    => $font['family'],
				'variants' => $font['variants'],
				'subsets'  => $font['subsets'],
			);
		}

		return apply_filters( 'kirki/fonts/google_fonts', $googlefonts );

	}

}
