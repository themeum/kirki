<?php
/**
 * Customizer Control: kirki-date.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A simple date control, using jQuery UI.
 */
class Kirki_Control_Date extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-date';

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
		global $wp_version;
		// If we're on WP 4.9+, then we don't need to add anything here.
		if ( version_compare( $wp_version, '4.9-beta' ) >= 0 ) {
			return;
		}
		?>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>

			<!-- Hardcoded error message for older WordPress versions. -->
			<ul><li class="notice notice-warning"><?php esc_attr_e( 'Update to WordPress 4.9 or greater for a datetime picker.', 'kirki' ); ?></li></ul>

			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="customize-control-content">
				<input {{{ data.inputAttrs }}} class="datepicker" type="text" id="{{ data.id }}" value="{{ data.value }}" {{{ data.link }}} />
			</div>
		</label>
		<?php
	}
}
