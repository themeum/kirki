<?php

namespace Kirki;

class Config {

	/** @var array The configuration values for Kirki */
	private $config = null;

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Get a configuration value
	 *
	 * @param string $key     The configuration key we are interested in
	 * @param string $default The default value if that configuration is not set
	 *
	 * @return mixed
	 */
	public function get( $key, $default='' ) {

		$cfg = $this->get_all();
		return isset( $cfg[$key] ) ? $cfg[$key] : $default;

	}

	/**
	 * Get a configuration value or throw an exception if that value is mandatory
	 *
	 * @param string $key     The configuration key we are interested in
	 *
	 * @return mixed
	 */
	public function getOrThrow( $key ) {

		$cfg = $this->get_all();
		if ( isset( $cfg[$key] ) ) {
			return $cfg[$key];
		}

		throw new RuntimeException( sprintf( "Configuration key %s is mandatory and has not been specified", $key ) );

	}

	/**
	 * Get the configuration options for the Kirki customizer.
	 *
	 * @uses 'kirki/config' filter.
	 */
	public function get_all() {

		if ( is_null( $this->config ) ) {

			// Get configuration from the filter
			$this->config = apply_filters( 'kirki/config', array() );

			// Merge a default configuration with the one we got from the user to make sure nothing is missing
			$default_config = array(
				'stylesheet_id' => 'kirki-styles',
				'capability'    => 'edit_theme_options',
				'logo_image'    => '',
				'description'   => '',
				'url_path'      => '',
				'options_type'  => 'theme_mod',
			);
			$this->config = array_merge( $default_config, $this->config );

			$this->config['logo_image']  = esc_url_raw( $this->config['logo_image'] );
			$this->config['description'] = esc_html( $this->config['description'] );
			$this->config['url_path']    = esc_url_raw( $this->config['url_path'] );

			// Get the translation strings.
			$this->config['i18n'] = ( ! isset( $this->config['i18n'] ) ) ? array() : $this->config['i18n'];
			$this->config['i18n'] = array_merge( $this->translation_strings(), $this->config['i18n'] );

		}

		return $this->config;

	}

	/**
	 * The i18n strings
	 */
	public function translation_strings() {

		$strings = array(
			'background-color'      => __( 'Background Color',         'kirki' ),
			'background-image'      => __( 'Background Image',         'kirki' ),
			'no-repeat'             => __( 'No Repeat',                'kirki' ),
			'repeat-all'            => __( 'Repeat All',               'kirki' ),
			'repeat-x'              => __( 'Repeat Horizontally',      'kirki' ),
			'repeat-y'              => __( 'Repeat Vertically',        'kirki' ),
			'inherit'               => __( 'Inherit',                  'kirki' ),
			'background-repeat'     => __( 'Background Repeat',        'kirki' ),
			'cover'                 => __( 'Cover',                    'kirki' ),
			'contain'               => __( 'Contain',                  'kirki' ),
			'background-size'       => __( 'Background Size',          'kirki' ),
			'fixed'                 => __( 'Fixed',                    'kirki' ),
			'scroll'                => __( 'Scroll',                   'kirki' ),
			'background-attachment' => __( 'Background Attachment',    'kirki' ),
			'left-top'              => __( 'Left Top',                 'kirki' ),
			'left-center'           => __( 'Left Center',              'kirki' ),
			'left-bottom'           => __( 'Left Bottom',              'kirki' ),
			'right-top'             => __( 'Right Top',                'kirki' ),
			'right-center'          => __( 'Right Center',             'kirki' ),
			'right-bottom'          => __( 'Right Bottom',             'kirki' ),
			'center-top'            => __( 'Center Top',               'kirki' ),
			'center-center'         => __( 'Center Center',            'kirki' ),
			'center-bottom'         => __( 'Center Bottom',            'kirki' ),
			'background-position'   => __( 'Background Position',      'kirki' ),
			'background-opacity'    => __( 'Background Opacity',       'kirki' ),
			'ON'                    => __( 'ON',                       'kirki' ),
			'OFF'                   => __( 'OFF',                      'kirki' ),
			'all'                   => __( 'All',                      'kirki' ),
			'cyrillic'              => __( 'Cyrillic',                 'kirki' ),
			'cyrillic-ext'          => __( 'Cyrillic Extended',        'kirki' ),
			'devanagari'            => __( 'Devanagari',               'kirki' ),
			'greek'                 => __( 'Greek',                    'kirki' ),
			'greek-ext'             => __( 'Greek Extended',           'kirki' ),
			'khmer'                 => __( 'Khmer',                    'kirki' ),
			'latin'                 => __( 'Latin',                    'kirki' ),
			'latin-ext'             => __( 'Latin Extended',           'kirki' ),
			'vietnamese'            => __( 'Vietnamese',               'kirki' ),
			'serif'                 => _x( 'Serif', 'font style',      'kirki' ),
			'sans-serif'            => _x( 'Sans Serif', 'font style', 'kirki' ),
			'monospace'             => _x( 'Monospace', 'font style',  'kirki' ),
		);

		return $strings;

	}

}
