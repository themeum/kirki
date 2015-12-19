<?php

class Kirki_Config extends Kirki_Customizer {

	/**
	 * The default arguments.
	 * These are set in the class constructor.
	 * Used as a fallback in case the user has not defined any.
	 */
	public $default_args = array();

	/**
	 * The class constructor
	 *
	 * @var $id    string    the configuration ID
	 * @var $args  array     the configuration arguments
	 * @return     void
	 */
	public function __construct( $id, $args = array() ) {

		// Call the parent constructor
		parent::__construct();
		// Set the default args
		$this->default_args = array(
			'capability'  => 'edit_theme_options',
			'option_type' => 'theme_mod',
			'option_name' => '',
			'compiler'    => array(),
		);
		// Process the 'kirki/config' filter by replacing the defaults
		$this->default_args = $this->config_from_filters();
		// Add the config
		$this->add_config( $id, $args );

	}

	/**
	 * Adds the configuration to the Kirki object.
	 *
	 * @var $config_id    the configuration ID.
	 * @var $args         the configuration arguments
	 * @return  void
	 */
	public function add_config( $config_id, $args ) {
		// Allow empty value as the config ID by setting the id to global.
		$config_id = ( '' == $config_id ) ? 'global' : $config_id;
		// Set the config
		Kirki::$config[ $config_id ] = array_merge( $this->default_args, $args );
	}

	/**
	 * Parses the 'kirki/config' filter.
	 *
	 * @return  array
	 */
	public function config_from_filters() {
		// get the args from the filter
		$default_args = $this->default_args;
		$args = apply_filters( 'kirki/config', $default_args );
		// create a valid config by merging with the default args.
		$valid_args = array();
		$valid_args['capability']  = isset( $args['capability'] ) ? $args['capability'] : $default_args['capability'];
		$valid_args['option_type'] = isset( $args['option_type'] ) ? $args['option_type'] : $default_args['option_type'];
		$valid_args['option_name'] = isset( $args['option_name'] ) ? $args['option_name'] : $default_args['option_name'];
		$valid_args['compiler']    = isset( $args['compiler'] ) ? $args['compiler'] : $default_args['compiler'];

		return $valid_args;

	}

}
