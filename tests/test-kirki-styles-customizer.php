<?php

class Test_Kirki_Styles_Customizer extends WP_UnitTestCase {

	public function test_google_font_enqueued() {
		Kirki();
		do_action( 'customize_controls_print_styles' );
		$styles = $GLOBALS['wp_styles']->registered;
		$this->assertTrue( isset( $styles['kirki-customizer-css'] ) );
	}

	public function test_custom_css() {
		add_filter( 'kirki/config', function( $config ) {
			$config['color_accent'] = '#00bcd4';
			$config['color_back'] = '#455a64';
			$config['width'] = '20%';
			return $config;
		});

		do_action( 'customize_controls_print_styles' );
		$this->assertTrue( false !== strpos( Kirki()->styles['back']->custom_css(), '#00bcd4' ) );
		$this->assertTrue( false !== strpos( Kirki()->styles['back']->custom_css(), '#455a64' ) );
		$this->assertTrue( false !== strpos( Kirki()->styles['back']->custom_css(), '20%' ) );
	}

}
