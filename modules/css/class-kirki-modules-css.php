<?php
/**
 * Handles the CSS Output of fields.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
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
	 * The CSS array
	 *
	 * @access public
	 * @var array
	 */
	public static $css_array = array();

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
				include_once wp_normalize_path( dirname( __FILE__ ) . $file ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
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

		// Allow completely disabling Kirki CSS output.
		if ( ( defined( 'KIRKI_NO_OUTPUT' ) && true === KIRKI_NO_OUTPUT ) || ( isset( $config['disable_output'] ) && true === $config['disable_output'] ) ) {
			return;
		}

		// Admin styles, adds compatibility with the new WordPress editor (Gutenberg).
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_styles' ), 100 );

		if ( ! apply_filters( 'kirki_output_inline_styles', true ) ) {
			$config   = apply_filters( 'kirki_config', array() );
			$priority = 999;
			if ( isset( $config['styles_priority'] ) ) {
				$priority = absint( $config['styles_priority'] );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), $priority );

			// Prints the styles.
			add_action( 'wp', array( $this, 'print_styles_action' ) );
			return;
		}

		add_action( 'wp_head', array( $this, 'print_styles_inline' ), 999 );
	}

	/**
	 * Print styles inline.
	 *
	 * @access public
	 * @since 3.0.36
	 * @return void
	 */
	public function print_styles_inline() {
		echo '<style id="kirki-inline-styles">';
		$this->print_styles();
		echo '</style>';
	}

	/**
	 * Enqueue the styles.
	 *
	 * @access public
	 * @since 3.0.36
	 * @return void
	 */
	public function enqueue_styles() {

		// Enqueue the dynamic stylesheet.
		wp_enqueue_style(
			'kirki-styles',
			add_query_arg(
				'action',
				apply_filters( 'kirki_styles_action_handle', 'kirki-styles' ),
				site_url()
			),
			array(),
			KIRKI_VERSION
		);

		// Enqueue FA if needed (I hope not, this FA version is pretty old, only kept here for backwards-compatibility purposes).
		if ( self::$enqueue_fa && apply_filters( 'kirki_load_fontawesome', true ) ) {
			wp_enqueue_script( 'kirki-fontawesome-font', 'https://use.fontawesome.com/30858dc40a.js', array(), '4.0.7', true );
		}
	}

	/**
	 * Prints the styles as an enqueued file.
	 *
	 * @access public
	 * @since 3.0.36
	 * @return void
	 */
	public function print_styles_action() {
		/**
		 * Note to code reviewers:
		 * There is no need for a nonce check here, we're only checking if this is a valid request or not.
		 */
		if ( empty( $_GET['action'] ) || apply_filters( 'kirki_styles_action_handle', 'kirki-styles' ) !== $_GET['action'] ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;
		}

		// This is a stylesheet.
		header( 'Content-type: text/css' );
		$this->print_styles();
		exit;
	}

	/**
	 * Prints the styles.
	 *
	 * @access public
	 */
	public function print_styles() {

		// Go through all configs.
		$configs = Kirki::$config;
		foreach ( $configs as $config_id => $args ) {
			if ( isset( $args['disable_output'] ) && true === $args['disable_output'] ) {
				continue;
			}
			$styles = self::loop_controls( $config_id );
			$styles = apply_filters( "kirki_{$config_id}_dynamic_css", $styles );
			if ( ! empty( $styles ) ) {
				/**
				 * Note to code reviewers:
				 *
				 * Though all output should be run through an escaping function, this is pure CSS.
				 *
				 * When used in the print_styles_action() method the PHP header() call makes the browser interpret it as such.
				 * No code, script or anything else can be executed from inside a stylesheet.
				 *
				 * When using in the print_styles_inline() method the wp_strip_all_tags call we use below
				 * strips anything that has the possibility to be malicious, and since this is inslide a <style> tag
				 * it can only be interpreted by the browser as such.
				 * wp_strip_all_tags() excludes the possibility of someone closing the <style> tag and then opening something else.
				 */
				echo wp_strip_all_tags( $styles ); // phpcs:ignore WordPress.Security.EscapeOutput
			}
		}
		do_action( 'kirki_dynamic_css' );
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

	/**
	 * Check if FontAwesome should be loaded.
	 *
	 * @static
	 * @since 3.0.35
	 * @access public
	 * @return bool
	 */
	public static function get_enqueue_fa() {
		return self::$enqueue_fa;
	}
}
