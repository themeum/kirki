<?php

class Test_Kirki_Helper extends WP_UnitTestCase {

	public function test() {
		$tests = array( 'primary', 'red', 'pink', 'purple', 'deep-purple', 'indigo', 'blue', 'light_blue', 'cyan', 'teal', 'green', 'light-green', 'lime', 'yellow', 'amber', 'orange', 'deep-orange', 'brown', 'grey', 'blue-grey', '50', '100', '200', '300', '400', '500', '600', '700', '800', '900', 'A100', 'A200', 'A400', 'A700', 'all' );
		foreach ( $tests as $test ) {
			$result = Kirki_Helper::get_material_design_colors( $test );
			$this->assertTrue( is_array( $result ) );
			$this->assertTrue( ! empty( $result ) );
		}

		global $wp_filesystem;
		Kirki_Helper::init_filesystem();
		$this->assertTrue( ! is_null( $wp_filesystem ) );

		$this->assertTrue( is_array( Kirki_Helper::get_posts( array() ) ) );
		$this->assertTrue( is_array( Kirki_Helper::get_taxonomies() ) );
	}

	public function test_compare_values() {
		$this->assertTrue( Kirki_Helper::compare_values( 'test', 'test', '===' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', 1, '===' ) );

		$this->assertTrue( Kirki_Helper::compare_values( 'test', 'test', '==' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', 1, '==' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', true, '==' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', 2, '==' ) );

		$this->assertTrue( ! Kirki_Helper::compare_values( 'test', 'test', '!==' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', 1, '!==' ) );

		$this->assertTrue( ! Kirki_Helper::compare_values( 'test', 'test', '!=' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', 1, '!=' ) );

		$this->assertTrue( Kirki_Helper::compare_values( '1', '2', '>=' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 2, '1', '>=' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '1', '>=' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 1, '1', '>=' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '2', 'greater or equal' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 2, '1', 'greater or equal' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '1', 'greater or equal' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 1, '1', 'greater or equal' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '2', 'equal or greater' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 2, '1', 'equal or greater' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '1', 'equal or greater' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 1, '1', 'equal or greater' ) );

		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '2', '<=' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 2, '1', '<=' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '1', '<=' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 1, '1', '<=' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '2', 'smaller or equal' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 2, '1', 'smaller or equal' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '1', 'smaller or equal' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 1, '1', 'smaller or equal' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '2', 'equal or smaller' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 2, '1', 'equal or smaller' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '1', 'equal or smaller' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 1, '1', 'equal or smaller' ) );

		$this->assertTrue( Kirki_Helper::compare_values( '1', '2', '>' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 2, '1', '>' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '1', '>' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 1, '1', '>' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1', '2', 'greater' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 2, '1', 'greater' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '1', 'greater' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 1, '1', 'greater' ) );

		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '2', '<' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 2, '1', '<' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '1', '<' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 1, '1', '<' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '2', 'smaller' ) );
		$this->assertTrue( Kirki_Helper::compare_values( 2, '1', 'smaller' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( '1', '1', 'smaller' ) );
		$this->assertTrue( ! Kirki_Helper::compare_values( 1, '1', 'smaller' ) );

		$this->assertTrue( Kirki_Helper::compare_values( array( '1a', '2b', '3c' ), array( '1a' ), 'contains' ) );
		$this->assertTrue( Kirki_Helper::compare_values( array( '1a', '2b', '3c' ), '2b', 'contains' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '3c', array( '1a', '2b', '3c' ), 'contains' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1a2b3c', 'b3', 'contains' ) );
		$this->assertTrue( Kirki_Helper::compare_values( array( '1a', '2b', '3c' ), array( '1a' ), 'in' ) );
		$this->assertTrue( Kirki_Helper::compare_values( array( '1a', '2b', '3c' ), '2b', 'in' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '3c', array( '1a', '2b', '3c' ), 'in' ) );
		$this->assertTrue( Kirki_Helper::compare_values( '1a2b3c', 'a2', 'in' ) );
	}
}
