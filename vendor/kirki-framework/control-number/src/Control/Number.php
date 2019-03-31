<?php
/**
 * Customizer Control: number.
 *
 * @package   kirki-framework/control-number
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Create a simple number control
 *
 * @since 1.0
 */
class Number extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-number';

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access private
	 * @since 1.0
	 * @var string
	 */
	private static $control_ver = '1.0';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		add_action(
			'customize_controls_print_footer_scripts',
			function() {
				echo '<script type="text/html" id="tmpl-kirki-input-number">';
				include apply_filters( 'kirki_control_view_number', __DIR__ . '/view.php' );
				echo '</script>';
			}
		);

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-number', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-number-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
	}
}
