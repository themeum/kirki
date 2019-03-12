<?php
/**
 * Customizer Control: multicheck.
 *
 * Multiple checkbox customize control class.
 * Props @ Justin Tadlock: http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
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
 * Adds a multicheck control.
 */
class MultiCheck extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-multicheck';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		$url = apply_filters(
			'kirki_package_url_control_multicheck',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-multicheck/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-multicheck',
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
			'kirki-control-multicheck-style',
			"$url/assets/styles/style.css",
			[],
			KIRKI_VERSION
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
		<# if ( ! data.choices ) { return; } #>

		<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>

		<ul>
			<# for ( key in data.choices ) { #>
				<li><label<# if ( _.contains( data.value, key ) ) { #> class="checked"<# } #>><input {{{ data.inputAttrs }}} type="checkbox" value="{{ key }}"<# if ( _.contains( data.value, key ) ) { #> checked<# } #> />{{ data.choices[ key ] }}</label></li>
			<# } #>
		</ul>
		<?php
	}
}
