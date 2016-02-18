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

		public static function add_field( $config_id, $args ) {

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
		 * Gets the $confi_id and $args specified in the field,
		 * and then checks the validity of $config_id.
		 * If $config_id is not valid, then fallback to using the 'global' config.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string
		 */
		public static function sanitize_config_id( $config_id, $args ) {
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
				$args = $config_id;
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
		public static function sanitize_option_name( $config_id, $args ) {

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
		public static function sanitize_capability( $config_id, $args ) {

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
		public static function sanitize_option_type( $config_id, $args ) {

			/**
			 * If an capability has been defined in the field itself,
			 * then escape it and return it.
			 */
			if ( isset( $args['option_type'] ) ) {
				return esc_attr( $args['option_type'] );
			}
			/**
			 * Try to get the capability from the config
			 */

			if ( isset( Kirki::$config[ $config_id ]['option_type'] ) ) {
				return esc_attr( Kirki::$config[ $config_id ]['option_type'] );
			}
			/**
			 * If all else fails, return option_type.
			 */
			return 'option_type';

		}

		/**
		 * Sanitizes the settings.
		 *
		 * @param   string  $config_id
		 * @param   array   $args
		 * @return  string|array
		 */
		public static function sanitize_settings( $config_id, $args ) {

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
					if ( 'option' == $config['option_type'] && '' != $config['option_name'] && ( false === strpos( $setting_key, '[' ) ) ) {
						$settings[ sanitize_key( $setting_key ) ] = esc_attr( $config['option_name'] ).'['.esc_attr( $setting_value ).']';
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
		public static function sanitize_tooltip( $config_id, $args ) {

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
		public static function sanitize_active_callback( $config_id, $args ) {

			if ( isset( $args['active_callback'] ) ) {
				if is_callable( $args['active_callback'] ) {
					return $args['active_callback'];
				}
			}
			if ( isset( $args['required'] ) ) {
				return array( 'Kirki_Active_Callback', 'evaluate' );
			}
			return '__return_true';

		}

	}
}
