<?php
/**
 * Handles adding to the footer the @font-face CSS for locally-hosted google-fonts.
 * Solves privacy concerns with Google's CDN and their sometimes less-than-transparent policies.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
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
	 * @param string $config_id   The config-ID.
	 * @param object $webfonts    The Kirki_Modules_Webfonts object.
	 * @param object $googlefonts The Kirki_Fonts_Google object.
	 * @param array  $args        Extra args we want to pass.
	 */
	public function __construct( $config_id, $webfonts, $googlefonts, $args = array() ) {

		$this->config_id   = $config_id;
		$this->webfonts    = $webfonts;
		$this->googlefonts = $googlefonts;

		add_action( 'wp_footer', array( $this, 'webfont_loader' ) );
	}

	/**
	 * Webfont Loader for Google Fonts.
	 *
	 * @access public
	 * @since 3.0.28
	 */
	public function webfont_loader() {

		// Go through our fields and populate $this->fonts.
		$this->webfonts->loop_fields( $this->config_id );

		$this->googlefonts->fonts = apply_filters( 'kirki_enqueue_google_fonts', $this->googlefonts->fonts );

		// Goes through $this->fonts and adds or removes things as needed.
		$this->googlefonts->process_fonts();

		$css = '';
		$fonts = array_keys( $this->googlefonts->fonts );
		$fonts = array_unique( $fonts );
		foreach ( $fonts as $family ) {
			$css .= Kirki_Fonts_Google_Local::init( $family )->get_css();
		}
		if ( $css ) {
			echo '<style id="kirki-local-webfonts-' . esc_attr( sanitize_key( $this->config_id ) ) . '">' . $css . '</style>'; // WPCS: XSS ok.
		}
	}
}
