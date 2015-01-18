<?php
/*
Plugin Name: Kirki Framework
Plugin URI: http://kirki.org
Description: An options framework using and extending the WordPress Customizer
Author: Aristeides Stathopoulos
Author URI: http://wpmu.io/
Version: 0.4
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

		$this->options = apply_filters( 'kirki/config', array() );
		$options = $this->options;

		// Include files
		if ( ! isset( $options['live_css'] ) || true == $options['live_css'] ) {
			include_once( dirname( __FILE__ ) . '/includes/background-css.php' );
		}
		include_once( dirname( __FILE__ ) . '/includes/required.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Scripts.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Color.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Fonts.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Settings.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-Kirki_Controls.php' );
		include_once( dirname( __FILE__ ) . '/includes/controls-init.php' );
		include_once( dirname( __FILE__ ) . '/includes/transport.php' );
		include_once( dirname( __FILE__ ) . '/includes/deprecated.php' );

		$scripts = new Kirki_Scripts();

		add_action( 'customize_register', array( $this, 'include_customizer_controls' ), 1 );

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

	function get_config() {

		$config = apply_filters( 'kirki/config', array() );
		return $config;

	}

	function get_controls() {

		$controls = apply_filters( 'kirki/controls', array() );
		return $controls;

	}

}

$kirki = new Kirki();

endif;
