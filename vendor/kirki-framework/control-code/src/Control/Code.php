<?php
/**
 * Customizer Control: code.
 *
 * Creates a new custom control.
 * Custom controls accept raw HTML/JS.
 *
 * @package    Kirki
 * @subpackage Controls
 * @copyright  Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since      1.0
 */

namespace Kirki\Control;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds a "code" control, alias of the WP_Customize_Code_Editor_Control class.
 */
class Code extends \WP_Customize_Code_Editor_Control {

	/**
	 * Whitelisting the "required" argument.
	 *
	 * @since 3.0.17
	 * @access public
	 * @var array
	 */
	public $required = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 4.0
	 */
	public function enqueue() {
		parent::enqueue();
		add_action(
			'customize_controls_print_footer_scripts',
			function() {
				echo '<script type="text/html" id="tmpl-kirki-input-code">';
				include apply_filters( 'kirki_control_view_code', __DIR__ . '/view.php' );
				echo '</script>';
			}
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {

		// Get the basics from the parent class.
		parent::to_json();

		// Required.
		$this->json['required'] = $this->required;
	}
}
