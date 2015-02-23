<?php

class Kirki_Style {

	public $controls;
	public $styles;
	public $css;

	function __construct() {

		$this->css    = '';
		$this->styles = apply_filters( 'kirki/styles', array() );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 150 );

	}

	function enqueue( $styles = array() ) {

		global $kirki;
		$controls = $kirki->get_controls();
		$config   = $kirki->get_config();
		$css      = $this->parse();

		wp_add_inline_style( $config['stylesheet_id'], $css );

	}

	function parse() {

		$styles = $this->styles;
		$css    = $this->css;

		// Early exit if styles are empty or not an array
		if ( empty( $styles ) || ! is_array( $styles ) ) {
			return;
		}

		foreach ( $styles as $style ) {
			$css .= $style . '{';
			foreach ( $style as $property => $value ) {
				$css .= $property . ':' . $value . ';';
			}
			$css .= '}';
		}

		return $css;

	}

}
