<?php
/**
 * Customizer Control: dropdown-pages.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.8
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A copy of WordPress core's "dropdown-pages" control.
 * The template has been converted to use Underscore.js
 * and we added a tooltip.
 */
class Kirki_Control_Dropdown_Pages extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'dropdown-pages';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		wp_enqueue_script( 'kirki-dropdown-pages', trailingslashit( Kirki::$url ) . 'controls/dropdown-pages/dropdown-pages.js', array( 'jquery', 'customize-base', 'selectize' ), false, true );
		wp_enqueue_style( 'selectize-css', trailingslashit( Kirki::$url ) . 'controls/dropdown-pages/selectize.css', null );

	}
}
