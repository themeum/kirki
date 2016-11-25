<?php
/**
 * Customizer Control: kirki-checkbox.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates a checkbox control in the customizer.
 * This is an almost verbatim copy of WordPress core's implementation
 * but we converted the template to use Underscore.js, and added the tooltip.
 */
class Kirki_Control_Checkbox extends WP_Customize_Control {

	/**
	 * Tooltips content.
	 *
	 * @access public
	 * @var string
	 */
	public $tooltip = '';

	/**
	 * Used to automatically generate all postMessage scripts.
	 *
	 * @access public
	 * @var array
	 */
	public $js_vars = array();

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
	 * The kirki_config we're using for this control
	 *
	 * @access public
	 * @var string
	 */
	public $kirki_config = 'global';

	/**
	 * The translation strings.
	 *
	 * @access protected
	 * @since 2.3.5
	 * @var array
	 */
	protected $l10n = array();
}
