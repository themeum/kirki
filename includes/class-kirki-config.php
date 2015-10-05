<?php

class Kirki_Config extends Kirki_Customizer {

	public $default_args = array();

	public function __construct( $id, $args = array() ) {

		parent::__construct();

		$this->default_args = array(
			'capability'  => 'edit_theme_options',
			'option_type' => 'theme_mod',
			'option_name' => '',
			'compiler'    => array(),
		);

		$this->add_config( $id, $args );

	}

	public function add_config( $config_id, $args ) {

		/**
		 * Allow empty value as the config ID by setting the id to global.
		 */
		$config_id = ( '' == $config_id ) ? 'global' : $config_id;
		/**
		 * Set the config
		 */
		Kirki::$config[ $config_id ] = array_merge( $this->default_args, $args );

	}


	public function config_from_filters() {

		$args = apply_filters( 'kirki/config', $this->default_args );

		$valid_args = array();
		$valid_args['capability']  = $args['capability'];
		$valid_args['option_type'] = $args['option_type'];
		$valid_args['option_name'] = $args['option_name'];
		$valid_args['compiler']    = $args['compiler'];

		return $valid_args;

	}

}
