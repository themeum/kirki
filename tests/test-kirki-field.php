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
}
