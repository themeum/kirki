<?php
/**
 * Background fields are just lots of sub-fields combined.
 * We have to actually separate the field to its sub-parts
 * and register each one of them separately.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Explodes background fields and creates sub-fields for it.
 */
class Kirki_Explode_Background_Field {

	/**
	 * Build the background fields.
	 * Takes a single field with type = background and explodes it to multiple controls.
	 *
	 * @param array $field The field arguments.
	 * @return null|array
	 */
	public static function explode( $field ) {
		$l10n    = self::l10n( $field['kirki_config'] );
		$choices = self::background_choices( $field );

		// Early exit if this is not a background field.
		if ( 'background' !== $field['type'] ) {
			return;
		}

		// No need to proceed any further if no defaults have been set.
		// We build the array of fields based on what default values have been defined.
		if ( ! isset( $field['default'] ) || ! is_array( $field['default'] ) ) {
			return;
		}

		$fields = array();
		$i      = 0;
		foreach ( $field['default'] as $key => $value ) {

			// No need to process the opacity, it is factored in the color control.
			if ( 'opacity' === $key ) {
				continue;
			}

			$key               = esc_attr( $key );
			$setting           = $key;
			$tooltip           = $field['tooltip'];
			$description       = isset( $l10n[ 'background-' . $key ] ) ? $l10n[ 'background-' . $key ] : '';
			$output_property   = 'background-' . $key;
			$label             = ( 0 === $i ) ? $field['label'] : '';
			$type              = 'select';
			$sanitize_callback = 'esc_attr';

			switch ( $key ) {
				case 'color':
					// Use 'color-alpha' instead of 'color' if default is an rgba value or if 'opacity' is set.
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
					// Small hack so that background attachments properly work.
					$output_property = 'background-attachment';
					$description     = $l10n['background-attachment'];
					break;
				default:
					$tooltip = '';
					break;
			}

			// If we're using options & option_name is set, then we need to modify the setting.
			if ( ( isset( $field['option_type'] ) && 'option' === $field['option_type'] && isset( $field['option_name'] ) ) && ! empty( $field['option_name'] ) ) {
				$property_setting = str_replace( ']', '', str_replace( $field['option_name'] . '[', '', $field['settings'] ) );
				$property_setting = esc_attr( $field['option_name'] ) . '[' . esc_attr( $property_setting ) . '_' . $setting . ']';
			} else {
				$property_setting = esc_attr( $field['settings'] ) . '_' . $setting;
			}

			// Build the field's output element.
			$output_element = $field['output'];
			if ( ! empty( $field['output'] ) ) {
				if ( is_array( $field['output'] ) ) {
					if ( isset( $field['output']['element'] ) ) {
						$output_element = $field['output']['element'];
					} elseif ( isset( $field['output'][0] ) && isset( $field['output'][0]['element'] ) ) {
						$output_element = $field['output'][0]['element'];
					}
				}
			}

			/**
			 * Build the field.
			 * We're merging with the original field here, so any extra properties are inherited.
			 */
			$fields[ $property_setting ] = array_merge( $field, array(
				'type'              => $type,
				'label'             => $label,
				'settings'          => $property_setting,
				'tooltip'           => $tooltip,
				'section'           => $field['section'],
				'priority'          => $field['priority'],
				'required'          => $field['required'],
				'description'       => $description,
				'default'           => $value,
				'id'                => sanitize_key( str_replace( '[', '-', str_replace( ']', '', $property_setting ) ) ),
				'choices'           => isset( $choices[ $key ] ) ? $choices[ $key ] : array(),
				'sanitize_callback' => $sanitize_callback,
				'output'            => ( ! empty( $field['output'] ) ) ? array(
					array(
						'element'  => $output_element,
						'property' => $output_property,
					),
				) : array(),
			) );
			$i++;
		}

		return $fields;

	}

