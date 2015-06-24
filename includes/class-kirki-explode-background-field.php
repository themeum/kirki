<?php

class Kirki_Explode_Background_Field extends Kirki_Field {
	/**
	 * Build the background fields.
	 * Takes a single field with type = background and explodes it to multiple controls.
	 *
	 * @param array
	 * @return null|array<Array>
	 */
	public static function explode( $field ) {
		$i18n    = Kirki_Toolkit::i18n();
		$choices = self::background_choices();

		// Early exit if this is not a background field.
		if ( 'background' != $field['type'] ) {
			return;
		}

		// Sanitize field
		$field = Kirki_Field::sanitize_field( $field );
		// No need to proceed any further if no defaults have been set.
		// We build the array of fields based on what default values have been defined.
		if ( ! isset( $field['default'] ) || ! is_array( $field['default'] ) ) {
			return;
		}

		$fields = array();
		$i      = 0;
		foreach ( $field['default'] as $key => $value ) {

			// No need to process the opacity, it is factored in the color control.
			if ( 'opacity' == $key ) {
				continue;
			}

			$key             = esc_attr( $key );
			$setting         = $key;
			$help            = $field['help'];
			$description     = isset( $i18n[ 'background-'.$key ] ) ? $i18n[ 'background-'.$key ] : '';
			$output_property = 'background-'.$key;
			$label           = ( 0 === $i ) ? $field['label'] : '';
			$type            = 'select';

			switch ( $key ) {
				case 'color':
					$type     = ( false !== strpos( $field['default']['color'], 'rgba' ) ) ? 'color-alpha' : 'color';
					$type     = ( isset( $field['default']['opacity'] ) ) ? 'color-alpha' : $type;
					break;
				case 'image':
					$type     = 'image';
					break;
				case 'attach':
					$output_property = 'background-attachment';
					$description     = $i18n['background-attachment'];
					break;
				default:
					$help     = '';
					break;
			}

			$fields[ $field['settings'].'_'.$setting ] = array_merge( $field, array(
				'type'        => $type,
				'label'       => $label,
				'settings'    => $field['settings'].'_'.$setting,
				'help'        => $help,
				'section'     => $field['section'],
				'priority'    => $field['priority'],
				'required'    => $field['required'],
				'description' => $description,
				'default'     => $value,
				'id'          => Kirki_Field::sanitize_id( array( 'settings' => Kirki_Field::sanitize_settings( array( 'settings' => $field['settings'].'_'.$setting ) ) ) ),
				'choices'     => isset( $choices[ $key ] ) ? $choices[ $key ] : array(),
				'output'      => ( '' != $field['output'] ) ? array(
					array(
						'element'  => $field['output'],
						'property' => $output_property,
					),
				) : '',
				'sanitize_callback' => Kirki_Field::fallback_callback( $type ),
			) );
			$i++;
		}

		return $fields;

	}

	/**
	 * Parse all fields and add the new background fields
	 *
	 * @param 	array
	 * @return  array
	 */
	public static function process_fields( $fields ) {
		foreach ( $fields as $field ) {
			if ( isset( $field['type'] ) && 'background' == $field['type'] ) {
				$explode = self::explode( $field );
				$fields  = array_merge( $fields, $explode );
			}
		}
		return $fields;
	}


	/**
	 * The background choices.
	 * @return array<string,array>
	 */
	public static function background_choices() {

		$i18n = Kirki_Toolkit::i18n();

		return array(
			'repeat'        => array(
				'no-repeat' => $i18n['no-repeat'],
				'repeat'    => $i18n['repeat-all'],
				'repeat-x'  => $i18n['repeat-x'],
				'repeat-y'  => $i18n['repeat-y'],
				'inherit'   => $i18n['inherit'],
			),
			'size'        => array(
				'inherit' => $i18n['inherit'],
				'cover'   => $i18n['cover'],
				'contain' => $i18n['contain'],
			),
			'attach'      => array(
				'inherit' => $i18n['inherit'],
				'fixed'   => $i18n['fixed'],
				'scroll'  => $i18n['scroll'],
			),
			'position'          => array(
				'left-top'      => $i18n['left-top'],
				'left-center'   => $i18n['left-center'],
				'left-bottom'   => $i18n['left-bottom'],
				'right-top'     => $i18n['right-top'],
				'right-center'  => $i18n['right-center'],
				'right-bottom'  => $i18n['right-bottom'],
				'center-top'    => $i18n['center-top'],
				'center-center' => $i18n['center-center'],
				'center-bottom' => $i18n['center-bottom'],
			),
		);

	}

}
