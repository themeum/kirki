<?php

if ( ! class_exists( 'Kirki_Field' ) ) {
	class Kirki_Field {

		private $args = null;

		public function __construct( $config_id = 'global', $args = array() ) {
			$this->add_field( $config_id, $args );;
		}

		private function add_field( $config_id = 'global', $args = array() ) {

			$defaults = array(
				'kirki_config'    => 'global',
				'capability'      => 'edit_theme_options',
				'option_name'     => '',
				'disable_output'  => false,
				'choices'         => array(),
				'output'          => array(),
				'variables'       => null,
				'option_type'     => 'theme_mod',
				'tooltip'         => '',
				'active_callback' => '__return_true',
				'type'            => 'kirki-generic',
			);

			// Sanitize $config_id
			$args      = $this->sanitize_config_id( $config_id, $args );
			$config_id = $args['kirki_config'];

			// Get the config arguments
			$config = Kirki::$config[ $config_id ];

			$calls = array(
				'sanitize_option_name',
				'sanitize_option_type',
				'sanitize_capability',
				'sanitize_settings',
				'sanitize_tooltip',
				'sanitize_active_callback',
				'sanitize_control_type',
				'sanitize_callback',
				'sanitize_id',
			);

			foreach ( $calls as $call ) {
				$args = $this->$call( $args );
			}

			$args = wp_parse_args( $args, $defaults );

			// Get the 'disable_output' argument from the config
			$args['disable_output'] = $config['disable_output'];

			// Add the field to the static $fields variable properly indexed
			Kirki::$fields[ $args['settings'] ] = $args;

			if ( 'background' == $args['type'] ) {
				// Build the background fields
				Kirki::$fields = Kirki_Explode_Background_Field::process_fields( Kirki::$fields );
			}

		}

		/**
		 * Gets the $config_id and $args specified in the field,
		 * and then checks the validity of $config_id.
		 * If $config_id is not valid, then fallback to using the 'global' config.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_config_id( $config_id = 'global', $args = array() ) {

			// Check if 'kirki_config' has been defined inside the $args.
			// In that case, it will override the $config.
			if ( isset( $args['kirki_config'] ) ) {
				$config_id = $args['kirki_config'];
			}
			// If $args is not used, then assume that $config_id took its place
			if ( is_array( $config_id ) && empty( $args ) ) {
				$args      = $config_id;
				$config_id = 'global';
			}
			// If $config_id is empty, use global config.
			if ( empty( $config_id ) ) {
				$config_id = 'global';
			}
			// If the defined config does not exist, use global.
			if ( ! isset( Kirki::$config[ $config_id ] ) ) {
				$config_id = 'global';
			}
			// Sanitize $config_id using the esc_attr() function
			$args['kirki_config'] = esc_attr( $config_id );

			return $args;

		}

		/**
		 * Sanitizes the setting name.
		 *
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_option_name( $args = array() ) {

			if ( isset( Kirki::$config[ $args['kirki_config'] ]['option_name'] ) ) {
				// use from config if not defined in the option
				$defaults = array(
					'option_name' => Kirki::$config[ $args['kirki_config'] ]['option_name'],
				);
				$args = wp_parse_args( $args, $defaults );
				// escape value
				$args['option_name'] = esc_attr( $args['option_name'] );
			}

			return $args;

		}

		/**
		 * Sanitizes the capability.
		 *
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_capability( $args = array() ) {

			// If an capability has not been defined in the field itself,
			// Then fallback to the capability from the field's config.
			if ( isset( Kirki::$config[ $args['kirki_config'] ]['capability'] ) ) {
				$defaults = array(
					'capability' => Kirki::$config[ $args['kirki_config'] ]['capability'],
				);
				$args = wp_parse_args( $args, $defaults );
			}
			// escape the value
			$args['capability'] = esc_attr( $args['capability'] );

			return $args;

		}

		/**
		 * Sanitizes the option_type
		 *
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_option_type( $args = array() ) {

			// If we have an option_name
			// then make sure we're using options and not theme_mods
			if ( '' != $args['option_name'] ) {
				$args['option_type'] = 'option';
			}

			// if no option_type has been defined for this field
			// Then try to get it from the config.
			// Fallback to "theme_mod"
			$defaults = array( 'option_type' => 'theme_mod' );
			if ( isset( Kirki::$config[ $args['kirki_config'] ]['option_type'] ) ) {
				$defaults = array( 'option_type' => Kirki::$config[ $args['kirki_config'] ]['option_type'] );
			}
			$args = wp_parse_args( $args, $defaults );

			// escape the value
			$args['option_type'] = esc_attr( $args['option_type'] );

			return $args;

		}

		/**
		 * Sanitizes the settings.
		 *
		 * @param   array   $args
		 * @return  string|array
		 */
		private function sanitize_settings( $args = array() ) {

			// Check for typos:
			// If the user has entered "setting" instead of "settings",
			// then use "setting" instead. It's a pretty common mistake
			// So we'll be accomodating.
			if ( ! isset( $args['settings'] ) && isset( $args['setting'] ) ) {
				$args['settings'] = $args['setting'];
				unset( $args['setting'] );
			}
			// If we have an array of settings then we need to sanitize each of them
			if ( is_array( $args['settings'] ) ) {
				$settings = array();
				foreach ( $args['settings'] as $setting_key => $setting_value ) {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $setting_value );
					// If we're using serialized options then we need to spice this up
					if ( 'option' == $args['option_type'] && '' != $args['option_name'] && ( false === strpos( $setting_key, '[' ) ) ) {
						$settings[ sanitize_key( $setting_key ) ] = esc_attr( $args['option_name'] ).'['.esc_attr( $setting_value ).']';
					} else {
						$settings[ sanitize_key( $setting_key ) ] = esc_attr( $setting_value );
					}
				}
				$args['settings'] = $settings;
			} else {
				if ( 'option' == $args['option_type'] && '' != $args['option_name'] && ( false === strpos( $args['settings'], '[' ) ) ) {
					// If we're using serialized options then we need to spice this up just like before.
					$args['settings'] = esc_attr( $args['option_name'] ) . '[' . esc_attr( $args['settings'] ) . ']';
				} else {
					$args['settings'] = esc_attr( $args['settings'] );
				}
			}

			return $args;

		}

		/**
		 * Sanitizes the tooltip message
		 *
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_tooltip( $args = array() ) {

			if ( isset( $args['tooltip'] ) ) {
				$args['tooltip'] = wp_strip_all_tags( $args['tooltip'] );
			} elseif ( isset( $args['help'] ) ) {
				$args['tooltip'] = wp_strip_all_tags( $args['help'] );
				unset( $args['help'] );
			}

			return $args;

		}

		/**
		 * Sanitizes the active_callback
		 *
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_active_callback( $args = array() ) {

			// Use our evaluation method as fallback if required argument is defined.
			if ( isset( $args['required'] ) ) {
				$defaults = array( 'active_callback' => array( 'Kirki_Active_Callback', 'evaluate' ) );
				$args = wp_parse_args( $args, $defaults );
			}

			// Make sure the function is callable, otherwise fallback to __return_true
			if ( isset( $args['active_callback'] ) && ! is_callable( $args['active_callback'] ) ) {
				$args['active_callback'] = '__return_true';
			}

			return $args;

		}

		/**
		 * Sanitizes the control type.
		 *
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_control_type( $args = array() ) {

			$defaults = array( 'type' => 'kirki-generic' );

			switch ( $args['type'] ) {

				case 'checkbox':
					$args['type'] = 'kirki-checkbox';
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 switch & toggle were part of the checkbox control.
					if ( isset( $args['mode'] ) && 'switch' == $args['mode'] ) {
						$args['type'] = 'switch';
					} elseif ( isset( $args['mode'] ) && 'toggle' == $args['mode'] ) {
						$args['type'] = 'toggle';
					}
					break;
				case 'radio':
					$args['type'] = 'kirki-radio';
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 radio-buttonset & radio-image were part of the checkbox control.
					if ( isset( $args['mode'] ) && 'buttonset' == $args['mode'] ) {
						$args['type'] = 'radio-buttonset';
					} elseif ( isset( $args['mode'] ) && 'image' == $args['mode'] ) {
						$args['type'] = 'radio-image';
					}
					break;
				case 'group-title':
				case 'group_title':
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 there was a group-title control.
					// Instead we now just use a "custom" control.
					$args['type'] = 'custom';
					break;
				case 'color-alpha':
				case 'color_alpha':
					// Just making sure that common mistakes will still work.
					$args['type'] = 'color-alpha';
					$args['choices']['alpha'] = true;
					break;
				case 'color':
					$args['type'] = 'color-alpha';
					$args['choices']['alpha'] = false;
					// If a default value of rgba() is defined for a color control then we need to enable the alpha channel.
					if ( isset( $args['default'] ) && false !== strpos( $args['default'], 'rgba' ) ) {
						$args['choices']['alpha'] = true;
					}
					break;
				case 'select':
				case 'select2':
				case 'select2-multiple':
					if ( 'select2-multiple' == $args['type'] ) {
						$args['multiple'] = 999;
					} else {
						$args['multiple'] = ( isset( $args['multiple'] ) ) ? intval( $args['multiple'] ) : 1;
					}
					$args['type'] = 'kirki-select';
					break;
				case 'textarea':
					$args['type']               = 'kirki-generic';
					$args['choices']['element'] = 'textarea';
					$args['choices']['rows']    = '5';
					if ( ! isset( $args['sanitize_callback'] ) ) {
						$args['sanitize_callback'] = 'wp_kses_post';
					}
					break;
				case 'text':
					$args['type']               = 'kirki-generic';
					$args['choices']['element'] = 'input';
					$args['choices']['type']    = 'text';
					if ( ! isset( $args['sanitize_callback'] ) ) {
						$args['sanitize_callback'] = 'wp_kses_post';
					}
					break;
				case 'kirki-generic':
					if ( ! isset( $args['choices']['element'] ) ) {
						$args['choices']['element'] = 'input';
					}
					break;
			}

			$args = wp_parse_args( $args, $defaults );

			// escape the control type
			$args['type'] = esc_attr( $args['type'] );

			return $args;

		}

		/**
		 * Sanitizes the control id.
		 * Sanitizing the ID should happen after the 'settings' sanitization.
		 * This way we can also properly handle cases where the option_type is set to 'option'
		 * and we're using an array instead of individual options.
		 *
		 * @param   array   $args
		 * @return  string
		 */
		private function sanitize_id( $args = array() ) {
			$args['id'] = sanitize_key( str_replace( '[', '-', str_replace( ']', '', $args['settings'] ) ) );
			return $args;
		}

		/**
		 * Sanitizes the setting sanitize_callback
		 *
		 * @param   array   $args
		 * @return  string|array
		 */
		private function sanitize_callback( $args = array() ) {

			$default_callbacks = array(
				'checkbox'         => array( 'Kirki_Sanitize_Values', 'checkbox' ),
				'toggle'           => array( 'Kirki_Sanitize_Values', 'checkbox' ),
				'switch'           => array( 'Kirki_Sanitize_Values', 'checkbox' ),
				'color'            => array( 'Kirki_Sanitize_Values', 'color' ),
				'color-alpha'      => array( 'Kirki_Sanitize_Values', 'color' ),
				'image'            => 'esc_url_raw',
				'upload'           => 'esc_url_raw',
				'radio'            => 'esc_attr',
				'radio-image'      => 'esc_attr',
				'radio-buttonset'  => 'esc_attr',
				'palette'          => 'esc_attr',
				'select'           => array( 'Kirki_Sanitize_Values', 'unfiltered' ),
				'select2'          => array( 'Kirki_Sanitize_Values', 'unfiltered' ),
				'select2-multiple' => array( 'Kirki_Sanitize_Values', 'unfiltered' ),
				'dropdown-pages'   => array( 'Kirki_Sanitize_Values', 'dropdown_pages' ),
				'slider'           => array( 'Kirki_Sanitize_Values', 'number' ),
				'number'           => array( 'Kirki_Sanitize_Values', 'number' ),
				'text'             => 'esc_textarea',
				'kirki-text'       => 'esc_textarea',
				'textarea'         => 'wp_kses_post',
				'editor'           => 'wp_kses_post',
				'multicheck'       => array( 'Kirki_Sanitize_Values', 'multicheck' ),
				'sortable'         => array( 'Kirki_Sanitize_Values', 'sortable' ),
			);

			if ( ! isset( $args['sanitize_callback'] ) || empty( $args['sanitize_callback'] ) || ! is_callable( $args['sanitize_callback'] ) ) {
				if ( array_key_exists( $args['type'], $default_callbacks ) ) {
					$args['sanitize_callback'] = $default_callbacks[ $args['type'] ];
				} else {
					$args['sanitize_callback'] = array( 'Kirki_Sanitize_Values', 'unfiltered' );
				}
			}

			return $args;

		}

	}

}
