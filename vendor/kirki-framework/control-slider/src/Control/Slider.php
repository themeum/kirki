<?php
/**
 * Customizer Control: slider.
 *
 * Creates a jQuery slider control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\Core\Kirki;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slider control (range).
 */
class Slider extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-slider';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		$url = apply_filters(
			'kirki_package_url_control_slider',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-slider/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-slider',
			"$url/assets/scripts/control.js",
			[
				'jquery',
				'customize-base',
				'kirki-dynamic-control',
			],
			KIRKI_VERSION,
			false
		);

		// Enqueue the style.
		wp_enqueue_style(
			'kirki-control-slider-style',
			"$url/assets/styles/style.css",
			[],
			KIRKI_VERSION
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['choices'] = wp_parse_args(
			$this->json['choices'],
			array(
				'min'    => '0',
				'max'    => '100',
				'step'   => '1',
				'suffix' => '',
			)
		);
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
			<div class="wrapper">
				<input {{{ data.inputAttrs }}} type="range" min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" value="{{ data.value }}" {{{ data.link }}} />
				<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_html_e( 'Reset', 'kirki' ); ?></span></span>
				<span class="value">
					<input {{{ data.inputAttrs }}} type="text"/>
					<span class="suffix">{{ data.choices['suffix'] }}</span>
				</span>
			</div>
		</label>
		<?php
	}
}
