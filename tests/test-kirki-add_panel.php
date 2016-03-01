<?php

class Test_Kirki_Add_Panel extends WP_UnitTestCase {

	public $wp_customize;

	function setUp() {
		parent::setUp();
		require_once( ABSPATH . WPINC . '/class-wp-customize-manager.php' );
		// @codingStandardsIgnoreStart
		$GLOBALS['wp_customize'] = new WP_Customize_Manager();
		// @codingStandardsIgnoreEnd
		$this->wp_customize = $GLOBALS['wp_customize'];
	}

	public function test_add_panel() {

		Kirki::add_panel( 'test_empty', array() );
		Kirki::add_panel( 'test', array(
			'priority'    => 4,
			'title'       => 'Title',
			'description' => 'My Description',
		) );

		$this->assertEquals(
			array(
				'id'              => 'test_empty',
				'description'     => '',
				'priority'        => 10,
				'active_callback' => '__return_true',
				'type'            => 'default',
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
				'type'            => 'default',
			),
			Kirki::$panels['test']
		);
		$this->assertEquals( 2, count( Kirki::$panels ) );
	}
}
