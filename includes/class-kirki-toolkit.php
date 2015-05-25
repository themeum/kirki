<?php

/**
 * Class Kirki
 *
 * The main Kirki object
 */
class Kirki_Toolkit {

	/** @var Kirki The only instance of this class */
	public static $instance = null;

	public static $version = '1.0.0-alpha';

	public $config        = null;
	public $font_registry = null;
	public $scripts       = null;
	public $fields        = null;
	public $api           = null;
	public $settings      = null;
	public $controls      = null;


	/**
	 * Access the single instance of this class
	 * @return Kirki
	 */
	public static function get_instance() {
		if ( self::$instance==null ) {
			self::$instance = new Kirki_Toolkit();
		}
		return self::$instance;
	}

	/**
	 * Shortcut method to get the configuration of the single instance.
	 */
	public static function config() {
		return self::get_instance()->config;
	}

	/**
	 * Shortcut method to get the translation strings
	 */
	public static function i18n() {
		$config  = self::config();
		$options = $config->get_all();
		return $options['i18n'];
	}

	/**
	 * Shortcut method to get the font registry.
	 */
	public static function fonts() {
		return self::get_instance()->font_registry;
	}

	/**
	 * Constructor is private, should only be called by get_instance()
	 */
	private function __construct() {
	}

}
