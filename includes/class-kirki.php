<?php

/**
 * Class Kirki
 *
 * The main Kirki object
 */
class Kirki {

	/** @var Kirki The only instance of this class */
	public static $instance = null;

	/** @var string Version number */
	public static $version = '0.8.4';

	/** @var Config Configuration */
	public $config = null;

	/** @var FontRegistry The font registry */
	public $font_registry = null;

	/** @var scripts */
	public $scripts = null;

	/** @var field */
	public $fields = null;

	/**
	 * Access the single instance of this class
	 * @return Kirki
	 */
	public static function get_instance() {
		if ( self::$instance==null ) {
			self::$instance = new Kirki();
		}
		return self::$instance;
	}

	/**
	 * Shortcut method to call the Field class
	 */
	public static function fields() {
		return self::get_instance()->fields;
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

		// Create our main objects
		$this->font_registry = new Kirki_Fonts_Font_Registry();
		$this->config        = new Kirki_Config();
		$this->fields        = new Kirki_Fields();
		$this->scripts       = new Kirki_Scripts_Registry();
		$this->styles        = new Kirki_Styles();

		// Hook into WP
		$init = new Kirki_Builder();

	}

}
