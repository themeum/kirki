<?php

class Test_Kirki_Scripts_Icons extends WP_UnitTestCase {

	public function test_empty() {

		Kirki_Scripts_Icons::generate_script();
		Kirki_Scripts_Icons::generate_script( array(
			'icon' => 'foo',
		) );
		Kirki_Scripts_Icons::generate_script( array(
			'icon'    => 'foo',
			'context' => 'panel'
		) );

		$this->assertEquals( '', Kirki_Scripts_Icons::$icons_script );
	}

	public function test_basic() {

		Kirki_Scripts_Icons::generate_script( array(
			'icon'    => 'foo',
			'context' => 'panel',
			'id'      => 'bar',
		) );
		$this->assertEquals(
			'$("#accordion-panel-bar h3").prepend(\'<span class="foo"></span>\');',
			Kirki_Scripts_Icons::$icons_script
		);

		Kirki_Scripts_Icons::$icons_script = '';
		Kirki_Scripts_Icons::generate_script( array(
			'icon'    => 'dashicons-foo',
			'context' => 'section',
			'id'      => 'bar',
		) );
		$this->assertEquals(
			'$("#accordion-section-bar h3").prepend(\'<span class="dashicons dashicons-foo"></span>\');',
			Kirki_Scripts_Icons::$icons_script
		);
	}

}
