<?php
/**
 * Override field methods
 *
 * @package    Kirki
 * @subpackage Controls
 * @copyright  Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since      3.0.36
 */

namespace Kirki\Field;

/**
 * Field overrides.
 */
class Dropdown_Pages extends Select {

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function set_choices() {
		$all_pages = get_pages();
		foreach ( $all_pages as $page ) {
			$this->choices[ $page->ID ] = $page->post_title;
		}
	}
}
