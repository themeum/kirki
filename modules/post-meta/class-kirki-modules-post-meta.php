<?php
/**
 * Customize_Queried_Post_Info class.
 *
 * @package CustomizeQueriedPostInfo
 */

/**
 * Class Customize_Queried_Post_Info.
 */
class Kirki_Modules_Post_Meta {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.1.0
	 */
	protected function __construct() {

		add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ) );
	}

	/**
	 * Enqueue Customizer control scripts.
	 *
	 * @access public
	 * @since 3.1.0
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'kirki_post_meta_previewed_controls', trailingslashit( Kirki::$url ) . 'modules/post-meta/customize-controls.js', array( 'jquery', 'customize-controls' ), KIRKI_VERSION, true );
	}

	/**
	 * Initialize Customizer preview.
	 *
	 * @access public
	 * @since 3.1.0
	 */
	public function customize_preview_init() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_preview_scripts' ) );
	}

	/**
	 * Enqueue script for Customizer preview.
	 *
	 * @access public
	 * @since 3.1.0
	 */
	public function enqueue_preview_scripts() {

		wp_enqueue_script( 'kirki_post_meta_previewed_preview', trailingslashit( Kirki::$url ) . 'modules/post-meta/customize-preview.js', array( 'jquery', 'customize-preview' ), KIRKI_VERSION, true );

		$wp_scripts   = wp_scripts();
		$queried_post = null;
		if ( is_singular() && get_queried_object() ) {
			$queried_post = get_queried_object();
			$queried_post->meta = get_post_custom( $queried_post->id );
		}
		$wp_scripts->add_data( 'kirki_post_meta_previewed_preview', 'data', sprintf( 'var _customizePostPreviewedQueriedObject = %s;', wp_json_encode( $queried_post ) ) );
	}
}
