<?php

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
