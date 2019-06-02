<?php
/**
 * Override field methods.
 *
 * @package   kirki-framework/control-fontawesome
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Field;

/**
 * Field overrides.
 */
class FontAwesome extends Field {

	/**
	 * The control class-name.
	 *
	 * @access protected
	 * @since 0.1
	 * @var string
	 */
	protected $control_class = '\Kirki\Control\FontAwesome';

	/**
	 * Whether we should register the control class for JS-templating or not.
	 *
	 * @access protected
	 * @since 0.1
	 * @var bool
	 */
	protected $control_has_js_template = true;

	/**
	 * Constructor.
	 * Registers any hooks we need to run.
	 *
	 * @access public
	 * @since 0.1
	 * @param array $args The field arguments.
	 */
	public function __construct( $args ) {
		parent::__construct( $args );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_fontawesome' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_fontawesome' ] );
	}

	/**
	 * Filter arguments before creating the setting.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['settings'] === $this->args['settings'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			// Set the sanitize-callback if none is defined.
			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = 'sanitize_text_field';
			}
		}
		return $args;
	}

	/**
	 * Filter arguments before creating the control.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['settings'] === $this->args['settings'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'kirki-fontawesome';
		}
		return $args;
	}

	/**
	 * Enqueue fontawesome in Gutenberg Editor.
	 *
	 * @access public
	 * @since 3.0.35
	 */
	public function enqueue_fontawesome() {
		if ( apply_filters( 'kirki_load_fontawesome', true ) ) {
			wp_enqueue_style( 'kirki-fontawesome-font', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', [], '4.0.7' );
		}
	}
}
