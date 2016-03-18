<?php

class Test_Kirki_Fonts extends WP_UnitTestCase {

	public function test_get_all_fonts() {
		$this->assertNotEmpty( Kirki_Fonts::get_all_fonts() );
	}

	public function test_get_standard_fonts() {
		$this->assertTrue( 3 == count( Kirki_Fonts::get_standard_fonts() ) );

		$this->assertNotEmpty( Kirki_Fonts::get_all_fonts() );

		$this->assertArrayHasKey( 'serif', Kirki_Fonts::get_standard_fonts() );
		$this->assertArrayHasKey( 'sans-serif', Kirki_Fonts::get_standard_fonts() );
		$this->assertArrayHasKey( 'monospace', Kirki_Fonts::get_standard_fonts() );

		$this->assertArrayHasKey( 'serif', Kirki_Fonts::get_all_fonts() );
		$this->assertArrayHasKey( 'sans-serif', Kirki_Fonts::get_all_fonts() );
		$this->assertArrayHasKey( 'monospace', Kirki_Fonts::get_all_fonts() );

		$this->assertTrue( 3 < count( Kirki_Fonts::get_all_fonts() ) );
	}

	public function test_instance() {
		$this->assertTrue( null != Kirki_Fonts::get_instance() );
	}

	public function test_get_backup_fonts() {
		$this->assertNotEmpty( Kirki_Fonts::get_backup_fonts() );
		$this->assertTrue( 5 == count( Kirki_Fonts::get_backup_fonts() ) );
		$this->assertArrayHasKey( 'serif', Kirki_Fonts::get_backup_fonts() );
		$this->assertArrayHasKey( 'sans-serif', Kirki_Fonts::get_backup_fonts() );
		$this->assertArrayHasKey( 'display', Kirki_Fonts::get_backup_fonts() );
		$this->assertArrayHasKey( 'handwriting', Kirki_Fonts::get_backup_fonts() );
		$this->assertArrayHasKey( 'monospace', Kirki_Fonts::get_backup_fonts() );
	}

	public function test_get_google_font_subsets() {
		$this->assertTrue( is_array( Kirki_Fonts::get_google_font_subsets() ) );
		$this->assertEquals( Kirki_Fonts::get_google_font_subsets(), Kirki_Fonts::get_google_font_subsets() );
	}

}
