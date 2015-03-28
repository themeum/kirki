<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;

class Dependencies extends EnqueueScript {

	/**
	 * Enqueue the scripts required.
	 */
	public function customize_controls_enqueue_scripts() {

		$controls = Kirki::config()->get_all();
		$kirki_url = isset( $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

		wp_enqueue_script( 'kirki_customizer_js', $kirki_url . 'assets/js/customizer.js', array( 'jquery', 'customize-controls' ) );
		wp_enqueue_script( 'serialize-js', $kirki_url . 'assets/js/serialize.js');
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tooltip' );

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_print_footer_scripts() {}

	public function wp_footer() {}

}
