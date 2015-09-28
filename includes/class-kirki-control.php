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

	public function control_class_name( $args ) {

		parent::__construct( $args );

		$class_name = 'WP_Customize_Control';
		if ( array_key_exists( $args['type'], Kirki::$control_types ) ) {
			$class_name = Kirki::$control_types[ $args['type'] ];
		}

		return $class_name;

	}

	/**
	 * Add the control
	 */
	public function add_control( $args ) {

		$control_class_name = $this->control_class_name( $args );

		$this->wp_customize->add_control( new $control_class_name(
			$this->wp_customize,
			Kirki_Field_Sanitize::sanitize_id( $args ),
			Kirki_Field_Sanitize::sanitize_field( $args )
		) );

	}

}
