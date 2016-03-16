<?php

if ( ! class_exists( 'Kirki_Field' ) ) {
	class Kirki_Field {

		/**
		 * @access protected
		 * @var string
		 */
		protected $kirki_config = 'global';

		/**
		 * @access protected
		 * @var string
		 */
		protected $capability = 'edit_theme_options';

		/**
		 * @access protected
		 * @var string
		 */
		protected $option_name = '';

		/**
		 * @access protected
		 * @var string
		 */
		protected $option_type = 'theme_mod';

		/**
		 * @access protected
		 * @var string|array
		 */
		protected $settings = '';

		/**
		 * @access protected
		 * @var bool
		 */
		protected $disable_output = false;

		/**
		 * @access protected
		 * @var string
		 */
		protected $type = 'kirki-generic';

		/**
		 * @access protected
		 * @var array
		 */
		protected $choices = array();

		/**
		 * @access protected
		 * @var string
		 */
		protected $section = '';

		/**
		 * @access protected
		 * @var string|array
		 */
		protected $default = '';

		/**
		 * @access protected
		 * @var int
		 */
		protected $priority = 10;

		/**
		 * @access protected
		 * @var string
		 */
		protected $id = '';

		/**
		 * @access protected
		 * @var array
		 */
		protected $output = array();

		/**
		 * @access protected
		 * @var array
		 */
		protected $js_vars = array();

		/**
		 * @access protected
		 * @var array
		 */
		protected $variables = array();

		/**
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
		 * @access protected
		 * @var string|array
		 */
		protected $active_callback = '__return_true';

		/**
		 * @access protected
		 * @var string|array
		 */
		protected $sanitize_callback = '';

		/**
		 * @access protected
		 * @var string
		 */
		protected $transport = 'refresh';

		/**
		 * @access protected
		 * @var array
		 */
		protected $required = array();

		/**
		 * @access protected
		 * @var int
		 */
		protected $multiple = 1;

		/**
		 * The class constructor.
		 * Parses and sanitizes all field arguments.
		 * Then it adds the field to Kirki::$fields
		 *
		 * @access public
		 * @param $config_id    string    The ID of the config we want to use.
		 *                                Defaults to "global".
		 *                                Configs are handled by the Kirki_Config class.
		 * @param $args         array     The arguments of the field.
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
			// assume that the provided argument is $args and set $config_id = 'global'
			if ( is_array( $config_id ) && empty( $args ) ) {
				$args = $config_id;
				$this->kirki_config = 'global';
			}
			$this->kirki_config = trim( esc_attr( $config_id ) );
			if ( '' == $config_id ) {
				$this->kirki_config = 'global';
			}
			// Get defaults from the class
			$defaults = get_class_vars( __CLASS__ );
			// Get the config arguments, and merge them with the defaults
			$config_defaults = Kirki::$config[ $this->kirki_config ];
			foreach ( $config_defaults as $key => $value ) {
				if ( isset( $defaults[ $key ] ) ) {
					if ( ! empty( $value ) && $value != $defaults[ $key ] ) {
						$defaults[ $key ] = $value;
					}
				}
			}
			// Merge our args with the defaults
			$args = wp_parse_args( $args, $defaults );
			// Set the class properties using the parsed args
			foreach ( $args as $key => $value ) {
				$this->$key = $value;
			}
			// An array of whitelisted properties that don't need to be sanitized here.
			// format: $key => $default_value
			$whitelisted = apply_filters( 'kirki/' . $this->kirki_config . '/fields/properties_whitelist', array(
				'label'       => '', // this is sanitized later in the controls themselves
				'description' => '', // this is sanitized later in the controls themselves
				'default'     => '', // this is sanitized later in the controls themselves
				'mode'        => '', // only used for backwards-compatibility reasons
				'fields'      => array(), // Used in repeater fields
			) );

			$this->set_field( $whitelisted );

		}

		protected function set_field( $whitelisted_properties = array() ) {

			$properties = get_class_vars( __CLASS__ );
			// remove any whitelisted properties from above
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

			// Sanitize the properties, skipping the ones run from the $priorities
			foreach ( $properties as $property => $value ) {
				if ( in_array( $property, $priorities ) ) {
					continue;
				}
				if ( method_exists( $this, 'set_' . $property ) ) {
					$method_name = 'set_' . $property;
					$this->$method_name();
				}
			}

			// Get all arguments with their values
			$args = get_class_vars( __CLASS__ );
			foreach ( $args as $key => $default_value ) {
				$args[ $key ] = $this->$key;
			}

			// add the whitelisted properties through the back door
			foreach ( $whitelisted_properties as $key => $default_value ) {
				if ( ! isset( $this->$key ) ) {
					$this->$key = $default_value;
				}
				$args[ $key ] = $this->$key;
			}

			// Add the field to the static $fields variable properly indexed
			Kirki::$fields[ $this->settings ] = $args;

			if ( 'background' == $this->type ) {
				// Build the background fields
				Kirki::$fields = Kirki_Explode_Background_Field::process_fields( Kirki::$fields );
			}

		}

		/**
		 * escape $kirki_config
		 *
		 * @access protected
		 */
		protected function set_kirki_config() {

			$this->kirki_config = esc_attr( $this->kirki_config );

		}

		/**
		 * escape $option_name
		 *
		 * @access protected
		 */
		protected function set_option_name() {

			$this->option_name = esc_attr( $this->option_name );

		}


		/**
		 * escape the $section
		 *
		 * @access protected
		 */
		protected function set_section() {

			$this->section = sanitize_key( $this->section );

		}

		/**
		 * Checks the capability chosen is valid.
		 * If not, then falls back to 'edit_theme_options'
		 *
		 * @access protected
		 */
		protected function set_capability() {
			// early exit if we're using 'edit_theme_options'.
			if ( 'edit_theme_options' == $this->capability ) {
				return;
			}
			// escape & trim the capability
			$this->capability = trim( esc_attr( $this->capability ) );
		}

		/**
		 * Make sure we're using the correct option_type
		 *
		 * @access protected
		 */
		protected function set_option_type() {

			// If we have an option_name
			// then make sure we're using options and not theme_mods
			if ( '' != $this->option_name ) {
				$this->option_type = 'option';
			}
			// Take care of common typos
			if ( 'options' == $this->option_type ) {
				$this->option_type = 'option';
			}
			// Take care of common typos
			if ( 'theme_mods' == $this->option_type ) {
				$this->option_type = 'theme_mod';
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
				// If we're using serialized options then we need to spice this up
				if ( 'option' == $this->option_type && '' != $this->option_name && ( false === strpos( $setting_key, '[' ) ) ) {
					$settings[ sanitize_key( $setting_key ) ] = esc_attr( $this->option_name ) . '[' . esc_attr( $setting_value ).']';
				}
			}
			$this->settings = $settings;
			if ( isset( $this->settings['kirki_placeholder_setting'] ) ) {
				$this->settings = $this->settings['kirki_placeholder_setting'];
			}

		}

		/**
		 * escapes the tooltip messages
		 *
		 * @access protected
		 */
		protected function set_tooltip() {

			if ( '' != $this->tooltip ) {
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

			if ( ! empty( $this->required ) ) {
				$this->active_callback = array( 'Kirki_Active_Callback', 'evaluate' );
				return;
			}
			// No need to proceed any further if we're using the default value
			if ( '__return_true' == $this->active_callback ) {
				return;
			}
			// Make sure the function is callable, otherwise fallback to __return_true
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

			switch ( $this->type ) {

				case 'checkbox':
					$this->type = 'kirki-checkbox';
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 switch & toggle were part of the checkbox control.
					if ( in_array( $this->mode, array( 'switch', 'toggle' ) ) ) {
						$this->type = $this->mode;
					}
					break;
				case 'radio':
					$this->type = 'kirki-radio';
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 radio-buttonset & radio-image were part of the checkbox control.
					if ( in_array( $this->mode, array( 'buttonset', 'image' ) ) ) {
						$this->type = 'radio-' . $this->mode;
					}
					break;
				case 'group-title':
				case 'group_title':
					// Tweaks for backwards-compatibility:
					// Prior to version 0.8 there was a group-title control.
					// Instead we now just use a "custom" control.
					$this->type = 'custom';
					break;
				case 'color-alpha':
				case 'color_alpha':
					// Just making sure that common typos will still work.
					$this->type = 'color-alpha';
					$this->choices['alpha'] = true;
					break;
				case 'color':
					$this->type = 'color-alpha';
					$this->choices['alpha'] = false;
					// If a default value of rgba() is defined for a color control then we need to enable the alpha channel.
					if ( false !== strpos( $this->default, 'rgba' ) ) {
						$this->choices['alpha'] = true;
					}
					break;
				case 'select':
				case 'select2':
				case 'select2-multiple':
					$this->multiple = ( 'select2-multiple' == $this->type ) ? 999 : intval( $this->multiple );
					$this->type     = 'kirki-select';
					break;
				case 'textarea':
					$this->type               = 'kirki-generic';
					$this->choices['element'] = 'textarea';
					$this->choices['rows']    = '5';
					if ( '' == $this->sanitize_callback ) {
						$this->sanitize_callback = 'wp_kses_post';
					}
					break;
				case 'text':
					$this->type               = 'kirki-generic';
					$this->choices['element'] = 'input';
					$this->choices['type']    = 'text';
					if ( '' == $this->sanitize_callback ) {
						$this->sanitize_callback = 'wp_kses_post';
					}
					break;
				case 'kirki-generic':
					if ( ! isset( $this->choices['element'] ) ) {
						$this->choices['element'] = 'input';
					}
					break;
			}

			// escape the control type (it doesn't hurt to be sure)
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
				'checkbox'         => array( 'Kirki_Sanitize_Values', 'checkbox' ),
				'toggle'           => array( 'Kirki_Sanitize_Values', 'checkbox' ),
				'switch'           => array( 'Kirki_Sanitize_Values', 'checkbox' ),
				'color'            => array( 'Kirki_Sanitize_Values', 'color' ),
				'color-alpha'      => array( 'Kirki_Sanitize_Values', 'color' ),
				'image'            => 'esc_url_raw',
				'upload'           => 'esc_url_raw',
				'radio'            => 'esc_attr',
				'radio-image'      => 'esc_attr',
				'radio-buttonset'  => 'esc_attr',
				'palette'          => 'esc_attr',
				'select'           => array( 'Kirki_Sanitize_Values', 'unfiltered' ),
				'select2'          => array( 'Kirki_Sanitize_Values', 'unfiltered' ),
				'select2-multiple' => array( 'Kirki_Sanitize_Values', 'unfiltered' ),
				'dropdown-pages'   => array( 'Kirki_Sanitize_Values', 'dropdown_pages' ),
				'slider'           => array( 'Kirki_Sanitize_Values', 'number' ),
				'number'           => array( 'Kirki_Sanitize_Values', 'number' ),
				'text'             => 'esc_textarea',
				'kirki-text'       => 'esc_textarea',
				'textarea'         => 'wp_kses_post',
				'editor'           => 'wp_kses_post',
				'multicheck'       => array( 'Kirki_Sanitize_Values', 'multicheck' ),
				'sortable'         => array( 'Kirki_Sanitize_Values', 'sortable' ),
				'typography'       => array( 'Kirki_Sanitize_Values', 'typography' ),
			);

			if ( array_key_exists( $this->type, $default_callbacks ) ) {
				$this->sanitize_callback = $default_callbacks[ $this->type ];
			}

		}

		/**
		 * Sets the $choices
		 *
		 * @access protected
		 */
		protected function set_choices() {

			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}

		}

		/**
		 * escapes the $disable_output
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
			// Convert to array of arrays if needed
			if ( isset( $this->output['element'] ) ) {
				$this->output = array( $this->output );
			}
			$outputs = array();
			foreach ( $this->output as $output ) {
				if ( ! isset( $output['element'] ) ) {
					continue;
				}
				if ( ! isset( $output['property'] ) && ! in_array( $this->type, array( 'typography', 'background' ) ) ) {
					continue;
				}
				if ( ! isset( $output['sanitize_callback'] ) && isset( $output['callback'] ) ) {
					$output['sanitize_callback'] = $output['callback'];
				}
				// Convert element arrays to strings
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

			/**
			 * @todo
			 *
			 * The following is a work in progress that will help us auto-calculate js_vars
			 * from the output of a field.
			 * During initial tests there were some unforseen side-effects so we're not enabling it yet.
			 */
			// // Try to auto-calculate these.
			// $js_vars = array();
			// if ( empty ( $this->js_vars ) && ! empty( $this->output ) ) {
			// 	$easy_css_properties = array(
			// 		// 'align-content',
			// 		// 'align-items',
			// 		// 'align-self',
			// 		// 'all',
			// 		// 'animation',
			// 		// 'animation-delay',
			// 		// 'animation-direction',
			// 		// 'animation-duration',
			// 		// 'animation-fill-mode',
			// 		// 'animation-iteration-count',
			// 		// 'animation-name',
			// 		// 'animation-play-state',
			// 		// 'animation-timing-function',
			// 		// 'backface-visibility',
			// 		// 'background',
			// 		// 'background-attachment',
			// 		// 'background-blend-mode',
			// 		// 'background-clip',
			// 		'background-color',
			// 		// 'background-image',
			// 		// 'background-origin',
			// 		// 'background-position',
			// 		'background-repeat',
			// 		// 'background-size',
			// 		// 'border',
			// 		// 'border-bottom',
			// 		'border-bottom-color',
			// 		'border-bottom-left-radius',
			// 		'border-bottom-right-radius',
			// 		'border-bottom-style',
			// 		'border-bottom-width',
			// 		// 'border-collapse',
			// 		'border-color',
			// 		// 'border-image',
			// 		// 'border-image-outset',
			// 		// 'border-image-repeat',
			// 		// 'border-image-slice',
			// 		// 'border-image-source',
			// 		'border-image-width',
			// 		// 'border-left',
			// 		'border-left-color',
			// 		// 'border-left-style',
			// 		'border-left-width',
			// 		// 'border-radius',
			// 		// 'border-right',
			// 		'border-right-color',
			// 		// 'border-right-style',
			// 		'border-right-width',
			// 		// 'border-spacing',
			// 		// 'border-style',
			// 		// 'border-top',
			// 		'border-top-color',
			// 		// 'border-top-left-radius',
			// 		// 'border-top-right-radius',
			// 		// 'border-top-style',
			// 		'border-top-width',
			// 		'border-width',
			// 		'bottom',
			// 		// 'box-shadow',
			// 		// 'box-sizing',
			// 		// 'caption-side',
			// 		'clear',
			// 		// 'clip',
			// 		'color',
			// 		'column-count',
			// 		// 'column-fill',
			// 		// 'column-gap',
			// 		// 'column-rule',
			// 		'column-rule-color',
			// 		// 'column-rule-style',
			// 		'column-rule-width',
			// 		// 'column-span',
			// 		'column-width',
			// 		// 'columns',
			// 		// 'content',
			// 		// 'counter-increment',
			// 		// 'counter-reset',
			// 		// 'cursor',
			// 		// 'direction',
			// 		'display',
			// 		// 'empty-cells',
			// 		// 'filter',
			// 		// 'flex',
			// 		// 'flex-basis',
			// 		// 'flex-direction',
			// 		// 'flex-flow',
			// 		// 'flex-grow',
			// 		// 'flex-shrink',
			// 		// 'flex-wrap',
			// 		// 'float',
			// 		// 'font',
			// 		// '@font-face',
			// 		// 'font-family',
			// 		'font-size',
			// 		// 'font-size-adjust',
			// 		// 'font-stretch',
			// 		'font-style',
			// 		'font-variant',
			// 		'font-weight',
			// 		// 'hanging-punctuation',
			// 		'height',
			// 		// 'justify-content',
			// 		// '@keyframes',
			// 		'left',
			// 		// 'letter-spacing',
			// 		'line-height',
			// 		'list-style',
			// 		// 'list-style-image',
			// 		// 'list-style-position',
			// 		'list-style-type',
			// 		'margin',
			// 		'margin-bottom',
			// 		'margin-left',
			// 		'margin-right',
			// 		'margin-top',
			// 		'max-height',
			// 		'max-width',
			// 		// '@media',
			// 		'min-height',
			// 		'min-width',
			// 		// 'nav-down',
			// 		// 'nav-index',
			// 		// 'nav-left',
			// 		// 'nav-right',
			// 		// 'nav-up',
			// 		// 'opacity',
			// 		// 'order',
			// 		// 'outline',
			// 		'outline-color',
			// 		// 'outline-offset',
			// 		// 'outline-style',
			// 		'outline-width',
			// 		'overflow',
			// 		'overflow-x',
			// 		'overflow-y',
			// 		'padding',
			// 		'padding-bottom',
			// 		'padding-left',
			// 		'padding-right',
			// 		'padding-top',
			// 		// 'page-break-after',
			// 		// 'page-break-before',
			// 		// 'page-break-inside',
			// 		// 'perspective',
			// 		// 'perspective-origin',
			// 		// 'position',
			// 		// 'quotes',
			// 		// 'resize',
			// 		'right',
			// 		// 'tab-size',
			// 		// 'table-layout',
			// 		'text-align',
			// 		// 'text-align-last',
			// 		// 'text-decoration',
			// 		'text-decoration-color',
			// 		// 'text-decoration-line',
			// 		// 'text-decoration-style',
			// 		'text-indent',
			// 		'text-justify',
			// 		// 'text-overflow',
			// 		// 'text-shadow',
			// 		// 'text-transform',
			// 		'top',
			// 		// 'transform',
			// 		// 'transform-origin',
			// 		// 'transform-style',
			// 		// 'transition',
			// 		// 'transition-delay',
			// 		// 'transition-duration',
			// 		// 'transition-property',
			// 		// 'transition-timing-function',
			// 		// 'unicode-bidi',
			// 		// 'vertical-align',
			// 		'visibility',
			// 		// 'white-space',
			// 		'width',
			// 		// 'word-break',
			// 		// 'word-spacing',
			// 		// 'word-wrap',
			// 		'z-index',
			// 	);
			// 	// start going through each item in the $output array
			// 	foreach ( $this->output as $output ) {
			// 		$output['function'] = 'css';
			// 		// If 'element' or 'property' are not defined, skip this.
			// 		if ( ! isset( $output['element'] ) || ! isset( $output['property'] ) ) {
			// 			continue;
			// 		}
			// 		// If this is not one of the "easy" elements, skip it.
			// 		if ( ! in_array( $output['property'], $easy_css_properties ) ) {
			// 			continue;
			// 		}
			// 		if ( is_array( $output['element'] ) ) {
			// 			$output['element'] = implode( ',', $output['element'] );
			// 		}
			// 		if ( false !== strrpos( $output['element'], ':' ) ) {
			// 			$output['function'] = 'style';
			// 		}
			// 		// If there's a sanitize_callback defined, skip this.
			// 		if ( isset( $output['sanitize_callback'] ) && ! empty( $output['sanitize_callback'] ) ) {
			// 			continue;
			// 		}
			// 		// If we got this far, it's safe to add this.

			// 		$js_vars[] = $output;
			// 	}

			// 	// Did we manage to get all the items from 'output'?
			// 	// If not, then we're missing something so don't add this.
			// 	if ( count( $js_vars ) != count( $this->output ) ) {
			// 		return;
			// 	}
			// 	$this->js_vars   = $js_vars;
			// 	$this->transport = 'postMessage';

			// }

		}

		/**
		 * Sets the $variables
		 *
		 * @access protected
		 */
		protected function set_variables() {

			if ( ! is_array( $this->variables ) ) {
				$this->variables = array();
			}

		}

		/**
		 * This is a fallback method:
		 * $help has now become $tooltip, so this just migrates the data
		 *
		 * @access protected
		 */
		protected function set_help() {

			if ( '' != $this->tooltip ) {
				return;
			}
			if ( '' != $this->help ) {
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

			if ( 'postmessage' == trim( strtolower( $this->transport ) ) ) {
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
