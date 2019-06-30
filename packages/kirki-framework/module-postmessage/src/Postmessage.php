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

namespace Kirki\Module;

use Kirki\Compatibility\Kirki;
use Kirki\URL;

/**
 * Adds styles to the customizer.
 */
class Postmessage {

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
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {
		add_action( 'customize_preview_init', [ $this, 'postmessage' ] );
		add_action( 'kirki_field_add_setting_args', [ $this, 'field_add_setting_args' ] );
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

		$args['transport'] = 'auto' === $args['transport'] ? 'postMessage' : $args['transport'];

		if ( 'postMessage' === $args['transport'] ) {
			$args['js_vars'] = isset( $args['js_vars'] ) ? (array) $args['js_vars'] : [];
			$args['output']  = isset( $args['output'] ) ? (array) $args['output'] : [];
			$js_vars         = $args['js_vars'];

			// Try to auto-generate js_vars.
			// First we need to check if js_vars are empty, and that output is not empty.
			if ( empty( $args['js_vars'] ) && ! empty( $args['output'] ) ) {

				foreach ( $args['output'] as $output ) {
					$output['function'] = isset( $output['function'] ) ? $output['function'] : 'style';
					$output['element']  = is_array( $output['element'] ) ? implode( ',', $output['element'] ) : $output['element'];
					$js_vars[]          = $output;
				}
			}

			$args['js_vars'] = $js_vars;
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
		wp_enqueue_script( 'kirki_auto_postmessage', URL::get_from_path( __DIR__ . '/postMessage.js' ), [ 'jquery', 'customize-preview', 'wp-hooks' ], '4.0', true );
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
