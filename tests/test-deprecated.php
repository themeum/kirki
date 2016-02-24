<?php

class Test_Kirki_Deprecated extends WP_UnitTestCase {

	public function test() {

		$this->assertEquals(
			kirki_get_option(),
			Kirki::get_option()
		);

		$this->assertEquals(
			kirki_sanitize_hex( '#ffffff' ),
			Kirki_Color::sanitize_hex( '#ffffff' )
		);

		$this->assertEquals(
			kirki_get_rgb( '#ffffff' ),
			Kirki_Color::get_rgb( '#ffffff' )
		);

		$this->assertEquals(
			kirki_get_rgba( '#ffffff' ),
			Kirki_Color::get_rgba( '#ffffff' )
		);

		$this->assertEquals(
			kirki_get_brightness( '#ffffff' ),
			Kirki_Color::get_brightness( '#ffffff' )
		);

		$this->assertEquals(
			Kirki_Fonts::get_all_fonts(),
			Kirki_GoogleFonts::get_all_fonts()
		);

		$this->assertEquals(
			Kirki_Fonts::is_google_font( 'foo' ),
			Kirki_GoogleFonts::is_google_font( 'foo' )
		);

		$this->assertEquals(
			Kirki_Fonts::get_google_font_subsets(),
			Kirki_GoogleFonts::get_google_font_subsets()
		);

		$this->assertEquals(
			Kirki_Fonts::get_standard_fonts(),
			Kirki_GoogleFonts::get_standard_fonts()
		);

		$this->assertEquals(
			Kirki_Fonts::get_google_fonts(),
			Kirki_GoogleFonts::get_google_fonts()
		);

	}

}
