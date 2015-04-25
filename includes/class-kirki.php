<?php

/**
 * Class Kirki
 *
 * The main Kirki object
 */
class Kirki {

	public static $instance    = null;
	public static $version     = '0.8.4';
	public static $instance_id = null;

	public $config        = null;
	public $font_registry = null;
	public $scripts       = null;
	public $fields        = null;
	public $builder       = null;

	/**
	 * Access the single instance of this class
	 * @return Kirki
	 */
	public static function get_instance( $instance_id = null ) {
		if ( $instance_id != self::$instance_id || null == self::$instance ) {
			self::$instance = new Kirki( $instance_id );
		}
		return self::$instance;
	}

	/**
	 * Shortcut method to call the Field class
	 */
	public static function fields( $instance_id = null ) {
		return self::get_instance( $instance_id )->fields;
	}

	/**
	 * Shortcut method to get the configuration of the single instance.
	 */
	public static function config( $instance_id = null ) {
		return self::get_instance( $instance_id )->config;
	}

	/**
	 * Shortcut method to get the translation strings
	 */
	public static function i18n( $instance_id = null ) {
		$config  = self::config( $instance_id );
		$options = $config->get_all();
		return $options['i18n'];
	}

	/**
	 * Shortcut method to get the font registry.
	 */
	public static function fonts( $instance_id = null ) {
		return self::get_instance( $instance_id )->font_registry;
	}

	/**
	 * Constructor is private, should only be called by get_instance()
	 */
	private function __construct( $instance_id ) {

		// Create our main objects
		$this->font_registry = new Kirki_Fonts_Font_Registry( $instance_id );
		$this->config        = new Kirki_Config( $instance_id );
		$this->fields        = new Kirki_Fields( $instance_id );
		$this->scripts       = new Kirki_Scripts_Registry( $instance_id );
		$this->styles        = new Kirki_Styles( $instance_id );

		// Hook into WP
		$this->builder       = new Kirki_Builder( $instance_id );

	}

}
