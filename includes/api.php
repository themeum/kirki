<?php

Kirki()->api = new Kirki_API();
class Kirki_API {

	public $config = array();

	public $fields = array();

	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'add_to_customizer' ), 1 );
	}

	public function add_to_customizer( $wp_customize ) {
		add_filter( 'kirki/fields', array( $this, 'merge_fields' ) );
	}

	public function merge_fields( $fields ) {
		return array_merge( $fields, $this->fields );
	}

}

/**
 * Sets the configuration options.
 *
 * @var		string		the configuration ID.
 * @var		array		the configuration options.
 */
function kirki_add_config( $config_id, $args ) {

	$default_args = array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
		'option'        => '',
		'compiler'      => array(),
	);
	$args = array_merge( $default_args, $args );

	// Set the config
	Kirki()->api->config[$config_id] = $args;

}

/**
 * Create a new field
 *
 * @var		string		the configuration ID for this field
 * @var		array		the field arguments
 */
function kirki_add_field( $config_id, $args ) {

	// Get the configuration options
	$config = Kirki()->api->config[$config_id];
	var_dump( $config );

	/**
	 * If we've set an option in the configuration
	 * then make sure we're using options and not theme_mods
	 */
	if ( '' != $config['option'] ) {
		$config['option_type'] = 'option';
	}

	/**
	 * If no option name has been set for the field,
	 * use the one from the configuration
	 */
	if ( ! isset( $args['option'] ) ) {
		$args['option'] = $config['option'];
	}

	/**
	 * If no capability has been set for the field,
	 * use the one from the configuration
	 */
	if ( ! isset( $args['capability'] ) ) {
		$args['capability'] = $config['capability'];
	}

	/**
	 * If no capability has been set for the field,
	 * use the one from the configuration
	 */
	if ( ! isset( $args['option_type'] ) ) {
		$args['option_type'] = $config['option_type'];
	}

	// Add the field to the Kirki_API class
	Kirki()->api->fields[] = $args;

}
