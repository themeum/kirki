<?php
/**
 * Customizer Control: kirki-select.
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
class Select extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-select';

	/**
	 * Placeholder text.
	 *
	 * @access public
	 * @since 3.0.21
	 * @var string|false
	 */
	public $placeholder = false;

	/**
	 * Maximum number of options the user will be able to select.
	 * Set to 1 for single-select.
	 *
	 * @access public
	 * @var int
	 */
	public $multiple = 1;

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
				$path = apply_filters( 'kirki_control_view_select', __DIR__ . '/view.php' );
				echo '<script type="text/html" id="tmpl-kirki-input-select">';
				include $path;
				echo '</script>';
			}
		);

		$url = apply_filters(
			'kirki_package_url_control_select',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-select/src'
		);
		$url = untrailingslashit( $url );

		// Enqueue selectWoo.
		wp_enqueue_script( 'selectWoo', "$url/assets/scripts/selectWoo/js/selectWoo.full.js", array( 'jquery' ), '1.0.1', true );
		wp_enqueue_style( 'selectWoo', "$url/assets/scripts/selectWoo/css/selectWoo.css", array(), '1.0.1' );

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-select',
			"$url/assets/scripts/control.js",
			[
				'jquery',
				'customize-base',
				'selectWoo',
			],
			KIRKI_VERSION,
			false
		);

		// Enqueue the style.
		wp_enqueue_style(
			'kirki-control-select-style',
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
		$this->json['multiple']    = $this->multiple;
		$this->json['placeholder'] = $this->placeholder;
	}
}
