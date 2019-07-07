<?php // phpcs:disable PHPCompatibility.FunctionDeclarations.NewClosure
/**
 * Option tweaks.
 *
 * @package   kirki-framework/data-option
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Data;

/**
 * Hooks and tweaks to allow Kirki saving Options instead of theme-mods.
 *
 * @since 1.0
 */
class Option {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __construct() {
		add_filter( 'kirki_field_add_setting_args', [ $this, 'add_setting_args' ], 20, 2 );
		add_filter( 'kirki_field_add_control_args', [ $this, 'add_control_args' ], 20, 2 );
	}

	/**
	 * Allow filtering the arguments.
	 *
	 * @since 0.1
	 * @param array                $args The arguments.
	 * @param WP_Customize_Manager $customizer The customizer instance.
	 * @return array                           Return the arguments.
	 */
	public function add_setting_args( $args, $customizer ) {
		// If this is not an option, early exit.
		if ( ! isset( $args['option_type'] ) || 'option' !== $args['option_type'] ) {
			return $args;
		}

		// Set "type" argument to option.
		$args['type'] = 'option';
		return $this->maybe_change_settings( $args );
	}

	/**
	 * Allow filtering the arguments.
	 *
	 * @since 0.1
	 * @param array                $args The arguments.
	 * @param WP_Customize_Manager $customizer The customizer instance.
	 * @return array                           Return the arguments.
	 */
	public function add_control_args( $args, $customizer ) {
		// If this is not an option, early exit.
		if ( ! isset( $args['option_type'] ) || 'option' !== $args['option_type'] ) {
			return $args;
		}
		return $this->maybe_change_settings( $args );
	}

	/**
	 * Change the settings argument.
	 *
	 * @access private
	 * @since 1.0
	 * @param array $args The arguments.
	 * @return array      Returns modified array with tweaks to the [settings] argument if needed.
	 */
	private function maybe_change_settings( $args ) {
		// Check if we have an option-name defined.
		if ( isset( $args['option_name'] ) ) {
			if ( isset( $args['settings'] ) && $args['settings'] && false !== strpos( $args['settings'], $args['option_name'] . '[' ) ) {
				return $args;
			}
			if ( false === strpos( $args['settings'], '[' ) ) {
				$parts = explode( '[', $args['settings'] );
				$final_parts = [ $args['option_name'] ];
				foreach ( $parts as $part ) {
					$final_parts[] = $part;
				}
				$args['settings'] = \implode( '][', $final_parts ) . ']';
				$args['settings'] = str_replace(
					$args['option_name'] . '][',
					$args['option_name'] . '[',
					$args['settings']
				);
			}
		}
		return $args;
	}
}
