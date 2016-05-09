<?php
/**
 * Processes typography-related fields
 * and generates the google-font link.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_Fonts_Google' ) ) {

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
		 * @access private
		 * @var array
		 */
		private $fonts = array();

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
		 * @access private
		 * @var array
		 */
		private $subsets = array();

		/**
		 * The google link
		 *
		 * @access private
		 * @var string
		 */
		private $link = '';

		/**
		 * The class constructor.
		 */
		private function __construct() {

			$config = apply_filters( 'kirki/config', array() );

			// If we have set $config['disable_google_fonts'] to true then do not proceed any further.
			if ( isset( $config['disable_google_fonts'] ) && true === $config['disable_google_fonts'] ) {
				return;
			}

			// Populate the array of google fonts.
			$this->google_fonts = Kirki_Fonts::get_google_fonts();

			// Enqueue link.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 105 );

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
		 * Calls all the other necessary methods to populate and create the link.
		 */
		public function enqueue() {

			// Go through our fields and populate $this->fonts.
			$this->loop_fields();

			// Goes through $this->fonts and adds or removes things as needed.
			$this->process_fonts();

			// Go through $this->fonts and populate $this->link.
			$this->create_link();

			// If $this->link is not empty then enqueue it.
			if ( '' !== $this->link ) {
				wp_enqueue_style( 'kirki_google_fonts', $this->link, array(), null );
			}
		}

		/**
		 * Goes through all our fields and then populates the $this->fonts property.
		 */
		private function loop_fields() {
			foreach ( Kirki::$fields as $field_id => $args ) {
				$this->generate_google_font( $args );
			}
		}

		/**
		 * Processes the arguments of a field
		 * determines if it's a typography field
		 * and if it is, then takes appropriate actions.
		 *
		 * @param array $args The field arguments.
		 */
		private function generate_google_font( $args ) {

			// Process typography fields.
			if ( isset( $args['type'] ) && 'kirki-typography' === $args['type'] ) {

				// Get the value.
				$value = Kirki_Values::get_sanitized_field_value( $args );

				// If we don't have a font-family then we can skip this.
				if ( ! isset( $value['font-family'] ) ) {
					return;
				}

				// Add support for older formats of the typography control.
				// We used to have font-weight instead of variant.
				if ( isset( $value['font-weight'] ) && ( ! isset( $value['variant'] ) || empty( $value['variant'] ) ) ) {
					$value['variant'] = $value['font-weight'];
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
				}
			}
		}

		/**
		 * Determines the vbalidity of the selected font as well as its properties.
		 * This is vital to make sure that the google-font script that we'll generate later
		 * does not contain any invalid options.
		 */
		private function process_fonts() {

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
						$variant_key = array_search( $variant, $this->fonts[ $font ] );
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
		 * Creates the google-fonts link.
		 */
		private function create_link() {

			// If we don't have any fonts then we can exit.
			if ( empty( $this->fonts ) ) {
				return;
			}

			// Get font-family + subsets.
			$link_fonts = array();
			foreach ( $this->fonts as $font => $variants ) {

				// Are we force-loading all variants?
				if ( true === self::$force_load_all_variants ) {
					if ( isset( $this->google_fonts[ $font ]['variants'] ) ) {
						$variants = $this->google_fonts[ $font ]['variants'];
					}
				}
				$variants = implode( ',', $variants );

				$link_font = str_replace( ' ', '+', $font );
				if ( ! empty( $variants ) ) {
					$link_font .= ':' . $variants;
				}
				$link_fonts[] = $link_font;
			}

			// Are we force-loading all subsets?
			if ( true === self::$force_load_all_subsets ) {

				if ( isset( $this->google_fonts[ $font ]['subsets'] ) ) {
					foreach ( $this->google_fonts[ $font ]['subsets'] as $subset ) {
						$this->subsets[] = $subset;
					}
				}
			}

			if ( ! empty( $this->subsets ) ) {
				$this->subsets = array_unique( $this->subsets );
			}

			$this->link = add_query_arg( array(
				'family' => str_replace( '%2B', '+', urlencode( implode( '|', $link_fonts ) ) ),
				'subset' => urlencode( implode( ',', $this->subsets ) ),
			), 'https://fonts.googleapis.com/css' );

		}
	}
}
