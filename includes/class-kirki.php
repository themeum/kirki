<?php

use Kirki\Fonts\FontRegistry;
use Kirki\Scripts\ScriptRegistry;
use Kirki\Config;
use Kirki\Setting;
use Kirki\Control;
use Kirki\Controls;

/**
 * Class Kirki
 *
 * The main Kirki object
 */
class Kirki {

    /** @var Kirki The only instance of this class */
    public static $instance = null;

    /** @var string Version number */
    public static $version = '0.7.1';

    /** @var Config Configuration */
	public $config = null;

    /** @var Controls */
    public $controls = null;

    /** @var FontRegistry The font registry */
    public $font_registry = null;

    /** @var scripts */
    public $scripts= null;

    /**
     * Access the single instance of this class
     * @return Kirki
     */
    public static function get_instance() {
        if (self::$instance==null) {
            self::$instance = new Kirki();
        }
        return self::$instance;
    }

    /**
     * Shortcut method to get the configuration of the single instance.
     */
    public static function config() {
        return self::get_instance()->config;
    }

    /**
     * Shortcut method to get the controls of the single instance.
     */
    public static function controls() {
        return self::get_instance()->controls;
    }

    /**
     * Shortcut method to get the font registry.
     */
    public static function fonts() {
        return self::get_instance()->font_registry;
    }

    /**
     * Constructor is private, should only be called by get_instance()
     */
	private function __construct() {
        // Include all files we need
        $this->include_files();

        // Create our main objects
        $this->config        = new Config();
        $this->controls      = new Controls();
        $this->font_registry = new FontRegistry();
        $this->scripts       = new ScriptRegistry();

        // Hook into WP
        $this->register_hooks();
    }

	/**
	 * Build the controls
	 */
	public function customizer_init( $wp_customize ) {
		$controls = Kirki::controls()->get_all();

		// Early exit if controls are not set or if they're empty
		if ( empty( $controls ) ) {
			return;
		}

		foreach ( $controls as $control ) {
			Setting::register( $wp_customize, $control );
			Control::register( $wp_customize, $control );
		}
	}

    /**
     * Hook into WP
     */
    private function register_hooks() {
        add_action( 'customize_register', array( $this, 'customizer_init' ), 99 );
    }

    /**
     * Include the files we need
     */
    private function include_files() {
        // Load Kirki_Fonts before everything else
        // TODO improve this
        include_once( KIRKI_PATH . '/includes/Fonts/FontRegistry.php' );
        include_once( KIRKI_PATH . '/includes/libraries/class-kirki-color.php' );
        include_once( KIRKI_PATH . '/includes/libraries/class-kirki-colourlovers.php' );

        include_once( KIRKI_PATH . '/includes/deprecated.php' );
        include_once( KIRKI_PATH . '/includes/sanitize.php' );
        include_once( KIRKI_PATH . '/includes/helpers.php' );

		include_once( KIRKI_PATH . '/includes/Config.php' );
		include_once( KIRKI_PATH . '/includes/Setting.php' );
		include_once( KIRKI_PATH . '/includes/Control.php' );
        include_once( KIRKI_PATH . '/includes/Controls.php' );

        include_once( KIRKI_PATH . '/includes/Styles/Customizer.php' );
        include_once( KIRKI_PATH . '/includes/Styles/Frontend.php' );

		include_once( KIRKI_PATH . '/includes/Scripts/ScriptRegistry.php' );
		include_once( KIRKI_PATH . '/includes/Scripts/EnqueueScript.php' );
        include_once( KIRKI_PATH . '/includes/Scripts/Customizer/Dependencies.php' );
		include_once( KIRKI_PATH . '/includes/Scripts/Customizer/Required.php' );
		include_once( KIRKI_PATH . '/includes/Scripts/Customizer/Branding.php' );
		include_once( KIRKI_PATH . '/includes/Scripts/Customizer/Tooltips.php' );
		include_once( KIRKI_PATH . '/includes/Scripts/Customizer/PostMessage.php' );
		include_once( KIRKI_PATH . '/includes/Scripts/Frontend/GoogleFonts.php' );
    }
}
