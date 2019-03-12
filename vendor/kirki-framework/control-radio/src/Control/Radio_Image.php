<?php
/**
 * Customizer Control: radio-image.
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
 * Radio Image control (modified radio).
 */
class Radio_Image extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-radio-image';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		$url = apply_filters(
			'kirki_package_url_control_radio',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-radio/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-radio',
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
			'kirki-control-radio-style',
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
		foreach ( $this->input_attrs as $attr => $value ) {
			if ( 'style' !== $attr ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
				continue;
			}
			$this->json['labelStyle'] = 'style="' . esc_attr( $value ) . '" ';
		}

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
		</label>
		<div id="input_{{ data.id }}" class="image">
			<# for ( key in data.choices ) { #>
				<# dataAlt = ( _.isObject( data.choices[ key ] ) && ! _.isUndefined( data.choices[ key ].alt ) ) ? data.choices[ key ].alt : '' #>
				<input {{{ data.inputAttrs }}} class="image-select" type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #> data-alt="{{ dataAlt }}">
					<label for="{{ data.id }}{{ key }}" {{{ data.labelStyle }}} class="{{{ data.id + key }}}">
						<# if ( _.isObject( data.choices[ key ] ) ) { #>
							<img src="{{ data.choices[ key ].src }}" alt="{{ data.choices[ key ].alt }}">
							<span class="image-label"><span class="inner">{{ data.choices[ key ].alt }}</span></span>
						<# } else { #>
							<img src="{{ data.choices[ key ] }}">
						<# } #>
						<span class="image-clickable"></span>
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}
