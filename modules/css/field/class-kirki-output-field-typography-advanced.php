<?php
/**
 * Handles CSS output for typography fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

/**
 * Output overrides.
 */
class Kirki_Output_Field_Typography_Advanced extends Kirki_Output {

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
		$breakpoints = [
			'global' => 'global',
			'desktop' => '@media screen and (min-width: 992px)',
			'tablet' => '@media screen and (min-width: 768px and max-width: 991px)',
			'mobile' => '@media screen and (max-width: 767px)'
		];
		if ( !$value )
			return;
		
		$value = Kirki_Field_Typography_Advanced::sanitize( $value );
		
		//Output global vars
		foreach ( Kirki_Field_Typography_Advanced::$global_properties as $property )
		{
			// Early exit if the value is not in the defaults.
			if ( ! isset( $this->field['default'][ $property ] ) ) {
				continue;
			}

			// Early exit if the value is not saved in the values.
			if ( ! isset( $value[ $property ] ) || ! $value[ $property ] ) {
				continue;
			}

			// Early exit if we use "choice" but not for this property.
			if ( isset( $output['choice'] ) && $output['choice'] !== $property ) {
				continue;
			}
			
			// Take care of variants.
			if ( 'variant' === $property && isset( $value['variant'] ) && ! empty( $value['variant'] ) ) {

				// Get the font_weight.
				$font_weight = str_replace( 'italic', '', $value['variant'] );
				$font_weight = ( in_array( $font_weight, array( '', 'regular' ), true ) ) ? '400' : $font_weight;

				// Is this italic?
				$is_italic = ( false !== strpos( $value['variant'], 'italic' ) );
				$this->styles['global'][ $output['element'] ]['font-weight'] = $font_weight;
				if ( $is_italic ) {
					$this->styles['global'][ $output['element'] ]['font-style'] = 'italic';
				}
				continue;
			}

			$property_value = $this->process_property_value( $property, $value[ $property ] );
			if ( 'font-family' === $property ) {
				$value['font-backup'] = ( isset( $value['font-backup'] ) ) ? $value['font-backup'] : '';
				$property_value       = $this->process_property_value(
					$property, array(
						$value['font-family'],
						$value['font-backup'],
					)
				);
			}
			$property       = ( isset( $output['choice'] ) && isset( $output['property'] ) ) ? $output['property'] : $property;
			$property_value = ( is_array( $property_value ) && isset( $property_value[0] ) ) ? $property_value[0] : $property_value;
			$this->styles['global'][ $output['element'] ][ $property ] = $output['prefix'] . $property_value . $output['suffix'];
		}
		
		//Now we loop through the media queries.
		foreach ( array( 'global', 'desktop', 'tablet', 'mobile' ) as $device )
		{
			if ( !isset( $value[$device] ) )
				continue;
			$device_value = $value[$device];
			$breakpoint = $breakpoints[$device];
			foreach ( Kirki_Field_Typography_Advanced::$device_properties as $property ) 
			{
				$property_value = $this->process_property_value( $property, $device_value[ $property ] );
				$property       = ( isset( $output['choice'] ) && isset( $output['property'] ) ) ? $output['property'] : $property;
				$property_value = ( is_array( $property_value ) && isset( $property_value[0] ) ) ? $property_value[0] : $property_value;
				$this->styles[ $breakpoint ][ $output['element'] ][ $property ] = $output['prefix'] . $property_value . $output['suffix'];
			}
		}
	}
}
