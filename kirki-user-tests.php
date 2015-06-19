<?php

class Kirki_Test_Field {

	/**
	 * The section is an array:
	 * section['id'], $section['name']
	 */
	public $section = array();

	/**
	 * The field is an array
	 * Built just like any other field.
	 * See https://github.com/reduxframework/kirki/wiki/Fields
	 */
	public $field = array();

	/**
	 * The class constructor
	 */
	public function __construct( $section_args = array(), $field_args = array() ) {

		$this->section = $section_args;
		$this->field = $field_args;

		$this->create_section();
		$this->add_fields_via_api();

		add_filter( 'kirki/fields', array( $this, 'add_filter_fields' ) );

	}

	/**
	 * Create the Section
	 */
	public function create_section() {
		Kirki::add_section( $this->section['id'], array(
			'priority' => 10,
			'title'    => $this->section['name'],
		) );
	}

	/**
	 * Add the field using the
	 */
	public function add_filter_fields( $fields ) {

		$args = $this->field;
		$args['section']      = $this->section['id'];

		$args['settings']     = $args['settings'].'_0';
		$args['label']        = sprintf( __( '%s theme_mod via filter', 'kirki' ), $args['type'] );
		$args['options_type'] = 'theme_mod';
		$fields[] = $args;

		$args['settings']     = $args['settings'].'_1';
		$args['label']        = sprintf( __( '%s single option via filter', 'kirki' ), $args['type'] );
		$args['options_type'] = 'option';
		$fields[] = $args;

		// $args['settings']     = $args['settings'] . '_2';
		// $args['options_type'] = 'option';
		// $args['label']        = sprintf( __( '%s serialized option via filter', 'kirki' ), $args['type'] );
		// $args['option_name']  = 'kirki_test';
		// $fields[] = $args;

		return $fields;

	}

	/**
	 * Add fields using the Kirki API
	 */
	public function add_fields_via_api() {

		$args = $this->field;
		$args['section']      = $this->section['id'];
		$args['capability']   = 'read';

		$args['settings']     = $args['settings'].'_3';
		$args['label']        = sprintf( __( '%s theme_mod via API', 'kirki' ), $args['type'] );
		$args['options_type'] = 'theme_mod';
		Kirki::add_field( '', $args );

		$args['settings']     = $args['settings'].'_4';
		$args['label']        = sprintf( __( '%s single option via API', 'kirki' ), $args['type'] );
		$args['options_type'] = 'option';
		Kirki::add_field( '', $args );

		// $args['settings']     = $args['settings'] . '_5';
		// $args['options_type'] = 'option';
		// $args['label']        = sprintf( __( '%s serialized option via API', 'kirki' ), $args['type'] );
		// $args['option_name']  = 'kirki_test';
		// Kirki::add_field( '', $args );

	}

}

$checkbox = new Kirki_Test_Field(
	array(
		'id'   => 'checkbox_test',
		'name' => __( 'Checkbox Tests', 'kirki' )
	),
	array(
		'settings' => 'checkbox_demo',
		'type'     => 'checkbox'
	)

);
