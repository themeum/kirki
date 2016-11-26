<?php
/**
 * Customizer Control: kirki-date.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A simple date control, using jQuery UI.
 */
class Kirki_Control_Date extends Kirki_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-date';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'kirki-date', trailingslashit( Kirki::$url ) . 'controls/date/date.js', array( 'jquery', 'customize-base', 'jquery-ui-datepicker' ), false, true );
		wp_enqueue_style( 'kirki-date-css', trailingslashit( Kirki::$url ) . 'controls/date/date.css', null );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content">
				<input {{{ data.inputAttrs }}} class="datepicker" type="text" id="{{ data.id }}" value="{{ data.value }}" {{{ data.link }}} />
			</div>
		</label>
		<?php
	}
}
