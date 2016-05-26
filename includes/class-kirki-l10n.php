<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class Kirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'kirki';

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
			load_plugin_textdomain( $this->textdomain, false, Kirki::$path . '/languages' );

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
				Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See Kirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_attr__( 'Background Color', 'kirki' ),
				'background-image'      => esc_attr__( 'Background Image', 'kirki' ),
				'no-repeat'             => esc_attr__( 'No Repeat', 'kirki' ),
				'repeat-all'            => esc_attr__( 'Repeat All', 'kirki' ),
				'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'kirki' ),
				'repeat-y'              => esc_attr__( 'Repeat Vertically', 'kirki' ),
				'inherit'               => esc_attr__( 'Inherit', 'kirki' ),
				'background-repeat'     => esc_attr__( 'Background Repeat', 'kirki' ),
				'cover'                 => esc_attr__( 'Cover', 'kirki' ),
				'contain'               => esc_attr__( 'Contain', 'kirki' ),
				'background-size'       => esc_attr__( 'Background Size', 'kirki' ),
				'fixed'                 => esc_attr__( 'Fixed', 'kirki' ),
				'scroll'                => esc_attr__( 'Scroll', 'kirki' ),
				'background-attachment' => esc_attr__( 'Background Attachment', 'kirki' ),
				'left-top'              => esc_attr__( 'Left Top', 'kirki' ),
				'left-center'           => esc_attr__( 'Left Center', 'kirki' ),
				'left-bottom'           => esc_attr__( 'Left Bottom', 'kirki' ),
				'right-top'             => esc_attr__( 'Right Top', 'kirki' ),
				'right-center'          => esc_attr__( 'Right Center', 'kirki' ),
				'right-bottom'          => esc_attr__( 'Right Bottom', 'kirki' ),
				'center-top'            => esc_attr__( 'Center Top', 'kirki' ),
				'center-center'         => esc_attr__( 'Center Center', 'kirki' ),
				'center-bottom'         => esc_attr__( 'Center Bottom', 'kirki' ),
				'background-position'   => esc_attr__( 'Background Position', 'kirki' ),
				'background-opacity'    => esc_attr__( 'Background Opacity', 'kirki' ),
				'on'                    => esc_attr__( 'ON', 'kirki' ),
				'off'                   => esc_attr__( 'OFF', 'kirki' ),
				'all'                   => esc_attr__( 'All', 'kirki' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'kirki' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'kirki' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'kirki' ),
				'greek'                 => esc_attr__( 'Greek', 'kirki' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'kirki' ),
				'khmer'                 => esc_attr__( 'Khmer', 'kirki' ),
				'latin'                 => esc_attr__( 'Latin', 'kirki' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'kirki' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'kirki' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'kirki' ),
				'arabic'                => esc_attr__( 'Arabic', 'kirki' ),
				'bengali'               => esc_attr__( 'Bengali', 'kirki' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'kirki' ),
				'tamil'                 => esc_attr__( 'Tamil', 'kirki' ),
				'telugu'                => esc_attr__( 'Telugu', 'kirki' ),
				'thai'                  => esc_attr__( 'Thai', 'kirki' ),
				'serif'                 => _x( 'Serif', 'font style', 'kirki' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'kirki' ),
				'monospace'             => _x( 'Monospace', 'font style', 'kirki' ),
				'font-family'           => esc_attr__( 'Font Family', 'kirki' ),
				'font-size'             => esc_attr__( 'Font Size', 'kirki' ),
				'font-weight'           => esc_attr__( 'Font Weight', 'kirki' ),
				'line-height'           => esc_attr__( 'Line Height', 'kirki' ),
				'font-style'            => esc_attr__( 'Font Style', 'kirki' ),
				'letter-spacing'        => esc_attr__( 'Letter Spacing', 'kirki' ),
				'top'                   => esc_attr__( 'Top', 'kirki' ),
				'bottom'                => esc_attr__( 'Bottom', 'kirki' ),
				'left'                  => esc_attr__( 'Left', 'kirki' ),
				'right'                 => esc_attr__( 'Right', 'kirki' ),
				'center'                => esc_attr__( 'Center', 'kirki' ),
				'justify'               => esc_attr__( 'Justify', 'kirki' ),
				'color'                 => esc_attr__( 'Color', 'kirki' ),
				'add-image'             => esc_attr__( 'Add Image', 'kirki' ),
				'change-image'          => esc_attr__( 'Change Image', 'kirki' ),
				'no-image-selected'     => esc_attr__( 'No Image Selected', 'kirki' ),
				'add-file'              => esc_attr__( 'Add File', 'kirki' ),
				'change-file'           => esc_attr__( 'Change File', 'kirki' ),
				'no-file-selected'      => esc_attr__( 'No File Selected', 'kirki' ),
				'remove'                => esc_attr__( 'Remove', 'kirki' ),
				'select-font-family'    => esc_attr__( 'Select a font-family', 'kirki' ),
				'variant'               => esc_attr__( 'Variant', 'kirki' ),
				'subsets'               => esc_attr__( 'Subset', 'kirki' ),
				'size'                  => esc_attr__( 'Size', 'kirki' ),
				'height'                => esc_attr__( 'Height', 'kirki' ),
				'spacing'               => esc_attr__( 'Spacing', 'kirki' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'kirki' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'kirki' ),
				'light'                 => esc_attr__( 'Light 200', 'kirki' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'kirki' ),
				'book'                  => esc_attr__( 'Book 300', 'kirki' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'kirki' ),
				'regular'               => esc_attr__( 'Normal 400', 'kirki' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'kirki' ),
				'medium'                => esc_attr__( 'Medium 500', 'kirki' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'kirki' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'kirki' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'kirki' ),
				'bold'                  => esc_attr__( 'Bold 700', 'kirki' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'kirki' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'kirki' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'kirki' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'kirki' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'kirki' ),
				'invalid-value'         => esc_attr__( 'Invalid Value', 'kirki' ),
				'add-new'           	=> esc_attr__( 'Add new', 'kirki' ),
				'row'           		=> esc_attr__( 'row', 'kirki' ),
				'limit-rows'            => esc_attr__( 'Limit: %s rows', 'kirki' ),
				'open-section'          => esc_attr__( 'Press return or enter to open this section', 'kirki' ),
				'back'                  => esc_attr__( 'Back', 'kirki' ),
				'reset-with-icon'       => sprintf( esc_attr__( '%s Reset', 'kirki' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_attr__( 'Text Align', 'kirki' ),
				'text-transform'        => esc_attr__( 'Text Transform', 'kirki' ),
				'none'                  => esc_attr__( 'None', 'kirki' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'kirki' ),
				'uppercase'             => esc_attr__( 'Uppercase', 'kirki' ),
				'lowercase'             => esc_attr__( 'Lowercase', 'kirki' ),
				'initial'               => esc_attr__( 'Initial', 'kirki' ),
				'select-page'           => esc_attr__( 'Select a Page', 'kirki' ),
				'open-editor'           => esc_attr__( 'Open Editor', 'kirki' ),
				'close-editor'          => esc_attr__( 'Close Editor', 'kirki' ),
				'switch-editor'         => esc_attr__( 'Switch Editor', 'kirki' ),
				'hex-value'             => esc_attr__( 'Hex Value', 'kirki' ),
			);

			// Apply global changes from the kirki/config filter.
			// This is generally to be avoided.
			// It is ONLY provided here for backwards-compatibility reasons.
			// Please use the kirki/{$config_id}/l10n filter instead.
			$config = apply_filters( 'kirki/config', array() );
			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			// Apply l10n changes using the kirki/{$config_id}/l10n filter.
			return apply_filters( 'kirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
