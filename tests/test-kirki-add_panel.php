<?php

class Test_Kirki_Add_Panel extends WP_UnitTestCase {

	public function __construct() {
		$this->add_panels();
	}

	public function add_panels() {
		Kirki::add_panel( 'test_empty', array() );
		Kirki::add_panel( 'test', array(
			'priority'    => 4,
			'title'       => 'Title',
			'description' => 'My Description',
		) );
	}

	public function test_add_panel() {
		$this->assertEquals(
			array(
				'id'              => 'test_empty',
				'description'     => '',
				'priority'        => 10,
				'active_callback' => '__return_true',
			),
			Kirki::$panels['test_empty']
		);
		$this->assertEquals(
			array(
				'id'              => 'test',
				'title'           => 'Title',
				'description'     => 'My Description',
				'priority'        => '4',
				'active_callback' => '__return_true',
			),
			Kirki::$panels['test']
		);
		$this->assertEquals( 2, count( Kirki::$panels ) );
	}
}