	/**
	 * Parse all fields and add the new background fields
	 *
	 * @param 	array $fields An array of all the generated fields.
	 * @return  array
	 */
	public static function process_fields( $fields ) {

		foreach ( $fields as $field ) {
			/**
			 * Make sure background fields are exploded
			 */
			if ( isset( $field['type'] ) && 'background' === $field['type'] ) {
				$explode = self::explode( $field );
				$fields  = array_merge( $fields, $explode );
			}
		}

		return $fields;

	}


	/**
	 * The background choices.
	 *
	 * @param array $field The field arguments.
	 * @return array<string,array>
	 */
	public static function background_choices( $field ) {

		$l10n = self::l10n( $field['kirki_config'] );

		return array(
			'repeat'        => array(
				'no-repeat' => $l10n['no-repeat'],
				'repeat'    => $l10n['repeat-all'],
				'repeat-x'  => $l10n['repeat-x'],
				'repeat-y'  => $l10n['repeat-y'],
				'inherit'   => $l10n['inherit'],
			),
			'size'        => array(
				'inherit' => $l10n['inherit'],
				'cover'   => $l10n['cover'],
				'contain' => $l10n['contain'],
			),
			'attach'      => array(
				'inherit' => $l10n['inherit'],
				'fixed'   => $l10n['fixed'],
				'scroll'  => $l10n['scroll'],
			),
			'position'          => array(
				'left-top'      => $l10n['left-top'],
				'left-center'   => $l10n['left-center'],
				'left-bottom'   => $l10n['left-bottom'],
				'right-top'     => $l10n['right-top'],
				'right-center'  => $l10n['right-center'],
				'right-bottom'  => $l10n['right-bottom'],
				'center-top'    => $l10n['center-top'],
				'center-center' => $l10n['center-center'],
				'center-bottom' => $l10n['center-bottom'],
			),
		);
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @static
	 * @access protected
	 * @since 2.4.0
	 * @param string|false $config_id The string-ID.
	 * @return array
	 */
	protected static function l10n( $config_id ) {
		$translation_strings = array(
			'background-color'      => esc_attr__( 'Background Color', 'kirki' ),
			'background-image'      => esc_attr__( 'Background Image', 'kirki' ),
			'no-repeat'             => esc_attr__( 'No Repeat', 'kirki' ),
			'repeat-all'            => esc_attr__( 'Repeat All', 'kirki' ),
			'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'kirki' ),
			'repeat-y'              => esc_attr__( 'Repeat Vertically', 'kirki' ),
			'inherit'               => esc_attr__( 'Inherit', 'kirki' ),
			'background-repeat'     => esc_attr__( 'Background Repeat', 'kirki' ),
			'cover'                 => esc_attr__( 'Cover', 'kirki' ),
			'contain'               => esc_attr__( 'Contain', 'kirki' ),
			'background-size'       => esc_attr__( 'Background Size', 'kirki' ),
			'fixed'                 => esc_attr__( 'Fixed', 'kirki' ),
			'scroll'                => esc_attr__( 'Scroll', 'kirki' ),
			'background-attachment' => esc_attr__( 'Background Attachment', 'kirki' ),
			'left-top'              => esc_attr__( 'Left Top', 'kirki' ),
			'left-center'           => esc_attr__( 'Left Center', 'kirki' ),
			'left-bottom'           => esc_attr__( 'Left Bottom', 'kirki' ),
			'right-top'             => esc_attr__( 'Right Top', 'kirki' ),
			'right-center'          => esc_attr__( 'Right Center', 'kirki' ),
			'right-bottom'          => esc_attr__( 'Right Bottom', 'kirki' ),
			'center-top'            => esc_attr__( 'Center Top', 'kirki' ),
			'center-center'         => esc_attr__( 'Center Center', 'kirki' ),
			'center-bottom'         => esc_attr__( 'Center Bottom', 'kirki' ),
			'background-position'   => esc_attr__( 'Background Position', 'kirki' ),
			'background-opacity'    => esc_attr__( 'Background Opacity', 'kirki' ),
		);
		return apply_filters( 'kirki/' . $config_id . '/l10n', $translation_strings );
	}
}
