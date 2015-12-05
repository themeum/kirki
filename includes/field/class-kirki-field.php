<?php

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

		if ( is_array( $config_id ) && empty( $args ) ) {
			$args      = $config_id;
			$config_id = 'global';
		}

		$config_id = ( '' == $config_id ) ? 'global' : $config_id;

		/**
		 * Get the configuration options
		 */
		if ( ! isset( Kirki::$config[ $config_id ] ) ) {
			$config_id = 'global';
		}
		$config = Kirki::$config[ $config_id ];

		/**
		 * If we've set an option in the configuration
		 * then make sure we're using options and not theme_mods
		 */
		if ( '' != $config['option_name'] ) {
			$config['option_type'] = 'option';
		}

		/**
		 * If no option name has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['option_name'] ) ) {
			$args['option_name'] = $config['option_name'];
		}

		/**
		 * If no capability has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['capability'] ) ) {
			$args['capability'] = $config['capability'];
		}

		/**
		 * Check if [settings] is set.
		 * If not set, check for [setting]
		 */
		if ( ! isset( $args['settings'] ) && isset( $args['setting'] ) ) {
			$args['settings'] = $args['setting'];
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
		Kirki::$fields[ Kirki_Field_Sanitize::sanitize_settings( $args ) ] = $args;

		if ( 'background' == $args['type'] ) {
			/**
			 * Build the background fields
			 */
			Kirki::$fields = Kirki_Explode_Background_Field::process_fields( Kirki::$fields );
		}

	}

	public static function get_config_id( $field ) {

		$config = 'global';
		/**
		 * Get the array of configs from the Kirki class
		 */
		$configs = Kirki::$config;
		/**
		 * Loop through all configs and search for a match
		 */
		foreach ( $configs as $config_id => $config_args ) {
			$option_type = ( isset( $config_args['option_type'] ) ) ? $config_args['option_type'] : 'theme_mod';
			$option_name = ( isset( $config_args['option_name'] ) ) ? $config_args['option_name'] : '';
			$types_match = false;
			$names_match = false;
			if ( isset( $field['option_type'] ) ) {
				$types_match = ( $option_type == $field['option_type'] ) ? true : false;
			}
			if ( isset( $field['option_name'] ) ) {
				$names_match = ( $option_name == $field['option_name'] ) ? true : false;
			}

			if ( $types_match && $names_match ) {
				$config = $config_id;
			}
		}

		return $config;

	}

}
