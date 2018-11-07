<?php
//TODO: Setup CSS output for spacing advanced.
class Kirki_Output_Field_Spacing_Advanced extends Kirki_Output {
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
				'element'     => '',
				'property'    => ''
			)
		);
		$breakpoints = Kirki::get_config_param( $this->field['kirki_config'], 'media_queries' );
		if ( !is_array( $value ) || empty( $output['element'] ) || empty( $output['property'] ) )
			return;
		
		$value = Kirki_Field_Spacing_Advanced::sanitize( $value );
		if ( isset ( $value['desktop'] ) )
		{
			$devices = [
				'desktop' => $value['desktop'], 
				'tablet' => $value['tablet'], 
				'mobile' => $value['mobile'] 
			];
			
			foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device_name )
			{
				if ( !isset( $devices[$device_name] ) )
					continue;
				$breakpoint = $breakpoints[$device_name];
				$top = $devices[$device_name]['top'];
				$right = $devices[$device_name]['right'];
				$bottom = $devices[$device_name]['bottom'];
				$left = $devices[$device_name]['left'];
				
				$this->styles[$breakpoint][ $output['element'] ][ $output['property'] ] = 
					$top . ' ' . $right . ' ' . $bottom . ' ' . $left;
			}
		}
		else
		{
			if ( !isset( $value['global'] ) )
				return;
			$top = $value['global']['top'];
			$right = $value['global']['right'];
			$bottom = $value['global']['bottom'];
			$left = $value['global']['left'];
			$this->styles['global'][ $output['element'] ][ $output['property'] ] = 
				$top . ' ' . $right . ' ' . $bottom . ' ' . $left;
		}
	}
}