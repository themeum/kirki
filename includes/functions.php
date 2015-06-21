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

function kirki_active_callback( $object ) {

	// Get all fields
	$fields = Kirki::$fields;

	if ( ! isset( $fields[ $object->id ] ) ) {
		return true;
	}

	$current_object = $fields[ $object->id ];

	if ( isset( $current_object['required'] ) ) {

		foreach ( $current_object['required'] as $requirement ) {

			if ( ! is_object( $object->manager->get_setting( $fields[ $requirement['setting'] ]['settings'] ) ) ) {
				return true;
			}

			if ( isset( $show ) && ! $show ) {
				return false;
			}

			$value = $object->manager->get_setting( $fields[ $requirement['setting'] ]['settings'] )->value();
			switch ( $requirement['operator'] ) {
				case '===' :
					$show = ( $requirement['value'] === $value ) ? true : false;
					break;
				case '==' :
					$show = ( $requirement['value'] == $value ) ? true : false;
					break;
				case '!==' :
					$show = ( $requirement['value'] !== $value ) ? true : false;
					break;
				case '!=' :
					$show = ( $requirement['value'] != $value ) ? true : false;
					break;
				case '>=' :
					$show = ( $requirement['value'] >= $value ) ? true : false;
					break;
				case '<=' :
					$show = ( $requirement['value'] <= $value ) ? true : false;
					break;
				case '>' :
					$show = ( $requirement['value'] > $value ) ? true : false;
					break;
				case '<' :
					$show = ( $requirement['value'] < $value ) ? true : false;
					break;
				default :
					$show = ( $requirement['value'] == $value ) ? true : false;

			}

		}

	}

	return $show;

}
