<?php

class Test_Kirki_Scripts_Customizer_Tooltips extends WP_UnitTestCase {

	public function test_generate_script() {
		Kirki::add_field( '', array(
			'settings' => 'foo',
			'type' => 'text',
			'section' => 'bar',
			'help' => 'Lorem Ipsum',
		) );
		$this->assertEquals(
			'$( "<a href=\'#\' class=\'tooltip hint--left\' data-hint=\'Lorem Ipsum\'><span class=\'dashicons dashicons-info\'></span></a>" ).prependTo( "#customize-control-foo" );',
			Kirki()->scripts->tooltips->generate_script()
		);
	}

	public function test_customize_controls_print_scripts() {
		Kirki::add_field( '', array(
			'settings' => 'foo',
			'type' => 'text',
			'section' => 'bar',
			'help' => 'Lorem Ipsum',
		) );
		$script = '$( "<a href=\'#\' class=\'tooltip hint--left\' data-hint=\'Lorem Ipsum\'><span class=\'dashicons dashicons-info\'></span></a>" ).prependTo( "#customize-control-foo" );';
		$this->expectOutputString( '<script>jQuery(document).ready(function($) { "use strict"; '.$script.'});</script>' );
		Kirki()->scripts->tooltips->customize_controls_print_footer_scripts();
	}
}
