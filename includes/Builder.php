<?php

namespace Kirki;

use Kirki;
use Kirki\Settings;
use Kirki\Controls;

class Builder {

	public $settings;
	private $controls;

	public function __construct() {

		$this->settings = new Settings();
		$this->controls = new Controls();
		add_action( 'customize_register', array( $this, 'build' ), 99 );

	}

	/**
	 * Build the customizer fields.
	 * Parses all fields and creates the setting & control for each of them.
	 */
	public function build( $wp_customize ) {
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
