<?php

class Kirki_Field extends Kirki_Customizer {

	public $args = null;

	public function __construct( $args ) {

		parent::__construct( $args );

		$this->args = $args;

		$this->add_settings();
		$this->add_control();

	}

	public function add_settings() {
		$settings = new Kirki_Settings( $this->args );
	}

	public function add_control() {
		$control  = new Kirki_Control( $this->args );
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
}
