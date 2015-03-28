<?php

class Kirki_Customizer_Scripts extends Kirki {

	function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ) );
	}

	/**
	 * Enqueue the scripts required.
	 */
	function customizer_scripts() {

		$config = $this->config;

		$kirki_url = isset( $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

		wp_enqueue_script( 'kirki_customizer_js', $kirki_url . 'assets/js/customizer.js', array( 'jquery', 'customize-controls' ) );
		wp_enqueue_script( 'serialize-js', $kirki_url . 'assets/js/serialize.js');
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tooltip' );

	}

}
$customizer_scripts = new Kirki_Customizer_Scripts();
