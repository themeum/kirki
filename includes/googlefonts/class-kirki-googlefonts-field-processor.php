<?php

class Kirki_GoogleFonts_Field_Processor extends Kirki_Fonts {

	/**
	 * The one true instance of this object
	 */
	private static $instance = null;

	/**
	 * iterate all our fields and find the ones that need are typography-related.
	 * Typography fields will be processed
	 * and call the Kirki_GoogleFonts_Manager class to add their fonts.
	 * Other typography fields will add their values globally
	 * to the Kirki_GoogleFonts_Manager class.
	 *
	 * @return void
	 */
	public static function generate_google_fonts( $field ) {
		/**
		 * Process typography fields
		 */
		if ( isset( $field['type'] ) && 'typography' == $field['type'] ) {
			// Get the value
			$value = Kirki_Values::get_sanitized_field_value( $field );
			// If we don't have a font-family then we can skip this.
			if ( ! isset( $value['font-family'] ) ) {
				return;
			}
			// Add support for older formats of the typography control.
			// We used to have font-weight instead of variant.
			if ( isset( $value['font-weight'] ) && ! isset( $value['variant'] ) || empty( $value['variant'] ) ) {
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
					Kirki_GoogleFonts_Manager::$subsets[] = $value['subset'];
				} else {
					foreach ( $value['subset'] as $subset ) {
						Kirki_GoogleFonts_Manager::$subsets[] = $subset;
					}
				}
			}
			// Add the requested google-font
			Kirki_GoogleFonts_Manager::add_font( $value['font-family'], $value['variant'] );
			// Add font-weight 700 so that bold works for all fonts
			Kirki_GoogleFonts_Manager::add_font( $value['font-family'], '700' );
			// Any additional font-weights we may need
			foreach ( Kirki_GoogleFonts_Manager::$variants as $variant ) {
				Kirki_GoogleFonts_Manager::add_font( $value['font-family'], $variant );
			}
		}

		/**
		 * Process non-typography fields
		 */
		else {
			if ( isset( $field['output'] ) && is_array( $field['output'] ) ) {
				foreach ( $field['output'] as $output ) {
					// If we don't have a typography-related output argument we can skip this.
					if ( ! isset( $output['property'] ) ||  ! in_array( $output['property'], array( 'font-family', 'font-weight', 'font-subset', 'subset' ) ) ) {
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
						Kirki_GoogleFonts_Manager::$variants[] = $value;
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
