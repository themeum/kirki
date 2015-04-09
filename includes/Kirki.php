<?php

use Kirki\Fonts\FontRegistry;
use Kirki\Scripts\ScriptRegistry;
use Kirki\Config;
use Kirki\Styles;
use Kirki\Fields;
use Kirki\Builder;

spl_autoload_register( function( $class ) {
	if ( stripos( $class, 'Kirki' ) === 0 ) {
		@include( KIRKI_PATH . DIRECTORY_SEPARATOR . 'includes' . str_replace( '\\', DIRECTORY_SEPARATOR, substr( $class, strlen( 'Kirki' ) ) ) . '.php' );
	}
});

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
		$this->font_registry = new FontRegistry();
		$this->config        = new Config();
		$this->fields        = new Fields();
		$this->scripts       = new ScriptRegistry();
		$this->styles        = new Styles();

		// Hook into WP
		$init = new Builder();

	}

}
