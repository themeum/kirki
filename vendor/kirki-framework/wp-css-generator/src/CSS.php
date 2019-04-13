<?php
/**
 * Compile Styles.
 *
 * @package   kirki-framework/wp-css-compiler
 * @author    Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Compiler;

/**
 * Css Compiler.
 *
 * @since 1.0
 */
class CSS {

	/**
	 * An array on instances of this object.
	 * 
	 * We use multiple instances because some styles may belong in the <head>,
	 * other styles may belong inside <body>, or secondary styles may even be 
	 * in the footer and anywhere in between.
	 *
	 * @static
	 * @access private
	 * @since 1.0
	 * @var array
	 */
	private static $instances = [];

	/**
	 * An array of styles
	 * 
	 * Array format:
	 * 	[
	 * 		media-query => [
	 * 			element => 
	 * 				property => value
	 * 			]
	 * 		]
	 * 	]
	 *
	 * @access private
	 * @since 1.0
	 * @var array
	 */
	private $css_array = [];

	/**
	 * Get - or create an instance.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param string $instance_id The instance ID.
	 * @return CSS                Returns an instance of this class.
	 */
	public static function get_instance( $instance_id = 'global' ) {
		if ( ! isset( self::$instances[ $instance_id ] ) ) {
			self::$instances[ $instance_id ] = new self( $instance_id );
		}
		return self::$instances[ $instance_id ];
	}

	/**
	 * Add a style to the array.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $params The parameters we want to add:
	 *                      [
	 *                      	'query'    => '',
	 *                          'element'  => '',
	 *                          'property' => '',
	 *                          'value'    => '',
	 *                      ]
	 * @return void
	 */
	public function add_item( $params ) {
		$params = wp_parse_args(
			$params,
			[
				'query'    => 'global',
				'element'  => '',
				'property' => '',
				'value'    => '',
			]
		);

		if ( ! isset( $this->css_array[ $params['query'] ] ) ) {
			$this->css_array[ $params['query'] ] = [];
		}
		if ( ! isset( $this->css_array[ $params['query'] ][ $params['element'] ] ) ) {
			$this->css_array[ $params['query'] ][ $params['element'] ] = [];
		}
		$this->css_array[ $params['query'] ][ $params['element'] ][ $params['property'] ] = $params['value'];
	}

	/**
	 * Gets the CSS as a string.
	 *
	 * @access public
	 * @since 1.0
	 * @return string
	 */
	public function get_css() {
		return Generator::from_array( $this->css_array );
	}
}