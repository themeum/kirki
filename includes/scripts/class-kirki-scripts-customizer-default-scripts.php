<?php

class Kirki_Scripts_Customizer_Default_Scripts extends Kirki_Scripts_Enqueue_Script {

	/**
	 * Enqueue the scripts required.
	 */
	public function customize_controls_enqueue_scripts() {

		$config = Kirki_Toolkit::config()->get_all();
		$kirki_url = ( '' != $config['url_path'] )? $config['url_path'] : KIRKI_URL;

		wp_enqueue_script( 'kirki-tooltip', trailingslashit( $kirki_url ) . 'assets/js/kirki-tooltip.js', array( 'jquery', 'customize-controls' ) );
		wp_enqueue_script( 'serialize-js', trailingslashit( $kirki_url ) . 'assets/js/serialize.js' );
		wp_enqueue_script( 'jquery-select2', trailingslashit( $kirki_url ) . 'assets/js/select2.full.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		wp_enqueue_script( 'jquery-stepper-min-js' );

		wp_enqueue_style( 'css-select2', trailingslashit( $kirki_url ) . 'assets/css/select2.min.css' );
	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_print_footer_scripts() {}

	public function wp_footer() {}

}
