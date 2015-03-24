<?php

class Kirki_Controls {

    /** @var array The controls */
    private $controls = null;

    /**
     * Constructor
     */
	public function __construct() {
        // Hook into WP
        $this->register_hooks();
	}

	/**
	 * Get the controls for the Kirki customizer.
	 *
	 * @uses  'kirki/controls' filter.
	 */
	public function get_all() {
        if ($this->controls==null) {
		    $user_controls = apply_filters( 'kirki/controls', array() );

            $this->controls = array();
			foreach ( $user_controls as $control ) {
                $this->controls[] = Kirki_Control::sanitize( $control );
			}
		}

		return $this->controls;
	}

    /**
     * Hook into WP
     */
    private function register_hooks() {
        add_action('customize_register', array($this, 'include_files'), 99);
    }

    /**
     * Include the custom control files. Because they depend on the WP_Cs
     */
    public function include_files() {
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
