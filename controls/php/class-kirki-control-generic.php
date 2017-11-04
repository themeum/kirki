<?php
/**
 * Customizer Control: kirki-generic.
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
 * A generic and pretty abstract control.
 * Allows for great manipulation using the field's "choices" argumnent.
 */
class Kirki_Control_Generic extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-generic';

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
				<# if ( 'textarea' == data.choices['element'] ) { #>
					<textarea {{{ data.inputAttrs }}} {{{ data.link }}} <# for ( key in data.choices ) { #> {{ key }}="{{ data.choices[ key ] }}"<# } #>>{{ data.value }}</textarea>
				<# } else { #>
					<# var element = ( data.choices.element ) ? data.choices.element : 'input'; #>
					<{{ element }}
						{{{ data.inputAttrs }}}
						value="{{ data.value }}"
						{{{ data.link }}}
						<# for ( key in data.choices ) { #>
							{{ key }}="{{ data.choices[ key ] }}"
						<# } #>
						<# if ( data.choices.content ) { #>
							>{{{ data.choices.content }}}</{{ element }}>
						<# } else { #>
							/>
						<# } #>
				<# } #>
			</div>
		</label>
		<?php
	}
}
