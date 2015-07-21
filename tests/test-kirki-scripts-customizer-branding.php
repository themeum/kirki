<?php

class Test_Kirki_Scripts_Customizer_Branding extends WP_UnitTestCase {

	public function test_generate_script() {
		add_filter( 'kirki/config', function() {
			return array(
				'logo_image' => 'http://foo.com/bar.png',
				'description' => 'Lorem ipsum dolor sit amet',
			);
		});
		$this->assertEquals(
			'$( \'div#customize-info .preview-notice\' ).replaceWith( \'<img src="http://foo.com/bar.png">\' );$( \'div#customize-info .accordion-section-content\' ).replaceWith( \'<div class="accordion-section-content"><div class="theme-description">Lorem ipsum dolor sit amet</div></div>\' );',
			Kirki()->scripts->branding->generate_script()
		);
	}

	public function test_customize_controls_print_scripts() {
		add_filter( 'kirki/config', function() {
			return array();
		});
		$this->expectOutputString( '' );
		print '';

		add_filter( 'kirki/config', function() {
			return array(
				'logo_image' => 'http://foo.com/bar.png',
				'description' => 'Lorem ipsum dolor sit amet',
			);
		});
		$script = '$( \'div#customize-info .preview-notice\' ).replaceWith( \'<img src="http://foo.com/bar.png">\' );$( \'div#customize-info .accordion-section-content\' ).replaceWith( \'<div class="accordion-section-content"><div class="theme-description">Lorem ipsum dolor sit amet</div></div>\' );';
		$this->expectOutputString( '<script>jQuery(document).ready(function($) { "use strict"; '.$script.'});</script>' );
		Kirki()->scripts->branding->customize_controls_print_scripts();
	}
}
