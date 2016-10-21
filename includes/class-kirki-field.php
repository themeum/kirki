<?php
/**
 * Creates and validates field parameters.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_Field' ) ) {

	/**
	 * Please do not use this class directly.
	 * You should instead extend it per-field-type.
	 */
	class Kirki_Field {

		/**
		 * The ID of the kirki_config we're using.
		 *
		 * @see Kirki_Config
		 * @access protected
		 * @var string
		 */
		protected $kirki_config = 'global';

		/**
		 * Thje capability required so that users can edit this field.
		 *
		 * @access protected
		 * @var string
		 */
		protected $capability = 'edit_theme_options';

		/**
		 * If we're using options instead of theme_mods
		 * and we want them serialized, this is the option that
		 * will saved in the db.
		 *
		 * @access protected
		 * @var string
		 */
		protected $option_name = '';

		/**
		 * Vustom input attributes (defined as an array).
		 *
		 * @access protected
		 * @var array
		 */
		protected $input_attrs = array();

		/**
		 * Use "theme_mod" or "option".
		 *
		 * @access protected
		 * @var string
		 */
		protected $option_type = 'theme_mod';

		/**
		 * The name of this setting (id for the db).
		 *
		 * @access protected
		 * @var string|array
		 */
		protected $settings = '';

		/**
		 * Set to true if you want to disable all CSS output for this field.
		 *
		 * @access protected
		 * @var bool
		 */
		protected $disable_output = false;

		/**
		 * The field type.
		 *
		 * @access protected
		 * @var string
		 */
		protected $type = 'kirki-generic';

		/**
		 * Some fields require options to be set.
		 * We're whitelisting the property here
		 * and suggest you validate this in a child class.
		 *
		 * @access protected
		 * @var array
		 */
		protected $choices = array();

		/**
		 * Assign this field to a section.
		 * Fields not assigned to a section will not be displayed in the customizer.
		 *
		 * @access protected
		 * @var string
		 */
		protected $section = '';

		/**
		 * The default value for this field.
		 *
		 * @access protected
		 * @var string|array
		 */
		protected $default = '';

		/**
		 * Priority determines the position of a control inside a section.
		 * Lower priority numbers move the control to the top.
		 *
		 * @access protected
		 * @var int
		 */
		protected $priority = 10;

		/**
		 * Unique ID for this field.
		 * This is auto-calculated from the $settings argument.
		 *
		 * @access protected
		 * @var string
		 */
		protected $id = '';

		/**
		 * Use if you want to automatically generate CSS from this field's value.
		 *
		 * @see https://kirki.org/docs/arguments/output
		 * @access protected
		 * @var array
		 */
		protected $output = array();

		/**
		 * Use to automatically generate postMessage scripts.
		 * Not necessary to use if you use 'transport' => 'auto'
		 * and have already set an array for the 'output' argument.
		 *
		 * @see https://kirki.org/docs/arguments/js_vars
		 * @access protected
		 * @var array
		 */
		protected $js_vars = array();

		/**
		 * If you want to use a CSS compiler, then use this to set the variable names.
		 *
		 * @see https://kirki.org/docs/arguments/variables
		 * @access protected
		 * @var array
		 */
		protected $variables = array();

		/**
		 * Text that will be used in a tooltip to provide extra info for this field.
		 *
		 * @access protected
		 * @var string
		 */
		protected $tooltip = '';

		/**
		 * Whitelisting for backwards-compatibility.
		 *
		 * @access protected
		 * @var string
		 */
		protected $help = '';

		/**
		 * Whitelisting for backwards-compatibility.
		 *
		 * @access protected
		 * @var string
		 */
		protected $mode = '';

		/**
		 * A custom callback to determine if the field should be visible or not.
		 *
		 * @access protected
		 * @var string|array
		 */
		protected $active_callback = '__return_true';

		/**
		 * A custom sanitize callback that will be used to properly save the values.
		 *
		 * @access protected
		 * @var string|array
		 */
		protected $sanitize_callback = '';

		/**
		 * Use 'refresh', 'postMessage' or 'auto'.
		 * 'auto' will automatically geberate any 'js_vars' from the 'output' argument.
		 *
		 * @access protected
		 * @var string
		 */
		protected $transport = 'refresh';

		/**
		 * Define dependencies to show/hide this field based on the values of other fields.
		 *
		 * @access protected
		 * @var array
		 */
		protected $required = array();

		/**
		 * Use only on select controls.
		 * Defines if this is a multi-select or not.
		 * If value is > 1, then the maximum number of selectable options
		 * is the number defined here.
		 *
		 * @access protected
		 * @var int
		 */
		protected $multiple = 1;

		/**
		 * Suggested width for cropped image.
		 *
		 * @access protected
		 * @var int
		 */
		protected $width = 150;

		/**
		 * Suggested height for cropped image.
		 *
		 * @access protected
		 * @var int
		 */
		protected $height = 150;

		/**
		 * Whether the width is flexible for cropped image.
		 *
		 * @access protected
		 * @var bool
		 */
		protected $flex_width = false;

		/**
		 * Whether the height is flexible for cropped image.
		 *
		 * @access protected
		 * @var bool
		 */
		protected $flex_height = false;

		/**
		 * Contain the settings for the repeater rows labels
		 *
		 * @access protected
		 * @var array
		 */
		protected $row_label = array();

		/**
		 * Partial Refreshes array.
		 *
		 * @access protected
		 * @var array
		 */
		protected $partial_refresh = array();

		/**
		 * Use only on image, cropped_image, upload controls.
		 * Limit the Media library to a specific mime type
		 *
		 * @access protected
		 * @var array
		 */
		protected $mime_type = '';

		/**
		 * The class constructor.
		 * Parses and sanitizes all field arguments.
		 * Then it adds the field to Kirki::$fields.
		 *
		 * @access public
		 * @param string $config_id    The ID of the config we want to use.
		 *                             Defaults to "global".
		 *                             Configs are handled by the Kirki_Config class.
		 * @param array  $args         The arguments of the field.
		 */
		public function __construct( $config_id = 'global', $args = array() ) {

			if ( isset( $args['setting'] ) && ! empty( $args['setting'] ) && ( ! isset( $args['settings'] ) || empty( $args['settings'] ) ) ) {
				$args['settings'] = $args['setting'];
				unset( $args['setting'] );
				error_log( 'Kirki: Typo found in field ' . $args['settings'] . ' ("setting" instead of "settings").' );
			}

			if ( is_string( $config_id ) ) {
				$args['kirki_config'] = $config_id;
			}

			// In case the user only provides 1 argument,
			// assume that the provided argument is $args and set $config_id = 'global'.
			if ( is_array( $config_id ) && empty( $args ) ) {
				$args = $config_id;
				$this->kirki_config = 'global';
			}
			$this->kirki_config = trim( esc_attr( $config_id ) );
			if ( '' === $config_id ) {
				$this->kirki_config = 'global';
			}

			// Get defaults from the class.
			$defaults = get_class_vars( __CLASS__ );

			// Get the config arguments, and merge them with the defaults.
			$config_defaults = ( isset( Kirki::$config['global'] ) ) ? Kirki::$config['global'] : array();
			if ( 'global' !== $this->kirki_config && isset( Kirki::$config[ $this->kirki_config ] ) ) {
				$config_defaults = Kirki::$config[ $this->kirki_config ];
			}
			$config_defaults = ( is_array( $config_defaults ) ) ? $config_defaults : array();
			foreach ( $config_defaults as $key => $value ) {
				if ( isset( $defaults[ $key ] ) ) {
					if ( ! empty( $value ) && $value != $defaults[ $key ] ) {
						$defaults[ $key ] = $value;
					}
				}
			}

			// Merge our args with the defaults.
			$args = wp_parse_args( $args, $defaults );

			// Set the class properties using the parsed args.
			foreach ( $args as $key => $value ) {
				$this->$key = $value;
			}

			// An array of whitelisted properties that don't need to be sanitized here.
			// Format: $key => $default_value.
			$whitelisted = apply_filters( 'kirki/' . $this->kirki_config . '/fields/properties_whitelist', array(
				'label'       => '', // This is sanitized later in the controls themselves.
				'description' => '', // This is sanitized later in the controls themselves.
				'mode'        => '', // Only used for backwards-compatibility reasons.
				'fields'      => array(), // Used in repeater fields.
				'row_label'   => array(), // Used in repeater fields.
			) );

			$this->set_field( $whitelisted );

		}

		/**
		 * Processes the field arguments
		 *
		 * @param array $whitelisted_properties Defines an array of arguments that will skip validation at this point.
		 */
		protected function set_field( $whitelisted_properties = array() ) {

			$properties = get_class_vars( __CLASS__ );
			// Remove any whitelisted properties from above.
			// These will get a free pass, completely unfiltered.
			foreach ( $whitelisted_properties as $key => $default_value ) {
				if ( isset( $properties[ $key ] ) ) {
					unset( $properties[ $key ] );
				}
			}

			// Some things must run before the others.
			$priorities = array(
				'option_name',
				'option_type',
				'settings',
			);

			foreach ( $priorities as $priority ) {
				if ( method_exists( $this, 'set_' . $priority ) ) {
					$method_name = 'set_' . $priority;
					$this->$method_name();
				}
			}

			// Sanitize the properties, skipping the ones run from the $priorities.
			foreach ( $properties as $property => $value ) {
				if ( in_array( $property, $priorities, true ) ) {
					continue;
				}
				if ( method_exists( $this, 'set_' . $property ) ) {
					$method_name = 'set_' . $property;
					$this->$method_name();
				}
			}

			// Get all arguments with their values.
			$args = get_class_vars( __CLASS__ );
			foreach ( $args as $key => $default_value ) {
				$args[ $key ] = $this->$key;
			}

			// Add the whitelisted properties through the back door.
			foreach ( $whitelisted_properties as $key => $default_value ) {
				if ( ! isset( $this->$key ) ) {
					$this->$key = $default_value;
				}
				$args[ $key ] = $this->$key;
			}

			// Add the field to the static $fields variable properly indexed.
			Kirki::$fields[ $this->settings ] = $args;

			if ( 'background' === $this->type ) {
				// Build the background fields.
				Kirki::$fields = Kirki_Explode_Background_Field::process_fields( Kirki::$fields );
			}

		}

		/**
		 * This allows us to process this on a field-basis
		 * by using sub-classes which can override this method.
		 *
		 * @access protected
		 */
		protected function set_default() {}

		/**
		 * Escape $kirki_config.
		 *
		 * @access protected
		 */
		protected function set_kirki_config() {

			$this->kirki_config = esc_attr( $this->kirki_config );

		}

		/**
		 * Escape $option_name.
		 *
		 * @access protected
		 */
		protected function set_option_name() {

			$this->option_name = esc_attr( $this->option_name );

		}

		/**
		 * Escape the $section.
		 *
		 * @access protected
		 */
		protected function set_section() {

			$this->section = sanitize_key( $this->section );

		}

		/**
		 * Escape the $section.
		 *
		 * @access protected
		 */
		protected function set_input_attrs() {

			if ( ! is_array( $this->input_attrs ) ) {
				$this->input_attrs = array();
			}

		}

		/**
		 * Checks the capability chosen is valid.
		 * If not, then falls back to 'edit_theme_options'
		 *
		 * @access protected
		 */
		protected function set_capability() {
			// Early exit if we're using 'edit_theme_options'.
			if ( 'edit_theme_options' === $this->capability ) {
				return;
			}
			// Escape & trim the capability.
			$this->capability = trim( esc_attr( $this->capability ) );
		}

		/**
		 * Make sure we're using the correct option_type
		 *
		 * @access protected
		 */
		protected function set_option_type() {

			// Take care of common typos.
			if ( 'options' === $this->option_type ) {
				$this->option_type = 'option';
			}
			// Take care of common typos.
			if ( 'theme_mods' === $this->option_type ) {
				$this->option_type = 'theme_mod';
			}
		}

		/**
		 * Modifications for partial refreshes.
		 *
		 * @access protected
		 */
		protected function set_partial_refresh() {
			if ( ! is_array( $this->partial_refresh ) ) {
				$this->partial_refresh = array();
			}
			foreach ( $this->partial_refresh as $id => $args ) {
				if ( ! is_array( $args ) || ! isset( $args['selector'] ) || ! isset( $args['render_callback'] ) || ! is_callable( $args['render_callback'] ) ) {
					unset( $this->partial_refresh[ $id ] );
					continue;
				}
			}
			if ( ! empty( $this->partial_refresh ) ) {
				$this->transport = 'postMessage';
			}
		}

		/**
		 * Sets the settings.
		 * If we're using serialized options it makes sure that settings are properly formatted.
		 * We'll also be escaping all setting names here for consistency.
		 *
		 * @access protected
		 */
		protected function set_settings() {

			// If settings is not an array, temporarily convert it to an array.
			// This is just to allow us to process everything the same way and avoid code duplication.
			// if settings is not an array then it will not be set as an array in the end.
			if ( ! is_array( $this->settings ) ) {
				$this->settings = array( 'kirki_placeholder_setting' => $this->settings );
			}
			$settings = array();
			foreach ( $this->settings as $setting_key => $setting_value ) {
				$settings[ sanitize_key( $setting_key ) ] = esc_attr( $setting_value );
				// If we're using serialized options then we need to spice this up.
				if ( 'option' === $this->option_type && '' !== $this->option_name && ( false === strpos( $setting_key, '[' ) ) ) {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $this->option_name ) . '[' . esc_attr( $setting_value ) . ']';
				}
			}
			$this->settings = $settings;
			if ( isset( $this->settings['kirki_placeholder_setting'] ) ) {
				$this->settings = $this->settings['kirki_placeholder_setting'];
			}

		}

		/**
		 * Escapes the tooltip messages.
		 *
		 * @access protected
		 */
		protected function set_tooltip() {

			if ( '' !== $this->tooltip ) {
				$this->tooltip = wp_strip_all_tags( $this->tooltip );
				return;
			}

		}

		/**
		 * Sets the active_callback
		 * If we're using the $required argument,
		 * Then this is where the switch is made to our evaluation method.
		 *
		 * @access protected
		 */
		protected function set_active_callback() {

			if ( is_array( $this->active_callback ) && ! is_callable( $this->active_callback ) ) {
				if ( isset( $this->active_callback[0] ) ) {
					$this->required = $this->active_callback;
				}
			}

			if ( ! empty( $this->required ) ) {
				$this->active_callback = array( 'Kirki_Active_Callback', 'evaluate' );
				return;
			}
			// No need to proceed any further if we're using the default value.
			if ( '__return_true' === $this->active_callback ) {
				return;
			}
			// Make sure the function is callable, otherwise fallback to __return_true.
			if ( ! is_callable( $this->active_callback ) ) {
				$this->active_callback = '__return_true';
			}

		}

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			// Escape the control type (it doesn't hurt to be sure).
			$this->type = esc_attr( $this->type );

		}

		/**
		 * Sets the $id.
		 * Setting the ID should happen after the 'settings' sanitization.
		 * This way we can also properly handle cases where the option_type is set to 'option'
		 * and we're using an array instead of individual options.
		 *
		 * @access protected
		 */
		protected function set_id() {

			$this->id = sanitize_key( str_replace( '[', '-', str_replace( ']', '', $this->settings ) ) );

		}

		/**
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function set_sanitize_callback() {

			// If a custom sanitize_callback has been defined,
			// then we don't need to proceed any further.
			if ( ! empty( $this->sanitize_callback ) ) {
				return;
			}

			$default_callbacks = array(
				'kirki-multicheck'       => array( 'Kirki_Sanitize_Values', 'multicheck' ),
				'kirki-sortable'         => array( 'Kirki_Sanitize_Values', 'sortable' ),
				'kirki-typography'       => array( 'Kirki_Sanitize_Values', 'typography' ),
			);

			if ( array_key_exists( $this->type, $default_callbacks ) ) {
				$this->sanitize_callback = $default_callbacks[ $this->type ];
			}

		}

		/**
		 * Sets the $choices.
		 *
		 * @access protected
		 */
		protected function set_choices() {

			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}

		}

		/**
		 * Escapes the $disable_output.
		 *
		 * @access protected
		 */
		protected function set_disable_output() {

			$this->disable_output = (bool) $this->disable_output;

		}

		/**
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function set_output() {

			if ( empty( $this->output ) ) {
				return;
			}
			if ( ! empty( $this->output ) && ! is_array( $this->output ) ) {
				$this->output = array( array( 'element' => $this->output ) );
			}
			// Convert to array of arrays if needed.
			if ( isset( $this->output['element'] ) ) {
				$this->output = array( $this->output );
			}
			$outputs = array();
			foreach ( $this->output as $output ) {
				if ( ! isset( $output['element'] ) ) {
					continue;
				}
				if ( ! isset( $output['property'] ) && ! in_array( $this->type, array( 'kirki-typography', 'background' ), true ) ) {
					continue;
				}
				if ( ! isset( $output['sanitize_callback'] ) && isset( $output['callback'] ) ) {
					$output['sanitize_callback'] = $output['callback'];
				}
				// Convert element arrays to strings.
				if ( is_array( $output['element'] ) ) {
					$output['element'] = array_unique( $output['element'] );
					sort( $output['element'] );
					$output['element'] = implode( ',', $output['element'] );
				}
				$outputs[] = array(
					'element'           => $output['element'],
					'property'          => ( isset( $output['property'] ) ) ? $output['property'] : '',
					'media_query'       => ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global',
					'sanitize_callback' => ( isset( $output['sanitize_callback'] ) ) ? $output['sanitize_callback'] : '',
					'units'             => ( isset( $output['units'] ) ) ? $output['units'] : '',
					'prefix'            => ( isset( $output['prefix'] ) ) ? $output['prefix'] : '',
					'suffix'            => ( isset( $output['suffix'] ) ) ? $output['suffix'] : '',
					'exclude'           => ( isset( $output['exclude'] ) ) ? $output['exclude'] : false,
				);
			}

		}

		/**
		 * Sets the $js_vars
		 *
		 * @access protected
		 */
		protected function set_js_vars() {

			if ( ! is_array( $this->js_vars ) ) {
				$this->js_vars = array();
			}

			// Check if transport is set to auto.
			// If not, then skip the auto-calculations and exit early.
			if ( 'auto' !== $this->transport ) {
				return;
			}

			// Set transport to refresh initially.
			// Serves as a fallback in case we failt to auto-calculate js_vars.
			$this->transport = 'refresh';

			$js_vars = array();

			// Try to auto-generate js_vars.
			// First we need to check if js_vars are empty, and that output is not empty.
			if ( empty( $this->js_vars ) && ! empty( $this->output ) ) {

				// Start going through each item in the $output array.
				foreach ( $this->output as $output ) {
					$output['function'] = 'css';

					// If 'element' or 'property' are not defined, skip this.
					if ( ! isset( $output['element'] ) || ! isset( $output['property'] ) ) {
						continue;
					}
					if ( is_array( $output['element'] ) ) {
						$output['element'] = implode( ',', $output['element'] );
					}
					if ( false !== strpos( $output['element'], ':' ) ) {
						$output['function'] = 'style';
					}

					// If there's a sanitize_callback defined, skip this.
					if ( isset( $output['sanitize_callback'] ) && ! empty( $output['sanitize_callback'] ) ) {
						continue;
					}

					// If we got this far, it's safe to add this.
					$js_vars[] = $output;
				}

				// Did we manage to get all the items from 'output'?
				// If not, then we're missing something so don't add this.
				if ( count( $js_vars ) !== count( $this->output ) ) {
					return;
				}
				$this->js_vars   = $js_vars;
				$this->transport = 'postMessage';

			}

		}

		/**
		 * Sets the $variables
		 *
		 * @access protected
		 */
		protected function set_variables() {
			$variable = '';
			if ( ! is_array( $this->variables ) ) {
				$variable = ( is_string( $this->variables ) && ! empty( $this->variables ) ) ? $this->variables : false;
				$this->variables = array();
				if ( $variable && empty( $this->variables ) ) {
					$this->variables[0]['name'] = $variable;
				}
			}
		}

		/**
		 * This is a fallback method:
		 * $help has now become $tooltip, so this just migrates the data
		 *
		 * @access protected
		 */
		protected function set_help() {

			if ( '' !== $this->tooltip ) {
				return;
			}
			if ( '' !== $this->help ) {
				$this->tooltip = wp_strip_all_tags( $this->help );
				// $help has been deprecated
				$this->help = '';
				return;
			}

		}

		/**
		 * Sets the $transport
		 *
		 * @access protected
		 */
		protected function set_transport() {

			if ( 'postmessage' === trim( strtolower( $this->transport ) ) ) {
				$this->transport = 'postMessage';
			}

		}

		/**
		 * Sets the $required
		 *
		 * @access protected
		 */
		protected function set_required() {

			if ( ! is_array( $this->required ) ) {
				$this->required = array();
			}

		}

		/**
		 * Sets the $multiple
		 *
		 * @access protected
		 */
		protected function set_multiple() {

			$this->multiple = absint( $this->multiple );

		}

		/**
		 * Sets the $priority
		 *
		 * @access protected
		 */
		protected function set_priority() {

			$this->priority = absint( $this->priority );

		}
	}
}
