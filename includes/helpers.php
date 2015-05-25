<?php


/**
 * Build the variables.
 *
 * @return string
 */
function kirki_get_variables() {

	// Get all fields
	$fields = Kirki_Toolkit::fields()->get_all();

	$variables = array();

	foreach ( $fields as $field ) {

		if ( false != $field['variables'] ) {

			foreach ( $field['variables'] as $field_variable ) {

				if ( isset( $field_variable['name'] ) ) {
					$variable_name     = esc_attr( $field_variable['name'] );
					$variable_callback = ( isset( $field_variable['callback'] ) && is_callable( $field_variable['callback'] ) ) ? $field_variable['callback'] : false;

					if ( $variable_callback ) {
						$variables[$field_variable['name']] = call_user_func( $field_variable['callback'], kirki_get_option( $field['settings'] ) );
					} else {
						$variables[$field_variable['name']] = kirki_get_option( $field['settings'] );
					}

				}

			}

		}

	}

	$variables_final = '';
	foreach ( $variables as $variable_name => $value ) {
		$variables_final .= $variable_name . ': ' . $value . '; ';
	}

	return $variables_final;

}

function kirki_field_active_callback( $control ) {

	// Get all fields
	$fields = Kirki_Toolkit::fields()->get_all();

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
