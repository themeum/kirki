<?php

namespace Kirki;

use Kirki;

class Builder {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'build' ), 99 );
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
			Kirki::setting()->add( $wp_customize, $field );
			Kirki::control()->add( $wp_customize, $field );
		}

	}

}
