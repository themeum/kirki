<?php

class Test_Kirki_Functions extends WP_UnitTestCase {

	public function test_kirki_path() {
		$this->assertEquals( KIRKI_PATH, kirki_path() );
	}

	public function test_kirki_url() {
		$this->assertEquals( KIRKI_URL, kirki_url() );
	}

}
