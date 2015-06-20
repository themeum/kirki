<?php

/**
 * Sanitizes all variables from our fields and separates complex fields to their sub-fields.
 */
class Kirki_Field {

	/**
	 * Sanitizes the field
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_field( $field ) {

		$field['settings_raw']      = self::sanitize_settings_raw( $field );
		$field['default']           = self::sanitize_default( $field );
		$field['label']             = self::sanitize_label( $field );
		$field['help']              = self::sanitize_help( $field );
		$field['description']       = self::sanitize_description( $field );
		$field['required']          = self::sanitize_required( $field );
		$field['transport']         = self::sanitize_transport( $field );
		$field['type']              = self::sanitize_control_type( $field );
		$field['option_type']       = self::sanitize_type( $field );
		$field['section']           = self::sanitize_section( $field );
		$field['settings']          = self::sanitize_settings( $field );
		$field['priority']          = self::sanitize_priority( $field );
		$field['choices']           = self::sanitize_choices( $field );
		$field['output']            = self::sanitize_output( $field );
		$field['sanitize_callback'] = self::sanitize_callback( $field );
		$field['js_vars']           = self::sanitize_js_vars( $field );
		$field['id']                = self::sanitize_id( $field );
		$field['capability']        = self::sanitize_capability( $field );
		$field['variables']         = self::sanitize_variables( $field );
		$field['active_callback']   = self::sanitize_active_callback( $field );

		return $field;

	}

	/**
	 * Sanitizes the control type.
	 *
	 * @param array the field definition
	 * @return string If not set, then defaults to text.
	 */
	public static function sanitize_control_type( $field ) {

		if ( ! isset( $field['type'] ) ) {
			return 'text';
		}

		if ( 'checkbox' == $field['type'] ) {

			$field['type'] = ( isset( $field['mode'] ) && 'switch' == $field['mode'] ) ? 'switch' : $field['type'];
			$field['type'] = ( isset( $field['mode'] ) && 'toggle' == $field['mode'] ) ? 'toggle' : $field['type'];

		} elseif ( 'radio' == $field['type'] ) {

			$field['type'] = ( isset( $field['mode'] ) && 'buttonset' == $field['mode'] ) ? 'radio-buttonset' : $field['type'];
			$field['type'] = ( isset( $field['mode'] ) && 'image' == $field['mode'] ) ? 'radio-image' : $field['type'];

		} elseif ( 'group-title' == $field['type'] || 'group_title' == $field['type'] ) {

			$field['type'] = 'custom';

		} elseif ( 'color_alpha' == $field['type'] || ( 'color' == $field['type'] && isset( $field['default'] ) && false !== strpos( $field['default'], 'rgba' ) ) ) {

			$field['type'] = 'color-alpha';

		}

		return esc_attr( $field['type'] );

	}

