<?php

class Test_Kirki_Helper extends WP_UnitTestCase {

	public function test() {
		$tests = array(
			'primary',
			'red',
			'pink',
			'purple',
			'deep-purple',
			'indigo',
			'blue',
			'light_blue',
			'cyan',
			'teal',
			'green',
			'light-green',
			'lime',
			'yellow',
			'amber',
			'orange',
			'deep-orange',
			'brown',
			'grey',
			'blue-grey',
			'50',
			'100',
			'200',
			'300',
			'400',
			'500',
			'600',
			'700',
			'800',
			'900',
			'A100',
			'A200',
			'A400',
			'A700',
			'all',
		);
		foreach ( $tests as $test ) {
			$result = Kirki_Helper::get_material_design_colors( $test );
			$this->assertTrue( is_array( $result ) );
			$this->assertTrue( ! empty( $result ) );
		}
	}
}
