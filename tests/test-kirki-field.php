<?php

class Test_Kirki_Field extends WP_UnitTestCase {

	public function test_set_kirki_config() {

		Kirki::add_field( 'global', array(
			'settings' => 'test1',
			'type'     => 'text',
		) );

		Kirki::add_field( 'my_test_config', array(
			'settings' => 'test2',
			'type'     => 'text',
		) );

		$this->assertTrue( 'global' === Kirki::$fields['test1']['kirki_config'] );
		$this->assertTrue( 'my_test_config' === Kirki::$fields['test2']['kirki_config'] );
	}

	public function test_set_input_attrs() {

		Kirki::add_field( 'global', array(
			'settings'    => 'test1',
			'type'        => 'text',
			'input_attrs' => 'test'
		) );

		$this->assertTrue( array() === Kirki::$fields['test1']['input_attrs'] );

		Kirki::add_field( 'global', array(
			'settings'    => 'test1',
			'type'        => 'text',
			'input_attrs' => array(
				'foo' => 'bar',
			),
		) );

		$this->assertTrue( array( 'foo' => 'bar' ) === Kirki::$fields['test1']['input_attrs'] );
	}

	public function test_set_capability() {

		Kirki::add_field( 'global', array(
			'settings' => 'test1',
			'type'     => 'text',
		) );

		$this->assertTrue( 'edit_theme_options' === Kirki::$fields['test1']['capability'] );

		Kirki::add_field( 'global', array(
			'settings'   => 'test1',
			'type'       => 'text',
			'capability' => 'foo',
		) );

		$this->assertTrue( 'foo' === Kirki::$fields['test1']['capability'] );
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
