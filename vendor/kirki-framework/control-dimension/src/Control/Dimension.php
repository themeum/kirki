<?php
/**
 * Customizer Control: dimension
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       2.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\Core\Kirki;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A text control with validation for CSS units.
 */
class Dimension extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-dimension';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		$url = apply_filters(
			'kirki_package_url_control_dimension',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-dimension/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-dimension',
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
			'kirki-control-dimension-style',
			"$url/assets/styles/style.css",
			[],
			KIRKI_VERSION
		);

		wp_localize_script(
			'kirki-control-dimension',
			'dimensionkirkiL10n',
			array(
				'invalid-value' => esc_html__( 'Invalid Value', 'kirki' ),
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
		<label class="customizer-text">
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="input-wrapper">
				<# var val = ( data.value && _.isString( data.value ) ) ? data.value.replace( '%%', '%' ) : ''; #>
				<input {{{ data.inputAttrs }}} type="text" value="{{ val }}"/>
			</div>
		</label>
		<?php
	}
}
