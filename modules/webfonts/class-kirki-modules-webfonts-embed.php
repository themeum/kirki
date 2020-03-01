<?php
/**
 * Adds the Webfont Loader to load fonts asyncronously.
 *
 * @package     Kirki
 * @category    Core
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0
 */

/**
 * Manages the way Google Fonts are enqueued.
 */
final class Kirki_Modules_Webfonts_Embed {

	/**
	 * The config ID.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var string
	 */
	protected $config_id;

	/**
	 * The Kirki_Modules_Webfonts object.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var object
	 */
	protected $webfonts;

	/**
	 * The Kirki_Fonts_Google object.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var object
	 */
	protected $googlefonts;

	/**
	 * Fonts to load.
	 *
	 * @access protected
	 * @since 3.0.26
	 * @var array
	 */
	protected $fonts_to_load = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0
	 * @param string $config_id   The config-ID.
	 * @param object $webfonts    The Kirki_Modules_Webfonts object.
	 * @param object $googlefonts The Kirki_Fonts_Google object.
	 * @param array  $args        Extra args we want to pass.
	 */
	public function __construct( $config_id, $webfonts, $googlefonts, $args = array() ) {
		$this->config_id   = $config_id;
		$this->webfonts    = $webfonts;
		$this->googlefonts = $googlefonts;

		add_action( 'wp', array( $this, 'init' ), 9 );
		add_filter( 'wp_resource_hints', array( $this, 'resource_hints' ), 10, 2 );
	}

	/**
	 * Init.
	 *
	 * @access public
	 * @since 3.0.36
	 * @return void
	 */
	public function init() {
		$this->populate_fonts();
		add_action( 'kirki_dynamic_css', array( $this, 'the_css' ) );
	}

	/**
	 * Add preconnect for Google Fonts.
	 *
	 * @access public
	 * @param array  $urls           URLs to print for resource hints.
	 * @param string $relation_type  The relation type the URLs are printed.
	 * @return array $urls           URLs to print for resource hints.
	 */
	public function resource_hints( $urls, $relation_type ) {
		$fonts_to_load = $this->googlefonts->fonts;

		if ( ! empty( $fonts_to_load ) && 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		}
		return $urls;
	}

	/**
	 * Webfont Loader for Google Fonts.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function populate_fonts() {

		// Go through our fields and populate $this->fonts.
		$this->webfonts->loop_fields( $this->config_id );

		$this->googlefonts->fonts = apply_filters( 'kirki_enqueue_google_fonts', $this->googlefonts->fonts );

		// Goes through $this->fonts and adds or removes things as needed.
		$this->googlefonts->process_fonts();

		foreach ( $this->googlefonts->fonts as $font => $weights ) {
			foreach ( $weights as $key => $value ) {
				if ( 'italic' === $value ) {
					$weights[ $key ] = '400i';
				} else {
					$weights[ $key ] = str_replace( array( 'regular', 'bold', 'italic' ), array( '400', '', 'i' ), $value );
				}
			}
			$this->fonts_to_load[] = array(
				'family'  => $font,
				'weights' => $weights,
			);
		}
	}

	/**
	 * Webfont Loader script for Google Fonts.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function the_css() {
		foreach ( $this->fonts_to_load as $font ) {
			$family  = str_replace( ' ', '+', trim( $font['family'] ) );
			$weights = join( ',', $font['weights'] );
			$url     = "https://fonts.googleapis.com/css?family={$family}:{$weights}&subset=cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai";

			$transient_id = 'kirki_gfonts_' . md5( $url );
			$contents     = get_transient( $transient_id );

			if ( ! class_exists( 'Kirki_Fonts_Downloader' ) ) {
				include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts-downloader.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
			}
			$downloader = new Kirki_Fonts_Downloader();
			$contents   = $downloader->get_styles( $url );

			if ( $contents ) {
				/**
				 * Note to code reviewers:
				 *
				 * Though all output should be run through an escaping function, this is pure CSS
				 * and it is added on a call that has a PHP `header( 'Content-type: text/css' );`.
				 * No code, script or anything else can be executed from inside a stylesheet.
				 * For extra security we're using the wp_strip_all_tags() function here
				 * just to make sure there's no <script> tags in there or anything else.
				 */
				echo wp_strip_all_tags( $contents ); // phpcs:ignore WordPress.Security.EscapeOutput
			}
		}
	}
}
