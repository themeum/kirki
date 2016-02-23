<?php

class Kirki_GoogleFonts_Fields_Iterator {

	/**
	 * The one true instance of this object
	 */
	private static $instance = null;

	/**
	 * An array of all our fields
	 */
	private $fields;

	/**
	 * The class constructor.
	 */
	private function __construct() {

		// Get the array of fields from the Kirki object.
		$this->fields = Kirki::$fields;

		// Early exit if no fields are found
		if ( empty( $this->fields ) ) {
			return;
		}

	}

	/**
	 * iterate all our fields and find the ones that need are typography-related.
	 * Typography fields will be processed
	 * and call the Kirki_GoogleFonts_Manager class to add their fonts.
	 * Other typography fields will add their values globally
	 * to the Kirki_GoogleFonts_Manager class.
	 *
	 * @return void
	 */
	public function iterate_fields() {

		foreach ( $this->fields as $field ) {

			/**
			 * Process typography fields
			 */
			if ( isset( $field['type'] ) && 'typography' == $field['type'] ) {
				// Get the value
				$value = Kirki_Values::get_sanitized_field_value( $field );
				// If we don't have a font-family then we can skip this.
				if ( ! isset( $value['font-family'] ) ) {
					continue;
				}
				// Set a default value for font-weight
				if ( ! isset( $value['font-weight'] ) ) {
					$value['font-weight'] = 400;
				}
				if ( isset( $value['subset'] ) ) {
					// Add the subset directly to the array of subsets
					// in the Kirki_GoogleFonts_Manager object.
					if ( ! is_array( $value['subset'] ) ) {
						Kirki_GoogleFonts_Manager::$subsets[] = $value['subset'];
					} else {
						foreach ( $value['subset'] as $subset ) {
							Kirki_GoogleFonts_Manager::$subsets[] = $subset;
						}
					}
				}
				// Get the font-style
				if ( ! isset( $value['font-style'] ) ) {
					$value['font-style'] = 'normal';
				}
				// Add the requested google-font
				Kirki_GoogleFonts_Manager::add_font( $value['font-family'], $value['font-weight'], $value['font-style'] );
				// Add font-weight 700 so that bold works for all fonts
				Kirki_GoogleFonts_Manager::add_font( $value['font-family'], 700, $value['font-style'] );
			}

			/**
			 * Process non-typography fields
			 */
			else {
				if ( isset( $field['output'] ) ) {
					foreach ( $field['output'] as $output ) {
						// If we don't have a typography-related output argument we can skip this.
						if ( ! isset( $output['property'] ) ||  ! in_array( $output['property'], array( 'font-family', 'font-weight', 'font-subset', 'subset', 'font-style' ) ) ) {
							continue;
						}
						// Get the value
						$value = Kirki_Values::get_sanitized_field_value( $field );

						// font-family
						if ( 'font-family' == $output['property'] ) {
							Kirki_GoogleFonts_Manager::add_font( $value );
						}
						// font-weight
						elseif ( 'font-weight' == $output['property'] ) {
							Kirki_GoogleFonts_Manager::$font_weights[] = $value;
						}
						// subsets
						elseif ( 'font-subset' == $output['property'] || 'subset' == $output['property'] ) {
							if ( ! is_array( $value ) ) {
								Kirki_GoogleFonts_Manager::$subsets[] = $value;
							} else {
								foreach ( $value as $subset ) {
									Kirki_GoogleFonts_Manager::$subsets[] = $subset;
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Get the one, true instance of this class.
	 * If $instance is not set then we instantiate the class.
	 *
	 * @return Kirki_GoogleFonts_Fields_Iterator
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}
