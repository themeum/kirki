<?php

class Test_Kirki_Color extends WP_UnitTestCase {

	public function test() {

		$this->assertEquals(
			array( 255, 255, 255 ),
			Kirki_Color::get_rgb( '#ffffff' )
		);

		$this->assertEquals(
			array( 0, 0, 0 ),
			Kirki_Color::get_rgb( '#000000' )
		);

		$this->assertEquals(
			array( 255, 0, 0 ),
			Kirki_Color::get_rgb( '#ff0000' )
		);

		$this->assertEquals(
			array( 0, 255, 0 ),
			Kirki_Color::get_rgb( '#00ff00' )
		);

		$this->assertEquals(
			array( 0, 0, 255 ),
			Kirki_Color::get_rgb( '#0000ff' )
		);

		$this->assertEquals( 'rgba(0,0,33,.4)', Kirki_Color::sanitize_rgba( 'rgba(0,0,33,.4)' ) );

		$this->assertEquals( 'transparent', Kirki_Color::sanitize_color( 'transparent' ) );
		$this->assertEquals( '#333333', Kirki_Color::sanitize_color( '#333333' ) );
		$this->assertEquals( 'rgba(255,200,200,1)', Kirki_Color::sanitize_color( 'rgba(255,200,200,1)' ) );

		$this->assertEquals( '#ffffff', Kirki_Color::rgba2hex( 'rgba(255,255,255,1)' ) );
		$this->assertEquals( '#000000', Kirki_Color::rgba2hex( 'rgba(0,0,0,1)' ) );

		$this->assertEquals( '1', Kirki_Color::get_alpha_from_rgba( 'rgba(255,255,255,1)' ) );
		$this->assertEquals( '.35', Kirki_Color::get_alpha_from_rgba( 'rgba(255,255,255,.35)' ) );
		$this->assertEquals( '0', Kirki_Color::get_alpha_from_rgba( 'rgba(255,255,255,0)' ) );

	}
}
