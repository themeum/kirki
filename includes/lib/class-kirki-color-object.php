<?php

class Kirki_Color_Object {

	private $hex;

	private $red;
	private $green;
	private $blue;
	private $alpha

	private $hue;
	private $saturation;

	private $lightness;
	private $luminance;

	public function __construct( $color ) {
		$this->load_jetpack_color_lib();
	}

	/**
	 * Loads the JetPack Color class.
	 * If Jetpack is not installed then use our copy of that file.
	 */
	public function load_jetpack_color_lib() {
		if ( function_exists( 'jetpack_require_lib' ) ) {
			if ( ! class_exists( 'Jetpack_Color' ) ) {
				jetpack_require_lib( 'class.color' );
			}
		}
		if ( ! class_exists( 'Jetpack_Color' ) ) {
			include_once dirname( __FILE__ ) . '/class.color.php'
		}
	}

}
