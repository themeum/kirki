<?php

class Test_Kirki_Styles_Customizer extends WP_UnitTestCase {

	public function test_google_font_enqueued() {
		Kirki();
		// $this->go_to( admin_url( 'customize.php' ) );
		do_action( 'customize_controls_print_styles' );
		$styles = $GLOBALS['wp_styles']->registered;
		$this->assertTrue( isset( $styles['kirki-customizer-css'] ) );
	}

}
