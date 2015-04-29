<?php

/**
 * Class Kirki_Framework
 *
 * The main Kirki object
 */
class Kirki_Framework {

	public static $instance;
	public static $instances = array();

	/** @var string Version number */
	public static $version = '0.9-dev';

	public $config  = null;
	public $fonts   = null;
	public $scripts = null;
	public $builder = null;

	public $fields  = null;

	/**
	 * Get Instance
	 * Get Kirki instance
	 * OR an instance of Kirki by [instance_id]
	 *
	 * @param  string $instance_id the defined configuration ID
	 *
	 * @return object                class instance
	 */
	public static function get_instance( $instance_id = false ) {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		if ( $instance_id && ! empty( self::$instances[$instance_id] ) ) {
			return self::$instances[$instance_id];
		}

		return self::$instance;
	}

	/**
	 * Shortcut method to call the Field class
	 */
	public static function fields( $instance = null ) {
		return self::get_instance( $instance )->fields;
	}

	/**
	 * Shortcut method to get the configuration of the single instance.
	 */
	public static function config( $instance = null ) {
		return self::get_instance( $instance )->config;
	}

	/**
	 * Shortcut method to get the translation strings
	 */
	public static function i18n( $instance = null ) {
		$config  = self::config( $instance );
		$options = $config->get_all();
		return $options['i18n'];
	}

	/**
	 * Shortcut method to get the font registry.
	 */
	public static function fonts( $instance = null ) {
		return self::get_instance( $instance )->fonts;
	}

	/**
	 * Constructor is private, should only be called by get_instance()
	 */
	private function __construct( $instance = null ) {
		do_action( 'kirki/construct' );
	}

}
