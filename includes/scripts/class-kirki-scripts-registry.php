<?php

/**
 * Instantiates all other scripts needed
 */
class Kirki_Scripts_Registry {

	public function __construct( $instance_id ) {

		$dependencies = new Kirki_Scripts_Customizer_Default_Scripts( $instance_id );
		$branding     = new Kirki_Scripts_Customizer_Branding( $instance_id );
		$postmessage  = new Kirki_Scripts_Customizer_PostMessage( $instance_id );
		$required     = new Kirki_Scripts_Customizer_Required( $instance_id );
		$tooltips     = new Kirki_Scripts_Customizer_Tooltips( $instance_id );
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts( $instance_id );
		$stepper      = new Kirki_Scripts_Customizer_Stepper( $instance_id );

	}

	public static function prepare( $script ) {
		return '<script>jQuery(document).ready(function($) { "use strict"; ' . $script . '});</script>';
	}

}
