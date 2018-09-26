<?php
class Kirki_Output_Field_Color_Gradient extends Kirki_Output {
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
				'property'    => 'background-image'
			)
		);
		
		if ( !is_array( $value ) || empty( $output['element'] ) ) {
			return;
		}
		
		if ( !is_array( $output['element'] ) )
			$output['element'] = array( $output['element'] );
		
		$value = Kirki_Field_Color_Gradient::sanitize( $value );
		
		$property = $output['property'];
		$color1 = $value['color1'];
		$color2 = $value['color2'];
		$location = $value['location'];
		$direction = $value['direction'];
		
		foreach ( $output['element'] as $el )
		{
			$this->styles[ 'global' ][ $el ][$property] =
				"linear-gradient({$direction}, {$color1} {$location}, {$color2});";
		}
	}
}