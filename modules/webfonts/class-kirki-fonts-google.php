<?php
/**
 * Processes typography-related fields
 * and generates the google-font link.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Manages the way Google Fonts are enqueued.
 */
final class Kirki_Fonts_Google {

	/**
	 * The Kirki_Fonts_Google instance.
	 * We use the singleton pattern here to avoid loading the google-font array multiple times.
	 * This is mostly a performance tweak.
	 *
	 * @access private
	 * @var null|object
	 */
	private static $instance = null;

	/**
	 * If set to true, forces loading ALL variants.
	 *
	 * @static
	 * @access public
	 * @var bool
	 */
	public static $force_load_all_variants = false;

	/**
	 * If set to true, forces loading ALL subsets.
	 *
	 * @static
	 * @access public
	 * @var bool
	 */
	public static $force_load_all_subsets = false;

	/**
	 * The array of fonts
	 *
	 * @access public
	 * @var array
	 */
	public $fonts = array();

	/**
	 * An array of all google fonts.
	 *
	 * @access private
	 * @var array
	 */
	private $google_fonts = array();

	/**
	 * The array of subsets
	 *
	 * @access public
	 * @var array
	 */
	public $subsets = array();

	/**
	 * The class constructor.
	 */
	private function __construct() {

		$config = apply_filters( 'kirki/config', array() );

		// If we have set $config['disable_google_fonts'] to true then do not proceed any further.
		if ( isset( $config['disable_google_fonts'] ) && true === $config['disable_google_fonts'] ) {
			return;
		}

		add_action( 'wp_ajax_kirki_fonts_google_all_get', array( $this, 'get_googlefonts_json' ) );
		add_action( 'wp_ajax_noprinv_kirki_fonts_google_all_get', array( $this, 'get_googlefonts_json' ) );
		add_action( 'wp_ajax_kirki_fonts_standard_all_get', array( $this, 'get_strandardfonts_json' ) );
		add_action( 'wp_ajax_noprinv_kirki_fonts_standard_all_get', array( $this, 'get_strandardfonts_json' ) );

		// Populate the array of google fonts.
		$this->google_fonts = Kirki_Fonts::get_google_fonts();

	}

	/**
	 * Get the one, true instance of this class.
	 * Prevents performance issues since this is only loaded once.
	 *
	 * @return object Kirki_Fonts_Google
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Kirki_Fonts_Google();
		}
		return self::$instance;
	}

	/**
	 * Processes the arguments of a field
	 * determines if it's a typography field
	 * and if it is, then takes appropriate actions.
	 *
	 * @param array $args The field arguments.
	 */
	public function generate_google_font( $args ) {

		// Process typography fields.
		if ( isset( $args['type'] ) && 'kirki-typography' === $args['type'] ) {

			// Get the value.
			$value = Kirki_Values::get_sanitized_field_value( $args );

			// If we don't have a font-family then we can skip this.
			if ( ! isset( $value['font-family'] ) ) {
				return;
			}

			// If not a google-font, then we can skip this.
			if ( ! Kirki_Fonts::is_google_font( $value['font-family'] ) ) {
				return;
			}

			// Set a default value for variants.
			if ( ! isset( $value['variant'] ) ) {
				$value['variant'] = 'regular';
			}
			if ( isset( $value['subsets'] ) ) {

				// Add the subset directly to the array of subsets in the Kirki_GoogleFonts_Manager object.
				// Subsets must be applied to ALL fonts if possible.
				if ( ! is_array( $value['subsets'] ) ) {
					$this->subsets[] = $value['subsets'];
				} else {
					foreach ( $value['subsets'] as $subset ) {
						$this->subsets[] = $subset;
					}
				}
			}

			// Add the requested google-font.
			if ( ! isset( $this->fonts[ $value['font-family'] ] ) ) {
				$this->fonts[ $value['font-family'] ] = array();
			}
			if ( ! in_array( $value['variant'], $this->fonts[ $value['font-family'] ], true ) ) {
				$this->fonts[ $value['font-family'] ][] = $value['variant'];
			}
			// Are we force-loading all variants?
			if ( true === self::$force_load_all_variants ) {
				$all_variants = Kirki_Fonts::get_all_variants();
				$args['choices']['variant'] = array_keys( $all_variants );
			}

			if ( ! empty( $args['choices']['variant'] ) && is_array( $args['choices']['variant'] ) ) {
				foreach ( $args['choices']['variant'] as $extra_variant ) {
					$this->fonts[ $value['font-family'] ][] = $extra_variant;
				}
			}
		} else {

			// Process non-typography fields.
			if ( isset( $args['output'] ) && is_array( $args['output'] ) ) {
				foreach ( $args['output'] as $output ) {

					// If we don't have a typography-related output argument we can skip this.
					if ( ! isset( $output['property'] ) || ! in_array( $output['property'], array( 'font-family', 'font-weight', 'font-subset', 'subset', 'subsets' ), true ) ) {
						continue;
					}

					// Get the value.
					$value = Kirki_Values::get_sanitized_field_value( $args );

					if ( is_string( $value ) ) {
						if ( 'font-family' === $output['property'] ) {
							if ( ! array_key_exists( $value, $this->fonts ) ) {
								$this->fonts[ $value ] = array();
							}
						} elseif ( 'font-weight' === $output['property'] ) {
							foreach ( $this->fonts as $font => $variants ) {
								if ( ! in_array( $value, $variants, true ) ) {
									$this->fonts[ $font ][] = $value;
								}
							}
						} elseif ( 'font-subset' === $output['property'] || 'subset' === $output['property'] || 'subsets' === $output['property'] ) {
							if ( ! is_array( $value ) ) {
								if ( ! in_array( $value, $this->subsets, true ) ) {
									$this->subsets[] = $value;
								}
							} else {
								foreach ( $value as $subset ) {
									if ( ! in_array( $subset, $this->subsets, true ) ) {
										$this->subsets[] = $subset;
									}
								}
							}
						}
					}
				} // End foreach().
			} // End if().
		} // End if().
	}

