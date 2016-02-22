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

		$font_registry = Kirki_Toolkit::fonts();

		$this->assertEquals(
			Kirki_Fonts::get_all_fonts(),
			$font_registry->get_all_fonts()
		);

		$this->assertEquals(
			Kirki_Fonts::get_font_choices(),
			$font_registry->get_font_choices()
		);

		$this->assertEquals(
			Kirki_Fonts::is_google_font( 'foo' ),
			$font_registry->is_google_font( 'foo' )
		);

		$this->assertEquals(
			Kirki_Fonts::get_google_font_uri( array( 'foo' ) ),
			$font_registry->get_google_font_uri( array( 'foo' ) )
		);

		$this->assertEquals(
			Kirki_Fonts::get_google_font_subsets(),
			$font_registry->get_google_font_subsets()
		);

		$this->assertEquals(
			Kirki_Fonts::choose_google_font_variants( 'Roboto' ),
			$font_registry->choose_google_font_variants( 'Roboto' )
		);

		$this->assertEquals(
			Kirki_Fonts::get_standard_fonts(),
			$font_registry->get_standard_fonts()
		);

		$this->assertEquals(
			Kirki_Fonts::get_font_stack( 'foo' ),
			$font_registry->get_font_stack( 'foo' )
		);

		$this->assertEquals(
			Kirki_Fonts::sanitize_font_choice( 'foo' ),
			$font_registry->sanitize_font_choice( 'foo' )
		);

		$this->assertEquals(
			Kirki_Fonts::get_google_fonts(),
			$font_registry->get_google_fonts()
		);

	}

}
