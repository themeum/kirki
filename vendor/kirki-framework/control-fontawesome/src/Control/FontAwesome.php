<?php
/**
 * Customizer Control: kirki-fontawesome.
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
 * Select control.
 */
class FontAwesome extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-fontawesome';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		$url = apply_filters(
			'kirki_package_url_control_fontawesome',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-fontawesome/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-fontawesome',
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
			'kirki-control-fontawesome-style',
			"$url/assets/styles/style.css",
			[],
			KIRKI_VERSION
		);

		wp_enqueue_script( 'kirki-fontawesome-font', 'https://use.fontawesome.com/30858dc40a.js', [], '4.0.7', false );

		ob_start();
		$json_path = wp_normalize_path( __DIR__ . '/assets/json/fontawesome.json' );
		include $json_path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
		$font_awesome_json = ob_get_clean();

		wp_localize_script( 'kirki-control-fontawesome', 'fontAwesomeJSON', $font_awesome_json );
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
			<select {{{ data.inputAttrs }}} {{{ data.link }}}></select>
		</label>
		<?php
	}
}
