<?php

/**
 * Helper function
 *
 * removes an item from an array
 */
function kirki_array_delete( $idx, $array ) {

	unset( $array[$idx] );
	return ( is_array( $array ) ) ? array_values( $array ) : null;

}

/**
 * Get the value of a field.
 */
function kirki_get_option( $option = '' ) {

	// Make sure the class is instanciated
	Kirki::get_instance();

	// Get the array of all the fields.
	$fields = Kirki::fields()->get_all();
	// Get the config.
	$config = Kirki::config()->get_all();

	// If we're using options instead of theme_mods,
	// then first we'll have to get the array of all options.
	if ( 'option' == $config['options_type'] ) {
		$values = array();
		if ( '' == $config['option_name'] ) {
			// No option name is defined.
			// Each options is saved separately in the db, so we'll manually build the array here.
			foreach ( $fields as $field ) {
				$values[$field['settings']] = get_option( $field['settings'], $field['default'] );
			}
		} else {
			// An option_name has been defined so our options are all saved in an array there.
			$values = get_option( $config['option_name'] );
			foreach ( $fields as $field ) {
				if ( ! isset( $values[$field['settings_raw']] ) ) {
					$values[$field['settings_raw']] = maybe_unserialize( $field['default'] );
				}
			}
		}
	}

	if ( '' == $option ) {
		// No option has been defined so we'll get all options and return an array
		// If we're using options then we already have the $values set above.
		// All we need here is a fallback for theme_mods
		if ( 'option' != $config['options_type'] ) {
			// We're using theme_mods
			$values = get_theme_mods();
		}

		// Early exit and return the array of all values
		return $values;

	}

	// If a value has been defined then we proceed.

	// Early exit if this option does not exist
	$field_id = ( 'option' == $config['options_type'] && '' != $config['option_name'] ) ? $config['option_name'] . '[' . $option . ']' : $option;
	if ( ! isset( $fields[$field_id] ) ) {
		return;
	}

	if ( 'option' == $config['options_type'] ) {
		// We're using options instead of theme_mods.
		// We already have the array of values set from above so we'll use that.
		$value  = ( isset( $values[$option] ) ) ? $values[$option] : $fields[$option]['default'];

	} else {
		// We're using theme_mods
		$value = get_theme_mod( $option, $fields[$option]['default'] );

	}

	// Combine background options to a single array
	if ( 'background' == $fields[$field_id]['type'] ) {
		if ( 'option' == $config['options_type'] ) {
			$value = array(
				'background-color'      => isset( $values[$option . '_color'] )    ? $values[$option . '_color']    : null,
				'background-repeat'     => isset( $values[$option . '_repeat'] )   ? $values[$option . '_repeat']   : null,
				'background-attachment' => isset( $values[$option . '_attach'] )   ? $values[$option . '_attach']   : null,
				'background-image'      => isset( $values[$option . '_image'] )    ? $values[$option . '_image']    : null,
				'background-position'   => isset( $values[$option . '_position'] ) ? $values[$option . '_position'] : null,
				'background-clip'       => isset( $values[$option . '_clip'] )     ? $values[$option . '_clip']     : null,
				'background-size'       => isset( $values[$option . '_size'] )     ? $values[$option . '_size']     : null,
			);
		} else {
			$value = array(
				'background-color'      => isset( $fields[$field_id]['default']['color'] )    ? get_theme_mod( $option . '_color',    $fields[$field_id]['default']['color'] )    : null,
				'background-repeat'     => isset( $fields[$field_id]['default']['repeat'] )   ? get_theme_mod( $option . '_repeat',   $fields[$field_id]['default']['repeat'] )   : null,
				'background-attachment' => isset( $fields[$field_id]['default']['attach'] )   ? get_theme_mod( $option . '_attach',   $fields[$field_id]['default']['attach'] )   : null,
				'background-image'      => isset( $fields[$field_id]['default']['image'] )    ? get_theme_mod( $option . '_image',    $fields[$field_id]['default']['image'] )    : null,
				'background-position'   => isset( $fields[$field_id]['default']['position'] ) ? get_theme_mod( $option . '_position', $fields[$field_id]['default']['position'] ) : null,
				'background-clip'       => isset( $fields[$field_id]['default']['clip'] )     ? get_theme_mod( $option . '_clip',     $fields[$field_id]['default']['clip'] )     : null,
				'background-size'       => isset( $fields[$field_id]['default']['size'] )     ? get_theme_mod( $option . '_size',     $fields[$field_id]['default']['size'] )     : null,
			);
		}
	}

	// Return the single value.
	// Pass it through maybe_unserialize so we're sure we get a proper value.
	return maybe_unserialize( $value );

}

/**
 * Load plugin textdomain.
 *
 * @since 0.8.0
 */
function kirki_load_textdomain() {
	$textdomain = 'kirki';

	// Look for WP_LANG_DIR/{$domain}-{$locale}.mo
	if ( file_exists( WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
		$file = WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo';
	}
	// Look for KIRKI_PATH/languages/{$domain}-{$locale}.mo
	if ( ! isset( $file ) && file_exists( KIRKI_PATH . '/languages/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
		$file = KIRKI_PATH . '/languages/' . $textdomain . '-' . get_locale() . '.mo';
	}

	if ( isset( $file ) ) {
		load_textdomain( $textdomain, $file );
	}

	load_plugin_textdomain( $textdomain, false, KIRKI_PATH . '/languages' );
}
add_action( 'plugins_loaded', 'kirki_load_textdomain' );

/**
 * Build the variables.
 *
 * @return string
 */
function kirki_get_variables() {

	// Get all fields
	$fields = Kirki::fields()->get_all();

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
	$fields = Kirki::fields()->get_all();

	$current_field = $fields[$control->id];

	if ( false != $current_field['required'] ) {

		foreach ( $current_field['required'] as $requirement ) {

			$show  = false;
			$value = $control->manager->get_setting( $requirement['setting'] )->value();
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
