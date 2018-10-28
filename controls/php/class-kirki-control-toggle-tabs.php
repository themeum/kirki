<?php
/**
 * Customizer Control: toggle-tabs.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Toggle Tabs control used for grouping controls inside of customizer.
 */
class Kirki_Control_Toggle_Tabs extends Kirki_Control_Base {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'toggle-tabs';

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
	protected function content_template()
	{
		?>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="kirki-toggle-tabs-outer">
				<div class="tabs">
					<# for ( var label in data.choices ) {
						var label_id = label.replace( ' ', '_' );
					#>
					<li href="#{{ data.id }}_{{ label_id }}">{{ label }}</li>
					<# } #>
				</div>
				<div class="tabs-content">
					<# for ( var label in data.choices ) {
						var label_id = label.replace( ' ', '_' );
					#>
					<div class="tab-content" id="{{ data.id }}_{{ label_id }}"></div>
					<# } #>
				</div>
			</div>
			<input type="hidden" value="" {{{ data.link }}} />
		</label>
		<?php
	}
}
