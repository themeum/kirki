<?php

if ( ! class_exists( 'Kirki_Fonts_Google' ) ) {
	/**
	 * Manages the way Google Fonts are enqueued.
	 */
	final class Kirki_Fonts_Google {

		private static $instance = null;

		private $fonts = array();
		private $subsets = array();
		private $link = '';

		/**
		 * The class constructor
		 */
		private function __construct() {

			$config = apply_filters( 'kirki/config', array() );
			// If we have set $config['disable_google_fonts'] to true
			// then do not proceed any further.
			if ( isset( $config['disable_google_fonts'] ) && true == $config['disable_google_fonts'] ) {
				return;
			}
			// enqueue link
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
			// go through our fields and populate $this->fonts
			$this->loop_fields();
			// Goes through $this->fonts and adds or removes things as needed.
			$this->process_fonts();
			// Go through $this->fonts and populate $this->link
			$this->create_link();
			// If $this->link is not empty then enqueue it.
			if ( '' != $this->link ) {
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

		private function generate_google_font( $args ) {
			/**
			 * Process typography fields
			 */
			if ( isset( $args['type'] ) && 'typography' == $args['type'] ) {
				// Get the value
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
				// Set a default value for variants
				if ( ! isset( $value['variant'] ) ) {
					$value['variant'] = 'regular';
				}
				if ( isset( $value['subset'] ) ) {
					// Add the subset directly to the array of subsets
					// in the Kirki_GoogleFonts_Manager object.
					// Subsets must be applied to ALL fonts if possible.
					if ( ! is_array( $value['subset'] ) ) {
						$this->subsets[] = $value['subset'];
					} else {
						foreach ( $value['subset'] as $subset ) {
							$this->subsets[] = $subset;
						}
					}
				}
				// Add the requested google-font
				if ( ! isset( $this->fonts[ $value['font-family'] ] ) ) {
					$this->fonts[ $value['font-family'] ] = array();
				}
				if ( ! in_array( $value['variant'], $this->fonts[ $value['font-family'] ] ) ) {
					$this->fonts[ $value['font-family'] ][] = $value['variant'];
				}
			}

			/**
			 * Process non-typography fields
			 */
			else {
				if ( isset( $args['output'] ) && is_array( $args['output'] ) ) {
					foreach ( $args['output'] as $output ) {
						// If we don't have a typography-related output argument we can skip this.
						if ( ! isset( $output['property'] ) || ! in_array( $output['property'], array( 'font-family', 'font-weight', 'font-subset', 'subset' ) ) ) {
							continue;
						}
						// Get the value
						$value = Kirki_Values::get_sanitized_field_value( $args );

						// font-family
						if ( 'font-family' == $output['property'] ) {
							if ( ! array_key_exists( $value, $this->fonts ) ) {
								$this->fonts[ $value ] = array();
							}
						}
						// font-weight
						elseif ( 'font-weight' == $output['property'] ) {
							foreach ( $this->fonts as $font => $variants ) {
								if ( ! in_array( $value, $variants ) ) {
									$this->fonts[ $font ][] = $value;
								}
							}
						}
						// subsets
						elseif ( 'font-subset' == $output['property'] || 'subset' == $output['property'] ) {
							if ( ! is_array( $value ) ) {
								if ( ! in_array( $value, $this->subsets ) ) {
									$this->subsets[] = $value;
								}
							} else {
								foreach ( $value as $subset ) {
									if ( ! in_array( $subset, $this->subsets ) ) {
										$this->subsets[] = $subset;
									}
								}
							}
						}
					}
				}
			}

		}

		private function process_fonts() {
			// Early exit if font-family is empty
			if ( empty( $this->fonts ) ) {
				return;
			}
			// Get an array of all available google fonts
			$google_fonts = Kirki_Fonts::get_google_fonts();

			$valid_subsets = array();
			foreach ( $this->fonts as $font => $variants ) {
				// Determine if this is indeed a google font or not.
				// If it's not, then just remove it from the array.
				if ( ! array_key_exists( $font, $google_fonts ) ) {
					unset( $this->fonts[ $font ] );
					continue;
				}
				// Get all valid font variants for this font
				$font_variants = array();
				if ( isset( $google_fonts[ $font ]['variants'] ) ) {
					$font_variants = $google_fonts[ $font ]['variants'];
				}
				foreach ( $variants as $variant ) {
					// If this is not a valid variant for this font-family
					// then unset it and move on to the next one.
					if ( ! in_array( $variant, $font_variants ) ) {
						unset( $this->fonts[ $font ][ $variant ] );
						continue;
					}
				}
				// Check if the selected subsets exist, even in one of the selected fonts.
				// If they don't, then they have to be removed otherwise the link will fail.
				if ( isset( $google_fonts[ $font ]['subsets'] ) ) {
					foreach ( $this->subsets as $subset ) {
						if ( in_array( $subset, $google_fonts[ $font ]['subsets'] ) ) {
							$valid_subsets[] = $subset;
						}
					}
				}
			}
			$this->subsets = $valid_subsets;
		}

		private function create_link() {
			// If we don't have any fonts then we can exit.
			if ( empty( $this->fonts ) ) {
				return;
			}
			// Get font-family + subsets
			$link_fonts = array();
			foreach ( $this->fonts as $font => $variants ) {
				$variants = implode( ',', $variants );

				$link_font = str_replace( ' ', '+', $font );
				if ( ! empty( $variants ) ) {
					$link_font .= ':' . $variants;
				}
				$link_fonts[] = $link_font;
			}
			$this->link = 'https://fonts.googleapis.com/css?family=';
			$this->link .= implode( '|', $link_fonts );

			if ( ! empty( $this->subsets ) ) {
				$this->link .= '&subset=' . implode( ',', $this->subsets );
			}

		}

	}

}
