<?php
/*
Plugin Name:   Kirki Framework
Plugin URI:    http://kirki.org
Description:   An options framework using and extending the WordPress Customizer
Author:        Aristeides Stathopoulos
Author URI:    http://press.codes
Version:       0.7.1
*/

if ( ! defined( 'KIRKI_PATH' ) ) {
	define( 'KIRKI_PATH', dirname( __FILE__ ) );
}
if ( ! defined( 'KIRKI_URL' ) ) {
	define( 'KIRKI_URL', plugin_dir_url( __FILE__ ) );
}

// Load Kirki_Fonts before everything else
include_once( KIRKI_PATH . '/includes/libraries/class-kirki-fonts.php' );
include_once( KIRKI_PATH . '/includes/libraries/class-kirki-color.php' );
include_once( KIRKI_PATH . '/includes/libraries/class-kirki-colourlovers.php' );

include_once( KIRKI_PATH . '/includes/deprecated.php' );
include_once( KIRKI_PATH . '/includes/controls.php' );
include_once( KIRKI_PATH . '/includes/google-fonts.php' );
include_once( KIRKI_PATH . '/includes/sanitize.php' );
include_once( KIRKI_PATH . '/includes/style.php' );

include_once( KIRKI_PATH . '/includes/class-kirki-config.php' );
include_once( KIRKI_PATH . '/includes/class-kirki-setting.php' );
include_once( KIRKI_PATH . '/includes/class-kirki-customizer-help-tooltips.php' );
include_once( KIRKI_PATH . '/includes/class-kirki-customizer-postmessage.php' );
include_once( KIRKI_PATH . '/includes/class-kirki-customizer-styles.php' );
include_once( KIRKI_PATH . '/includes/class-kirki-customizer-scripts.php' );


class Kirki {

	public $config;
	public $customizer_scripts;
	public $customizer_styles;
	public $scripts;
	public $styles;

}

$kirki = new Kirki();
$kirki->config = new Kirki_Config();
$kirki->customizer_scripts = new Kirki_Customizer_Scripts();
$kirki->customizer_styles = new Kirki_Customizer_Styles();
$kirki->styles = array(
	$styles = new Kirki_Styles(),
);
$kirki->scripts = array(
	$google_fonts = new Kirki_Google_Fonts_Script(),
);
