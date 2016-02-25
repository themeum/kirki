<?php

if ( ! class_exists( 'Kirki_Field' ) ) {
	class Kirki_Field {

		private $args = null;

		private $default_args = array(
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

		public function __construct( $config_id = 'global', $args = array() ) {
			$this->set_field( $config_id, $args );
		}

		private function set_field( $config_id = 'global', $args = array() ) {

			$this->args = $args;

			$this->config_id( $config_id );

			$this->option_name();
			$this->option_type();
			$this->capability();
			$this->settings();
			$this->tooltip();
			$this->active_callback();
			$this->type();
			$this->sanitize_callback();
			$this->the_id();

			$this->args = wp_parse_args( $this->args, $this->default_args );

			// Get the config arguments
			$config = Kirki::$config[ $this->args['kirki_config'] ];
			// Get the 'disable_output' argument from the config
			$this->args['disable_output'] = $config['disable_output'];

			// Add the field to the static $fields variable properly indexed
			Kirki::$fields[ $this->args['settings'] ] = $this->args;

			if ( 'background' == $this->args['type'] ) {
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
		 * @return  string
		 */
		private function config_id( $config_id = 'global' ) {
			// Check if 'kirki_config' has been defined inside the $args.
			// In that case, it will override the $config.
			if ( isset( $this->args['kirki_config'] ) ) {
				$config_id = $this->args['kirki_config'];
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
			$this->args['kirki_config'] = esc_attr( $config_id );
		}

		/**
		 * Sets the setting name.
		 */
		private function option_name() {
			if ( isset( Kirki::$config[ $this->args['kirki_config'] ]['option_name'] ) ) {
				// use from config if not defined in the option
				$defaults = array(
					'option_name' => Kirki::$config[ $this->args['kirki_config'] ]['option_name'],
				);
				$this->args = wp_parse_args( $this->args, $defaults );
				// escape value
				$this->args['option_name'] = esc_attr( $this->args['option_name'] );
			}
		}

		/**
		 * Sets the capability.
		 */
		private function capability() {
			// If a capability has not been defined in the field itself,
			// Then fallback to the capability from the field's config.
			if ( isset( Kirki::$config[ $this->args['kirki_config'] ]['capability'] ) ) {
				$defaults = array(
					'capability' => Kirki::$config[ $this->args['kirki_config'] ]['capability'],
				);
				$this->args = wp_parse_args( $this->args, $defaults );
			}
			// escape the value
			$this->args['capability'] = esc_attr( $this->args['capability'] );
		}

		/**
		 * Sets the option_type
		 */
		private function option_type() {
			// If we have an option_name
			// then make sure we're using options and not theme_mods
			if ( '' != $this->args['option_name'] ) {
				$this->args['option_type'] = 'option';
			}

			// if no option_type has been defined for this field
			// Then try to get it from the config.
			// Fallback to "theme_mod"
			$defaults = array( 'option_type' => 'theme_mod' );
			if ( isset( Kirki::$config[ $this->args['kirki_config'] ]['option_type'] ) ) {
				$defaults = array( 'option_type' => Kirki::$config[ $this->args['kirki_config'] ]['option_type'] );
			}
			$this->args = wp_parse_args( $this->args, $defaults );

			// escape the value
			$this->args['option_type'] = esc_attr( $this->args['option_type'] );
		}

		/**
		 * Sets the settings.
		 */
		private function settings() {
			// Check for typos:
			// If the user has entered "setting" instead of "settings",
			// then use "setting" instead. It's a pretty common mistake
			// So we'll be accomodating.
			if ( ! isset( $this->args['settings'] ) && isset( $this->args['setting'] ) ) {
				$this->args['settings'] = $this->args['setting'];
				unset( $this->args['setting'] );
			}
			// If we have an array of settings then we need to sanitize each of them
			if ( ! is_array( $this->args['settings'] ) ) {
				$this->args['settings'] = array(
					'kirki_placeholder_setting' => $this->args['settings']
				);
			}
			$settings = array();
			foreach ( $this->args['settings'] as $setting_key => $setting_value ) {
				$settings[ sanitize_key( $setting_key ) ] = esc_attr( $setting_value );
				// If we're using serialized options then we need to spice this up
				if ( 'option' == $this->args['option_type'] && '' != $this->args['option_name'] && ( false === strpos( $setting_key, '[' ) ) ) {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $this->args['option_name'] ).'['.esc_attr( $setting_value ).']';
				}
			}
			$this->args['settings'] = $settings;
			if ( isset( $this->args['settings']['kirki_placeholder_setting'] ) ) {
				$this->args['settings'] = $this->args['settings']['kirki_placeholder_setting'];
			}
		}

		/**
		 * Sets the tooltip message
		 */
		private function tooltip() {
			if ( isset( $this->args['tooltip'] ) ) {
				$this->args['tooltip'] = wp_strip_all_tags( $this->args['tooltip'] );
			} elseif ( isset( $this->args['help'] ) ) {
				$this->args['tooltip'] = wp_strip_all_tags( $this->args['help'] );
				unset( $this->args['help'] );
			}
		}

		/**
		 * Sets the active_callback
		 */
		private function active_callback() {
			// Use our evaluation method as fallback if required argument is defined.
			if ( isset( $this->args['required'] ) ) {
				$defaults = array( 'active_callback' => array( 'Kirki_Active_Callback', 'evaluate' ) );
				$this->args = wp_parse_args( $this->args, $defaults );
			}

			// Make sure the function is callable, otherwise fallback to __return_true
			if ( isset( $this->args['active_callback'] ) && ! is_callable( $this->args['active_callback'] ) ) {
				$this->args['active_callback'] = '__return_true';
			}
		}

		/**
		 * Sets the control type.
		 */
		private function type() {

			$defaults = array( 'type' => 'kirki-generic' );

			switch ( $this->args['type'] ) {

				case 'checkbox':
					$this->args['type'] = 'kirki-checkbox';
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 switch & toggle were part of the checkbox control.
					if ( isset( $this->args['mode'] ) && 'switch' == $this->args['mode'] ) {
						$this->args['type'] = 'switch';
					} elseif ( isset( $this->args['mode'] ) && 'toggle' == $this->args['mode'] ) {
						$this->args['type'] = 'toggle';
					}
					break;
				case 'radio':
					$this->args['type'] = 'kirki-radio';
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 radio-buttonset & radio-image were part of the checkbox control.
					if ( isset( $this->args['mode'] ) && 'buttonset' == $this->args['mode'] ) {
						$this->args['type'] = 'radio-buttonset';
					} elseif ( isset( $this->args['mode'] ) && 'image' == $this->args['mode'] ) {
						$this->args['type'] = 'radio-image';
					}
					break;
				case 'group-title':
				case 'group_title':
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 there was a group-title control.
					// Instead we now just use a "custom" control.
					$this->args['type'] = 'custom';
					break;
				case 'color-alpha':
				case 'color_alpha':
					// Just making sure that common mistakes will still work.
					$this->args['type'] = 'color-alpha';
					$this->args['choices']['alpha'] = true;
					break;
				case 'color':
					$this->args['type'] = 'color-alpha';
					$this->args['choices']['alpha'] = false;
					// If a default value of rgba() is defined for a color control then we need to enable the alpha channel.
					if ( isset( $this->args['default'] ) && false !== strpos( $this->args['default'], 'rgba' ) ) {
						$this->args['choices']['alpha'] = true;
					}
					break;
				case 'select':
				case 'select2':
				case 'select2-multiple':
					$this->args['multiple'] = ( isset( $this->args['multiple'] ) ) ? intval( $this->args['multiple'] ) : 1;
					if ( 'select2-multiple' == $this->args['type'] ) {
						$this->args['multiple'] = 999;
					}
					$this->args['type'] = 'kirki-select';
					break;
				case 'textarea':
					$this->args['type']               = 'kirki-generic';
					$this->args['choices']['element'] = 'textarea';
					$this->args['choices']['rows']    = '5';
					if ( ! isset( $this->args['sanitize_callback'] ) ) {
						$this->args['sanitize_callback'] = 'wp_kses_post';
					}
					break;
				case 'text':
					$this->args['type']               = 'kirki-generic';
					$this->args['choices']['element'] = 'input';
					$this->args['choices']['type']    = 'text';
					if ( ! isset( $this->args['sanitize_callback'] ) ) {
						$this->args['sanitize_callback'] = 'wp_kses_post';
					}
					break;
				case 'kirki-generic':
					if ( ! isset( $this->args['choices']['element'] ) ) {
						$this->args['choices']['element'] = 'input';
					}
					break;
			}

			$this->args = wp_parse_args( $this->args, $defaults );

			// escape the control type
			$this->args['type'] = esc_attr( $this->args['type'] );

		}

		/**
		 * Sets the control id.
		 * Setting the ID should happen after the 'settings' sanitization.
		 * This way we can also properly handle cases where the option_type is set to 'option'
		 * and we're using an array instead of individual options.
		 */
		private function the_id() {
			$this->args['id'] = sanitize_key( str_replace( '[', '-', str_replace( ']', '', $this->args['settings'] ) ) );
		}

		/**
		 * Sets the setting sanitize_callback
		 */
		private function sanitize_callback() {
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
			if ( ! isset( $this->args['sanitize_callback'] ) || empty( $this->args['sanitize_callback'] ) || ! is_callable( $this->args['sanitize_callback'] ) ) {
				$this->args['sanitize_callback'] = array( 'Kirki_Sanitize_Values', 'unfiltered' );
				if ( array_key_exists( $this->args['type'], $default_callbacks ) ) {
					$this->args['sanitize_callback'] = $default_callbacks[ $this->args['type'] ];
				}
			}
		}

	}

}
