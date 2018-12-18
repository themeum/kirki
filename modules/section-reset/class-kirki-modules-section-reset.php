<?php
/**
 * Adds ability to reset sections inside customizer.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Nathaniel Glover
 * @copyright   Copyright (c) 2018, Nathaniel Glover
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.26
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kirki_Modules_Section_Reset {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 */
	protected function __construct() {
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ) );
		add_action( 'wp_ajax_kirki_reset_section', array( $this, 'ajax_reset_section' ) );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 */
	public function customize_controls_print_footer_scripts() {
		wp_enqueue_script( 'kirki-section-reset', trailingslashit( Kirki::$url ) . 'modules/section-reset/section-reset.js', array( 'jquery' ), KIRKI_VERSION, false );
		wp_localize_script( 'kirki-section-reset', 'kirki_reset_section', array(
			'reset_section'   => __( 'Reset Section', 'kirki' ),
			'confirm_section' => __( "Attention! This will remove all customizations made to this section!\n\nThis action is irreversible!", 'kirki' ),
			'something_went_wrong' => __( "Something went wrong.", 'kirki' ),
			'nonce'   => array(
				'reset' => wp_create_nonce( 'kirki-section-reset' ),
			)
		) );
	}
	
	/**
	 * Handles resetting called by reset button
	 */
	public function ajax_reset_section()
	{
		$section = isset ( $_REQUEST['section'] ) ? $_REQUEST['section'] : '';
		$nonce = isset ( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : '';
		if ( !wp_verify_nonce( $nonce, 'kirki-section-reset'  ) )
			wp_send_json_error( __( 'Invalid nonce.', 'kirki' ) );
		if ( empty( $section ) )
			wp_send_json_error( __( 'Section not set', 'kirki' ) );
		
		if ( isset( Kirki::$sections[$section] ) )
		{
			foreach ( Kirki::$fields as $field )
			{
				if ( $field['section'] !== $section )
					continue;
				if ( $field['option_type'] === 'theme_mod' )
					remove_theme_mod( $field['settings'] );
				else
					delete_option( $field['settings'] );
			}
			Kirki::$skip_output_context = true;
			new Kirki_CSS_To_File();
			do_action( 'customize_save_after' );
			Kirki::$skip_output_context = false;
			wp_send_json_success();
		}
		else
		{
			wp_send_json_error( __( 'Could not find section', 'kirki' ) );
		}
	}
}
