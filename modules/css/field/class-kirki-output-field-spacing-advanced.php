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
		
		if ( !is_array( $value ) || empty( $output['element'] ) || empty( $output['property'] ) )
			return;
		
		$value       = Kirki_Field_Spacing_Advanced::sanitize( $value );
		$suffix      = isset( $output['suffix'] ) ? $output['suffix'] : '';
		$prefix      = isset( $output['prefix'] ) ? $output['prefix'] : '';
		$units       = isset( $output['units'] ) ? $output['units'] : '';
		$breakpoints = Kirki::get_config_param( $this->field['kirki_config'], 'media_queries' );
		
		if ( $this->field['choices']['use_media_queries'] )
		{
			foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device )
			{
				if ( !isset( $value[$device] ) )
					continue;
				$breakpoint = $breakpoints[$device];
				
				foreach ( array( 'top', 'right', 'bottom', 'left' ) as $side )
				{
					if ( !isset( $value[$device][$side] ) || strlen( $value[$device][$side] ) === 0 )
						continue;
					$output_val = $value[$device][$side];
					if ( isset( $value[$device]['unit'] ) )
						$output_val .= $value[$device]['unit'];
					$this->styles[$breakpoint][ $output['element'] ][ $output['property'] ][ $side ] = $prefix . $output_val . $units . $suffix;;
				}
			}
		}
		else {
			foreach ( array( 'top', 'right', 'bottom', 'left' ) as $side )
			{
				if ( !isset( $value[$side] ) || strlen( $value[$side] ) === 0 )
					continue;
				$output_val = $value[$side];
				if ( isset( $value['unit'] ) )
					$output_val .= $value['unit'];
				$this->styles['global'][ $output['element'] ][ $output['property'] ][ $side ] = $prefix . $output_val . $units . $suffix;
			}
		}
		
	}
}