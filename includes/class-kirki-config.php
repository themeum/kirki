<?php
/**
 * Processes configurations.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 */

if ( ! class_exists( 'Kirki_Config' ) ) {

	/**
	 * The Kirki_Config object
	 */
	final class Kirki_Config {

		/**
		 * Each instance is stored separately in this array.
		 *
		 * @static
		 * @access private
		 * @var array
		 */
		private static $instances = array();

		/**
		 * The finalized configuration array.
		 *
		 * @access protected
		 * @var array
		 */
		protected $config_final = array();

		/**
		 * The configuration ID.
		 *
		 * @access protected
		 * @var string
		 */
		protected $id = 'global';

		/**
		 * Capability (fields will inherit this).
		 *
		 * @access protected
		 * @var string
		 */
		protected $capability = 'edit_theme_options';

		/**
		 * The data-type we'll be using.
		 *
		 * @access protected
		 * @var string
		 */
		protected $option_type = 'theme_mod';

		/**
		 * If we're using serialized options, then this is the global option name.
		 *
		 * @access protected
		 * @var string
		 */
		protected $option_name = '';

		/**
		 * The compiler.
		 *
		 * @access protected
		 * @var array
		 */
		protected $compiler = array();

		/**
		 * Set to true if you want to completely disable any Kirki-generated CSS.
		 *
		 * @access protected
		 * @var bool
		 */
		protected $disable_output = false;

		/**
		 * The class constructor.
		 * Use the get_instance() static method to get the instance you need.
		 *
		 * @access private
		 *
		 * @param string $id     @see Kirki_Config::get_instance().
		 * @param array  $args   @see Kirki_Config::get_instance().
		 */
		private function __construct( $id = 'global', $args = array() ) {

			// Get defaults from the class.
			$defaults = get_class_vars( __CLASS__ );
			// Skip the what we don't need in this context.
			unset( $defaults['config_final'] );
			unset( $defaults['instances'] );
			// Apply any kirki/config global filters.
			$defaults = apply_filters( 'kirki/config', $defaults );
			// Merge our args with the defaults.
			$args = wp_parse_args( $args, $defaults );

			// Modify default values with the defined ones.
			foreach ( $args as $key => $value ) {
				// Is this property whitelisted?
				if ( property_exists( $this, $key ) ) {
					$args[ $key ] = $value;
				}
			}

			$this->config_final       = $args;
			$this->config_final['id'] = $id;

		}

		/**
		 * Use this method to get an instance of your config.
		 * Each config has its own instance of this object.
		 *
		 * @static
		 * @access public
		 * @param string $id     Config ID.
		 * @param array  $args   {
		 * Optional. Arguments to override config defaults.
		 *
		 *    @type string      $capability       @see https://codex.wordpress.org/Roles_and_Capabilities
		 *    @type string      $option_type      theme_mod or option.
		 *    @type string      $option_name      If we want to used serialized options,
		 *                                        this is where we'll be adding the option name.
		 *                                        All fields using this config will be items in that array.
		 *    @type array       $compiler         Not yet fully implemented
		 *    @type bool        $disable_output   If set to true, no CSS will be generated
		 *                                        from fields using this configuration.
		 * }
		 *
		 * @return Kirki_Config
		 */
		public static function get_instance( $id = 'global', $args = array() ) {

			$id = trim( esc_attr( $id ) );
			$id = ( '' === $id ) ? 'global' : $id;

			$id_md5 = md5( $id );
			if ( ! isset( self::$instances[ $id_md5 ] ) ) {
				self::$instances[ $id_md5 ] = new self( $id, $args );
			}
			return self::$instances[ $id_md5 ];

		}

		/**
		 * Returns the $config_final property
		 *
		 * @access public
		 *
		 * @return array
		 */
		public function get_config() {

			return $this->config_final;

		}
	}
}
