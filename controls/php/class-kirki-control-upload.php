<?php
/**
 * Customizer Control: image.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.23
 */

/**
 * Adds the image control.
 */
class Kirki_Control_Upload extends WP_Customize_Upload_Control {

	/**
	 * Whitelisting the "required" argument.
	 *
	 * @since 3.0.17
	 * @access public
	 * @var array
	 */
	public $required = array();

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.0.23
	 *
	 * @uses WP_Customize_Media_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['required'] = $this->required;
	}
}
