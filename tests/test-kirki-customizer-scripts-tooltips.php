<?php

class Test_Kirki_Scripts_Tooltips extends WP_UnitTestCase {

	public function test_empty() {

		Kirki_Scripts_Tooltips::generate_script();
		Kirki_Scripts_Tooltips::generate_script( array(
			'type' => 'foo'
		) );
		Kirki_Scripts_Tooltips::generate_script( array(
			'type'    => 'color-alpha',
			'tooltip' => 'bar',
		) );

		$this->assertEquals( '', Kirki_Scripts_Tooltips::$tooltip_script );

	}

	public function test_basic() {

		Kirki_Scripts_Tooltips::generate_script( array(
			'type'     => 'foo',
			'settings' => 'bar',
			'tooltip'  => 'My Tooltip',
		) );
		$this->assertEquals(
			'$( "<a href=\'#\' class=\'tooltip hint--left\' data-hint=\'My Tooltip\'><span class=\'dashicons dashicons-info\'></span></a>" ).prependTo( "#customize-control-bar" );',
			Kirki_Scripts_Tooltips::$tooltip_script
		);

	}

}
