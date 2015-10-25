<?php

class Kirki_Settings extends Kirki_Customizer {

	public function __construct( $args ) {

		parent::__construct( $args );
		$this->add_settings( $args );

	}

	public function add_settings( $args ) {

		if ( isset( $args['settings'] ) && is_array( $args['settings'] ) ) {
			$settings          = Kirki_Field_Sanitize::sanitize_settings( $args );
			$defaults          = isset( $args['default'] ) ? $args['default'] : array();
			$sanitize_callback = Kirki_Field_Sanitize::sanitize_callback( $args );
			foreach ( $settings as $setting_key => $setting_value ) {
				$default    = ( isset( $defaults[ $setting_key ] ) ) ? $defaults[ $setting_key ] : '';
				$type       = Kirki_Field_Sanitize::sanitize_type( $args );
				$capability = Kirki_Field_Sanitize::sanitize_capability( $args );
				$transport  = isset( $args['transport'] ) ? $args['transport'] : 'refresh';

				if ( isset( $args['sanitize_callback'] ) && is_array( $args['sanitize_callback'] ) ) {
					if ( isset( $args['sanitize_callback'][ $setting_key ] ) ) {
						$sanitize_callback = Kirki_Field_Sanitize::sanitize_callback( array( 'sanitize_callback' => $args['sanitize_callback'][ $setting_key ] ) );
					}
				}
				$this->wp_customize->add_setting( $setting_value, array(
					'default'           => $default,
					'type'              => $type,
					'capability'        => $capability,
					'sanitize_callback' => $sanitize_callback,
					'transport'         => $transport,
				) );
			}
		}

		if ( isset( $args['type'] ) && array_key_exists( $args['type'], Kirki_Control::$setting_types ) ) {
			// We must instantiate a custom class for the setting
			$setting_classname = Kirki_Control::$setting_types[ $args['type'] ];
			$this->wp_customize->add_setting( new $setting_classname( $this->wp_customize, Kirki_Field_Sanitize::sanitize_settings( $args ), array(
				'default'           => isset( $args['default'] ) ? $args['default'] : '',
				'type'              => Kirki_Field_Sanitize::sanitize_type( $args ),
				'capability'        => Kirki_Field_Sanitize::sanitize_capability( $args ),
				'transport'         => isset( $args['transport'] ) ? $args['transport'] : 'refresh',
				'sanitize_callback' => Kirki_Field_Sanitize::sanitize_callback( $args ),
			) ) );

		} else {
			$this->wp_customize->add_setting( Kirki_Field_Sanitize::sanitize_settings( $args ), array(
				'default'           => isset( $args['default'] ) ? $args['default'] : '',
				'type'              => Kirki_Field_Sanitize::sanitize_type( $args ),
				'capability'        => Kirki_Field_Sanitize::sanitize_capability( $args ),
				'transport'         => isset( $args['transport'] ) ? $args['transport'] : 'refresh',
				'sanitize_callback' => Kirki_Field_Sanitize::sanitize_callback( $args ),
			) );
		}

	}
}
