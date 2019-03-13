<?php
/**
 * Customizer Control: number.
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
 * Create a simple number control
 */
class Number extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-number';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		add_action(
			'customize_controls_print_footer_scripts',
			function() {
				$path = apply_filters( 'kirki_control_view_number', __DIR__ . '/view.php' );
				echo '<script type="text/html" id="tmpl-kirki-input-number">';
				include $path;
				echo '</script>';
			}
		);

		$url = apply_filters(
			'kirki_package_url_control_number',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-number/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-number',
			"$url/assets/scripts/control.js",
			[
				'jquery',
				'customize-base',
			],
			KIRKI_VERSION,
			false
		);

		// Enqueue the style.
		wp_enqueue_style(
			'kirki-control-number-style',
			"$url/assets/styles/style.css",
			[],
			KIRKI_VERSION
		);
	}
}
