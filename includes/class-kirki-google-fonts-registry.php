<?php
/**
 * Provides access to fonts available for selection in the controls
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Google_Fonts_Registry' ) ) {
	return;
}

class Kirki_Google_Fonts_Registry {

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

		return apply_filters( 'kirki/fonts/all', array_merge( $standard_fonts, $google_fonts ) );
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
	public function is_google_font( $font ) {
		return ( array_key_exists( $font, $this->get_google_fonts() ) );
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
			// Verify that the font exists
			if ( $this->is_google_font( $font ) ) {
				// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
				$family[] = $font . ':' . join( ',', $this->choose_google_font_variants( $font, $allowed_fonts[ $font ]['variants'] ) ) . ',';
			}
		}

		// Convert from array to string
		if ( empty( $family ) ) {
			return '';
		} else {
			$request = str_replace( ' ', '+', '//fonts.googleapis.com/css?family=' . implode( '%7C', $family ) );
		}

		// load the font weight
		$weight   = ( is_array( $weight ) ) ? implode( ',', $weight ) : $weight;
		$request .= trim( $weight );

		// Load the font subset
		if ( 'all' == $subset ) {

			$subsets_available = $this->get_google_font_subsets();
			// Remove the all set
			unset( $subsets_available['all'] );
			// Build the array
			$subsets = array_keys( $subsets_available );

		} else {

			$subsets = (array) $subset;

		}
		$final_subsets = array();
		foreach ( $subsets as $subset ) {
			if ( is_array( $subset ) ) {
				foreach ( $subsets as $subset => $value ) {
					if ( ! is_array( $value ) ) {
						$final_subsets[] = $value;
					} else {
						foreach ( $value as $sub_subset => $sub_value ) {
							$final_subsets[] = $sub_value;
						}
					}
				}
			} else {
				$final_subsets[] = $subset;
			}
		}
		/**
		 * Append the subset string
		 */
		$request .= ( ! empty( $final_subsets ) ) ? '&subset=' . join( ',', $final_subsets ) : '';

		return $request;
	}

	/**
	 * Retrieve the list of available Google font subsets.
	 *
	 * @return array    The available subsets.
	 */
	public function get_google_font_subsets() {

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
	 * Given a font, chose the variants to load for the theme.
	 *
	 * Attempts to load regular, italic, and 700. If regular is not found, the first variant in the family is chosen. italic
	 * and 700 are only loaded if found. No fallbacks are loaded for those fonts.
	 *
	 * @param  string    $font        The font to load variants for.
	 * @param  array     $variants    The variants for the font.
	 * @return array                  The chosen variants.
	 */
	public function choose_google_font_variants( $font, $variants = array() ) {

		$chosen_variants = array();

		if ( empty( $variants ) ) {
			$fonts = $this->get_google_fonts();
			if ( array_key_exists( $font, $fonts ) ) {
				$variants = $fonts[ $font ]['variants'];
			}
		}

		// If a "regular" variant is not found, get the first variant
		$chosen_variants[] = ( ! in_array( 'regular', $variants ) ) ? $variants[0] : 'regular';
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
	public function get_standard_fonts() {

		$i18n = Kirki_Toolkit::i18n();

		if ( null == $this->standard_fonts ) {
			$this->standard_fonts = apply_filters( 'kirki/fonts/standard_fonts', array(
				'serif'     => array(
					'label' => $i18n['serif'],
					'stack' => 'Georgia,Times,"Times New Roman",serif',
				),
				'sans-serif' => array(
					'label'  => $i18n['sans-serif'],
					'stack'  => 'Helvetica,Arial,sans-serif',
				),
				'monospace' => array(
					'label' => $i18n['monospace'],
					'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
				),
			) );
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
			return $all_fonts[ $font ]['stack'];
		}
		return '"' . $font . '",' . $sans;

	}

	/**
	 * Sanitize a font choice.
	 *
	 * @param  string    $value    The font choice.
	 * @return string              The sanitized font choice.
	 */
	public function sanitize_font_choice( $value ) {

		// The array key is an integer, so the chosen option is a heading, not a real choice
		if ( is_int( $value ) ) {
			return '';
		}
		if ( array_key_exists( $value, $this->get_font_choices() ) ) {
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

		global $wp_filesystem;
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if ( empty( $wp_filesystem ) ) {
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		if ( null == $this->google_fonts ) {

			$json = $wp_filesystem->get_contents( Kirki::$path . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'webfonts.json' );
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

			$this->google_fonts = apply_filters( 'kirki/fonts/google_fonts', $google_fonts );

		}

		return $this->google_fonts;

	}

	/**
	 * Return an array of backup fonts based on the font-category
	 *
	 * @return array
	 */
	public function get_backup_fonts() {

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
