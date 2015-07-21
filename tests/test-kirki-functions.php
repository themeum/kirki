<?php

class Test_Kirki_Functions extends WP_UnitTestCase {

	public function test_kirki_path() {
		$this->assertEquals( KIRKI_PATH, kirki_path() );
	}

	public function test_kirki_url() {
		$this->assertEquals( KIRKI_URL, kirki_url() );
		add_filter( 'kirki/config', function( $config ) {
			$config['url_path'] = get_stylesheet_directory_uri().'/inc';
			return $config;
		});
		$this->assertEquals( get_stylesheet_directory_uri().'/inc', kirki_url() );
	}

}
