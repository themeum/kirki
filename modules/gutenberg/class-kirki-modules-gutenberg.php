<?php
/**
 * Gutenberg integration for Kirki.
 *
 * This class contains methods for integrating Kirki with
 * the new WordPress core editor, Gutenberg.  It provides
 * fonts and styles to be output by the theme.
 *
 * @package     Kirki
 * @category    Core
 * @author      Tim Elsass
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.35
 */

/**
 * Wrapper class for static methods.
 *
 * @since 3.0.35
 */
class Kirki_Modules_Gutenberg {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.35
	 * @var object
	 */
	private static $instance;

	/**
	 * Configuration reference.
	 *
	 * @access public
	 * @since 3.0.35
	 * @var object $configs
	 */
	private $configs;

	/**
	 * Whether feature is enabled.
	 *
	 * @access public
	 * @since 3.0.35
	 * @var bool $enabled
	 */
	public $enabled;

	/**
	 * CSS Module reference.
	 *
	 * @access public
	 * @since 3.0.35
	 * @var object $modules_css
	 */
	private $modules_css;

	/**
	 * Webfonts Module reference.
	 *
	 * @access public
	 * @since 3.0.35
	 * @var object $modules_webfonts
	 */
	private $modules_webfonts;

	/**
	 * Google Fonts reference.
	 *
	 * @access public
	 * @since 3.0.35
	 * @var object $google_fonts
	 */
	private $google_fonts;

	/**
	 * Webfonts Loader Module reference.
	 *
	 * @access public
	 * @since 3.0.35
	 * @var object $modules_webfonts
	 */
	private $modules_webfont_loader;

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	/**
	 * Initialize Module.
	 *
	 * Sets class properties and add necessary hooks.
	 *
	 * @since 3.0.35
	 */
	public function init() {
		$this->set_configs();
		$this->set_enabled();
		$this->set_modules_css();
		$this->set_google_fonts();
		$this->set_modules_webfonts();
		$this->set_modules_webfont_loader();
		$this->add_hooks();
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
	 * Add hooks for Gutenberg editor integration.
	 *
	 * @access protected
	 * @since 3.0.35
	 */
	protected function add_hooks() {
		if ( ! $this->is_disabled() ) {
			add_action( 'after_setup_theme', array( $this, 'add_theme_support' ), 999 );
			add_action( 'enqueue_block_editor_assets', array( $this, 'load_fonts' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_fontawesome' ) );
			add_filter( 'block_editor_settings', array( $this, 'enqueue' ) );
		}
	}

	/**
	 * Add theme support for editor styles.
	 *
	 * This checks if theme has declared editor-styles support
	 * already, and if not present, declares it. Hooked late.
	 *
	 * @access public
	 * @since 3.0.35
	 */
	public function add_theme_support() {
		if ( true !== get_theme_support( 'editor-styles' ) ) {
			add_theme_support( 'editor-styles' );
		}
	}

	/**
	 * Enqueue styles to Gutenberg Editor.
	 *
	 * @access public
	 * @since 3.0.35
	 */
	public function enqueue( $settings ) {
		$styles = $this->get_styles();

		if ( ! empty( $styles ) ) {
			$settings['styles'][] = array( 'css' => $styles );
		}

		return $settings;
	}

	/**
	 * Gets the styles to add to Gutenberg Editor.
	 *
	 * @access public
	 * @since 3.0.35
	 *
	 * @return string $styles String containing inline styles to add to Gutenberg.
	 */
	public function get_styles() {

		$styles = null;

		foreach ( $this->configs as $config_id => $args ) {

			if ( true === $this->is_disabled( $args ) ) {
				continue;
			}

			$modules_css = $this->modules_css;
			$styles      = $modules_css::loop_controls( $config_id );
			$styles      = apply_filters( "kirki_gutenberg_{$config_id}_dynamic_css", $styles );

			if ( empty( $styles ) ) {
				continue;
			}
		}

		return $styles;
	}

	/**
	 * Helper method to check if feature is disabled.
	 *
	 * Feature can be disabled by KIRKI_NO_OUTPUT constant,
	 * gutenbeg_support argument, and disabled output argument.
	 *
	 * @access public
	 * @since 3.0.35
	 *
	 * @return bool $disabled Is gutenberg integration feature disabled?
	 */
	private function is_disabled( $args = array() ) {
		if ( defined( 'KIRKI_NO_OUTPUT' ) && true === KIRKI_NO_OUTPUT ) {
			return true;
		}

		if ( ! empty( $args ) ) {
			if ( isset( $args['disable_output'] ) && true === $args['disable_output'] ) {
				return true;
			}

			if ( ! isset( $args['gutenberg_support'] ) || true !== $args['gutenberg_support'] ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Load Fonts in Gutenberg Editor.
	 *
	 * @access public
	 * @since 3.0.35
	 */
	public function load_fonts() {

		$modules_webfonts = $this->modules_webfonts;
		$google_fonts     = $this->google_fonts;
		foreach ( $this->configs as $config_id => $args ) {

			if ( $this->is_disabled( $args ) ) {
				continue;
			}

			$this->modules_webfont_loader->set_load( true );
			$this->modules_webfont_loader->enqueue_scripts();

			$async = new Kirki_Modules_Webfonts_Async(
				$config_id,
				$modules_webfonts::get_instance(),
				$google_fonts::get_instance()
			);

			$async->webfont_loader();
			$async->webfont_loader_script();

			$local_fonts = new Kirki_Modules_Webfonts_Local(
				$modules_webfonts::get_instance(),
				$google_fonts::get_instance()
			);

			$local_fonts->add_styles();

			return;
		}
	}

	/**
	 * Enqueue fontawesome in Gutenberg Editor.
	 *
	 * @access public
	 * @since 3.0.35
	 */
	public function enqueue_fontawesome() {
		foreach ( $this->configs as $config_id => $args ) {

			if ( $this->is_disabled( $args ) ) {
				continue;
			}
			$modules_css = $this->modules_css;
			if ( $modules_css::get_enqueue_fa() && apply_filters( 'kirki_load_fontawesome', true ) ) {
				wp_enqueue_script( 'kirki-fontawesome-font', 'https://use.fontawesome.com/30858dc40a.js', array(), '4.0.7', true );
			}

			return;
		}
	}

	/**
	 * Set class property for $configs.
	 *
	 * @access private
	 * @since 3.0.35
	 */
	private function set_configs() {
		return $this->configs = Kirki::$config;
	}

	/**
	 * Set class property for $enabled.
	 *
	 * @access private
	 * @since 3.0.35
	 */
	private function set_enabled() {
		$this->enabled = ! $this->is_disabled();
	}

	/**
	 * Set class property for $modules_css.
	 *
	 * @access private
	 * @since 3.0.35
	 */
	private function set_modules_css() {
		$this->modules_css = Kirki_Modules_CSS::get_instance();
	}

	/**
	 * Set class property for $google_fonts.
	 *
	 * @access private
	 * @since 3.0.35
	 */
	private function set_google_fonts() {
		$this->google_fonts = Kirki_Fonts_Google::get_instance();
	}

	/**
	 * Set class property for $modules_webfonts.
	 *
	 * @access private
	 * @since 3.0.35
	 */
	private function set_modules_webfonts() {
		$this->modules_webfonts = Kirki_Modules_Webfonts::get_instance();
	}

	/**
	 * Set class property for $modules_webfont_loader.
	 *
	 * @access private
	 * @since 3.0.35
	 */
	private function set_modules_webfont_loader() {
		$this->modules_webfont_loader = Kirki_Modules_Webfont_Loader::get_instance();
	}
}