	/**
	 * Sanitizes the setting type.
	 *
	 * @param array the field definition
	 * @return string (theme_mod|option)
	 */
	public static function sanitize_type( $field ) {
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $field['option_type'] ) ) {
			return esc_attr( $field['option_type'] );
		} else {
			return ( isset( $config['option_type'] ) ) ? esc_attr( $config['option_type'] ) : 'theme_mod';
		}
	}

	/**
	 * Sanitizes the setting variables.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_variables( $field ) {
		return ( isset( $field['variables'] ) && is_array( $field['variables'] ) ) ? $field['variables'] : false;
	}

	/**
	 * Sanitizes the setting active callback.
	 *
	 * @param array the field definition
	 * @return string callable function name.
	 */
	public static function sanitize_active_callback( $field ) {
		return ( isset( $field['active_callback'] ) ) ? $field['active_callback'] : 'kirki_field_active_callback';
	}

	/**
	 * Sanitizes the setting permissions.
	 *
	 * @param array the field definition
	 * @return string (theme_mod|option)
	 */
	public static function sanitize_capability( $field ) {
		if ( ! isset( $field['capability'] ) ) {
			$config = apply_filters( 'kirki/config', array() );
			return isset( $config['capability'] ) ? esc_attr( $config['capability'] ) : 'edit_theme_options';
		} else {
			return esc_attr( $field['capability'] );
		}
	}

	/**
	 * Sanitizes the raw setting name.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_settings_raw( $field ) {

		/**
		 * Compatibility tweak
		 * Previous versions of the Kirki customizer used 'setting' istead of 'settings'.
		 */
		if ( ! isset( $field['settings'] ) && isset( $field['setting'] ) ) {
			$field['settings'] = $field['setting'];
		}

		// Sanitize the field's settings attribute.
		$field['settings'] = sanitize_key( $field['settings'] );

		return $field['settings'];

	}

	/**
	 * Sanitizes the setting name
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_settings( $field ) {

		// If the value of 'option_name' is not empty, then we're also using options instead of theme_mods.
		if ( ( isset( $field['option_name'] ) ) && ! empty( $field['option_name'] ) ) {
			$field['settings'] = esc_attr( $field['option_name'] ).'['.esc_attr( $field['settings'] ).']';
		}

		return $field['settings'];

	}

	/**
	 * Sanitizes the control label.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_label( $field ) {
		return ( isset( $field['label'] ) ) ? esc_html( $field['label'] ) : '';
	}

	/**
	 * Sanitizes the control section
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_section( $field ) {
		return sanitize_key( $field['section'] );
	}

	/**
	 * Sanitizes the control id.
	 * Sanitizing the ID should happen after the 'settings' sanitization.
	 * This way we can also properly handle cases where the option_type is set to 'option'
	 * and we're using an array instead of individual options.
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_id( $field ) {
		$id = str_replace( '[', '-', str_replace( ']', '', $field['settings'] ) );
		return sanitize_key( $id );
	}

	/**
	 * Sanitizes the setting default value
	 *
	 * @param array the field definition
	 * @return mixed
	 */
	public static function sanitize_default( $field ) {

		if ( ! isset( $field['default'] ) ) {
			return '';
		} else {
			if ( is_array( $field['default'] ) ) {
				array_walk_recursive( $field['default'], array( 'Kirki_Field', 'sanitize_defaults_array' ) );
				return $field['default'];
			} else {
				if ( isset( $field['type'] ) && 'custom' != $field['type'] ) {
					return esc_textarea( $field['default'] );
				} else {
					// Return raw & unfiltered for custom controls
					return $field['default'];
				}
			}
		}

	}

	/**
	 * Sanitizes the defaults array.
	 * This is used as a callback function in the sanitize_default method.
	 */
	public static function sanitize_defaults_array( $value = '', $key = '' ) {
		$value = esc_textarea( $value );
		$key   = esc_attr( $key );
	}

	/**
	 * Sanitizes the control description
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_description( $field ) {

		/**
		 * Compatibility tweak
		 *
		 * Previous verions of the Kirki Customizer had the 'description' field mapped to the new 'help'
		 * and instead of 'description' we were using 'subtitle'.
		 * This has been deprecated in favor of WordPress core's 'description' field that was recently introduced.
		 *
		 */
		if ( isset( $field['subtitle'] ) ) {
			$field['description'] = $field['subtitle'];
		}

		return ( isset( $field['description'] ) ) ? wp_strip_all_tags( $field['description'] ) : '';

	}

	/**
	 * Sanitizes the control help
	 *
	 * @param array the field definition
	 * @return string
	 */
	public static function sanitize_help( $field ) {

		/**
		 * Compatibility tweak
		 *
		 * Previous verions of the Kirki Customizer had the 'description' field mapped to the new 'help'
		 * and instead of 'description' we were using 'subtitle'.
		 * This has been deprecated in favor of WordPress core's 'description' field that was recently introduced.
		 *
		 */
		if ( isset( $field['subtitle'] ) ) {
			// Use old arguments form.
			$field['help'] = ( isset( $field['description'] ) ) ? $field['description'] : '';
		}
		return isset( $field['help'] ) ? wp_strip_all_tags( $field['help'] ) : '';

	}

	/**
	 * Sanitizes the control choices.
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_choices( $field ) {
		if ( ! isset( $field['choices'] ) ) {
			return array();
		} else {
			if ( is_array( $field['choices'] ) ) {
				array_walk_recursive( $field['choices'], array( 'Kirki_Field', 'sanitize_defaults_array' ) );
				return $field['choices'];
			} else {
				return esc_attr( $field['choices'] );
			}
		}
	}

	/**
	 * Sanitizes the control output
	 *
	 * @param array the field definition
	 * @return array
	 */
	public static function sanitize_output( $field ) {
		if ( isset( $field['output'] ) ) {
			if ( is_array( $field['output'] ) ) {
				$output_sanitized = array();
				if ( isset( $field['output']['element'] ) ) {
					$output_sanitized[] = array(
						'element'  => ( isset( $field['output']['element'] ) ) ? sanitize_text_field( $field['output']['element'] ) : '',
						'property' => ( isset( $field['output']['property'] ) ) ? sanitize_text_field( $field['output']['property'] ) : '',
						'units'    => ( isset( $field['output']['units'] ) ) ? sanitize_text_field( $field['output']['units'] ) : '',
						'prefix'   => ( isset( $field['output']['prefix'] ) ) ? sanitize_text_field( $field['output']['prefix'] ) : '',
						'suffix'   => ( isset( $field['output']['suffix'] ) ) ? sanitize_text_field( $field['output']['suffix'] ) : '',
					);
				} else {
					foreach ( $field['output'] as $output ) {
						$output_sanitized[] = array(
							'element'  => ( isset( $output['element'] ) ) ? sanitize_text_field( $output['element'] ) : '',
							'property' => ( isset( $output['property'] ) ) ? sanitize_text_field( $output['property'] ) : '',
							'units'    => ( isset( $output['units'] ) ) ? sanitize_text_field( $output['units'] ) : '',
							'prefix'   => ( isset( $output['prefix'] ) ) ? sanitize_text_field( $output['prefix'] ) : '',
							'suffix'   => ( isset( $output['suffix'] ) ) ? sanitize_text_field( $output['suffix'] ) : '',
						);
					}
				}
			} else {
				$output_sanitized = esc_attr( $field['output'] );
			}
		} else {
			$output_sanitized = null;
		}
		return $output_sanitized;
	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param array the field definition
	 * @return string postMessage|refresh (defaults to refresh)
	 */
	public static function sanitize_transport( $field ) {
		return ( isset( $field['transport'] ) && 'postMessage' == $field['transport'] ) ? 'postMessage' : 'refresh';
	}

	/**
	 * Sanitizes the setting sanitize_callback
	 *
	 * @param array the field definition
	 * @return mixed the sanitization callback for this setting
	 */
	public static function sanitize_callback( $field ) {

		if ( isset( $field['sanitize_callback'] ) && ! empty( $field['sanitize_callback'] ) ) {
			return $field['sanitize_callback'];
		} else { // Fallback callback
			return self::fallback_callback( $field['type'] );
		}

	}

	/**
	 * Sanitizes the control js_vars.
	 *
	 * @param array the field definition
	 * @return array|null
	 */
	public static function sanitize_js_vars( $field ) {
		if ( isset( $field['js_vars'] ) && is_array( $field['js_vars'] ) ) {
			$js_vars_sanitized = array();
			if ( isset( $field['js_vars']['element'] ) ) {
				$js_vars_sanitized[] = array(
					'element'  => ( isset( $field['js_vars']['element'] ) ) ? sanitize_text_field( $field['js_vars']['element'] ) : '',
					'function' => ( isset( $field['js_vars']['function'] ) ) ? esc_js( $field['js_vars']['function'] ) : '',
					'property' => ( isset( $field['js_vars']['property'] ) ) ? esc_js( $field['js_vars']['property'] ) : '',
					'units'    => ( isset( $field['js_vars']['units'] ) ) ? esc_js( $field['js_vars']['units'] ) : '',
				);
			} else {
				foreach ( $field['js_vars'] as $js_vars ) {
					$js_vars_sanitized[] = array(
						'element'  => ( isset( $js_vars['element'] ) ) ? sanitize_text_field( $js_vars['element'] ) : '',
						'function' => ( isset( $js_vars['function'] ) ) ? esc_js( $js_vars['function'] ) : '',
						'property' => ( isset( $js_vars['property'] ) ) ? esc_js( $js_vars['property'] ) : '',
						'units'    => ( isset( $js_vars['units'] ) ) ? esc_js( $js_vars['units'] ) : '',
					);
				}
			}
		} else {
			$js_vars_sanitized = null;
		}
		return $js_vars_sanitized;
	}

	/**
	 * Sanitizes the control required argument.
	 *
	 * @param array the field definition
	 * @return array|null
	 */
	public static function sanitize_required( $field ) {
		if ( isset( $field['required'] ) && is_array( $field['required'] ) ) {
			$required_sanitized = array();
			if ( isset( $field['required']['setting'] ) ) {
				$required_sanitized[] = array(
					'setting'  => ( isset( $field['required']['setting'] ) ) ? sanitize_text_field( $field['required']['setting'] ) : '',
					'operator' => ( isset( $field['required']['operator'] ) && in_array( $field['required']['operator'], array( '==', '===', '!=', '!==', '>=', '<=', '>', '<' ) ) ) ? $field['required']['operator'] : '==',
					'value'    => ( isset( $field['required']['value'] ) ) ? sanitize_text_field( $field['required']['value'] ) : true,
				);
			} else {
				foreach ( $field['required'] as $required ) {
					$required_sanitized[] = array(
						'setting'  => ( isset( $required['setting'] ) ) ? sanitize_text_field( $required['setting'] ) : '',
						'operator' => ( isset( $required['operator'] ) && in_array( $required['operator'], array( '==', '===', '!=', '!==', '>=', '<=', '>', '<' ) ) ) ? $required['operator'] : '==',
						'value'    => ( isset( $required['value'] ) ) ? sanitize_text_field( $required['value'] ) : true,
					);
				}
			}
		} else {
			$required_sanitized = null;
		}
		return $required_sanitized;
	}

	/**
	 * Sanitizes the control priority
	 *
	 * @param array the field definition
	 * @return int
	 */
	public static function sanitize_priority( $field ) {

		if ( isset( $field['priority'] ) ) {
			$priority = intval( $field['priority'] );
		}

		if ( isset( $priority ) && '0' != $priority ) {
			return absint( $priority );
		} else {
			return 10;
		}

	}

	/**
	 * Build the background fields.
	 * Takes a single field with type = background and explodes it to multiple controls.
	 */
	public static function build_background_fields( $fields ) {
		$i18n    = Kirki_Toolkit::i18n();
		$choices = self::background_choices();

		foreach ( $fields as $field ) {

			if ( 'background' == $field['type'] ) {

				$expanded_fields = array();

				// Set any unset values to avoid PHP warnings below.
				$field['settings']    = ( ! isset( $field['settings'] ) && isset( $field['setting'] ) ) ? $field['setting'] : $field['settings'];
				$field['section']     = ( isset( $field['section'] ) ) ? $field['section'] : 'background';
				$field['help']        = ( isset( $field['help'] ) ) ? $field['help'] : '';
				$field['description'] = ( isset( $field['description'] ) ) ? $field['description'] : $i18n['background-color'];
				$field['required']    = ( isset( $field['required'] ) ) ? $field['required'] : array();
				$field['transport']   = ( isset( $field['transport'] ) ) ? $field['transport'] : 'refresh';
				$field['default']     = ( isset( $field['default'] ) ) ? $field['default'] : array();
				$field['priority']    = ( isset( $field['priority'] ) ) ? $field['priority'] : 10;
				$field['output']      = ( isset( $field['output'] ) && '' != $field['output'] ) ? $field['output'] : '';

				if ( isset( $field['default']['color'] ) ) {
					$color_mode = ( false !== strpos( $field['default']['color'], 'rgba' ) ) ? 'color-alpha' : 'color';
					if ( isset( $field['default']['opacity'] ) ) {
						$color_mode = 'color-alpha';
					}
					$expanded_fields[] = array(
						'type'        => $color_mode,
						'label'       => isset( $field['label'] ) ? $field['label'] : '',
						'settings'    => $field['settings'].'_color',
						'help'        => $field['help'],
						'description' => $field['description'],
						'default'     => $field['default']['color'],
						'output'      => ( '' != $field['output'] ) ? array(
							array(
								'element'  => $field['output'],
								'property' => 'background-color',
								'callback' => array( 'Kirki_Sanitize', 'color' ),
							),
						) : '',
					);
				}

				if ( isset( $field['default']['image'] ) ) {
					$expanded_fields[] = array(
						'type'        => 'image',
						'settings'    => $field['settings'].'_image',
						'description' => $i18n['background-image'],
						'default'     => $field['default']['image'],
						'output'      => ( '' != $field['output'] ) ? array(
							array(
								'element'  => $field['output'],
								'property' => 'background-image',
								'callback' => 'esc_url_raw',
							),
						) : '',
					);
				}

				if ( isset( $field['default']['repeat'] ) ) {
					$expanded_fields[] = array(
						'type'        => 'select',
						'settings'    => $field['settings'].'_repeat',
						'choices'     => $choices['repeat'],
						'description' => $i18n['background-repeat'],
						'default'     => $field['default']['repeat'],
						'output'      => ( '' != $field['output'] ) ? array(
							array(
								'element'  => $field['output'],
								'property' => 'background-repeat',
								'callback' => 'esc_attr',
							),
						) : '',
					);
				}

				if ( isset( $field['default']['size'] ) ) {
					$expanded_fields[] = array(
						'type'        => 'radio-buttonset',
						'settings'    => $field['settings'].'_size',
						'choices'     => $choices['size'],
						'description' => $i18n['background-size'],
						'default'     => $field['default']['size'],
						'output'      => ( '' != $field['output'] ) ? array(
							array(
								'element'  => $field['output'],
								'property' => 'background-size',
								'callback' => 'esc_attr',
							),
						) : '',
					);
				}

				if ( isset( $field['default']['attach'] ) ) {
					$expanded_fields[] = array(
						'type'        => 'radio-buttonset',
						'settings'    => $field['settings'].'_attach',
						'choices'     => $choices['attach'],
						'description' => $i18n['background-attachment'],
						'default'     => $field['default']['attach'],
						'output'      => ( '' != $field['output'] ) ? array(
							array(
								'element'  => $field['output'],
								'property' => 'background-attachment',
								'callback' => 'esc_attr',
							),
						) : '',
					);
				}

				if ( isset( $field['default']['position'] ) ) {
					$expanded_fields[] = array(
						'type'        => 'select',
						'settings'    => $field['settings'].'_position',
						'choices'     => $choices['position'],
						'description' => $i18n['background-position'],
						'default'     => $field['default']['position'],
						'output'      => ( '' != $field['output'] ) ? array(
							array(
								'element'  => $field['output'],
								'property' => 'background-position',
								'callback' => 'esc_attr',
							),
						) : '',
					);
				}

				foreach ( $expanded_fields as $expanded_field ) {
					$expanded_field['label']     = ( ! isset( $expanded_field['label'] ) ) ? '' : $expanded_field['label'];
					$expanded_field['help']      = ( ! isset( $expanded_field['help'] ) ) ? '' : $expanded_field['help'];
					$expanded_field['section']   = $field['section'];
					$expanded_field['priority']  = $field['priority'];
					$expanded_field['required']  = $field['required'];
					$expanded_field['transport'] = $field['transport'];
					$fields[]     = $expanded_field;
				}

			}

		}

		return $fields;

	}

	/**
	 * The background choices.
	 * @return array
	 */
	public static function background_choices() {

		$i18n = Kirki_Toolkit::i18n();

		$choices = array(
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

		return $choices;
	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param string the control type
	 * @return array|string the function name of a sanitization callback
	 */
	public static function fallback_callback( $field_type ) {

		if ( in_array( $field_type, array( 'checkbox', 'toggle', 'switch' ) ) ) {
			$sanitize_callback = array( 'Kirki_Sanitize', 'checkbox' );
		} elseif ( 'color' == $field_type ) {
			$sanitize_callback = array( 'Kirki_Color', 'sanitize_hex' );
		} elseif ( 'color-alpha' == $field_type ) {
			$sanitize_callback = array( 'Kirki_Sanitize', 'color' );
		} elseif ( in_array( $field_type, array( 'image', 'upload' ) ) ) {
			$sanitize_callback = 'esc_url_raw';
		} elseif ( in_array( $field_type, array( 'radio', 'radio-image', 'radio-buttonset', 'select', 'palette' ) ) ) {
			$sanitize_callback = array( 'Kirki_Sanitize', 'choice' );
		} elseif ( 'dropdown-pages' == $field_type ) {
			$sanitize_callback = array( 'Kirki_Sanitize', 'dropdown_pages' );
		} elseif ( in_array( $field_type, array( 'slider', 'number' ) ) ) {
			$sanitize_callback = array( 'Kirki_Sanitize', 'number' );
		} elseif ( in_array( $field_type, array( 'text', 'textarea', 'editor' ) ) ) {
			$sanitize_callback = 'esc_textarea';
		} elseif ( 'multicheck' == $field_type ) {
			$sanitize_callback = array( 'Kirki_Sanitize', 'multicheck' );
		} elseif ( 'sortable' == $field_type ) {
			$sanitize_callback = array( 'Kirki_Sanitize', 'sortable' );
		} else {
			$sanitize_callback = array( 'Kirki_Sanitize', 'unfiltered' );
		}

		return $sanitize_callback;

	}

}
