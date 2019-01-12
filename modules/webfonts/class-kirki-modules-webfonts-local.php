<?php
/**
 * Handles adding to the footer the @font-face CSS for locally-hosted google-fonts.
 * Solves privacy concerns with Google's CDN and their sometimes less-than-transparent policies.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.28
 */

/**
 * Manages the way Google Fonts are enqueued.
 */
final class Kirki_Modules_Webfonts_Local {

	/**
	 * The config ID.
	 *
	 * @access protected
	 * @since 3.0.28
	 * @var string
	 */
	protected $config_id;

	/**
	 * The Kirki_Modules_Webfonts object.
	 *
	 * @access protected
	 * @since 3.0.28
	 * @var object
	 */
	protected $webfonts;

	/**
	 * The Kirki_Fonts_Google object.
	 *
	 * @access protected
	 * @since 3.0.28
	 * @var object
	 */
	protected $googlefonts;

	/**
	 * Fonts to load.
	 *
	 * @access protected
	 * @since 3.0.28
	 * @var array
	 */
	protected $fonts_to_load = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3..28
	 * @param object $webfonts    The Kirki_Modules_Webfonts object.
	 * @param object $googlefonts The Kirki_Fonts_Google object.
	 */
	public function __construct( $webfonts, $googlefonts ) {

		$this->webfonts    = $webfonts;
		$this->googlefonts = $googlefonts;

		add_action( 'wp_footer', array( $this, 'add_styles' ) );
	}

	/**
	 * Webfont Loader for Google Fonts.
	 *
	 * @access public
	 * @since 3.0.28
	 */
	public function add_styles() {

		// Go through our fields and populate $this->fonts.
		$this->webfonts->loop_fields( $this->config_id );
		$this->googlefonts->process_fonts();
		$hosted_fonts = $this->googlefonts->get_hosted_fonts();

		// Early exit if we don't need to add any fonts.
		if ( empty( $hosted_fonts ) ) {
			return;
		}

		// Make sure we only do this once per font-family.
		$hosted_fonts = array_unique( $hosted_fonts );

		// Start CSS.
		$css = '';
		foreach ( $hosted_fonts as $family ) {

			// Add the @font-face CSS for this font-family.
			$css .= Kirki_Fonts_Google_Local::init( $family )->get_css();
		}

		// If we've got CSS, add to the footer.
		if ( $css ) {
			echo '<style id="kirki-local-webfonts-' . esc_attr( sanitize_key( $this->config_id ) ) . '">' . $css . '</style>'; // WPCS: XSS ok.
		}
	}
}
