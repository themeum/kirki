<?php

/**
 * This class adds any modifications needed to accomodate
 * option-types other than 'theme_mod' and 'option'.
 */
if ( ! class_exists( 'Kirki_Option_Type' ) ) {

	class Kirki_Option_Type {

		/**
		 * @access protected
		 * @var string
		 */
		protected $type = 'theme_mod';

		/**
		 * @static
		 * @access private
		 * @var array
		 */
		private static $instances = array();

		/**
		 * The class constructor
		 *
		 * @access private
		 */
		private function __construct( $type ) {

			$this->type = $type;

			if ( method_exists( $this, 'update_' . $this->type ) ) {
				add_action( 'customize_update_' . $this->type, array( $this, 'update_' . $this->type ), 10, 2 );
			}

			if ( method_exists( $this, 'get_value_' . $this->type ) ) {
				add_action( 'kirki/controls/get_value/' . $this->type, array( $this, 'get_value_' . $this->type ), 10, 2 );
			}

		}

		/**
		 * Use this method to get an instance of this object.
		 *
		 * @static
		 * @access public
		 * @param string    $type     The option_type for the field
		 *
		 * @return Kirki_Option_Type
		 */
		public static function get_instance( $type = 'theme_mod' ) {

			if ( ! isset( self::$instances[ $type ] ) ) {
				self::$instances[ $type ] = new self( $type );
			}
			return self::$instances[ $type ];

		}

	}


}
