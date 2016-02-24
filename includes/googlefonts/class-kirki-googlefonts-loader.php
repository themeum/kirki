<?php

class Kirki_GoogleFonts_Loader extends Kirki_GoogleFonts_Manager {

	/**
	 * The generated script
	 */
	private static $script;

	public function __construct() {
		// Add script in <head>
		add_action( 'wp_head', array( $this, 'add_script' ) );
	}

	public function add_script() {
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
		?>
		<script type="text/javascript" id="kirki-googlefonts">
			WebFontConfig = {
				google: { families: [ '<?php echo implode( '\', \'', $fonts ); ?>' ] },
				timeout: 2500 // Set the timeout to 2.5 seconds
			};
			(function() {
				var wf   = document.createElement('script');
				wf.src   = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';
				wf.type  = 'text/javascript';
				wf.async = 'true';
				var s    = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(wf, s);
			})();
		</script>
		<?php

	}

}

