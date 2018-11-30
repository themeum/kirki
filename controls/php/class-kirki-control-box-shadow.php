<?php
/**
 * Customizer Control: box-shadow.
 *
 * Creates a box shadow control.
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
 * Box shadow control.
 */
class Kirki_Control_Box_Shadow extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-box-shadow';
	
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
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
			<div class="kirki-unit-choices-outer">
				<div class="kirki-unit-choice">
					<input id="{{ data.id }}_px" type="radio" data-setting="unit" value="px" checked>
					<label class="kirki-unit-choice-label" for="{{ data.id }}_px">px</label>
				</div>
			</div>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="kirki-control-type-dimensions">
				<ul class="kirki-control-dimensions">
					<# _.each( ['h_offset', 'v_offset', 'blur', 'spread'], function( side ) {
						if ( side === 'blur' || side === 'spread' )
						{
							if ( data.default && _.isUndefined( data.default[side] ) )
								return false;
						}
						var label = side.replace( '_', '-' );
					#>
					<li class="kirki-control-dimension">
						<input type="number" id="{{{ data.id }}}-{{{ side }}}" side="{{{ side }}}">
						<label for="{{{ data.id }}}-{{{ side }}}" class="kirki-control-dimension-label"><?php _e('{{{ label }}}', 'kirki') ?></span>
					</li>
					<# }); #>
				</ul>
			</div>
			<div class="color">
				<p><b><?php _e( 'Color', 'kirki' ) ?></b></p>
				<input type="text" class="color-picker" data-alpha="true" value="" />
			</div>
			<input class="box-shadow-hidden-value" type="hidden" value="" {{{ data.link }}} />
		</label>
		<?php
	}
}