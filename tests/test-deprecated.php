<?php

class Test_Kirki_Deprecated extends WP_UnitTestCase {

	public function add_theme_mod_field() {
		Kirki::add_field( '', array(
			'type' => 'text',
			'settings' => 'the_mod_option',
			'section' => 'my_section',
			'default' => 'foo',
			'priority' => 20,
			'option_type' => 'theme_mod',
		) );
	}

	public function test_kirki_get_option() {
		$this->add_theme_mod_field();
		$this->assertEquals( 'foo', kirki_get_option( 'the_mod_option' ) );
		set_theme_mod( 'the_mod_option', 'bar' );
		$this->assertEquals( 'bar', kirki_get_option( 'the_mod_option' ) );
	}

	public function test_kirki_sanitize_hex() {
		$random_color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
		$this->assertEquals( kirki_sanitize_hex( $random_color ), Kirki_Color::sanitize_hex( $random_color ) );
	}

	public function test_kirki_get_rgb() {
		$random_color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
		$this->assertEquals( kirki_get_rgb( $random_color ), Kirki_Color::get_rgb( $random_color ) );
	}

	public function test_kirki_get_rgba() {
		$random_color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
		$this->assertEquals( kirki_get_rgba( $random_color ), Kirki_Color::get_rgba( $random_color ) );
	}

	public function test_kirki_get_brightness() {
		$random_color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT) . str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
		$this->assertEquals( kirki_get_brightness( $random_color ), Kirki_Color::get_brightness( $random_color ) );
	}

	public function test_kirki_fonts() {
		$this->assertEquals( Kirki_Fonts::get_all_fonts(), Kirki_Toolkit::fonts()->get_all_fonts() );
		$this->assertEquals( Kirki_Fonts::get_font_choices(), Kirki_Toolkit::fonts()->get_font_choices() );
		$this->assertEquals( Kirki_Fonts::is_google_font( 'Open Sans' ), Kirki_Toolkit::fonts()->is_google_font( 'Open Sans' ) );
		$this->assertEquals( Kirki_Fonts::get_google_font_uri( array( 'Roboto' ) ), Kirki_Toolkit::fonts()->get_google_font_uri( array( 'Roboto' ) ) );
		$this->assertEquals( Kirki_Fonts::get_google_font_subsets(), Kirki_Toolkit::fonts()->get_google_font_subsets() );
		$this->assertEquals( Kirki_Fonts::choose_google_font_variants( 'Roboto' ), Kirki_Toolkit::fonts()->choose_google_font_variants( 'Roboto' ) );
		$this->assertEquals( Kirki_Fonts::get_standard_fonts(), Kirki_Toolkit::fonts()->get_standard_fonts() );
		$this->assertEquals( Kirki_Fonts::get_font_stack( '' ), Kirki_Toolkit::fonts()->get_font_stack( '' ) );
		$this->assertEquals( Kirki_Fonts::sanitize_font_choice( '' ), Kirki_Toolkit::fonts()->sanitize_font_choice( '' ) );
		$this->assertEquals( Kirki_Fonts::get_google_fonts(), Kirki_Toolkit::fonts()->get_google_fonts() );
	}
}
