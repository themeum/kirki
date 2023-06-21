<?php
/**
 * Init Kirki PRO.
 *
 * @package kirki-pro
 * @since 1.0.0
 */

namespace Kirki\Pro;

/**
 * Class to init Kirki PRO.
 *
 * Only call this class when it's used as embedded package.
 * This class will not be called when it's used as a regular plugin.
 *
 * @since 1.0.0
 */
class Init {

	/**
	 * The class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Stop, if Kirki is not installed.
		if ( ! defined( 'KIRKI_VERSION' ) ) {
			return;
		}

		// Stop, if Kirki PRO is already installed.
		if ( defined( 'KIRKI_PRO_VERSION' ) ) {
			return;
		}

		require_once __DIR__ . '/../vendor/autoload.php';

		$packages = [
			'packages/kirki-pro-headline-divider',
			'packages/kirki-pro-input-slider',
			'packages/kirki-pro-margin-padding',
			'packages/kirki-pro-responsive',
			'packages/kirki-pro-tabs',
		];

		foreach ( $packages as $package ) {
			$init_class_name = str_ireplace( 'packages/kirki-pro-', '', $package );
			$init_class_name = str_ireplace( '-', ' ', $init_class_name );
			$init_class_name = ucwords( $init_class_name );
			$init_class_name = str_ireplace( ' ', '', $init_class_name );
			$init_class_name = '\\Kirki\\Pro\\' . $init_class_name . '\\Init';
			
			if ( class_exists( $init_class_name ) ) {
				new $init_class_name();
			}
		}

	}

}
