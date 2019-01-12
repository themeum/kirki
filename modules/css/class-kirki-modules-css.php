<?php
/**
 * Handles the CSS Output of fields.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * The Kirki_Modules_CSS object.
 */
class Kirki_Modules_CSS {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Whether we've already processed this or not.
	 *
	 * @access public
	 * @var bool
	 */
	public $processed = false;

	/**
	 * The CSS array
	 *
	 * @access public
	 * @var array
	 */
	public static $css_array = array();

	/**
	 * Set to true if you want to use the AJAX method.
	 *
	 * @access public
	 * @var bool
	 */
	public static $ajax = false;

	/**
	 * The Kirki_CSS_To_File object.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var object
	 */
	protected $css_to_file;

	/**
	 * Should we enqueue font-awesome?
	 *
	 * @static
	 * @access protected
	 * @since 3.0.26
	 * @var bool
	 */
	protected static $enqueue_fa = false;

	/**
	 * Constructor
	 *
	 * @access protected
	 */
	protected function __construct() {

		$class_files = array(
			'Kirki_CSS_To_File'                         => '/class-kirki-css-to-file.php',
			'Kirki_Modules_CSS_Generator'               => '/class-kirki-modules-css-generator.php',
			'Kirki_Output'                              => '/class-kirki-output.php',
			'Kirki_Output_Field_Background'             => '/field/class-kirki-output-field-background.php',
			'Kirki_Output_Field_Image'                  => '/field/class-kirki-output-field-image.php',
			'Kirki_Output_Field_Multicolor'             => '/field/class-kirki-output-field-multicolor.php',
			'Kirki_Output_Field_Dimensions'             => '/field/class-kirki-output-field-dimensions.php',
			'Kirki_Output_Field_Typography'             => '/field/class-kirki-output-field-typography.php',
			'Kirki_Output_Property'                     => '/property/class-kirki-output-property.php',
			'Kirki_Output_Property_Background_Image'    => '/property/class-kirki-output-property-background-image.php',
			'Kirki_Output_Property_Background_Position' => '/property/class-kirki-output-property-background-position.php',
			'Kirki_Output_Property_Font_Family'         => '/property/class-kirki-output-property-font-family.php',
		);

		foreach ( $class_files as $class_name => $file ) {
			if ( ! class_exists( $class_name ) ) {
				include_once wp_normalize_path( dirname( __FILE__ ) . $file );
			}
		}

		add_action( 'init', array( $this, 'init' ) );

	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Init.
	 *
	 * @access public
	 */
	public function init() {

		Kirki_Modules_Webfonts::get_instance();

		global $wp_customize;

		$config   = apply_filters( 'kirki_config', array() );
		$priority = 999;
		if ( isset( $config['styles_priority'] ) ) {
			$priority = absint( $config['styles_priority'] );
		}

		// Allow completely disabling Kirki CSS output.
		if ( ( defined( 'KIRKI_NO_OUTPUT' ) && true === KIRKI_NO_OUTPUT ) || ( isset( $config['disable_output'] ) && true === $config['disable_output'] ) ) {
			return;
		}

		$method = apply_filters( 'kirki_dynamic_css_method', 'inline' );
		if ( $wp_customize ) {
			// If we're in the customizer, load inline no matter what.
			add_action( 'wp_enqueue_scripts', array( $this, 'inline_dynamic_css' ), $priority );

			// If we're using file method, on save write the new styles.
			if ( 'file' === $method ) {
				$this->css_to_file = new Kirki_CSS_To_File();
				add_action( 'customize_save_after', array( $this->css_to_file, 'write_file' ) );
			}
			return;
		}

		if ( 'file' === $method ) {
			// Attempt to write the CSS to file.
			$this->css_to_file = new Kirki_CSS_To_File();
			// If we succesd, load this file.
			$failed = get_transient( 'kirki_css_write_to_file_failed' );
			// If writing CSS to file hasn't failed, just enqueue this file.
			if ( ! $failed ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_compiled_file' ), $priority );
				return;
			}
		}

		// If we are in the customizer, load CSS using inline-styles.
		// If we are in the frontend AND self::$ajax is true, then load dynamic CSS using AJAX.
		if ( ( true === self::$ajax ) || ( isset( $config['inline_css'] ) && false === $config['inline_css'] ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ), $priority );
			add_action( 'wp_ajax_kirki_dynamic_css', array( $this, 'ajax_dynamic_css' ) );
			add_action( 'wp_ajax_nopriv_kirki_dynamic_css', array( $this, 'ajax_dynamic_css' ) );
			return;
		}

		// If we got this far then add styles inline.
		add_action( 'wp_enqueue_scripts', array( $this, 'inline_dynamic_css' ), $priority );
	}

