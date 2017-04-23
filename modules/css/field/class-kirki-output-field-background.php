<?php
/**
 * Handles CSS output for background fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Output overrides.
 */
class Kirki_Output_Field_Background extends Kirki_Output {

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
		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';

		// Background-image.
		if ( isset( $value['background-image'] ) && ! empty( $value['background-image'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['background-image'] = $output['prefix'] . $this->process_property_value( 'background-image', $value['background-image'] ) . $output['suffix'];
		}

		// Background-color.
		if ( isset( $value['background-color'] ) && ! empty( $value['background-color'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['background-color'] = $output['prefix'] . $this->process_property_value( 'background-color', $value['background-color'] ) . $output['suffix'];
		}

		// Background-repeat.
		if ( isset( $value['background-repeat'] ) && ! empty( $value['background-repeat'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['background-repeat'] = $output['prefix'] . $this->process_property_value( 'background-repeat', $value['background-repeat'] ) . $output['suffix'];
		}

		// Background-position.
		if ( isset( $value['background-position'] ) && ! empty( $value['background-position'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['background-position'] = $output['prefix'] . $this->process_property_value( 'background-position', $value['background-position'] ) . $output['suffix'];
		}

		// Background-size.
		if ( isset( $value['background-size'] ) && ! empty( $value['background-size'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['background-size'] = $output['prefix'] . $this->process_property_value( 'background-size', $value['background-size'] ) . $output['suffix'];
		}

		// Background-attachment.
		if ( isset( $value['background-attachment'] ) && ! empty( $value['background-attachment'] ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ]['background-attachment'] = $output['prefix'] . $this->process_property_value( 'background-attachment', $value['background-attachment'] ) . $output['suffix'];
		}
	}
}
