<?php

class Test_Kirki_Toolkit extends WP_UnitTestCase {

	function test_font_registry() {
		$this->assertTrue( is_object( Kirki()->font_registry ) );
	}

	function test_scripts() {
		$this->assertTrue( is_object( Kirki()->scripts ) );
	}

	function test_api() {
		$this->assertTrue( is_object( Kirki()->api ) );
	}

	function test_styles() {
		$this->assertTrue( is_array( Kirki()->styles ) );
	}

	function test_styles_back() {
		$this->assertTrue( is_object( Kirki()->styles['back'] ) );
	}

	function test_styles_front() {
		$this->assertTrue( is_object( Kirki()->styles['front'] ) );
	}

	function test_i18n() {
		$this->assertTrue( is_array( Kirki_Toolkit::i18n() ) );
	}
}
