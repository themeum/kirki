<?php
/**
 * Handles CSS output for typography fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

/**
 * Output overrides.
 */
class Kirki_Output_Field_Typography extends Kirki_Output {

	/**
	 * Processes a single item from the `output` array.
	 *
	 * @access protected
	 * @param array $output The `output` item.
	 * @param array $value  The field's value.
	 */
	protected function process_output( $output, $value ) {
		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
		$output['element']     = ( isset( $output['element'] ) ) ? $output['element'] : 'body';
		$output['prefix']      = ( isset( $output['prefix'] ) ) ? $output['prefix'] : '';
		$output['suffix']      = ( isset( $output['suffix'] ) ) ? $output['suffix'] : '';

		// Take care of font-families.
		if ( isset( $value['font-family'] ) && ! empty( $value['font-family'] ) ) {
			$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
			$this->styles[ $output['media_query'] ][ $output['element'] ]['font-family'] = $output['prefix'] . $this->process_property_value( 'font-family', $value['font-family'] ) . $output['suffix'];
		}

		// Add support for the older font-weight parameter.
		// This has been deprecated so the code below is just to add some backwards-compatibility.
		// Once a user visits their customizer and make changes to their typography,
		// new values are saved and this one is no longer used.
		if ( isset( $value['font-weight'] ) && ! empty( $value['font-weight'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['font-weight'] = $output['prefix'] . $value['font-weight'] . $output['suffix'];
		}

		// Take care of variants.
		if ( isset( $value['variant'] ) && ! empty( $value['variant'] ) ) {

			// Get the font_weight.
			$font_weight = str_replace( 'italic', '', $value['variant'] );
			$font_weight = ( in_array( $font_weight, array( '', 'regular' ) ) ) ? '400' : $output['prefix'] . $font_weight . $output['suffix'];

			// Is this italic?
			$is_italic = ( false !== strpos( $value['variant'], 'italic' ) );
			$this->styles[ $output['media_query'] ][ $output['element'] ]['font-weight'] = $output['prefix'] . $font_weight . $output['suffix'];
			$font_style = $is_italic ? 'italic' : 'normal' ;
			$this->styles[ $output['media_query'] ][ $output['element'] ]['font-style'] = $output['prefix'] . $font_style . $output['suffix'];
		}

		// Take care of font-size.
		if ( isset( $value['font-size'] ) && ! empty( $value['font-size'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['font-size'] = $output['prefix'] . $value['font-size'] . $output['suffix'];
		}

		// Take care of line-height.
		if ( isset( $value['line-height'] ) && ! empty( $value['line-height'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['line-height'] = $output['prefix'] . $value['line-height'] . $output['suffix'];
		}

		// Take care of letter-spacing.
		if ( isset( $value['letter-spacing'] ) && ( ! empty( $value['letter-spacing'] ) || '0' == $value['letter-spacing'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['letter-spacing'] = $output['prefix'] . $value['letter-spacing'] . $output['suffix'];
		}

		// Take care of word-spacing.
		if ( isset( $value['word-spacing'] ) && ( ! empty( $value['word-spacing'] ) || '0' == $value['word-spacing'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['word-spacing'] = $output['prefix'] . $value['word-spacing'] . $output['suffix'];
		}

		// Take care of text-align.
		if ( isset( $value['text-align'] ) && ! empty( $value['text-align'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['text-align'] = $output['prefix'] . $value['text-align'] . $output['suffix'];
		}

		// Take care of text-transform.
		if ( isset( $value['text-transform'] ) && ! empty( $value['text-transform'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['text-transform'] = $output['prefix'] . $value['text-transform'] . $output['suffix'];
		}

		// Take care of color.
		if ( isset( $value['color'] ) && ! empty( $value['color'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['color'] = $output['prefix'] . $value['color'] . $output['suffix'];
		}
	}
}
