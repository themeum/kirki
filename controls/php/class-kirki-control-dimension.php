<?php
/**
 * Customizer Control: dimension
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A text control with validation for CSS units.
 */
class Kirki_Control_Dimension extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-dimension';

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.1.0
	 * @return array
	 */
	protected function l10n() {
		return array(
			'invalidValue' => esc_attr__( 'Invalid Value', 'kirki' ),
		);
	}
}
