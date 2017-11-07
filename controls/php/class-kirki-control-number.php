<?php
/**
 * Customizer Control: number.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create a simple number control
 */
class Kirki_Control_Number extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-number';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		wp_localize_script( 'kirki-script', 'numberKirkiL10n', array(
			'min-error'  => esc_attr__( 'Value lower than allowed minimum', 'kirki' ),
			'max-error'  => esc_attr__( 'Value higher than allowed maximum', 'kirki' ),
			'step-error' => esc_attr__( 'Invalid Value', 'kirki' ),
		) );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="customize-control-content">
				<input {{{ data.inputAttrs }}} type="text" {{{ data.link }}} value="{{ data.value }}" />
			</div>
		</label>
		<?php
	}
}
