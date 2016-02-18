<?php

class Test_Kirki_Textdomain extends WP_UnitTestCase {

	function test_kirki_load_textdomain() {
		do_action( 'plugins_loaded' );
		$this->assertEquals( 10, has_action( 'plugins_loaded', 'kirki_load_textdomain' ) );
		global $l10n;
		$this->assertEquals( true, isset( $l10n['kirki'] ) );
	}

}
