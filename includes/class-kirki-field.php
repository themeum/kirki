<?php

if ( ! class_exists( 'Kirki_Field' ) ) {
	class Kirki_Field extends Kirki_Customizer {

		public $args = null;

		public function __construct( $args ) {

			/**
			 * Run the parent class constructor
			 */
			parent::__construct( $args );
			/**
			 * Set the field arguments
			 */
			$this->args = $args;
			/**
			 * Create the settings.
			 */
			new Kirki_Settings( $this->args );
			/**
			 * Check if we're on the customizer.
			 * If we are, then we will create the controls,
			 * add the scripts needed for the customizer
			 * and any other tweaks that this field may require.
			 */
			if ( $this->wp_customize ) {
				/**
				 * Create the control
				 */
				new Kirki_Control( $this->args );
				/**
				 * Create the scripts for postMessage to properly work
				 */
				Kirki_Customizer_Scripts_PostMessage::generate_script( $this->args );
				/**
				 * Create the scripts for tooltips.
				 */
				Kirki_Customizer_Scripts_Tooltips::generate_script( $this->args );
			}

		}

		public static function add_field( $config_id = 'global', $args = array() ) {

			/**
			 * Sanitize $config_id
			 */
			$config_id = self::sanitize_config_id( $config_id, $args );
			$args['kirki_config'] = $config_id;
			/**
			 * Get the config arguments
			 */
			$config = Kirki::$config[ $config_id ];
			/**
			 * Sanitize option_name
			 */
			$args['option_name'] = self::sanitize_option_name( $config_id, $args );
			/**
			 * If we've set an option in the configuration
			 * then make sure we're using options and not theme_mods
			 */
			if ( isset( $config['option_name'] ) && ! empty( $config['option_name'] ) ) {
				$args['option_type'] = 'option';
			}
			/**
			 * Sanitize option_type
			 */
			$args['option_type'] = self::sanitize_option_type( $config_id, $args );
			/**
			 * Sanitize capability
			 */
			$args['capability'] = self::sanitize_capability( $config_id, $args );
			/**
			 * Get the 'disable_output' argument from the config
			 */
			$args['disable_output'] = $config['disable_output'];
			/**
			 * Sanitize settings
			 */
			$args['settings'] = self::sanitize_settings( $config_id, $args );
			/**
			 * Sanitize tooltip messages
			 */
			$args['tooltip'] = self::sanitize_tooltip( $config_id, $args );
			/**
			 * Sanitize active_callback
			 */
			$args['active_callback'] = self::sanitize_active_callback( $config_id, $args );
			/**
			 * Sanitize control type
			 */
			$args['type'] = self::sanitize_control_type( $config_id, $args );
			/**
			 * If no choices have been defined, use an empty array
			 */
			$args['choices'] = ( isset( $args['choices'] ) ) ? $args['choices'] : array();
			/**
			 * Tweaks for simple controls
			 */
			if ( 'kirki-text' == $args['type'] ) {
				$args['type']               = 'kirki-generic';
				$args['choices']['element'] = 'input';
				$args['choices']['type']    = 'text';
				if ( ! isset( $args['sanitize_callback'] ) ) {
					$args['sanitize_callback'] = 'wp_kses_post';
				}
			} elseif ( 'kirki-textarea' == $args['type'] ) {
				$args['type']               = 'kirki-generic';
				$args['choices']['element'] = 'textarea';
				$args['choices']['rows']    = '5';
				if ( ! isset( $args['sanitize_callback'] ) ) {
					$args['sanitize_callback'] = 'wp_kses_post';
				}
			}
			if ( 'kirki-generic' == $args['type'] && ! isset( $args['choices']['element'] ) ) {
				$args['choices']['element'] = 'input';
			}
			/**
			 * Sanitize the sanitize_callback argument.
			 */
			$args['sanitize_callback'] = self::sanitize_callback( $config_id, $args );
			/**
			 * set choices for color controls
			 */
			if ( 'kirki-color' == $args['type'] ) {
				$args['choices']['alpha'] = false;
				$args['type'] = 'color-alpha';
			} elseif ( 'color-alpha' == $args['type'] ) {
				$args['choices']['alpha'] = true;
			}
			/**
			 * If no output argument has been defined, use an empty array
			 */
			$args['output'] = isset( $args['output'] ) ? $args['output'] : array();
			/**
			 * If "variables" has not been defined, set to null.
			 */
			$args['variables'] = ( isset( $args['variables'] ) && is_array( $args['variables'] ) ) ? $args['variables'] : null;
			/**
			 * Sanitize the id (for internal use)
			 */
			$args['id'] = self::sanitize_id( $config_id, $args );
			/**
			 * Make sure the "multiple" argument is properly formatted for <select> controls
			 */
			if ( 'kirki-select' == $args['type'] ) {
				$args['multiple'] = ( isset( $args['multiple'] ) ) ? intval( $args['multiple'] ) : 1;
			}

			/**
			 * Add the field to the static $fields variable properly indexed
			 */
			Kirki::$fields[ $args['settings'] ] = $args;

			if ( 'background' == $args['type'] ) {
				/**
				 * Build the background fields
				 */
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
		public static function sanitize_config_id( $config_id = 'global', $args = array() ) {
			/**
			 * Check if 'kirki_config' has been defined inside the $args.
			 * In that case, it will override the $config.
			 */
			if ( isset( $args['kirki_config'] ) ) {
				$config_id = $args['kirki_config'];
			}
			/**
			 * If $args is not used, then assume that $config_id took its place
			 */
			if ( is_array( $config_id ) && empty( $args ) ) {
				$args      = $config_id;
				$config_id = 'global';
			}
			/**
			 * If $config_id is empty, use global config.
			 */
			if ( empty( $config_id ) ) {
				$config_id = 'global';
			}
			/**
			 * If the defined config does not exist, use global.
			 */
			if ( ! isset( Kirki::$config[ $config_id ] ) ) {
				$config_id = 'global';
			}
			return esc_attr( $config_id );
		}

		/**
		 * Sanitizes the setting name.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_option_name( $config_id = 'global', $args = array() ) {

			/**
			 * If an option_name has been defined in the field itself,
			 * then escape it and return it.
			 */
			if ( isset( $args['option_name'] ) ) {
				return esc_attr( $args['option_name'] );
			}
			/**
			 * Try to get the option_name from the config
			 */
			if ( isset( Kirki::$config[ $config_id ]['option_name'] ) ) {
				return esc_attr( Kirki::$config[ $config_id ]['option_name'] );
			}
			/**
			 * If all else fails, return empty.
			 */
			return '';

		}

		/**
		 * Sanitizes the capability.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_capability( $config_id = 'global', $args = array() ) {

			/**
			 * If an capability has been defined in the field itself,
			 * then escape it and return it.
			 */
			if ( isset( $args['capability'] ) ) {
				return esc_attr( $args['capability'] );
			}
			/**
			 * Try to get the capability from the config
			 */
			if ( isset( Kirki::$config[ $config_id ]['capability'] ) ) {
				return esc_attr( Kirki::$config[ $config_id ]['capability'] );
			}
			/**
			 * If all else fails, return edit_theme_options.
			 */
			return 'edit_theme_options';

		}

		/**
		 * Sanitizes the option_type
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_option_type( $config_id = 'global', $args = array() ) {

			/**
			 * If an option_type has been defined in the field itself,
			 * then escape it and return it.
			 */
			if ( isset( $args['option_type'] ) ) {
				return esc_attr( $args['option_type'] );
			}
			/**
			 * Try to get the option_type from the config
			 */
			if ( isset( Kirki::$config[ $config_id ]['option_type'] ) ) {
				return esc_attr( Kirki::$config[ $config_id ]['option_type'] );
			}
			/**
			 * If all else fails, return option_type.
			 */
			return 'theme_mod';

		}

		/**
		 * Sanitizes the settings.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string|array
		 */
		public static function sanitize_settings( $config_id = 'global', $args = array() ) {

			/**
			 * Check for typos:
			 * If the user has entered "setting" instead of "settings",
			 * then use "setting" instead. It's a pretty common mistake
			 * So we'll be accomodating.
			 */
			if ( ! isset( $args['settings'] ) && isset( $args['setting'] ) ) {
				$args['settings'] = $args['setting'];
			}
			/**
			 * If we have an array of settings then we need to sanitize each of them
			 */
			if ( is_array( $args['settings'] ) ) {
				$settings = array();
				foreach ( $args['settings'] as $setting_key => $setting_value ) {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $setting_value );
					/**
					 * If we're using serialized options then we may need to modify things a bit
					 */
					if ( 'option' == $args['option_type'] && '' != $args['option_name'] && ( false === strpos( $setting_key, '[' ) ) ) {
						$settings[ sanitize_key( $setting_key ) ] = esc_attr( $args['option_name'] ).'['.esc_attr( $setting_value ).']';
					}
				}
				return $settings;
			}
			/**
			 * If we got to this point then settings is not an array.
			 * Continue sanitizing it
			 */
			if ( 'option' == $args['option_type'] && '' != $args['option_name'] && ( false === strpos( $args['settings'], '[' ) ) ) {
				/**
				 * If we're using serialized options then we may need to modify things a bit
				 */
				return esc_attr( $args['option_name'] ) . '[' . esc_attr( $args['settings'] ) . ']';
			}

			return esc_attr( $args['settings'] );

		}

		/**
		 * Sanitizes the tooltip message
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_tooltip( $config_id = 'global', $args = array() ) {

			if ( isset( $args['tooltip'] ) ) {
				return wp_strip_all_tags( $args['tooltip'] );
			}
			if ( isset( $args['help'] ) ) {
				return wp_strip_all_tags( $args['help'] );
			}
			return '';

		}

		/**
		 * Sanitizes the active_callback
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_active_callback( $config_id = 'global', $args = array() ) {

			if ( isset( $args['active_callback'] ) && is_callable( $args['active_callback'] ) ) {
				return $args['active_callback'];
			} elseif ( isset( $args['required'] ) ) {
				return array( 'Kirki_Active_Callback', 'evaluate' );
			}
			return '__return_true';

		}

		/**
		 * Sanitizes the control type.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_control_type( $config_id = 'global', $args = array() ) {

			// If no field type has been defined then fallback to text
			if ( ! isset( $args['type'] ) ) {
				return 'kirki-text';
			}

			switch ( $args['type'] ) {

				case 'checkbox':
					$args['type'] = 'kirki-checkbox';
					/**
					 * Tweaks for backwards-compatibility:
					 * Prior to version 0.8 switch & toggle were part of the checkbox control.
					 */
					if ( isset( $args['mode'] ) && 'switch' == $args['mode'] ) {
						$args['type'] = 'switch';
					} elseif ( isset( $args['mode'] ) && 'toggle' == $args['mode'] ) {
						$args['type'] = 'toggle';
					}
					break;
				case 'radio':
					$args['type'] = 'kirki-radio';
					/**
					 * Tweaks for backwards-compatibility:
					 * Prior to version 0.8 radio-buttonset & radio-image were part of the checkbox control.
					 */
					if ( isset( $args['mode'] ) ) {
						if ( 'buttonset' == $args['mode'] ) {
							$args['type'] = 'radio-buttonset';
						} elseif ( 'image' == $args['mode'] ) {
							$args['type'] = 'radio-image';
						}
					}
					break;
				case 'group-title':
				case 'group_title':
					/**
					 * Tweaks for backwards-compatibility:
					 * Prior to version 0.8 there was a group-title control.
					 */
					$args['type'] = 'custom';
					break;
				case 'color_alpha':
					// Just making sure that common mistakes will still work.
					$args['type'] = 'color-alpha';
					break;
				case 'color':
					$args['type'] = 'kirki-color';
					// If a default value of rgba() is defined for a color control then use color-alpha instead.
					if ( isset( $args['default'] ) && false !== strpos( $args['default'], 'rgba' ) ) {
						$args['type'] = 'color-alpha';
					}
					break;
				case 'select':
				case 'select2':
				case 'select2-multiple':
					$args['type'] = 'kirki-select';
					break;
				case 'textarea':
					$args['type'] = 'kirki-textarea';
					break;
				case 'text':
					$args['type'] = 'kirki-text';
					break;
			}

			/**
			 * sanitize using esc_attr and return the value.
			 */
			return esc_attr( $args['type'] );

		}

		/**
		 * Sanitizes the control id.
		 * Sanitizing the ID should happen after the 'settings' sanitization.
		 * This way we can also properly handle cases where the option_type is set to 'option'
		 * and we're using an array instead of individual options.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_id( $config_id = 'global', $args = array() ) {
			return sanitize_key( str_replace( '[', '-', str_replace( ']', '', $args['settings'] ) ) );
		}

		/**
		 * Sanitizes the setting sanitize_callback
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string|array
		 */
		public static function sanitize_callback( $config_id = 'global', $args = array() ) {

			if ( isset( $args['sanitize_callback'] ) && ! empty( $args['sanitize_callback'] ) ) {
				if ( is_callable( $args['sanitize_callback'] ) ) {
					return $args['sanitize_callback'];
				}
			}
			// Fallback callback
			return self::fallback_callback( $config_id, $args );

		}

		/**
		 * returns a callable function or method that can be used to sanitize the values.
		 * This is used as fallback in case a sanitize_callback has not been defined for a setting.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string|array
		 */
		public static function fallback_callback( $config_id = 'global', $args = array() ) {

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

			if ( array_key_exists( $args['type'], $default_callbacks ) ) {
				return $default_callbacks[ $args['type'] ];
			} else {
				return array( 'Kirki_Sanitize_Values', 'unfiltered' );
			}

		}

	}

}