	/**
	 * Determines the vbalidity of the selected font as well as its properties.
	 * This is vital to make sure that the google-font script that we'll generate later
	 * does not contain any invalid options.
	 */
	public function process_fonts() {

		// Early exit if font-family is empty.
		if ( empty( $this->fonts ) ) {
			return;
		}

		$valid_subsets = array();
		foreach ( $this->fonts as $font => $variants ) {

			// Determine if this is indeed a google font or not.
			// If it's not, then just remove it from the array.
			if ( ! array_key_exists( $font, $this->google_fonts ) ) {
				unset( $this->fonts[ $font ] );
				continue;
			}

			// Get all valid font variants for this font.
			$font_variants = array();
			if ( isset( $this->google_fonts[ $font ]['variants'] ) ) {
				$font_variants = $this->google_fonts[ $font ]['variants'];
			}
			foreach ( $variants as $variant ) {

				// If this is not a valid variant for this font-family
				// then unset it and move on to the next one.
				if ( ! in_array( $variant, $font_variants, true ) ) {
					$variant_key = array_search( $variant, $this->fonts[ $font ], true );
					unset( $this->fonts[ $font ][ $variant_key ] );
					continue;
				}
			}

			// Check if the selected subsets exist, even in one of the selected fonts.
			// If they don't, then they have to be removed otherwise the link will fail.
			if ( isset( $this->google_fonts[ $font ]['subsets'] ) ) {
				foreach ( $this->subsets as $subset ) {
					if ( in_array( $subset, $this->google_fonts[ $font ]['subsets'], true ) ) {
						$valid_subsets[] = $subset;
					}
				}
			}
		}
		$this->subsets = $valid_subsets;
	}

	/**
	 * Gets the googlefonts JSON file.
	 *
	 * @since 3.0.17
	 * @return void
	 */
	public function get_googlefonts_json() {
		include wp_normalize_path( dirname( __FILE__ ) . '/webfonts.json' );
		exit();
	}

	/**
	 * Get the standard fonts JSON.
	 *
	 * @since 3.0.17
	 * @return void
	 */
	public function get_strandardfonts_json() {
		echo wp_json_encode( Kirki_Fonts::get_standard_fonts() ); // WPCS: XSS ok.
		exit();
	}
}
