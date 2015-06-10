<?php

function kirki_path() {
	return KIRKI_PATH;
}

function kirki_url() {
	$config = apply_filters( 'kirki/config', array() );
	if ( isset( $config['url_path'] ) ) {
		return $config['url_path'];
	} else {
		return KIRKI_URL;
	}
}

function kirki_field_active_callback( $control ) {

	// Get all fields
	$fields = Kirki::$fields;

	if ( ! isset( $fields[$control->id] ) ) {
		return true;
	}

	$current_field = $fields[$control->id];

	if ( false != $current_field['required'] ) {

		foreach ( $current_field['required'] as $requirement ) {

			if ( ! is_object( $control->manager->get_setting( $fields[$requirement['setting']]['settings'] ) ) ) {
				return true;
			}

			$show  = false;
			$value = $control->manager->get_setting( $fields[$requirement['setting']]['settings'] )->value();
			switch ( $requirement['operator'] ) {
				case '===' :
					$show = ( $requirement['value'] === $value ) ? true : $show;
					break;
				case '==' :
					$show = ( $requirement['value'] == $value ) ? true : $show;
					break;
				case '!==' :
					$show = ( $requirement['value'] !== $value ) ? true : $show;
					break;
				case '!=' :
					$show = ( $requirement['value'] != $value ) ? true : $show;
					break;
				case '>=' :
					$show = ( $requirement['value'] >= $value ) ? true : $show;
					break;
				case '<=' :
					$show = ( $requirement['value'] <= $value ) ? true : $show;
					break;
				case '>' :
					$show = ( $requirement['value'] > $value )  ? true : $show;
					break;
				case '<' :
					$show = ( $requirement['value'] < $value )  ? true : $show;
					break;
				default :
					$show = ( $requirement['value'] == $value ) ? true : $show;

			}

			if ( ! $show ) {
				return false;
			}

		}

	} else {

		$show = true;

	}

	return $show;

}
