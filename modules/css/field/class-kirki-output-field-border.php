<?php
class Kirki_Output_Field_Border extends Kirki_Output {

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
	
	if ( ! is_array( $value ) ) {
		return;
	}

	$border_style = $value['style'];
	if ( empty ( $border_style ) )
		return;

	$color = isset( $value['color'] ) ? $value['color'] : '';

	$border_pos = ['top', 'bottom', 'left', 'right'];

	foreach ( $border_pos as $pos )
	{
		if ( !empty( $value[$pos] ) ){
			$size = $value[$pos];
			$this->styles[ 'global' ][ $output['element'] ]['border-' . $pos] =
				"{$border_style} {$color} {$size}px";
		}
	}
}
}