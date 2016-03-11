<?php

if ( ! class_exists( 'Kirki_Fonts' ) ) {

	final class Kirki_Fonts {

		public static $mode = 'link';

		private static $instance = null;

		public static $google_fonts = null;

		private function __construct() {}

		/**
		 * Get the one, true instance of this class.
		 * Prevents performance issues since this is only loaded once.
		 *
		 * @return object Kirki_Fonts
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Compile font options from different sources.
		 *
		 * @return array    All available fonts.
		 */
		public static function get_all_fonts() {
			$standard_fonts = self::get_standard_fonts();
			$google_fonts   = self::get_google_fonts();

			return apply_filters( 'kirki/fonts/all', array_merge( $standard_fonts, $google_fonts ) );
		}

		/**
		 * Return an array of standard websafe fonts.
		 *
		 * @return array    Standard websafe fonts.
		 */
		 public static function get_standard_fonts() {
			$i18n = Kirki_l10n::get_strings();
			return apply_filters( 'kirki/fonts/standard_fonts', array(
				'serif'     => array(
					'label' => $i18n['serif'],
					'stack' => 'Georgia,Times,"Times New Roman",serif',
				),
				'sans-serif' => array(
					'label'  => $i18n['sans-serif'],
					'stack'  => 'Helvetica,Arial,sans-serif',
				),
				'monospace' => array(
					'label' => $i18n['monospace'],
					'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
				),
			) );
		}

		/**
		 * Return an array of backup fonts based on the font-category
		 *
		 * @return array
		 */
		public static function get_backup_fonts() {
			$backup_fonts = array(
				'sans-serif'  => 'Helvetica, Arial, sans-serif',
				'serif'       => 'Georgia, serif',
				'display'     => '"Comic Sans MS", cursive, sans-serif',
				'handwriting' => '"Comic Sans MS", cursive, sans-serif',
				'monospace'   => '"Lucida Console", Monaco, monospace',
			);
			return apply_filters( 'kirki/fonts/backup_fonts', $backup_fonts );
		}

		/**
		 * Return an array of all available Google Fonts.
		 *
		 * @return array    All Google Fonts.
		 */
		public static function get_google_fonts() {

			if ( null === self::$google_fonts || empty( self::$google_fonts ) ) {

				global $wp_filesystem;
				// Initialize the WP filesystem, no more using 'file-put-contents' function
				if ( empty( $wp_filesystem ) ) {
					require_once( ABSPATH . '/wp-admin/includes/file.php' );
					WP_Filesystem();
				}

				$json_path = wp_normalize_path( dirname( dirname( __FILE__ ) ) . '/assets/json/webfonts.json' );
				$json      = $wp_filesystem->get_contents( $json_path );
				// Get the list of fonts from our json file and convert to an array
				$fonts = json_decode( $json, true );

				$google_fonts = array();
				if ( is_array( $fonts ) ) {
					foreach ( $fonts['items'] as $font ) {
						$google_fonts[ $font['family'] ] = array(
							'label'    => $font['family'],
							'variants' => $font['variants'],
							'subsets'  => $font['subsets'],
							'category' => $font['category'],
						);
					}
				}

				self::$google_fonts = apply_filters( 'kirki/fonts/google_fonts', $google_fonts );

			}

			return self::$google_fonts;

		}

		public static function get_all_subsets() {
			$i18n = Kirki_l10n::get_strings();
			return array(
				// 'all'          => $i18n['all'],
				'cyrillic'     => $i18n['cyrillic'],
				'cyrillic-ext' => $i18n['cyrillic-ext'],
				'devanagari'   => $i18n['devanagari'],
				'greek'        => $i18n['greek'],
				'greek-ext'    => $i18n['greek-ext'],
				'khmer'        => $i18n['khmer'],
				// 'latin'        => $i18n['latin'],
				'latin-ext'    => $i18n['latin-ext'],
				'vietnamese'   => $i18n['vietnamese'],
				'hebrew'       => $i18n['hebrew'],
				'arabic'       => $i18n['arabic'],
				'bengali'      => $i18n['bengali'],
				'gujarati'     => $i18n['gujarati'],
				'tamil'        => $i18n['tamil'],
				'telugu'       => $i18n['telugu'],
				'thai'         => $i18n['thai'],
			);
		}

		public static function get_all_variants() {
			$i18n = Kirki_l10n::get_strings();
			return array(
				'100'       => $i18n['ultra-light'],
				'100italic' => $i18n['ultra-light-italic'],
				'200'       => $i18n['light'],
				'200italic' => $i18n['light-italic'],
				'300'       => $i18n['book'],
				'300italic' => $i18n['book-italic'],
				'regular'   => $i18n['regular'],
				'italic'    => $i18n['italic'],
				'500'       => $i18n['medium'],
				'500italic' => $i18n['medium-italic'],
				'600'       => $i18n['semi-bold'],
				'600italic' => $i18n['semi-bold-italic'],
				'700'       => $i18n['bold'],
				'700italic' => $i18n['bold-italic'],
				'800'       => $i18n['extra-bold'],
				'800italic' => $i18n['extra-bold-italic'],
				'900'       => $i18n['ultra-bold'],
				'900italic' => $i18n['ultra-bold-italic'],
			);
		}

		/**
		 * @param string $fontname
		 */
		public static function is_google_font( $fontname ) {
			return ( array_key_exists( $fontname, self::$google_fonts ) );
		}

		public static function get_font_choices() {
			$fonts = self::get_all_fonts();
			$fonts_array = array();
			foreach ( $fonts as $key => $args ) {
				$fonts_array[ $key ] = $key;
			}
			return $fonts_array;
		}

	}

}
