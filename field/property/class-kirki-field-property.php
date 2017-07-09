<?php
/**
 * This class can be extended on a per-property basis.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Please do not use this class directly.
 * You should instead extend it per-field-property.
 */
class Kirki_Field_Property {

	/**
	 * An array of the field arguments.
	 *
	 * @access protected
	 * @var array
	 */
	protected $args = array();

	/**
	 * The class constructor.
	 *
	 * @access public
	 * @param array $args The arguments of the field.
	 */
	public function __construct( $args ) {
		$this->args = $args;
	}

	/**
	 * Gets the property.
	 *
	 * @access public
	 */
	public function get_property() {}
}
