<?php
/**
 * Customizer Control: kirki-radio.
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
 * Radio control
 */
class Radio extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-radio';

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
				$path = apply_filters( 'kirki_control_view_radio', __DIR__ . '/view-radio.php' );
				echo '<script type="text/html" id="tmpl-kirki-input-radio">';
				include $path;
				echo '</script>';
			}
		);

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
}
