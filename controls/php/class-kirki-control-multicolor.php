<?php
/**
 * Customizer Control: multicolor.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Multicolor control.
 */
class Kirki_Control_Multicolor extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-multicolor';

	/**
	 * Enable/Disable Alpha channel on color pickers
	 *
	 * @access public
	 * @var boolean
	 */
	public $alpha = true;

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();

		$this->json['alpha'] = (bool) $this->alpha;
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
		<span class="customize-control-title">
			{{{ data.label }}}
		</span>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="multicolor-group-wrapper">
			<# for ( key in data.choices ) { #>
				<# if ( 'irisArgs' !== key ) { #>
					<div class="multicolor-single-color-wrapper">
						<input {{{ data.inputAttrs }}} id="{{ data.id }}-{{ key }}" type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default[ key ] }}" data-alpha="{{ data.alpha }}" value="{{ data.value[ key ] }}" class="kirki-color-control color-picker multicolor-index-{{ key }}" data-label="<# if ( data.choices[ key ] ) { #>{{ data.choices[ key ] }}<# } else { #>{{ key }}<# } #>" />
					</div>
				<# } #>
			<# } #>
		</div>
		<input class="multicolor-hidden-value" type="hidden" {{{ data.link }}}>
		<?php
	}
}
