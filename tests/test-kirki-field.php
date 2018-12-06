<?php

class Test_Kirki_Field extends WP_UnitTestCase {

	public function test_set_input_attrs() {

		Kirki::add_field( 'global', array(
			'settings'    => 'test1',
			'type'        => 'text',
			'input_attrs' => 'test'
		) );

		$this->assertFalse( array() === Kirki::$fields['test1']['input_attrs'] );

		Kirki::add_field( 'global', array(
			'settings'    => 'test1',
			'type'        => 'text',
			'input_attrs' => array(
				'foo' => 'bar',
			),
		) );

		$this->assertTrue( array( 'foo' => 'bar' ) === Kirki::$fields['test1']['input_attrs'] );
	}

	public function test_set_active_callback() {

		Kirki::add_field( 'global', array(
			'settings'        => 'test1',
			'type'            => 'text',
			'active_callback' => array(
				array(
					'setting'  => 'foo',
					'operator' => '===',
					'value'    => 'bar',
				),
				'__return_true',
			),
		) );

		$this->assertEquals(
			array(
				array(
					'setting'  => 'foo',
					'operator' => '===',
					'value'    => 'bar',
				),
			),
			Kirki::$fields['test1']['required']
		);
	}
}
