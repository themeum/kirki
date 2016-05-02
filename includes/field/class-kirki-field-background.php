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

			// Apply migration filters for theme_mods.
			foreach( array( 'color', 'repeat', 'size', 'attach', 'position' ) as $property ) {
				add_filter( 'theme_mod_' . $this->settings . '_' . $property, array( $this, 'get_theme_mod_' . $property ) );
			}
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
		 * @param string $value The value.
		 * @return string
		 */
		public function get_theme_mod_color( $value ) {
			return $this->get_theme_mod( 'color', $value );
		}


		/**
		 * Takes care of migrating previous versions to the new format
		 * and returning the right value.
		 *
		 * @access public
		 * @param string $value The value.
		 * @return string
		 */
		public function get_theme_mod_repeat( $value ) {
			return $this->get_theme_mod( 'repeat', $value );
		}

		/**
		 * Takes care of migrating previous versions to the new format
		 * and returning the right value.
		 *
		 * @access public
		 * @param string $value The value.
		 * @return string
		 */
		public function get_theme_mod_size( $value ) {
			return $this->get_theme_mod( 'size', $value );
		}

		/**
		 * Takes care of migrating previous versions to the new format
		 * and returning the right value.
		 *
		 * @access public
		 * @param string $value The value.
		 * @return string
		 */
		public function get_theme_mod_attach( $value ) {
			return $this->get_theme_mod( 'attach', $value );
		}

		/**
		 * Takes care of migrating previous versions to the new format
		 * and returning the right value.
		 *
		 * @access public
		 * @param string $value The value.
		 * @return string
		 */
		public function get_theme_mod_position( $value ) {
			return $this->get_theme_mod( 'position', $value );
		}

		/**
		 * Takes care of migrating previous versions to the new format
		 * and returning the right value.
		 *
		 * @access public
		 * @param string $context The sub-control.
		 * @param string $value   The value.
		 * @return string
		 */
		public function get_theme_mod( $context = '', $value ) {

			// If this field is not using theme_mods, then just return the value.
			if ( 'theme_mod' !== $this->option_type ) {
				return $value;
			}
			// Make sure we're using a color field for this background.
			if ( ! is_array( $this->default ) || ! isset( $this->default[ $context ] ) ) {
				return $value;
			}

			// If we don't have a $this->settings . '_color' theme_mod then we don't need to migrate anything.
			if ( false === get_theme_mod( $this->settings . '_' . $context, false ) ) {
				return $value;
			}

			// Update the new format value and delete the old theme-mod.
			$new_value          = get_theme_mod( $this->settings, array() );
			$new_value['color'] = get_theme_mod( $this->settings . '_' . $context, false );
			set_theme_mod( $this->settings, $new_value );
			remove_theme_mod( $this->settings . '_' . $context );

			return $new_value[ $context ];
		}
	}
}
