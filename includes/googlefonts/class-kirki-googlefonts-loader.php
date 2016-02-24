<?php

class Kirki_GoogleFonts_Loader extends Kirki_GoogleFonts_Manager {

	/**
	 * The generated script
	 */
	private static $script;

	private static $script_fonts = array();

	private static $link = '';

	public function __construct() {
		if ( 'script' == Kirki_Fonts::$mode ) {
			// Add script in <head>
			add_action( 'wp_head', array( $this, 'add_script' ) );
		} else {
			// enqueue link
			add_action( 'wp_enqueue_scripts', array( $this, 'link' ), 105 );
		}
	}

	private function loop_fields() {
		foreach ( Kirki::$fields as $field_id => $args ) {
			Kirki_GoogleFonts_Field_Processor::generate_google_fonts( $args );
		}
	}

	private function set_properties() {

		$this->loop_fields();

		// If we don't have any fonts then we can exit.
		if ( empty( parent::$fonts ) ) {
			return;
		}
		$all_subsets  = array();
		$link_fonts   = array();
		$script_fonts = array();
		foreach ( parent::$fonts as $font => $properties ) {
			$variants = implode( ',', $properties['variants'] );
			$subsets  = implode( ',', $properties['subsets'] );

			$link_font = str_replace( ' ', '+', $font );
			if ( ! empty( $variants ) ) {
				$link_font .= ':' . $variants;
			}
			$link_fonts[] = $link_font;
			$all_subsets = array_merge( $all_subsets, $properties['subsets'] );

			$script_fonts[] = str_replace( ' ', '+', $font ) . ':' . $variants . ':' . $subsets;
		}

		$all_subsets = array_unique( $all_subsets );
		self::$link  = 'https://fonts.googleapis.com/css?family=';
		self::$link .= implode( '|', $link_fonts );
		if ( ! empty( $all_subsets ) ) {
			self::$link  .= '&subset=' . implode( ',', $all_subsets );
		}

	}


	/**
	 * Enqueue Google fonts if necessary
	 */
	public function link() {
		$this->set_properties();
		$config = apply_filters( 'kirki/config', array() );
		/**
		 * If we have set $config['disable_google_fonts'] to true
		 * then do not proceed any further.
		 */
		if ( isset( $config['disable_google_fonts'] ) && true == $config['disable_google_fonts'] ) {
			return;
		}
		if ( ! empty( self::$link ) ) {
			wp_enqueue_style( 'kirki_google_fonts', self::$link, array(), null );
		}
	}

	public function add_script() {
		$this->set_properties();
		?>
		<script type="text/javascript" id="kirki-googlefonts">
			WebFontConfig = {
				google: { families: [ '<?php echo implode( '\', \'', self::$script_fonts ); ?>' ] },
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

