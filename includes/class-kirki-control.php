<?php

class Kirki_Control extends Kirki_Customizer {

	public $wp_customize;

	/**
	 * The class constructor
	 */
	public function __construct( $args ) {

		parent::__construct( $args );
		$this->add_control( $args );

	}

	/**
	 * Get the class name of the class needed to create tis control.
	 *
	 * @param  $args array
	 * @return  string
	 */
	public static function control_class_name( $args ) {

		$class_name = 'WP_Customize_Control';
		if ( array_key_exists( $args['type'], Kirki_Init::$control_types ) ) {
			$class_name = Kirki_Init::$control_types[ $args['type'] ];
		}

		return $class_name;

	}

	/**
	 * Add the control.
	 *
	 * @param  $arg array
	 * @return  void
	 */
	public function add_control( $args ) {

		$control_class_name = self::control_class_name( $args );

		$this->wp_customize->add_control( new $control_class_name(
			$this->wp_customize,
			Kirki_Field_Sanitize::sanitize_id( $args ),
			Kirki_Field_Sanitize::sanitize_field( $args )
		) );

	}

}
