<?php

class Test_Kirki_Classes_Init extends WP_UnitTestCase {

	public function test() {

		$l10n = new Kirki_l10n();
		$this->assertTrue( is_object( $l10n ) );

		$loading = new Kirki_Scripts_Loading();
		$this->assertTrue( is_object( $loading ) );

	}

}
