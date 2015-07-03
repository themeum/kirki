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
		$args['section'] = sanitize_key( $this->field['type'] );

		$args['settings']    = sanitize_key( $this->field['type'] ).'_demo_0';
		$args['label']       = sprintf( __( '%s theme_mod via filter', 'kirki' ), $args['type'] );
		$args['option_type'] = 'theme_mod';
		$fields[] = $args;

		$args['settings']    = sanitize_key( $this->field['type'] ).'_demo_1';
		$args['label']       = sprintf( __( '%s single option via filter', 'kirki' ), $args['type'] );
		$args['option_type'] = 'option';
		$fields[] = $args;

		$args['settings']    = sanitize_key( $this->field['type'] ).'_demo_2';
		$args['option_type'] = 'option';
		$args['label']       = sprintf( __( '%s serialized option via filter', 'kirki' ), $args['type'] );
		$args['option_name'] = 'kirki_test';
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

		$args['settings']    = sanitize_key( $this->field['type'] ).'_demo_3';
		$args['label']       = sprintf( __( '%s theme_mod via API', 'kirki' ), $args['type'] );
		$args['option_type'] = 'theme_mod';
		Kirki::add_field( '', $args );

		$args['settings']    = sanitize_key( $this->field['type'] ).'_demo_4';
		$args['label']       = sprintf( __( '%s single option via API', 'kirki' ), $args['type'] );
		$args['option_type'] = 'option';
		Kirki::add_field( '', $args );

		$args['settings']    = sanitize_key( $this->field['type'] ).'_demo_5';
		$args['option_type'] = 'option';
		$args['label']       = sprintf( __( '%s serialized option via API', 'kirki' ), $args['type'] );
		$args['option_name'] = 'kirki_test';
		Kirki::add_field( '', $args );

	}

}

// checkbox
$checkbox = new Kirki_Test_Field( array( 'type' => 'checkbox', 'default' => 1 ) );

// color-alpha
$color_alpha = new Kirki_Test_Field( array( 'type' => 'color-alpha', 'default' => 'rgba(255,0,0,.75)', 'output' => array( 'element' => 'body a', 'property' => 'color' ) ) );

// color
$color = new Kirki_Test_Field( array( 'type' => 'color', 'default' => '#0000ff', 'output' => array( 'element' => 'a:hover', 'property' => 'color' ) ) );

// custom
$custom = new Kirki_Test_Field( array( 'type' => 'custom', 'default' => '<div style="text-align:center; background-color:#333; margin:10px 5px;"><h3 style="color: #fff !important;">Custom Control Test</h3></div>' ) );

// dropdown-pages
$dropdown_pages = new Kirki_Test_Field( array( 'type' => 'dropdown-pages', 'default' => 1 ) );

// editor
$editor = new Kirki_Test_Field( array( 'type' => 'editor', 'default' => 'This is the standard TinyMCE editor.' ) );

// image
$image = new Kirki_Test_Field( array( 'type' => 'image', 'default' => '' ) );

// multicheck
$multicheck = new Kirki_Test_Field( array( 'type' => 'multicheck', 'default' => array( 'option1' ), 'choices' => array( 'option1' => __( 'Option 1', 'kirki' ), 'option2' => __( 'Option 2', 'kirki' ), 'option3' => __( 'Option 3', 'kirki' ) ) ) );

// number
$number = new Kirki_Test_Field( array( 'type' => 'number', 'default' => '99' ) );

// palette
$palette = new Kirki_Test_Field( array( 'type' => 'palette', 'default' => 'red', 'choices' => array( 'red' => array( '#F9BAAF', '#FB9D8C', '#FD8069' ), 'green' => array( '#C9F7C4', '#B3F9AC', '#9DFA94' ), 'blue' => array( '#D9E3F6', '#CCDAF7', '#BED1F8' ) ) ) );

// radio-buttonset
$radio_buttonset = new Kirki_Test_Field( array( 'type' => 'radio-buttonset', 'default' => 'option2', 'choices' => array( 'option1' => __( 'Option 1', 'kirki' ), 'option2' => __( 'Option 2', 'kirki' ), 'option-3' => __( 'Option 3', 'kirki' ) ) ) );

// radio-image
$radio_image = new Kirki_Test_Field( array( 'type' => 'radio-image', 'default' => 'option3', 'choices' => array( 'option1' => admin_url().'/images/align-left-2x.png', 'option2' => admin_url().'/images/align-center-2x.png', 'option3' => admin_url().'/images/align-right-2x.png' ) ) );

// radio
$radio = new Kirki_Test_Field( array( 'type' => 'radio', 'default' => 'option1', 'choices' => array( 'option1' => __( 'Option 1', 'kirki' ), 'option2' => __( 'Option 2', 'kirki' ), 'option3' => __( 'Option 3', 'kirki' ) ) ) );

// select
$select = new Kirki_Test_Field( array( 'type' => 'select', 'default' => 'option2', 'choices' => array( 'option1' => __( 'Option 1', 'kirki' ), 'option2' => __( 'Option 2', 'kirki' ), 'option3' => __( 'Option 3', 'kirki' ) ) ) );

// slider
$slider = new Kirki_Test_Field( array( 'type' => 'slider', 'default' => 0, 'choices' => array( 'min' => -100, 'max' => 100, 'step' => 1 ) ) );

// sortable
$sortable = new Kirki_Test_Field( array( 'type' => 'sortable', 'default' => array( 'option2', 'option1' ), 'choices' => array( 'option1' => __( 'Option 1', 'kirki' ), 'option2' => __( 'Option 2', 'kirki' ), 'option3' => __( 'Option 3', 'kirki' ), 'option4' => __( 'Option 4', 'kirki' ) ) ) );

// switch
$switch = new Kirki_Test_Field( array( 'type' => 'switch', 'default' => '1' ) );

// text
$text = new Kirki_Test_Field( array( 'type' => 'text', 'default' => __( 'This is some default text for the text control.', 'kirki' ) ) );

// textarea
$textarea = new Kirki_Test_Field( array( 'type' => 'textarea', 'default' => __( 'This is some default text for the textarea control.', 'kirki' ) ) );

// toggle
$toggle = new Kirki_Test_Field( array( 'type' => 'toggle', 'default' => '1' ) );

// upload
$upload = new Kirki_Test_Field( array( 'type' => 'upload', 'default' => '' ) );
