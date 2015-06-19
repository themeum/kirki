<?php

class Kirki_Test_Field {

	/**
	 * The field is an array
	 * Built just like any other field.
	 * See https://github.com/reduxframework/kirki/wiki/Fields
	 */
	public $field = array();

	/**
	 * The class constructor
	 */
	public function __construct( $field_args = array() ) {

		$this->field = $field_args;
		$this->create_section();
		$this->add_fields_via_api();

		add_filter( 'kirki/fields', array( $this, 'add_filter_fields' ) );

	}

	/**
	 * Create the Section
	 */
	public function create_section() {
		Kirki::add_section( sanitize_key( $this->field['type'] ), array(
			'priority' => 10,
			'title'    => sprintf( __( '%s test', 'kirki' ), $this->field['type'] ),
		) );
	}

	/**
	 * Add the field using the
	 */
	public function add_filter_fields( $fields ) {

		$args = $this->field;
		$args['section']      = sanitize_key( $this->field['type'] );

		$args['settings']     = sanitize_key( $this->field['type'] ).'_demo_0';
		$args['label']        = sprintf( __( '%s theme_mod via filter', 'kirki' ), $args['type'] );
		$args['options_type'] = 'theme_mod';
		$fields[] = $args;

		$args['settings']     = sanitize_key( $this->field['type'] ).'_demo_1';
		$args['label']        = sprintf( __( '%s single option via filter', 'kirki' ), $args['type'] );
		$args['options_type'] = 'option';
		$fields[] = $args;

		$args['settings']     = sanitize_key( $this->field['type'] ).'_demo_2';
		$args['options_type'] = 'option';
		$args['label']        = sprintf( __( '%s serialized option via filter', 'kirki' ), $args['type'] );
		$args['option_name']  = 'kirki_test';
		$fields[] = $args;

		return $fields;

	}

	/**
	 * Add fields using the Kirki API
	 */
	public function add_fields_via_api() {

		$args = $this->field;
		$args['section']      = sanitize_key( $this->field['type'] );
		$args['capability']   = 'read';

		$args['settings']     = sanitize_key( $this->field['type'] ).'_demo_3';
		$args['label']        = sprintf( __( '%s theme_mod via API', 'kirki' ), $args['type'] );
		$args['options_type'] = 'theme_mod';
		Kirki::add_field( '', $args );

		$args['settings']     = sanitize_key( $this->field['type'] ).'_demo_4';
		$args['label']        = sprintf( __( '%s single option via API', 'kirki' ), $args['type'] );
		$args['options_type'] = 'option';
		Kirki::add_field( '', $args );

		$args['settings']     = sanitize_key( $this->field['type'] ).'_demo_5';
		$args['options_type'] = 'option';
		$args['label']        = sprintf( __( '%s serialized option via API', 'kirki' ), $args['type'] );
		$args['option_name']  = 'kirki_test';
		Kirki::add_field( '', $args );

	}

}

// checkbox
$checkbox = new Kirki_Test_Field( array( 'type' => 'checkbox' ) );
/**
// color-alpha
$color_alpha = new Kirki_Test_Field( array( 'type' => 'color-alpha' ) );
// color
$color = new Kirki_Test_Field( array( 'type' => 'color' ) );
// custom
$custom = new Kirki_Test_Field( array( 'type' => 'custom' ) );
// dropdown-pages
$dropdown_pages = new Kirki_Test_Field( array( 'type' => 'dropdown-pages' ) );
// editor
$editor = new Kirki_Test_Field( array( 'type' => 'editor' ) );
// image
$image = new Kirki_Test_Field( array( 'type' => 'image' ) );
// multicheck
$multicheck = new Kirki_Test_Field( array( 'type' => 'multicheck' ) );
// number
$number = new Kirki_Test_Field( array( 'type' => 'number' ) );
// palette
$palette = new Kirki_Test_Field( array( 'type' => 'palette' ) );
// radio-buttonset
$radio_buttonset = new Kirki_Test_Field( array( 'type' => 'radio-buttonset' ) );
// radio-image
$radio_image = new Kirki_Test_Field( array( 'type' => 'radio-image' ) );
// radio
$radio = new Kirki_Test_Field( array( 'type' => 'radio' ) );
// select
$select = new Kirki_Test_Field( array( 'type' => 'select' ) );
// slider
$slider = new Kirki_Test_Field( array( 'type' => 'slider' ) );
// sortable
$sortable = new Kirki_Test_Field( array( 'type' => 'sortable' ) );
// switch
$switch = new Kirki_Test_Field( array( 'type' => 'switch' ) );
// text
$text = new Kirki_Test_Field( array( 'type' => 'text' ) );
// textarea
$textarea = new Kirki_Test_Field( array( 'type' => 'textarea' ) );
// toggle
$toggle = new Kirki_Test_Field( array( 'type' => 'toggle' ) );
// upload
$upload = new Kirki_Test_Field( array( 'type' => 'upload' ) );
*/
