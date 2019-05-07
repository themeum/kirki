<?php
/**
 * Automatic postMessage scripts calculation for Kirki controls.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

namespace Kirki\Modules\Postmessage;

use Kirki\Core\Kirki;
use Kirki\URL;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Module {

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
	 * An array of fields to be processed.
	 *
	 * @access protected
	 * @since 1.0
	 * @var array
	 */
	protected $fields = [];

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		add_action( 'customize_preview_init', [ $this, 'postmessage' ] );
		add_action( 'kirki_field_add_setting_args', [ $this, 'field_add_setting_args' ] );
	}

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
	 * Filter setting args before adding the setting to the customizer.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $args The field arguments.
	 * @return array
	 */
	public function field_add_setting_args( $args ) {

		if ( ! isset( $args['transport'] ) ) {
			return $args;
		}

		if ( 'postMessage' === $args['transport'] && isset( $args['js_vars'] ) && ! empty( $args['js_vars'] ) ) {
			$this->fields[] = $args;
			return $args;
		}

		if ( 'auto' === $args['transport'] ) {
			$args['js_vars'] = isset( $args['js_vars'] ) ? (array) $args['js_vars'] : [];
			$args['output']  = isset( $args['output'] ) ? (array) $args['output'] : [];
			$js_vars         = $args['js_vars'];
			
			// Set transport to refresh initially.
			// Serves as a fallback in case we failt to auto-calculate js_vars.
			$args['transport'] = 'refresh';

			// Try to auto-generate js_vars.
			// First we need to check if js_vars are empty, and that output is not empty.
			if ( empty( $args['js_vars'] ) && ! empty( $args['output'] ) ) {

				foreach ( $args['output'] as $output ) {
					$output['function'] = ( isset( $output['function'] ) ) ? $output['function'] : 'style';
					
					// If 'element' is not defined, skip this.
					if ( ! isset( $output['element'] ) ) {
						continue;
					}
					
					if ( is_array( $output['element'] ) ) {
						$output['element'] = implode( ',', $output['element'] );
					}

					// If there's a sanitize_callback defined skip this, unless we also have a js_callback defined.
					if ( isset( $output['sanitize_callback'] ) && ! empty( $output['sanitize_callback'] ) && ! isset( $output['js_callback'] ) ) {
						continue;
					}

					// If we got this far, it's safe to add this.
					$js_vars[] = $output;
				}
			}

			// Did we manage to get all the items from 'output'?
			// If not, then we're missing something so don't add this.
			if ( count( $js_vars ) !== count( $args['output'] ) ) {
				$js_vars = [];
			}
			$args['js_vars'] = $js_vars;
			if ( ! empty( $args['js_vars'] ) ) {
				$args['transport'] = 'postMessage';
			}
		}
		$this->fields[] = $args;
		return $args;
	}

	/**
	 * Enqueues the postMessage script
	 * and adds variables to it using the wp_localize_script function.
	 * The rest is handled via JS.
	 */
	public function postmessage() {
		wp_enqueue_script( 'kirki_auto_postmessage', URL::get_from_path( __DIR__ . '/assets/scripts/script.js' ), [ 'jquery', 'customize-preview' ], KIRKI_VERSION, true );
		$fields = array_merge( Kirki::$fields, $this->fields );
		$data   = [];
		foreach ( $fields as $field ) {
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['settings'] ) ) {
				$data[] = $field;
			}
		}
		wp_localize_script( 'kirki_auto_postmessage', 'kirkiPostMessageFields', $data );
		$extras = apply_filters( 'kirki_postmessage_script', false );
		if ( $extras ) {
			wp_add_inline_script( 'kirki_auto_postmessage', $extras, 'after' );
		}
	}
}
