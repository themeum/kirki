<?php

class Test_Kirki_Fonts extends WP_UnitTestCase {

	public function test_get_all_fonts() {
		$this->assertNotEmpty( Kirki_Fonts::get_all_fonts() );
	}

	public function test_get_standard_fonts() {
		$this->assertNotEmpty( Kirki_Fonts::get_all_fonts() );
		$this->assertTrue( 3 == count( Kirki_Fonts::get_standard_fonts() ) );
		$this->assertArrayHasKey( 'serif', Kirki_Fonts::get_all_fonts() );
		$this->assertArrayHasKey( 'sans-serif', Kirki_Fonts::get_all_fonts() );
		$this->assertArrayHasKey( 'monospace', Kirki_Fonts::get_all_fonts() );
	}

}
