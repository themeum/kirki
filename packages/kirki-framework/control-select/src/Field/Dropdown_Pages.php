<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-select
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Dropdown_Pages extends Select {

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_choices() {
		$all_pages = get_pages();
		foreach ( $all_pages as $page ) {
			$this->choices[ $page->ID ] = $page->post_title;
		}
	}
}
