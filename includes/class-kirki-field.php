<?php

class Kirki_Field extends Kirki_Customizer {

	public $args = null;

	public function __construct( $args ) {

		parent::__construct( $args );

		$this->args = $args;

	}

}
