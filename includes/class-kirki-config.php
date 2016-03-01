<?php

if ( ! class_exists( 'Kirki_Config' ) ) {

	class Kirki_Config {

		/**
		 * @access protected
		 * @var string
		 */
		protected $capability = 'edit_theme_options';

		/**
		 * @access protected
		 * @var string
		 */
		protected $option_type = 'theme_mod';

		/**
		 * @access protected
		 * @var string
		 */
		protected $option_name = '';

		/**
		 * @access protected
		 * @var array
		 */
		protected $compiler = array();

		/**
		 * @access protected
		 * @var bool
		 */
		protected $disable_output = false;

		/**
		 * @access protected
		 * @var bool
		 */
		protected $postMessage = '';

		/**
		 * The class constructor
		 *
		 * @param string    $id     Config ID
		 * @param array     $args   {
		 *    Optional. Arguments to override config defaults.
		 *
		 *    @type string      $capability       @see https://codex.wordpress.org/Roles_and_Capabilities
		 *    @type string      $option_type      theme_mod or option.
		 *    @type string      $option_name      If we want to used serialized options,
		 *                                        this is where we'll be adding the option name.
		 *                                        All fields using this config will be items in that array.
		 *    @type array       $compiler         Not yet fully implemented
		 *    @type bool        $disable_output   If set to true, no CSS will be generated
		 *                                        from fields using this configuration.
		 *    @type string      $postMessage
		 * }
		 */
		public function __construct( $id, $args = array() ) {
			$id = trim( esc_attr( $id ) );
			if ( '' == $id ) {
				$id = 'global';
			}
			// Get defaults from the class
			$defaults = get_class_vars( __CLASS__ );
			// Apply any kirki/config global filters.
			$defaults = apply_filters( 'kirki/config', $defaults );
			// Merge our args with the defaults
			$args = wp_parse_args( $args, $defaults );

			// Modify default values with the defined ones
			foreach ( $args as $key => $value ) {
				// Is this property whitelisted?
				if ( property_exists( $this, $key ) ) {
					$args[ $key ] = $value;
				}
			}

			// Add our config
			Kirki::$config[ $id ] = $args;

		}

	}

}
