<?php

/**
 * Field "partial_refresh" argument format:

	partial_refresh => array(
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

	private $wp_customize;

	public function __construct() {

		global $wp_customize;
		if ( $wp_customize ) {
			$this->wp_customize = $wp_customize;
		}

		add_action( 'customize_register', array( $this, 'register_partials' ), 99 );

	}

	public function register_partials( WP_Customize_Manager $wp_customize ) {

		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		$fields = Kirki::$fields;

		foreach ( $fields as $field_id => $args ) {
			if ( isset( $args['partial_refresh'] ) ) {
				foreach ( $args['partial_refresh'] as $partial_refresh => $partial_refresh_args ) {
					$function = false;
					if ( isset( $partial_refresh_args['render_callback'] ) ) {
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
