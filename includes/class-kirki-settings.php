<?php

if ( ! class_exists( 'Kirki_Settings' ) ) {

	class Kirki_Settings {

		/**
		 * @access protected
		 * @var WP_Customize_Manager
		 */
		protected $wp_customize;

		/**
		 * @access protected
		 * @var array
		 */
		protected $setting_types = array();

		/**
		 * Creates a new Kirki_Settings object.
		 * Class constructor.
		 *
		 * @access public
		 * @param $args    array    the field definition as sanitized in Kirki_Field
		 */
		public function __construct( $args = array() ) {

			// Set the $wp_customize property
			global $wp_customize;
			if ( ! $wp_customize ) {
				return;
			}
			$this->wp_customize = $wp_customize;

			// Set the setting_types
			$this->set_setting_types();
			// Add the settings
			$this->add_settings( $args );

		}

		/**
		 * Adds the settings for this field.
		 * If settings are defined as an array, then it goes through them
		 * and calls the add_setting method.
		 * If not an array, then it just calls add_setting
		 *
		 * @access private
		 * @param $args    array    the field definition as sanitized in Kirki_Field
		 */
		final private function add_settings( $args = array() ) {

			// Get the classname we'll be using to create our setting(s)
			if ( ! isset( $args['type'] ) || ! array_key_exists( $args['type'], $this->setting_types ) ) {
				$args['type'] = 'default';
			}
			$classname = $this->setting_types[ $args['type'] ];

			// If settings are defined as an array, then we need to go through them
			// and call add_setting for each one of them separately.
			if ( isset( $args['settings'] ) && is_array( $args['settings'] ) ) {
				// Make sure defaults have been defined
				if ( ! isset( $args['default'] ) || ! is_array( $args['default'] ) ) {
					$args['default'] = array();
				}
				foreach ( $args['settings'] as $key => $value ) {
					$default   = ( isset( $defaults[ $key ] ) ) ? $defaults[ $key ] : '';
					$this->add_setting( $classname, $value, $default, $args['option_type'], $args['capability'], $args['transport'], $args['sanitize_callback'] );
				}
			}
			$this->add_setting( $classname, $args['settings'], $args['default'], $args['option_type'], $args['capability'], $args['transport'], $args['sanitize_callback'] );
		}

		/**
		 * This is where we're finally adding the setting to the Customizer.
		 *
		 * @access private
		 * @param $classname            string          the name of the class that will be used to create this setting.
		 *                                              We're getting this from $this->setting_types
		 * @param $setting              string          the setting-name
		 *                                              If settings is an array, then this method is called per-setting.
		 * @param $default              string|array    default value for this setting
		 * @param $type                 string          theme_mod|option
		 * @param $capability           string          @see https://codex.wordpress.org/Roles_and_Capabilities
		 * @param $transport            string          refresh|postMessage
		 * @param $sanitize_callback    string|array    a callable sanitization function or method.
		 */
		final private function add_setting( $classname, $setting, $default, $type, $capability, $transport, $sanitize_callback ) {

			$this->wp_customize->add_setting( new $classname( $this->wp_customize, $setting, array(
				'default'           => $default,
				'type'              => $type,
				'capability'        => $capability,
				'transport'         => $transport,
				'sanitize_callback' => $sanitize_callback,
			) ) );

		}

		/**
		 * Sets the $this->setting_types property.
		 * Makes sure the kirki/setting_types filter is applied
		 * and that the defined classes actually exist.
		 * If a defined class does not exist, it is removed.
		 */
		final private function set_setting_types() {

			// Apply the kirki/setting_types filter
			$this->setting_types = apply_filters( 'kirki/setting_types', array(
				'default'  => 'Kirki_Settings_Default_Setting',
				'repeater' => 'Kirki_Settings_Repeater_Setting',
			) );

			// Make sure the defined classes actually exist
			foreach ( $this->setting_types as $key => $classname ) {

				if ( ! class_exists( $classname ) ) {
					unset( $this->setting_types[ $key ] );
				}

			}

		}

	}

}
