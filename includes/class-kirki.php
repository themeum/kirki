<?php

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

    /** @var Kirki_Config Configuration */
	public $config = null;

    /** @var Kirki_Controls Controls */
    public $controls = null;

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
     * Constructor is private, should only be called by get_instance()
     */
	private function __construct() {
        // Include all files we need
        $this->include_files();

        // Create our main objects
        $this->config = new Kirki_Config();
        $this->controls = new Kirki_Controls();

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
			Kirki_Setting::register( $wp_customize, $control );
			Kirki_Control::register( $wp_customize, $control );
		}
	}

    /**
     * Hook into WP
     */
    private function register_hooks() {
        add_action('customize_register', array($this, 'customizer_init'), 99);
    }

    /**
     * Include the files we need
     */
    private function include_files() {
        // Load Kirki_Fonts before everything else
        // TODO improve this
        include_once( KIRKI_PATH . '/includes/libraries/class-kirki-fonts.php' );
        include_once( KIRKI_PATH . '/includes/libraries/class-kirki-color.php' );
        include_once( KIRKI_PATH . '/includes/libraries/class-kirki-colourlovers.php' );

        include_once( KIRKI_PATH . '/includes/deprecated.php' );
        include_once( KIRKI_PATH . '/includes/sanitize.php' );
        include_once( KIRKI_PATH . '/includes/helpers.php' );

        include_once( KIRKI_PATH . '/includes/class-kirki-google-fonts-script.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-config.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-styles.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-setting.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-control.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-controls.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-customizer-help-tooltips.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-customizer-postmessage.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-customizer-styles.php' );
        include_once( KIRKI_PATH . '/includes/class-kirki-customizer-scripts.php' );

        // Our custom controls
        // TODO autoload this using a PSR-4 autoloader?
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-group-title-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-multicheck-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-number-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-buttonset-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-image-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-sortable-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-switch-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-toggle-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-palette-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-custom-control.php' );
        include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-editor-control.php' );
    }
}