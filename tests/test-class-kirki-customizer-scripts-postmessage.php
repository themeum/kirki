<?php

class Test_Class_Kirki_Customizer_Scripts_PostMessage extends WP_UnitTestCase {

	public function test_generate_script() {
		Kirki_Customizer_Scripts_PostMessage::generate_script( array(
			'settings'  => 'my_setting',
			'transport' => 'postMessage',
			'js_vars'   => array(
				array(
					'element'  => 'body',
					'function' => 'css',
					'property' => 'font-size',
					'units'    => 'px',
				),
			),
		) );

		$this->assertEquals(
			Kirki_Customizer_Scripts_PostMessage::$postmessage_script,
			'wp.customize( \'my_setting\', function( value ) {value.bind( function( newval ) {$(\'body\').css(\'font-size\', newval + \'px\' );}); });'
		);
	}
}
