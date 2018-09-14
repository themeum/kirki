<?php
/**
 * Customizer Control: code.
 *
 * Creates a new custom control.
 * Custom controls accept raw HTML/JS.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

// @codingStandardsIgnoreFile Generic.Files.OneClassPerFile.MultipleFound Generic.Classes.DuplicateClassName.Found

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Show warning if old WordPress.
 */
if ( ! class_exists( 'WP_Customize_Code_Editor_Control' ) ) {
	/**
	 * Adds a warning message instead of the control.
	 */
	class Kirki_Control_Code extends Kirki_Control_Base {

		/**
		 * The message.
		 *
		 * @since 3.0.21
		 */
		protected function content_template() {
			?>
			<div class="notice notice-error" data-type="error"><div class="notification-message">
				<?php esc_attr_e( 'Please update your WordPress installation to a version newer than 4.9 to access the code control.', 'kirki' ); ?>
			</div></div>
			<?php
		}
	}
} else {

	/**
	 * Adds a "code" control, alias of the WP_Customize_Code_Editor_Control class.
	 */
	class Kirki_Control_Code extends WP_Customize_Code_Editor_Control {}
}
