<?php
/**
 * Customizer Control: slider.
 *
 * Creates a jQuery slider control.
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
 * Slider control (range).
 */
class Kirki_Control_Slider extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-slider';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['choices'] = wp_parse_args( $this->json['choices'], array(
			'media_queries'  => false,
			'units' => array (
				'' => array(
					'min' => '0',
					'max' => '100',
					'step' => '1'
				)
			)
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
		<#
		#>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<# if ( data.choices.media_queries ) { #>
			<ul class="kirki-respnsive-switchers">
				<li class="desktop"><span class="dashicons dashicons-desktop"></span></li>
				<li class="tablet hidden"><span class="dashicons dashicons-tablet"></span></li>
				<li class="mobile hidden"><span class="dashicons dashicons-smartphone"></span></li>
			</ul>
			<# } #>
			<# if ( data.choices.units && data.choices.units.length > 0 ) { #>
			<div class="kirki-units-choices">
				<# for ( key in data.choices.units ) { #>
				<input id="unit_{{ key }}_{{ data.id }}" type="radio" name="unit_type_{{ data.id }}" data-setting="unit" value="{{ key }}" min="{{ data.choices.units[key]['min'] }}" max="{{ data.choices.units[key]['max'] }}" step="{{ data.choices.units[key]['step'] }}">
				<label class="kirki-units-choices-label" for="unit_{{ key }}_{{ data.id }}">{{ key }}</label>
				<# } #>
			</div>
			<# } #>
			<div class="wrapper">
				<input {{{ data.inputAttrs }}} type="range" min="0" max="100" step="" value="" />
				<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_attr_e( 'Reset', 'kirki' ); ?></span></span>
				<span class="value">
					<input {{{ data.inputAttrs }}} type="text"/>
				</span>
			</div>
			<input class="slider-hidden-value" type="hidden" value="{{ data.value }}" {{{ data.link }}} />
		</label>
		<?php
	}
}
