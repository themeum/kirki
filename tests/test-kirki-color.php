<?php

class KirkiColorTest extends WP_UnitTestCase {

	function test_hex_sanitize_white() {

		// 1-letter hex
		$this->assertEquals( '#ffffff', Kirki_Color::sanitize_hex( 'f' ) );
		// 2-letter hex
		$this->assertEquals( '#ffffff', Kirki_Color::sanitize_hex( 'ff' ) );
		// 3-letter hex
		$this->assertEquals( '#ffffff', Kirki_Color::sanitize_hex( 'fff' ) );
		// 4-letter hex
		$this->assertEquals( '#ffffff', Kirki_Color::sanitize_hex( 'ffff' ) );
		// 5-letter hex
		$this->assertEquals( '#ffffff', Kirki_Color::sanitize_hex( 'fffff' ) );
		// 6-letter hex
		$this->assertEquals( '#ffffff', Kirki_Color::sanitize_hex( 'ffffff' ) );
		// 7-letter hex
		$this->assertEquals( '#ffffff', Kirki_Color::sanitize_hex( 'fffffff' ) );

	}

	function test_hex_sanitize_black() {

		// 1-letter hex
		$this->assertEquals( '#000000', Kirki_Color::sanitize_hex( '0' ) );
		// 2-letter hex
		$this->assertEquals( '#000000', Kirki_Color::sanitize_hex( '00' ) );
		// 3-letter hex
		$this->assertEquals( '#000000', Kirki_Color::sanitize_hex( '000' ) );
		// 4-letter hex
		$this->assertEquals( '#000000', Kirki_Color::sanitize_hex( '0000' ) );
		// 5-letter hex
		$this->assertEquals( '#000000', Kirki_Color::sanitize_hex( '00000' ) );
		// 6-letter hex
		$this->assertEquals( '#000000', Kirki_Color::sanitize_hex( '000000' ) );
		// 7-letter hex
		$this->assertEquals( '#000000', Kirki_Color::sanitize_hex( '0000000' ) );

	}

	function test_hex_sanitize_invalid() {
		$this->assertEquals( '#ff8855', Kirki_Color::sanitize_hex( 'fg8p5m' ) );
	}

	function test_get_rgb_white() {
		$this->assertEquals( array( 255, 255, 255 ), Kirki_Color::get_rgb( '#ffffff' ) );
		$this->assertEquals( '255,255,255', Kirki_Color::get_rgb( '#ffffff', true ) );
	}

	function test_get_rgb_black() {
		$this->assertEquals( array( 0, 0, 0 ), Kirki_Color::get_rgb( '#000000' ) );
		$this->assertEquals( '0,0,0', Kirki_Color::get_rgb( '#000000', true ) );
	}

}
