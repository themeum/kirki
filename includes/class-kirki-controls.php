<?php

class Kirki_Controls {

    /** @var array The controls */
    private $controls = null;

	public function __construct() {
		add_action( 'customize_register', array( $this, 'include_controls' ) );
	}

	/**
	 * Include our custom control classes
	 */
	function include_controls( $wp_customize ) {

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

	}

	/**
	 * Get the controls for the Kirki customizer.
	 *
	 * @uses  'kirki/controls' filter.
	 */
	public static function get_controls() {

		$controls = apply_filters( 'kirki/controls', array() );
		$final_controls = array();

		if ( ! empty( $controls ) ) {
			foreach ( $controls as $control ) {
				$final_controls[] = Kirki_Control::sanitize( $control );
			}
		}

		return $final_controls;

	}

}
$controls = new Kirki_Controls();
