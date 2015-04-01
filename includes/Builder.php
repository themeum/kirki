<?php

namespace Kirki;

use Kirki;
use Kirki\Settings;
use Kirki\Controls;

class Builder {

	private $settings;
	private $controls;

	public function __construct() {
		add_action( 'customize_register', array( $this, 'build' ), 99 );
		$this->settings = new Settings();
		$this->controls = new Controls();
	}

	/**
	 * Build the customizer controls
	 */
	public function build( $wp_customize ) {
		$fields = Kirki::fields()->get_all();

		// Early exit if controls are not set or if they're empty
		if ( empty( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {
			$field = Kirki::fields()->sanitize_field( $field );
			$this->settings->add( $wp_customize, $field );
			$this->controls->add( $wp_customize, $field );
		}

	}

}
