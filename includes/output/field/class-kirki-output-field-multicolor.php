<?php

class Kirki_Output_Field_Multicolor extends Kirki_Output {

	protected function process_output( $output, $value ) {

		foreach ( $value as $key => $sub_value ) {

			// If "choice" is not defined, there's no reason to continue
			if ( ! isset( $output['choice'] ) ) {
				return;
			}

			// If "element" is not defined, there's no reason to continue
			if ( ! isset( $output['element'] ) ) {
				return;
			}

			// If the "choice" is not the same as the $key in our loop, there's no reason to proceed.
			if ( $key != $output['choice'] ) {
				return;
			}

			// If "property" is not defined, fallback to "color".
			$output['property'] = ( ! isset( $output['property'] ) || empty( $output['property'] ) ) ? 'color' : $output['property'] = 'color';

			// If "media_query" is not defined, use "global".
			$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';

			// Create the styles
			$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $sub_value;

		}

	}

}
