<?php
/**
 * Customizer Control: preset.
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
 * Preset control (modified select).
 */
class Kirki_Control_Preset extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-preset';

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
		<# if ( ! data.choices ) return; #>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{ data.label }}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<select {{{ data.inputAttrs }}} {{{ data.link }}} data-multiple="1">
				<# for ( key in data.choices ) { #>
					<option value="{{ key }}"<# if ( key === data.value ) { #>selected<# } #>>
						{{ data.choices[ key ]['label'] }}
					</option>
				<# } #>
			</select>
		</label>
		<?php
	}
}
