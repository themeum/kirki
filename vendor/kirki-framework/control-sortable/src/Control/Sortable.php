<?php
/**
 * Customizer Control: sortable.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

namespace Kirki\Control;

use Kirki\Core\Kirki;
use Kirki\Control\Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sortable control (uses checkboxes).
 */
class Sortable extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-sortable';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		$url = apply_filters(
			'kirki_package_url_control_sortable',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-sortable/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-sortable',
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
			'kirki-control-sortable-style',
			"$url/assets/styles/style.css",
			[],
			KIRKI_VERSION
		);
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label class='kirki-sortable'>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<ul class="sortable">
				<# _.each( data.value, function( choiceID ) { #>
					<li {{{ data.inputAttrs }}} class='kirki-sortable-item' data-value='{{ choiceID }}'>
						<i class='dashicons dashicons-menu'></i>
						<i class="dashicons dashicons-visibility visibility"></i>
						{{{ data.choices[ choiceID ] }}}
					</li>
				<# }); #>
				<# _.each( data.choices, function( choiceLabel, choiceID ) { #>
					<# if ( -1 === data.value.indexOf( choiceID ) ) { #>
						<li {{{ data.inputAttrs }}} class='kirki-sortable-item invisible' data-value='{{ choiceID }}'>
							<i class='dashicons dashicons-menu'></i>
							<i class="dashicons dashicons-visibility visibility"></i>
							{{{ data.choices[ choiceID ] }}}
						</li>
					<# } #>
				<# }); #>
			</ul>
		</label>
		<?php
	}
}
