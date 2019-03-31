<?php
/**
 * Customizer Control: image.
 *
 * @package   kirki-framework/control-typography
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

/**
 * Adds the image control.
 *
 * @psince 1.0
 */
class Upload extends \WP_Customize_Upload_Control {

	/**
	 * Whitelisting the "required" argument.
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $required = [];

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @uses WP_Customize_Media_Control::to_json()
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['required'] = $this->required;
	}
}