	/**
	 * Enqueues compiled CSS file.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function enqueue_compiled_file() {

		wp_enqueue_style( 'kirki-styles', $this->css_to_file->get_url(), array(), $this->css_to_file->get_timestamp() );

	}
	/**
	 * Adds inline styles.
	 *
	 * @access public
	 */
	public function inline_dynamic_css() {
		$configs = Kirki::$config;
		if ( ! $this->processed ) {
			foreach ( $configs as $config_id => $args ) {
				if ( isset( $args['disable_output'] ) && true === $args['disable_output'] ) {
					continue;
				}
				$styles = self::loop_controls( $config_id );
				$styles = apply_filters( "kirki_{$config_id}_dynamic_css", $styles );
				if ( ! empty( $styles ) ) {
					$stylesheet = apply_filters( "kirki_{$config_id}_stylesheet", false );
					if ( $stylesheet ) {
						wp_add_inline_style( $stylesheet, $styles );
						continue;
					}
					wp_enqueue_style( 'kirki-styles-' . $config_id, trailingslashit( Kirki::$url ) . 'assets/css/kirki-styles.css', array(), KIRKI_VERSION );
					wp_add_inline_style( 'kirki-styles-' . $config_id, $styles );
				}
			}
			$this->processed = true;
		}

		if ( self::$enqueue_fa && apply_filters( 'kirki_load_fontawesome', true ) ) {
			wp_enqueue_script( 'kirki-fontawesome-font', 'https://use.fontawesome.com/30858dc40a.js', array(), '4.0.7', true );
		}
	}

	/**
	 * Get the dynamic-css.php file
	 *
	 * @access public
	 */
	public function ajax_dynamic_css() {
		require wp_normalize_path( Kirki::$path . '/modules/css/dynamic-css.php' );
		exit;
	}

	/**
	 * Enqueues the ajax stylesheet.
	 *
	 * @access public
	 */
	public function frontend_styles() {
		wp_enqueue_style( 'kirki-styles-php', admin_url( 'admin-ajax.php' ) . '?action=kirki_dynamic_css', array(), KIRKI_VERSION );
	}

	/**
	 * Loop through all fields and create an array of style definitions.
	 *
	 * @static
	 * @access public
	 * @param string $config_id The configuration ID.
	 */
	public static function loop_controls( $config_id ) {

		// Get an instance of the Kirki_Modules_CSS_Generator class.
		// This will make sure google fonts and backup fonts are loaded.
		Kirki_Modules_CSS_Generator::get_instance();

		$fields = Kirki::$fields;
		$css    = array();

		// Early exit if no fields are found.
		if ( empty( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {

			// Only process fields that belong to $config_id.
			if ( $config_id !== $field['kirki_config'] ) {
				continue;
			}

			if ( true === apply_filters( "kirki_{$config_id}_css_skip_hidden", true ) ) {
				// Only continue if field dependencies are met.
				if ( ! empty( $field['required'] ) ) {
					$valid = true;

					foreach ( $field['required'] as $requirement ) {
						if ( isset( $requirement['setting'] ) && isset( $requirement['value'] ) && isset( $requirement['operator'] ) ) {
							$controller_value = Kirki_Values::get_value( $config_id, $requirement['setting'] );
							if ( ! Kirki_Helper::compare_values( $controller_value, $requirement['value'], $requirement['operator'] ) ) {
								$valid = false;
							}
						}
					}

					if ( ! $valid ) {
						continue;
					}
				}
			}

			// Only continue if $field['output'] is set.
			if ( isset( $field['output'] ) && ! empty( $field['output'] ) ) {
				$css = Kirki_Helper::array_replace_recursive( $css, Kirki_Modules_CSS_Generator::css( $field ) );

				// Add the globals.
				if ( isset( self::$css_array[ $config_id ] ) && ! empty( self::$css_array[ $config_id ] ) ) {
					Kirki_Helper::array_replace_recursive( $css, self::$css_array[ $config_id ] );
				}
			}
		}

		$css = apply_filters( "kirki_{$config_id}_styles", $css );

		if ( is_array( $css ) ) {
			return Kirki_Modules_CSS_Generator::styles_parse( Kirki_Modules_CSS_Generator::add_prefixes( $css ) );
		}
	}

	/**
	 * Runs when we're adding a font-awesome field to allow enqueueing the
	 * fontawesome script on the frontend.
	 *
	 * @static
	 * @since 3.0.26
	 * @access public
	 * @return void
	 */
	public static function add_fontawesome_script() {
		self::$enqueue_fa = true;
	}
}
