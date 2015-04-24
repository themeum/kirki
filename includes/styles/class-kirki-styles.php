<?php

/**
 * Instantiates all styling-related classes
 */
class Kirki_Styles {

	public function __construct() {

		$customizer_styles = new Kirki_Styles_Customizer();
		$frontend_styles   = new Kirki_Styles_Frontend();

	}

}
