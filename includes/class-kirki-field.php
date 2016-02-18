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
			 * If we've set an option in the configuration
			 * then make sure we're using options and not theme_mods
			 */
			if ( isset( $config['option_name'] ) && ! empty( $config['option_name'] ) ) {
				$config['option_type'] = 'option';
			}

			/**
			 * Sanitize option_name
			 */
			$args['option_name'] = self::sanitize_option_name( $config_id, $args );

			/**
			 * If no capability has been set for the field,
			 * use the one from the configuration
			 */
			if ( ! isset( $args['capability'] ) ) {
				$args['capability'] = $config['capability'];
			}

			/**
			 * Check the 'disable_output' argument from the config
			 */
			$args['disable_output'] = $config['disable_output'];

			/**
			 * Check if [settings] is set.
			 * If not set, check for [setting].
			 * After this check is complete, we'll do some additional tweaking
			 * based on whether this is an option or a theme_mod.
			 * If an option and option_name is also defined,
			 * then we'll have to change the setting.
			 */
			if ( ! isset( $args['settings'] ) && isset( $args['setting'] ) ) {
				$args['settings'] = $args['setting'];
			}
			if ( is_array( $args['settings'] ) ) {
				$settings = array();
				foreach ( $args['settings'] as $setting_key => $setting_value ) {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $setting_value );
					if ( 'option' == $config['option_type'] && '' != $config['option_name'] && ( false === strpos( $setting_key, '[' ) ) ) {
						$settings[ sanitize_key( $setting_key ) ] = esc_attr( $config['option_name'] ).'['.esc_attr( $setting_value ).']';
					}
				}
				$args['settings'] = $settings;
			} else {
				if ( 'option' == $config['option_type'] && '' != $config['option_name'] && ( false === strpos( $args['settings'], '[' ) ) ) {
					$args['settings'] = esc_attr( $args['option_name'] ) . '[' . esc_attr( $args['settings'] ) . ']';
				} else {
					$args['settings'] = esc_attr( $args['settings'] );
				}
			}

			/**
			 * If no option-type has been set for the field,
			 * use the one from the configuration
			 */
			if ( ! isset( $args['option_type'] ) ) {
				$args['option_type'] = $config['option_type'];
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


	}
}
