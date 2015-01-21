<?php
/*
Plugin Name:   Kirki Framework
Plugin URI:    http://kirki.org
Description:   An options framework using and extending the WordPress Customizer
Author:        Aristeides Stathopoulos
Author URI:    http://press.codes
Version:       0.5
*/

/**
* The main Kirki class
*/
if ( ! class_exists( 'Kirki' ) ) :
class Kirki {

	function __construct() {

		if ( ! defined( 'KIRKI_PATH' ) ) {
			define( 'KIRKI_PATH', dirname( __FILE__ ) );
		}
		if ( ! defined( 'KIRKI_URL' ) ) {
			define( 'KIRKI_URL', plugin_dir_url( __FILE__ ) );
		}

		$options = $this->get_config();

		include_once( dirname( __FILE__ ) . '/includes/required.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Scripts.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Style_Background.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Style_Color.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Style_Fonts.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Style_Generic.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Color.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Fonts.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Settings.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Controls.php' );
		include_once( dirname( __FILE__ ) . '/includes/deprecated.php' );

		$scripts      = new Kirki_Scripts();
		$styles_bg    = new Kirki_Style_Background();
		$styles_color = new Kirki_Style_Color();
		$styles_fonts = new Kirki_Style_Fonts();
		$styles_gen   = new Kirki_Style_Generic();

		add_action( 'customize_register', array( $this, 'include_customizer_controls' ), 1 );
		add_action( 'customize_register', array( $this, 'customizer_builder' ), 99 );

	}

	/**
	 * Include the necessary files
	 */
	function include_customizer_controls() {

		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Checkbox_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Color_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Image_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Multicheck_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Number_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Radio_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Sliderui_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Text_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Textarea_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Upload_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Select_Control.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls/class-Kirki_Customize_Group_Title_Control.php' );

	}

	/**
	 * Build the controls
	 */
	function customizer_builder( $wp_customize ) {

		$controls = $this->get_controls();
		$kirki_settings = new Kirki_Settings();
		$kirki_controls = new Kirki_Controls();

		// Early exit if controls are not set or if they're empty
		if ( ! isset( $controls ) || empty( $controls ) ) {
			return;
		}
		foreach ( $controls as $control ) {
			$kirki_settings->add_setting( $wp_customize, $control );
			$kirki_controls->add_control( $wp_customize, $control );
		}

	}

	function get_config() {

		$config = apply_filters( 'kirki/config', array() );

		$controls = $this->get_controls();
		foreach( $controls as $control ) {
			if ( isset( $control['output'] ) ) {
				$uses_output = true;
			}
		}

		if ( isset( $uses_output ) && ! isset( $config['stylesheet_id'] ) ) {
			$config['stylesheet_id'] = 'kirki-styles';
		}
		return $config;

	}

	function get_controls() {

		$controls = apply_filters( 'kirki/controls', array() );
		return $controls;

	}

}

global $kirki;
$kirki = new Kirki();

endif;
