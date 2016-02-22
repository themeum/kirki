<?php

class Test_Kirki_Customizer_Scripts_Icons extends WP_UnitTestCase {

	public function test_empty() {

		Kirki_Customizer_Scripts_Icons::generate_script();
		Kirki_Customizer_Scripts_Icons::generate_script( array(
			'icon' => 'foo',
		) );
		Kirki_Customizer_Scripts_Icons::generate_script( array(
			'icon'    => 'foo',
			'context' => 'panel'
		) );

		$this->assertEquals( '', Kirki_Customizer_Scripts_Icons::$icons_script );
	}

	public function test_basic() {

		Kirki_Customizer_Scripts_Icons::generate_script( array(
			'icon'    => 'foo',
			'context' => 'panel',
			'id'      => 'bar',
		) );
		$this->assertEquals(
			'$("#accordion-panel-bar h3").prepend(\'<span class="foo"></span>\');',
			Kirki_Customizer_Scripts_Icons::$icons_script
		);

		Kirki_Customizer_Scripts_Icons::$icons_script = '';
		Kirki_Customizer_Scripts_Icons::generate_script( array(
			'icon'    => 'dashicons-foo',
			'context' => 'section',
			'id'      => 'bar',
		) );
		$this->assertEquals(
			'$("#accordion-section-bar h3").prepend(\'<span class="dashicons dashicons-foo"></span>\');',
			Kirki_Customizer_Scripts_Icons::$icons_script
		);
	}

}
