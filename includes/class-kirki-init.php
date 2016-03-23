<?php

if ( ! class_exists( 'Kirki_Init' ) ) {
	class Kirki_Init {

		/**
		 * the class constructor
		 */
		public function __construct() {
			$this->set_url();
			add_action( 'customize_update_user_meta', array( $this, 'update_user_meta' ), 10, 2 );
			add_action( 'wp_loaded', array( $this, 'add_to_customizer' ), 1 );
		}

		/**
		 * Properly set the Kirki URL for assets
		 * Determines if Kirki is installed as a plugin, in a child theme, or a parent theme
		 * and then does some calculations to get the proper URL for its CSS & JS assets
		 */
		public function set_url() {
			/**
			 * Are we on a parent theme?
			 */
			if ( Kirki_Toolkit::is_parent_theme( __FILE__ ) ) {
				$relative_url = str_replace( Kirki_Toolkit::clean_file_path( get_template_directory() ), '', dirname( dirname( __FILE__ ) ) );
				Kirki::$url = trailingslashit( get_template_directory_uri() . $relative_url );
			}
			/**
			 * Are we on a child theme?
			 */
			elseif ( Kirki_Toolkit::is_child_theme( __FILE__ ) ) {
				$relative_url = str_replace( Kirki_Toolkit::clean_file_path( get_stylesheet_directory() ), '', dirname( dirname( __FILE__ ) ) );
				Kirki::$url = trailingslashit( get_stylesheet_directory_uri() . $relative_url );
			}
			/**
			 * Fallback to plugin
			 */
			else {
				Kirki::$url = plugin_dir_url( dirname( __FILE__ ) . 'kirki.php' );
			}
		}

		/**
		 * Helper function that adds the fields, sections and panels to the customizer.
		 *
		 * @return void
		 */
		public function add_to_customizer() {
			$this->fields_from_filters();
			add_action( 'customize_register', array( $this, 'register_control_types' ) );
			add_action( 'customize_register', array( $this, 'add_panels' ), 97 );
			add_action( 'customize_register', array( $this, 'add_sections' ), 98 );
			add_action( 'customize_register', array( $this, 'add_fields' ), 99 );
			new Kirki_Customizer_Scripts_Loading();
		}

		/**
		 * Register control types
		 *
		 * @return  void
		 */
		public function register_control_types() {
			global $wp_customize;

			$wp_customize->register_section_type( 'Kirki_Sections_Expanded_Section' );
			$wp_customize->register_section_type( 'Kirki_Sections_Hover_Section' );

			$wp_customize->register_panel_type( 'Kirki_Panels_Expanded_Panel' );

			$wp_customize->register_control_type( 'Kirki_Controls_Checkbox_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Code_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Color_Alpha_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Custom_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Dashicons_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Dimension_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Number_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Radio_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Radio_Buttonset_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Radio_Image_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Select_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Slider_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Spacing_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Switch_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Generic_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Toggle_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Typography_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Palette_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Preset_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Multicheck_Control' );
			$wp_customize->register_control_type( 'Kirki_Controls_Sortable_Control' );
		}

		/**
		 * register our panels to the WordPress Customizer
		 *
		 * @var	object	The WordPress Customizer object
		 * @return  void
		 */
		public function add_panels() {
			if ( ! empty( Kirki::$panels ) ) {
				foreach ( Kirki::$panels as $panel_args ) {
					new Kirki_Panel( $panel_args );
				}
			}
		}

		/**
		 * register our sections to the WordPress Customizer
		 *
		 * @var	object	The WordPress Customizer object
		 * @return  void
		 */
		public function add_sections() {
			if ( ! empty( Kirki::$sections ) ) {
				foreach ( Kirki::$sections as $section_args ) {
					new Kirki_Section( $section_args );
				}
			}
		}

		/**
		 * Create the settings and controls from the $fields array and register them.
		 *
		 * @var	object	The WordPress Customizer object
		 * @return  void
		 */
		public function add_fields() {

			global $wp_customize;
			foreach ( Kirki::$fields as $args ) {
				if ( isset( $args['type'] ) && 'background' == $args['type'] ) {
					continue;
				}
				/**
				 * Create the settings.
				 */
				new Kirki_Settings( $args );
				/**
				 * Check if we're on the customizer.
				 * If we are, then we will create the controls,
				 * add the scripts needed for the customizer
				 * and any other tweaks that this field may require.
				 */
				if ( $wp_customize ) {
					/**
					 * Create the control
					 */
					new Kirki_Control( $args );
					/**
					 * Create the scripts for tooltips.
					 */
					Kirki_Customizer_Scripts_Tooltips::generate_script( $args );
				}
			}
		}

		/**
		 * Build the variables.
		 *
		 * @return array 	('variable-name' => value)
		 */
		public function get_variables() {

			$variables = array();

			/**
			 * Loop through all fields
			 */
			foreach ( Kirki::$fields as $field ) {
				/**
				 * Check if we have variables for this field
				 */
				if ( isset( $field['variables'] ) && false != $field['variables'] && ! empty( $field['variables'] ) ) {
					/**
					 * Loop through the array of variables
					 */
					foreach ( $field['variables'] as $field_variable ) {
						/**
						 * Is the variable ['name'] defined?
						 * If yes, then we can proceed.
						 */
						if ( isset( $field_variable['name'] ) ) {
							/**
							 * Sanitize the variable name
							 */
							$variable_name = esc_attr( $field_variable['name'] );
							/**
							 * Do we have a callback function defined?
							 * If not then set $variable_callback to false.
							 */
							$variable_callback = ( isset( $field_variable['callback'] ) && is_callable( $field_variable['callback'] ) ) ? $field_variable['callback'] : false;
							/**
							 * If we have a variable_callback defined then get the value of the option
							 * and run it through the callback function.
							 * If no callback is defined (false) then just get the value.
							 */
							if ( $variable_callback ) {
								$variables[ $variable_name ] = call_user_func( $field_variable['callback'], Kirki::get_option( $field['settings'] ) );
							} else {
								$variables[ $variable_name ] = Kirki::get_option( $field['settings'] );
							}

						}

					}

				}

			}
			/**
			 * Pass the variables through a filter ('kirki/variable')
			 * and return the array of variables
			 */
			return apply_filters( 'kirki/variable', $variables );

		}

		public static function path() {

		}

		/**
		 * Process fields added using the 'kirki/fields' and 'kirki/controls' filter.
		 * These filters are no longer used, this is simply for backwards-compatibility
		 */
		public function fields_from_filters() {

			$fields = apply_filters( 'kirki/controls', array() );
			$fields = apply_filters( 'kirki/fields', $fields );

			if ( ! empty( $fields ) ) {
				foreach ( $fields as $field ) {
					Kirki::add_field( 'global', $field );
				}
			}

		}

		/**
		 * Handle saving of settings with "user_meta" storage type.
		 *
		 * @param $value                 string     Value being saved
		 * @param wp_customize_setting   object     $WP_Customize_Setting The WP_Customize_Setting instance when saving is happening.
		 */
		public function update_user_meta( $value, $wp_customize_setting ) {
			update_user_meta( get_current_user_id(), $wp_customize_setting->id, $value );
		}

	}

}
