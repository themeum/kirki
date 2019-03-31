<?php
/**
 * Customizer Control: kirki-select.
 *
 * @package   kirki-framework/control-select
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Select control.
 *
 * @since 1.0
 */
class Select extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-select';

	/**
	 * Placeholder text.
	 *
	 * @access public
	 * @since 1.0
	 * @var string|false
	 */
	public $placeholder = false;

	/**
	 * Maximum number of options the user will be able to select.
	 * Set to 1 for single-select.
	 *
	 * @access public
	 * @since 1.0
	 * @var int
	 */
	public $multiple = 1;

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public static $control_ver = '1.0';

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
				$path = apply_filters( 'kirki_control_view_select', __DIR__ . '/view.php' );
				echo '<script type="text/html" id="tmpl-kirki-input-select">';
				include $path;
				echo '</script>';
			}
		);

		// Enqueue selectWoo.
		wp_enqueue_script( 'selectWoo', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/selectWoo/js/selectWoo.full.js' ), [ 'jquery' ], '1.0.1', true );
		wp_enqueue_style( 'selectWoo', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/selectWoo/css/selectWoo.css' ), [], '1.0.1' );

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-select', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'selectWoo' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-select-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
	}

	/**
	 * Get the URL for the control folder.
	 *
	 * This is a static method because there are more controls in the Kirki framework
	 * that use colorpickers, and they all need to enqueue the same assets.
	 *
	 * @static
	 * @access public
	 * @since 1.0.6
	 * @return string
	 */
	public static function get_control_path_url() {
		return URL::get_from_path( dirname( __DIR__ ) );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['multiple']    = $this->multiple;
		$this->json['placeholder'] = $this->placeholder;
	}
}
