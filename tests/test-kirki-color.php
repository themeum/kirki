<?php

class Test_Kirki_Color extends WP_UnitTestCase {

	public function test_get_rgb() {

		$this->assertEquals(
			'rgb(255,255,255)',
			Kirki_Color::get_rgb( '#ffffff' )
		);

		$this->assertEquals(
			'rgb(0,0,0)',
			Kirki_Color::get_rgb( '#000000' )
		);

		$this->assertEquals(
			'rgb(255,0,0)',
			Kirki_Color::get_rgb( '#ff0000' )
		);

		$this->assertEquals(
			'rgb(0,255,0)',
			Kirki_Color::get_rgb( '#00ff00' )
		);

		$this->assertEquals(
			'rgb(0,0,255)',
			Kirki_Color::get_rgb( '#0000ff' )
		);

	}
}
