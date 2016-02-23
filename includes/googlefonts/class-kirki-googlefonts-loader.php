<?php

class Kirki_GoogleFonts_Loader extends Kirki_GoogleFonts_Manager {

	/**
	 * The generated script
	 */
	private static $script;

	public function __construct() {
		// Generate the script
		$this->generate_script();
		// Add script in <head>
		add_action( 'wp_head', array( $this, 'add_script' ), 999 );
	}

	private function generate_script() {
		// If we don't have any fonts then we can exit.
		if ( empty( parent::$fonts ) ) {
			return;
		}
		$fonts = array();
		foreach ( parent::$fonts as $font => $properties ) {
			$variants = implode( ',', $properties['variants'] );
			$subsets  = implode( ',', $properties['subsets'] );

			$fonts[] = str_replace( ' ', '+', $font ) . ':' . $variants . ':' . $subsets;
		}

		$fonts = '\'' . implode( '\', \'', $fonts ) . '\'';
		self::$script  = 'WebFontConfig = {';
		self::$script .= 'google: { families: [ ' . $fonts . ' ] }';
		self::$script .= '};';
		self::$script .= '(function() {';
		self::$script .= 'var wf = document.createElement(\'script\');';
		self::$script .= 'wf.src = \'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js\';';
		self::$script .= 'wf.type = \'text/javascript\';';
		self::$script .= 'wf.async = \'true\';';
		self::$script .= 'var s = document.getElementsByTagName(\'script\')[0];';
		self::$script .= 's.parentNode.insertBefore(wf, s);';
		self::$script .= '})();';

	}

	public static function get_script() {
		return self::$script;
	}

	/**
	 * Wraps the script in <script> tags
	 * and prepares it for output.
	 */
	public function add_script() {
		return '<script type="text/javascript">' . self::$script . '</script>';
	}

}

