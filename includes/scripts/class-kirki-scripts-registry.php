<?php

/**
 * Instantiates all other scripts needed
 */
class Kirki_Scripts_Registry {

	public function __construct() {

		$dependencies = new Kirki_Scripts_Customizer_Default_Scripts();
		$branding     = new Kirki_Scripts_Customizer_Branding();
		$postmessage  = new Kirki_Scripts_Customizer_PostMessage();
		$required     = new Kirki_Scripts_Customizer_Required();
		$tooltips     = new Kirki_Scripts_Customizer_Tooltips();
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$stepper      = new Kirki_Scripts_Customizer_Stepper();

	}

	public static function prepare( $script ) {
		return '<script>jQuery(document).ready(function($) { "use strict"; ' . $script . '});</script>';
	}

}
