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
class Kirki_Control_Slider_Advanced extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-slider-advanced';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['choices'] = wp_parse_args( $this->json['choices'], array(
			'media_queries'  => '0',
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
		$uq_id = mt_rand( 100, 1000 );
		?>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<# if ( data.choices.media_queries ) { #>
			<ul class="kirki-respnsive-switchers">
				<li class="desktop"><span class="dashicons dashicons-desktop"></span></li>
				<li class="tablet hidden"><span class="dashicons dashicons-tablet"></span></li>
				<li class="mobile hidden"><span class="dashicons dashicons-smartphone"></span></li>
			</ul>
			<div class="kirki-units-choices">
				<input id="margin_type_px_<?php echo $uq_id ?>" type="radio" name="margin_type" data-setting="unit" value="px">
				<label class="kirki-units-choices-label" for="margin_type_px_<?php echo $uq_id ?>">px</label>
			</div>
			<# } #>
			<div class="wrapper">
				<input {{{ data.inputAttrs }}} type="range" min="0" max="100" step="" value="" />
				<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_attr_e( 'Reset', 'kirki' ); ?></span></span>
				<span class="value">
					<input {{{ data.inputAttrs }}} type="number"/>
				</span>
			</div>
			<input type="hidden" value="" {{{ data.link }}} />
		</label>
		<?php
	}
}