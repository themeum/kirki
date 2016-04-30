<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

if ( ! class_exists( 'Kirki_Field_Background' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Background extends Kirki_Field {

		/**
		 * The class constructor.
		 * We'll be calling the parent constructor and also adding some filters
		 * that will be used for backwards-compatibility purposes.
		 *
		 * @access public
		 * @param string $config_id    The ID of the config we want to use.
		 *                             Defaults to "global".
		 *                             Configs are handled by the Kirki_Config class.
		 * @param array  $args         The arguments of the field.
		 */
		public function __construct( $config_id = 'global', $args = array() ) {

			// Call the parent-class constructor.
			parent::__construct( $config_id, $args );

			// Apply color filters for theme_mods.
			add_filter( $this->settings . '_color', array( $this, 'get_theme_mod_color' ) );
		}

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-background';

		}

		/**
		 * Takes care of migrating previous versions to the new format
		 * and returning the right value.
		 *
		 * @access public
		 * @param string $value The color value.
		 * @return string
		 */
		public function get_theme_mod_color( $value ) {

			// If this field is not using theme_mods, then just return the value.
			if ( 'theme_mod' !== $this->option_type ) {
				return $value;
			}
			// Make sure we're using a color field for this background.
			if ( ! is_array( $this->default ) || ! isset( $this->default['color'] ) ) {
				return $value;
			}

			// If we don't have a $this->settings . '_color' theme_mod then we don't need to migrate anything.
			if ( false !== get_theme_mod( $this->settings . '_color', false ) ) {
				return $value;
			}

			// Update the new format value and delete the old theme-mod.
			$new_value          = get_theme_mod( $this->settings, array() );
			$new_value['color'] = get_theme_mod( $this->settings . '_color', false );
			set_theme_mod( $this->settings, $new_value );
			remove_theme_mod( $this->settings . '_color' );

			return $new_value['color'];
		}
	}
}
