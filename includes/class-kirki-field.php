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

}
