<?php

class Kirki_Customizer {

	public $wp_customize;

	/**
	 * The class constructor
	 */
	public function __construct( $args = array() ) {

		global $wp_customize;
		if ( ! $wp_customize ) {
			return;
		}

		$this->wp_customize = $wp_customize;

	}

}
