<?php

/**
 * Field "partial_refresh" argument format:

	'transport'       => 'postMessage',
	'partial_refresh' => array(
		'header_site_title' => array(
			'selector'        => '.site-title a',
			'render_callback' => function() {
				return get_bloginfo( 'name', 'display' );
			},
		),
		'document_title' => array(
			'selector'        => 'head > title',
			'render_callback' => 'wp_get_document_title',
		),
	),
 *
 */
class Kirki_Selective_Refresh {

	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_partials' ), 99 );
	}

	/**
	 * Parses all fields and searches for the "partial_refresh" argument inside them.
	 * If that argument is found, then it starts parsing the array of arguments.
	 * Registers a selective_refresh in the customizer for each one of them.
	 *
	 * @param $wp_customize WP_Customize_Manager
	 */
	public function register_partials( WP_Customize_Manager $wp_customize ) {

		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		// Get an array of all fields
		$fields = Kirki::$fields;

		// Start parsing the fields
		foreach ( $fields as $field_id => $args ) {
			if ( isset( $args['partial_refresh'] ) ) {
				// Start going through each item in the array of partial refreshes
				foreach ( $args['partial_refresh'] as $partial_refresh => $partial_refresh_args ) {
					// If we have all we need, create the selective refresh call.
					if ( isset( $partial_refresh_args['render_callback'] ) && isset( $partial_refresh_args['selector'] ) ) {
						$wp_customize->selective_refresh->add_partial( $partial_refresh, array(
							'selector'        => $partial_refresh_args['selector'],
							'settings'        => array( $args['settings'] ),
							'render_callback' => $partial_refresh_args['render_callback'],
						) );
					}
				}
			}
		}
	}
}
