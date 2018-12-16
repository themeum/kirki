<?php
/**
 * Automatic preset scripts calculation for Kirki controls.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.26
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_Section_Reset {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.26
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.26
	 */
	protected function __construct() {
		add_action( 'wp_ajax_reset_section', array( $this, 'ajax_reset_section' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ) );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.26
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
	 * @since 3.0.26
	 */
	public function customize_controls_print_footer_scripts() {
		wp_enqueue_script( 'kirki-section-reset', trailingslashit( Kirki::$url ) . 'modules/section-reset/section-reset.js', array( 'jquery' ), KIRKI_VERSION, false );
		wp_localize_script( 'kirki-section-reset', 'kirki_reset_section', array(
			'reset_all'   => __( 'Reset All', 'kirki' ),
			'reset_section'   => __( 'Reset Section', 'kirki' ),
			'confirm' => __( "Attention! This will remove all customizations ever made via customizer to this theme!\n\nThis action is irreversible!", 'kirki' ),
			'confirm_section' => __( "Attention! This will remove all customizations made to this section.!\n\nThis action is irreversible!", 'kirki' ),
			'something_went_wrong' => __( "Something went wrong.", 'kirki' ),
			'nonce'   => array(
				'reset' => wp_create_nonce( 'section-reset' ),
			)
		) );
	}
	
	public function ajax_reset_section()
	{
		$section = isset ( $_REQUEST['section'] ) ? $_REQUEST['section'] : '';
		if ( empty( $section ) )
			wp_send_json_error( __( 'Section not set.', 'kirki' ) );
		$sections = Kirki::$sections;
		$fields = Kirki::$fields;
		if ( isset( $sections[$section] ) )
		{
			foreach ( $fields as $field )
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
