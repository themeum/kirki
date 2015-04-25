<?php

/**
 * Instantiates all styling-related classes
 */
class Kirki_Styles {

	public $instance_id;

	public function __construct( $instance_id ) {

		$this->instance_id = $instance_id;

		$customizer_styles = new Kirki_Styles_Customizer( $this->instance_id );
		$frontend_styles   = new Kirki_Styles_Frontend( $this->instance_id );

	}

}
