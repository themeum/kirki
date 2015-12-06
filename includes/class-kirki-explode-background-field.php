<?php

class Kirki_Explode_Background_Field extends Kirki_Field_Sanitize {
	/**
	 * Build the background fields.
	 * Takes a single field with type = background and explodes it to multiple controls.
	 *
	 * @param array
	 * @return null|array
	 */
	public static function explode( $field ) {
		$i18n    = Kirki_Toolkit::i18n();
		$choices = self::background_choices();

		// Early exit if this is not a background field.
		if ( 'background' != $field['type'] ) {
			return;
		}

		// Sanitize field
		$field = Kirki_Field_Sanitize::sanitize_field( $field );
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
			$description     = isset( $i18n['background-' . $key] ) ? $i18n['background-' . $key] : '';
			$output_property = 'background-' . $key;
			$label           = ( 0 === $i ) ? $field['label'] : '';
			$type            = 'select';
			$sanitize_callback = 'esc_attr';

			switch ( $key ) {
				case 'color':
					/**
					 * Use 'color-alpha' instead of 'color' if default is an rgba value
					 * or if 'opacity' is set.
					 */
					$type = ( false !== strpos( $field['default']['color'], 'rgba' ) ) ? 'color-alpha' : 'color';
					$type = ( isset( $field['default']['opacity'] ) ) ? 'color-alpha' : $type;
					if ( isset( $field['default']['opacity'] ) && false === strpos( $value, 'rgb' ) ) {
						$value = Kirki_Color::get_rgba( $value, $field['default']['opacity'] );
					}
					$sanitize_callback = array( 'Kirki_Sanitize_Values', 'color' );
					break;
				case 'image':
					$type = 'image';
					$sanitize_callback = 'esc_url_raw';
					break;
				case 'attach':
					/**
					 * Small hack so that background attachments properly work.
					 */
					$output_property = 'background-attachment';
					$description     = $i18n['background-attachment'];
					break;
				default:
					$help = '';
					break;
			}

			/**
			 * If we're using options & option_name is set, then we need to modify the setting.
			 */
			if ( ( isset( $field['option_type'] ) && 'option' == $field['option_type'] && isset( $field['option_name'] ) ) && ! empty( $field['option_name'] ) ) {
				$property_setting = str_replace( ']', '', str_replace( $field['option_name'] . '[', '', $field['settings'] ) );
				$property_setting = esc_attr( $field['option_name'] ) . '[' . esc_attr( $property_setting ) . '_' . $setting . ']';
			} else {
				$property_setting = esc_attr( $field['settings'] ) . '_' . $setting;
			}

			/**
			 * Build the field.
			 * We're merging with the original field here, so any extra properties are inherited.
			 */
			$fields[ $property_setting ] = array_merge( $field, array(
				'type'        => $type,
				'label'       => $label,
				'settings'    => $property_setting,
				'help'        => $help,
				'section'     => $field['section'],
				'priority'    => $field['priority'],
				'required'    => $field['required'],
				'description' => $description,
				'default'     => $value,
				'id'          => Kirki_Field_Sanitize::sanitize_id( array( 'settings' => Kirki_Field_Sanitize::sanitize_settings( array( 'settings' => $field['settings'] . '_' . $setting ) ) ) ),
				'choices'     => isset( $choices[ $key ] ) ? $choices[ $key ] : array(),
				'output'      => ( '' != $field['output'] ) ? array(
					array(
						'element'  => $field['output'],
						'property' => $output_property,
					),
				) : '',
				'sanitize_callback' => ( isset( $sanitize_callback ) ) ? $sanitize_callback : Kirki_Field_Sanitize::fallback_callback( $type ),
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
			/**
			 * Make sure background fields are exploded
			 */
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
