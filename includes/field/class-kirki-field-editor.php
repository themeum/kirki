<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

if ( ! class_exists( 'Kirki_Field_Editor' ) ) {

	/**
	 * Field overrides.
	 */
	class Kirki_Field_Editor extends Kirki_Field {

		/**
		 * Constructor.
		 * Since editor fields only work properly if there's a single tinyMCE instance
		 * We'll be adding a global editor using the add_editor method.
		 *
		 * @access public
		 * @param string $config_id    The ID of the config we want to use.
		 *                             Defaults to "global".
		 *                             Configs are handled by the Kirki_Config class.
		 * @param array  $args         The arguments of the field.
		 */
		public function __construct( $config_id = 'global', $args = array() ) {

			// Call the parent-class constructor.
			parent::__construct( $config_id, $args );

			// Add the editor.
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'add_editor' ) );

			global $wp_customize;
			if ( $wp_customize ) {
				// Add the tinyMCE code plugin.
				add_filter( 'mce_external_plugins', array( $this, 'add_code_plugin' ) );
				add_filter( 'mce_buttons', array( $this, 'tinymce_code_button' ) );
			}

		}

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'kirki-editor';

		}

		/**
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function set_sanitize_callback() {

			// If a custom sanitize_callback has been defined,
			// then we don't need to proceed any further.
			if ( ! empty( $this->sanitize_callback ) ) {
				return;
			}
			$this->sanitize_callback = 'wp_kses_post';

		}

		/**
		 * Adds the global textarea
		 *
		 * @access public
		 */
		public function add_editor() {
			wp_enqueue_script( 'tiny_mce' );

			echo '<div id="kirki_editor_pane" class="hidden">';
			wp_editor( '', 'kirki-editor', array(
				'_content_editor_dfw' => false,
				'drag_drop_upload'    => true,
				'tabfocus_elements'   => 'content-html,save-post',
				'editor_height'       => 200,
				'default_editor'      => 'tinymce',
				'quicktags'           => false,
				'tinymce'             => array(
					'resize'             => false,
					'wp_autoresize_on'   => false,
					'add_unload_trigger' => false,
				),
			) );
			echo '</div>';
			do_action( 'admin_footer' );
			do_action( 'admin_print_footer_scripts' );
		}

		/**
		 * Add the "code" tinyMCE plugin.
		 *
		 * @access public
		 * @see https://www.tinymce.com/docs/plugins/code/
		 * @param array $plugins All tinyMCE plugins.
		 * @return array
		 */
		public function add_code_plugin( $plugins ) {

			$plugins['code'] = trailingslashit( Kirki::$url ) . 'assets/js/vendor/tinymce.plugin.code.js';
			return $plugins;

		}

		/**
		 * Add the "code" tinyMCE button.
		 *
		 * @access public
		 * @param array $buttons TinyMCE buttons.
		 * @return array
		 */
		public function tinymce_code_button( $buttons ) {

			if ( ! in_array( 'code', $buttons ) ) {
				$buttons[] = 'code';
			}
			/*
			// Remove advanced mode?
			if ( false !== ( $key = array_search( 'wp_adv', $buttons ) ) ) {
				unset( $buttons[ $key ] );
			}
			*/
			return $buttons;

		}
	}
}
