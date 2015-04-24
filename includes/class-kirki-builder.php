<?php

/**
 * The field builder class.
 */
class Kirki_Builder {

	public $settings;
	private $controls;

	public function __construct() {

		$this->settings = new Kirki_Settings();
		$this->controls = new Kirki_Controls();
		add_action( 'customize_register', array( $this, 'build' ), 99 );

	}

	/**
	 * Build the customizer fields.
	 * Parses all fields and creates the setting & control for each of them.
	 */
	public function build( $wp_customize ) {

		include_once( KIRKI_PATH . '/includes/class-kirki-control.php' );
		include_once( KIRKI_PATH . '/includes/class-kirki-controls.php' );

		$fields = Kirki::fields()->get_all();

		// Early exit if controls are not set or if they're empty
		if ( empty( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {
			$this->build_field( $wp_customize, $field );
		}

	}

	/**
	 * Build a single field
	 */
	public function build_field( $wp_customize, $field ) {
		$this->settings->add( $wp_customize, $field );
		$this->controls->add( $wp_customize, $field );
	}

}
