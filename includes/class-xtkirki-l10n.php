<?php
/**
 * Internationalization helper.
 *
 * @package     XTKirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'XTKirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class XTKirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'xtkirki';

		/**
		 * The class constructor.
		 * Adds actions & filters to handle the rest of the methods.
		 *
		 * @access public
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		}

		/**
		 * Load the plugin textdomain
		 *
		 * @access public
		 */
		public function load_textdomain() {

			if ( null !== $this->get_path() ) {
				load_textdomain( $this->textdomain, $this->get_path() );
			}
			load_plugin_textdomain( $this->textdomain, false, XTKirki::$path . '/languages' );

		}

		/**
		 * Gets the path to a translation file.
		 *
		 * @access protected
		 * @return string Absolute path to the translation file.
		 */
		protected function get_path() {
			$path_found = false;
			$found_path = null;
			foreach ( $this->get_paths() as $path ) {
				if ( $path_found ) {
					continue;
				}
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					$path_found = true;
					$found_path = $path;
				}
			}

			return $found_path;

		}

		/**
		 * Returns an array of paths where translation files may be located.
		 *
		 * @access protected
		 * @return array
		 */
		protected function get_paths() {

			return array(
				WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
				XTKirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See XTKirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_attr__( 'Background Color', 'xtkirki' ),
				'background-image'      => esc_attr__( 'Background Image', 'xtkirki' ),
				'no-repeat'             => esc_attr__( 'No Repeat', 'xtkirki' ),
				'repeat-all'            => esc_attr__( 'Repeat All', 'xtkirki' ),
				'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'xtkirki' ),
				'repeat-y'              => esc_attr__( 'Repeat Vertically', 'xtkirki' ),
				'inherit'               => esc_attr__( 'Inherit', 'xtkirki' ),
				'background-repeat'     => esc_attr__( 'Background Repeat', 'xtkirki' ),
				'cover'                 => esc_attr__( 'Cover', 'xtkirki' ),
				'contain'               => esc_attr__( 'Contain', 'xtkirki' ),
				'background-size'       => esc_attr__( 'Background Size', 'xtkirki' ),
				'fixed'                 => esc_attr__( 'Fixed', 'xtkirki' ),
				'scroll'                => esc_attr__( 'Scroll', 'xtkirki' ),
				'background-attachment' => esc_attr__( 'Background Attachment', 'xtkirki' ),
				'left-top'              => esc_attr__( 'Left Top', 'xtkirki' ),
				'left-center'           => esc_attr__( 'Left Center', 'xtkirki' ),
				'left-bottom'           => esc_attr__( 'Left Bottom', 'xtkirki' ),
				'right-top'             => esc_attr__( 'Right Top', 'xtkirki' ),
				'right-center'          => esc_attr__( 'Right Center', 'xtkirki' ),
				'right-bottom'          => esc_attr__( 'Right Bottom', 'xtkirki' ),
				'center-top'            => esc_attr__( 'Center Top', 'xtkirki' ),
				'center-center'         => esc_attr__( 'Center Center', 'xtkirki' ),
				'center-bottom'         => esc_attr__( 'Center Bottom', 'xtkirki' ),
				'background-position'   => esc_attr__( 'Background Position', 'xtkirki' ),
				'background-opacity'    => esc_attr__( 'Background Opacity', 'xtkirki' ),
				'on'                    => esc_attr__( 'ON', 'xtkirki' ),
				'off'                   => esc_attr__( 'OFF', 'xtkirki' ),
				'all'                   => esc_attr__( 'All', 'xtkirki' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'xtkirki' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'xtkirki' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'xtkirki' ),
				'greek'                 => esc_attr__( 'Greek', 'xtkirki' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'xtkirki' ),
				'khmer'                 => esc_attr__( 'Khmer', 'xtkirki' ),
				'latin'                 => esc_attr__( 'Latin', 'xtkirki' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'xtkirki' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'xtkirki' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'xtkirki' ),
				'arabic'                => esc_attr__( 'Arabic', 'xtkirki' ),
				'bengali'               => esc_attr__( 'Bengali', 'xtkirki' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'xtkirki' ),
				'tamil'                 => esc_attr__( 'Tamil', 'xtkirki' ),
				'telugu'                => esc_attr__( 'Telugu', 'xtkirki' ),
				'thai'                  => esc_attr__( 'Thai', 'xtkirki' ),
				'serif'                 => _x( 'Serif', 'font style', 'xtkirki' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'xtkirki' ),
				'monospace'             => _x( 'Monospace', 'font style', 'xtkirki' ),
				'font-family'           => esc_attr__( 'Font Family', 'xtkirki' ),
				'font-size'             => esc_attr__( 'Font Size', 'xtkirki' ),
				'font-weight'           => esc_attr__( 'Font Weight', 'xtkirki' ),
				'line-height'           => esc_attr__( 'Line Height', 'xtkirki' ),
				'font-style'            => esc_attr__( 'Font Style', 'xtkirki' ),
				'letter-spacing'        => esc_attr__( 'Letter Spacing', 'xtkirki' ),
				'top'                   => esc_attr__( 'Top', 'xtkirki' ),
				'bottom'                => esc_attr__( 'Bottom', 'xtkirki' ),
				'left'                  => esc_attr__( 'Left', 'xtkirki' ),
				'right'                 => esc_attr__( 'Right', 'xtkirki' ),
				'center'                => esc_attr__( 'Center', 'xtkirki' ),
				'justify'               => esc_attr__( 'Justify', 'xtkirki' ),
				'color'                 => esc_attr__( 'Color', 'xtkirki' ),
				'add-image'             => esc_attr__( 'Add Image', 'xtkirki' ),
				'change-image'          => esc_attr__( 'Change Image', 'xtkirki' ),
				'no-image-selected'     => esc_attr__( 'No Image Selected', 'xtkirki' ),
				'add-file'              => esc_attr__( 'Add File', 'xtkirki' ),
				'change-file'           => esc_attr__( 'Change File', 'xtkirki' ),
				'no-file-selected'      => esc_attr__( 'No File Selected', 'xtkirki' ),
				'remove'                => esc_attr__( 'Remove', 'xtkirki' ),
				'select-font-family'    => esc_attr__( 'Select a font-family', 'xtkirki' ),
				'variant'               => esc_attr__( 'Variant', 'xtkirki' ),
				'subsets'               => esc_attr__( 'Subset', 'xtkirki' ),
				'size'                  => esc_attr__( 'Size', 'xtkirki' ),
				'height'                => esc_attr__( 'Height', 'xtkirki' ),
				'spacing'               => esc_attr__( 'Spacing', 'xtkirki' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'xtkirki' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'xtkirki' ),
				'light'                 => esc_attr__( 'Light 200', 'xtkirki' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'xtkirki' ),
				'book'                  => esc_attr__( 'Book 300', 'xtkirki' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'xtkirki' ),
				'regular'               => esc_attr__( 'Normal 400', 'xtkirki' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'xtkirki' ),
				'medium'                => esc_attr__( 'Medium 500', 'xtkirki' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'xtkirki' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'xtkirki' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'xtkirki' ),
				'bold'                  => esc_attr__( 'Bold 700', 'xtkirki' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'xtkirki' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'xtkirki' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'xtkirki' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'xtkirki' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'xtkirki' ),
				'invalid-value'         => esc_attr__( 'Invalid Value', 'xtkirki' ),
				'add-new'           	=> esc_attr__( 'Add new', 'xtkirki' ),
				'row'           		=> esc_attr__( 'row', 'xtkirki' ),
				'limit-rows'            => esc_attr__( 'Limit: %s rows', 'xtkirki' ),
				'open-section'          => esc_attr__( 'Press return or enter to open this section', 'xtkirki' ),
				'back'                  => esc_attr__( 'Back', 'xtkirki' ),
				'reset-with-icon'       => sprintf( esc_attr__( '%s Reset', 'xtkirki' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_attr__( 'Text Align', 'xtkirki' ),
				'text-transform'        => esc_attr__( 'Text Transform', 'xtkirki' ),
				'none'                  => esc_attr__( 'None', 'xtkirki' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'xtkirki' ),
				'uppercase'             => esc_attr__( 'Uppercase', 'xtkirki' ),
				'lowercase'             => esc_attr__( 'Lowercase', 'xtkirki' ),
				'initial'               => esc_attr__( 'Initial', 'xtkirki' ),
				'select-page'           => esc_attr__( 'Select a Page', 'xtkirki' ),
				'open-editor'           => esc_attr__( 'Open Editor', 'xtkirki' ),
				'close-editor'          => esc_attr__( 'Close Editor', 'xtkirki' ),
				'switch-editor'         => esc_attr__( 'Switch Editor', 'xtkirki' ),
				'hex-value'             => esc_attr__( 'Hex Value', 'xtkirki' ),
			);

			// Apply global changes from the xtkirki/config filter.
			// This is generally to be avoided.
			// It is ONLY provided here for backwards-compatibility reasons.
			// Please use the xtkirki/{$config_id}/l10n filter instead.
			$config = apply_filters( 'xtkirki/config', array() );
			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			// Apply l10n changes using the xtkirki/{$config_id}/l10n filter.
			return apply_filters( 'xtkirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
