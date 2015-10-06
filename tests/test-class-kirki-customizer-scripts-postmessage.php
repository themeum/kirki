<?php

class Test_Class_Kirki_Customizer_Scripts_PostMessage extends WP_UnitTestCase {

	public function test_generate_script_valid() {
		$postmessage = new Kirki_Customizer_Scripts_PostMessage();
		/**
		 * No script should be generated here
		 */
		Kirki_Customizer_Scripts_PostMessage::generate_script( array(
			'settings'  => 'my_setting',
			'transport' => 'refresh',
		) );
		$this->assertEquals(
			Kirki_Customizer_Scripts_PostMessage::$postmessage_script,
			null
		);

		/**
		 * Generate the script normally with valid values
		 * Use the "css" function.
		 */
		Kirki_Customizer_Scripts_PostMessage::$postmessage_script = '';
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

		/**
		 * Generate the script normally with valid values
		 * Use the "html" function.
		 */
		Kirki_Customizer_Scripts_PostMessage::$postmessage_script = '';
		Kirki_Customizer_Scripts_PostMessage::generate_script( array(
			'settings'  => 'my_setting',
			'transport' => 'postMessage',
			'js_vars'   => array(
				array(
					'element'  => 'body',
					'function' => 'html',
				),
			),
		) );
		$this->assertEquals(
			Kirki_Customizer_Scripts_PostMessage::$postmessage_script,
			'wp.customize( \'my_setting\', function( value ) {value.bind( function( newval ) {$(\'body\').html( newval );}); });'
		);

		/**
		 * Test that the final script is properly wrapped and echoed
		 */
		$this->expectOutputString('<script>jQuery(document).ready(function($) { "use strict"; wp.customize( \'my_setting\', function( value ) {value.bind( function( newval ) {$(\'body\').html( newval );}); });});</script>');
		$postmessage->enqueue_script();

	}

}
