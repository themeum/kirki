<?php

class Kirki_Output_Control_Spacing extends Kirki_Output {

	protected function process_output( $output, $value ) {

		foreach ( $value as $key => $sub_value ) {
			if ( ! isset( $output['property'] ) || empty( $output['property'] ) ) {
				$property = $key;
			} elseif ( false !== strpos( $output['property'], '%%' ) ) {
				$property = str_replace( '%%', $key, $output['property'] );
			} else {
				$property = $output['property'] . '-' . $key;
			}
			$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
			$this->styles[ $output['media_query'] ][ $output['element'] ][ $property ] = $sub_value;
		}

	}

}
