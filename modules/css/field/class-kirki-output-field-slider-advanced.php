<?php
class Kirki_Output_Field_Slider_Advanced extends Kirki_Output {
	/**
	 * Processes a single item from the `output` array.
	 *
	 * @access protected
	 * @param array $output The `output` item.
	 * @param array $value  The field's value.
	 */
	protected function process_output( $output, $value ) {

		$output = wp_parse_args(
			$output, array(
				'element'     => ''
			)
		);
		
		if ( empty( $output['element'] ) )
			return;
		
		$value       = Kirki_Field_Slider_Advanced::sanitize( $value );
		$value       = Kirki_Field_Slider_Advanced::normalize_default( $value, $this->field );
		
		$suffix      = isset( $output['suffix'] ) ? $output['suffix'] : '';
		$prefix      = isset( $output['prefix'] ) ? $output['prefix'] : '';
		$units       = isset( $output['units'] ) ? $output['units'] : '';
		$breakpoints = Kirki::get_config_param( $this->field['kirki_config'], 'media_queries' );
		$has_units   = isset( $this->field['choices']['units'] );
		if ( $has_units )
			$units = '';
		if ( $this->field['choices']['use_media_queries'] )
		{
			foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device )
			{
				if ( !isset ( $value[$device] ) )
					continue;
				$breakpoint = $breakpoints[$device];
				$device_val = '';
				if ( $has_units ) {
					$device_val = $value[$device]['value'] . $value[$device]['unit'];
				}
				else {
					$device_val = $value[$device];
				}
				$this->styles[ $breakpoint ][ $output['element'] ][ $output['property'] ] = $prefix . $device_val . $units . $suffix;
			}
		}
		else
		{
			$output_value = '';
			if ( $has_units || isset( $value['unit'] ) ) {
				$output_value = $value['value'] . $value['unit'];
			}
			else {
				$output_value = $value;
			}
			$this->styles[ 'global' ][ $output['element'] ][ $output['property'] ] = $prefix . $output_value . $units . $suffix;
		}
	}
}