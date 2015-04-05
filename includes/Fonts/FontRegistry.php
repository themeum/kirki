<?php

namespace Kirki\Fonts;

Use Kirki;

/**
 * Class FontManager
 * @package Kirki\Fonts
 *
 *          Provides access to fonts available for selection in the controls
 */
class FontRegistry {

	/** @var array */
	private $standard_fonts = null;

	/** @var array */
	private $google_fonts = null;

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Compile font options from different sources.
	 *
	 * @return array    All available fonts.
	 */
	public function get_all_fonts() {
		$standard_fonts = $this->get_standard_fonts();
		$google_fonts   = $this->get_google_fonts();

		return apply_filters('kirki/fonts/all', array_merge($standard_fonts, $google_fonts));
	}

	/**
	 * Packages the font choices into value/label pairs for use with the customizer.
	 *
	 * @return array    The fonts in value/label pairs.
	 */
	public function get_font_choices() {
		$fonts   = $this->get_all_fonts();
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
	public function is_google_font($font) {
		$allowed_fonts = $this->get_google_fonts();
		return ( array_key_exists( $font, $allowed_fonts ) ) ? true : false;
	}


	/**
	 * Build the HTTP request URL for Google Fonts.
	 *
	 * @return string    The URL for including Google Fonts.
	 */
	public function get_google_font_uri( $fonts, $weight = 400, $subset = 'all' ) {
		// De-dupe the fonts
		$allowed_fonts = $this->get_google_fonts();
		$fonts         = array_unique( $fonts );
		$family        = array();

		// Validate each font and convert to URL format
		foreach ( $fonts as $font ) {
			$font = trim( $font );

			// Verify that the font exists
			if ( $this->is_google_font( $font ) ) {
				// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
				$family[] = urlencode( $font . ':' . join( ',', $this->choose_google_font_variants( $font, $allowed_fonts[ $font ]['variants'] ) ) );
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
			$subsets_available = $this->get_google_font_subsets();

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
	public function get_google_font_subsets() {
		$i18n = Kirki::i18n();
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
	public function choose_google_font_variants($font, $variants = array()) {
		$chosen_variants = array();

		if ( empty( $variants ) ) {
			$fonts = $this->get_google_fonts();
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

		return apply_filters( 'kirki/font/variants', array_unique($chosen_variants), $font, $variants );
	}

	/**
	 * Return an array of standard websafe fonts.
	 *
	 * @return array    Standard websafe fonts.
	 */
	public function get_standard_fonts() {
		$i18n = Kirki::i18n();
		if ($this->standard_fonts==null) {
			$this->standard_fonts = apply_filters('kirki/fonts/standard_fonts', array(
				'serif'      => array(
					'label' => $i18n['serif'],
					'stack' => 'Georgia,Times,"Times New Roman",serif'
				),
				'sans-serif' => array(
					'label' => $i18n['sans-serif'],
					'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif'
				),
				'monospace'  => array(
					'label' => $i18n['monospace'],
					'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'
				)
			));
		}

		return $this->standard_fonts;
	}


	/**
	 * Validate the font choice and get a font stack for it.
	 *
	 * @param  string    $font    The 1st font in the stack.
	 * @return string             The full font stack.
	 */
	public function get_font_stack( $font ) {
		$all_fonts = $this->get_all_fonts();

		// Sanitize font choice
		$font = $this->sanitize_font_choice( $font );
		$sans = '"Helvetica Neue",sans-serif';

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
	public function sanitize_font_choice( $value ) {
		if ( is_int( $value ) ) {
			// The array key is an integer, so the chosen option is a heading, not a real choice
			return '';
		} else if ( array_key_exists( $value, $this->get_font_choices() ) ) {
			return $value;
		}

		return '';
	}

	/**
	 * Return an array of all available Google Fonts.
	 *
	 * @return array    All Google Fonts.
	 */
	public function get_google_fonts() {
		if ($this->google_fonts==null) {
			// Get the list of fonts from our json file and convert to an array
			$fonts = json_decode(file_get_contents(KIRKI_PATH . '/assets/json/webfonts.json'), true);

			$google_fonts = array();
			foreach ($fonts['items'] as $font) {
				$google_fonts[$font['family']] = array(
					'label'    => $font['family'],
					'variants' => $font['variants'],
					'subsets'  => $font['subsets'],
				);
			}

			$this->google_fonts = apply_filters('kirki/fonts/google_fonts', $google_fonts);
		}

		return $this->google_fonts;
	}

}
