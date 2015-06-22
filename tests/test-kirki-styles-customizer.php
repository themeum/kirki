<?php

class Test_Kirki_Styles_Customizer extends WP_UnitTestCase {

	public function test_google_font_enqueued() {
		Kirki();
		do_action( 'customize_controls_print_styles' );
		$styles = $GLOBALS['wp_styles']->registered;
		$this->assertTrue( isset( $styles['kirki-customizer-css'] ) );
	}

	// public function test_custom_css() {
	// 	add_filter( 'kirki/config', function( $config ) {
	// 		$config['color_accent'] = '#00bcd4';
	// 		$config['color_back']   = '#455a64';
	// 		$config['width']        = '20%';
	// 		return $config;
	// 	});
	//
	// 	Kirki();
	// 	do_action( 'customize_controls_print_styles' );
	// 	$styles = $GLOBALS['wp_styles']->registered;
	// 	$this->assertTrue( strpos( $styles['kirki-customizer-css']->extra['after'][3], '#00bcd4' ) );
	// 	$this->assertTrue( strpos( $styles['kirki-customizer-css']->extra['after'][0], '#455a64' ) );
	// 	$this->assertTrue( strpos( $styles['kirki-customizer-css']->extra['after'][0], '20%' ) );
	// }

}
