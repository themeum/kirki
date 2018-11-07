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
		
		if ( !is_array( $value ) || empty( $output['element'] ) )
			return;
		
		$value = Kirki_Field_Slider_Advanced::sanitize( $value );
		$suffix = isset ( $output['suffix'] ) ? $output['suffix'] : '';
		$prefix = isset ( $output['prefix'] ) ? $output['prefix'] : '';
		$breakpoints = Kirki::get_config_param( $this->field['kirki_config'], 'media_queries' );
		if ( isset ( $value['desktop'] ) )
		{
			$devices = [ 
				'desktop' => $value['desktop'], 
				'tablet' => $value['tablet'], 
				'mobile' => $value['mobile'] 
			];
			
			foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device )
			{
				if ( !isset ( $devices[$device] ) )
					continue;
				$breakpoint = $breakpoints[$device];
				$device_val = $devices[$device];
				$this->styles[ $breakpoint ][ $output['element'] ][ $output['property'] ] = $prefix . $device_val . $suffix;
			}
		}
		else
		{
			if ( !isset( $value['global'] ) )
				return;
			$this->styles['global'][ $output['element'] ][ $output['property'] ] = $prefix . $value['global'] . $suffix;
		}
	}
}