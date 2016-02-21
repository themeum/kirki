<?php

class Test_Kirki_Control extends WP_UnitTestCase {

	public function test_count_controls() {
		$this->assertEquals( 24, count( Kirki_Control::$control_types ) );
	}

	public function test_count_settings() {
		$this->assertEquals( 1, count( Kirki_Control::$setting_types ) );
	}

	public function test_control_class_names() {
		foreach ( Kirki_Control::$control_types as $key => $value ) {
			$this->assertEquals( $value, Kirki_Control::control_class_name( array( 'type' => $key ) ) );
		}
		$this->assertEquals( $value, Kirki_Control::control_class_name( array( 'type' => $key ) ) );
		$this->assertEquals( 'WP_Customize_Control', Kirki_Control::control_class_name( array( 'type' => 'foo' ) ) );
	}

}
