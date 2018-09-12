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
		
		if ( !is_array( $value ) || empty( $output['element'] ) ) {
			return;
		}
		
		//fwrite(STDERR, var_export($value,true) . PHP_EOL);
		$value = Kirki_Field_Slider_Advanced::sanitize( $value );
		//var_dump($value);
		if ( isset ( $value['desktop'] ) )
		{
			$breakpoints = [
				'desktop' => '@media screen and (min-width: 992px)',
				'tablet' => '@media screen and (min-width: 768px and max-width: 991px)',
				'mobile' => '@media screen and (max-width: 767px)'
			];
			$devices = [ 
				'desktop' => $value['desktop'], 
				'tablet' => $value['tablet'], 
				'mobile' => $value['mobile'] 
			];
			
			foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device )
			{
				if ( !isset ( $devices[$device] ) )
					break;
				$breakpoint = $breakpoints[$device];
				$device_val = $devices[$device];
				$this->styles[ $breakpoint ][ $output['element'] ][ $output['property'] ] = $device_val['value'] . $device_val['unit'];
			}
		}
		else
		{
			$suffix = isset ( $output['suffix'] ) ? $output['suffix'] : '';
			$this->styles[ 'global' ][ $output['element'] ][ $output['property'] ] = $value['value'] . $suffix;
		}
	}
}