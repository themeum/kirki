<?php

class KirkiColorTest extends WP_UnitTestCase {

	public function test_hex_sanitize() {

		/**
		 * White
		 */
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

		/**
		 * Black
		 */
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

		/**
		 * Invalid color characters
		 */
		$this->assertEquals( '#ff8855', Kirki_Color::sanitize_hex( 'fg8p5m' ) );

	}

	public function test_get_rgb() {
		/**
		 * White
		 */
		$this->assertEquals( array( 255, 255, 255 ), Kirki_Color::get_rgb( '#ffffff' ) );
		$this->assertEquals( '255,255,255', Kirki_Color::get_rgb( '#ffffff', true ) );
		/**
		 * Black
		 */
		$this->assertEquals( array( 0, 0, 0 ), Kirki_Color::get_rgb( '#000000' ) );
		$this->assertEquals( '0,0,0', Kirki_Color::get_rgb( '#000000', true ) );
	}

	public function test_rgba2hex() {
		/**
		 * White
		 */
		$this->assertEquals( '#ffffff', Kirki_Color::rgba2hex( 'rgba(255,255,255,1)' ) );
		$this->assertEquals( '#ffffff', Kirki_Color::rgba2hex( 'rgba(255,255,255,0)' ) );
		$this->assertEquals( '#ffffff', Kirki_Color::rgba2hex( 'rgba(  255, 255, 255, 0    )   ' ) );
		$this->assertEquals( true, ( '#ffffff' != Kirki_Color::rgba2hex( 'rgba(255,230,255,1)' ) ) );
		/**
		 * Black
		 */
		$this->assertEquals( '#000000', Kirki_Color::rgba2hex( 'rgba(0,0,0,1)' ) );
		$this->assertEquals( '#000000', Kirki_Color::rgba2hex( 'rgba( 0, 0, 0, 1)' ) );
		$this->assertEquals( true, ( '#000000' != Kirki_Color::rgba2hex( 'rgba(0,0,0,.1)' ) ) );
		/**
		 * Opacity
		 */
		$this->assertEquals( '#7f7f7f', Kirki_Color::rgba2hex( 'rgba(0,0,0,.5)' ) );
		$this->assertEquals( '#ff7f7f', Kirki_Color::rgba2hex( 'rgba(255,0,0,.5)' ) );
		$this->assertEquals( '#7fff7f', Kirki_Color::rgba2hex( 'rgba(0,255,0,.5)' ) );
		$this->assertEquals( '#7f7fff', Kirki_Color::rgba2hex( 'rgba(0,0,255,.5)' ) );
	}

	public function test_get_rgba() {
		// White
		$this->assertEquals( 'rgba(255,255,255,1)', Kirki_Color::get_rgba( '#ffffff', 1 ) );
		$this->assertEquals( 'rgba(255,255,255,1)', Kirki_Color::get_rgba( '#ffffff', 100 ) );
		// Transparent
		$this->assertEquals( 'rgba(255,255,255,0)', Kirki_Color::get_rgba( '#ffffff', 0 ) );
		// grey
		$this->assertEquals( 'rgba(0,0,0,0.5)', Kirki_Color::get_rgba( '#000000', .5 ) );
		// colors
		$this->assertEquals( 'rgba(255,0,0,0.5)', Kirki_Color::get_rgba( '#ff0000', .5 ) );
		$this->assertEquals( 'rgba(0,255,0,0.5)', Kirki_Color::get_rgba( '#00ff00', .5 ) );
		$this->assertEquals( 'rgba(0,0,255,0.5)', Kirki_Color::get_rgba( '#0000ff', .5 ) );
	}

	public function test_get_brightness() {
		$this->assertEquals( '0', Kirki_Color::get_brightness( '#000000' ) );
		$this->assertEquals( '255', Kirki_Color::get_brightness( '#ffffff' ) );
		$this->assertEquals( 127, Kirki_Color::get_brightness( '#7f7f7f' ) );
		$this->assertEquals( 105, Kirki_Color::get_brightness( '#ff00ff' ) );
	}

	public function test_adjust_brightness() {
		$this->assertEquals( '#ffffff', Kirki_Color::adjust_brightness( '#000000', 255 ) );
		$this->assertEquals( '#000000', Kirki_Color::adjust_brightness( '#000000', 0 ) );
		$this->assertEquals( '#ffffff', Kirki_Color::adjust_brightness( '#fff', 0 ) );
		$this->assertEquals( '#000000', Kirki_Color::adjust_brightness( '#fff', -255 ) );
		$this->assertEquals( '#7f7f7f', Kirki_Color::adjust_brightness( '#fff', (0 - 255/2) ) );
	}

	public function test_mix_colors() {
		$this->assertEquals( '#ffffff', Kirki_Color::mix_colors( '#ffffff', 'fff', 100 ) );
		$this->assertEquals( '#ffffff', Kirki_Color::mix_colors( '#ffffff', 'fff', 0 ) );
		$this->assertEquals( '#ffffff', Kirki_Color::mix_colors( '#ffffff', 'fff', 37 ) );

		$this->assertEquals( '#000000', Kirki_Color::mix_colors( '#000000', '000', 100 ) );
		$this->assertEquals( '#000000', Kirki_Color::mix_colors( '#000000', '000', 0 ) );
		$this->assertEquals( '#000000', Kirki_Color::mix_colors( '#000000', '0000', 37 ) );

		$this->assertEquals( '#7f7f7f', Kirki_Color::mix_colors( '#ffffff', '000', 50 ) );
		$this->assertEquals( '#7f7f7f', Kirki_Color::mix_colors( '#ffffff', '#000000', 50 ) );
		$this->assertEquals( '#7f7f7f', Kirki_Color::mix_colors( '#000000', '#ffffff', 50 ) );
	}

}
