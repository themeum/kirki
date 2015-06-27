<?php

class Test_Kirki_Customizer_Script_Postmessage extends WP_UnitTestCase {

	public function init_customizer() {
		global $wp_customize;
		if ( ! isset( $wp_customize ) ) {
			if ( ! class_exists( 'WP_Customize_Manager' ) ) {
				require_once( ABSPATH . '/wp-includes/class-wp-customize-manager.php' );
			}
			$wp_customize = new WP_Customize_Manager();
		}
		return $wp_customize;
	}

	public function test_generate_script() {
		$js_vars = array(
			'element' => 'body',
			'function' => 'css',
			'property' => 'color',
		);
		Kirki::add_field( '', array( 'settings' => 'foo', 'type' => 'text', 'transport' => 'postMessage', 'js_vars' => $js_vars ) );
		set_theme_mod( 'foo', '#333' );
		$wp_customize = $this->init_customizer();

		$this->assertEquals(
			'wp.customize( \'foo\', function( value ) {value.bind( function( newval ) {$(\'body\').css(\'color\', newval );}); });',
			Kirki()->scripts->postmessage->generate_script()
		);

		$js_vars = array(
			'element' => 'body',
			'function' => 'html',
		);
		Kirki::add_field( '', array( 'settings' => 'foo', 'type' => 'text', 'transport' => 'postMessage', 'js_vars' => $js_vars ) );
		set_theme_mod( 'foo', 'this is a string' );
		$wp_customize = $this->init_customizer();

		$this->assertEquals(
			'wp.customize( \'foo\', function( value ) {value.bind( function( newval ) {$(\'body\').html( newval );}); });',
			Kirki()->scripts->postmessage->generate_script()
		);
	}
}
