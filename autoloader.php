<?php
/**
 * The Kirki autoloader.
 * Handles locating and loading other class-files.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! function_exists( 'kirki_autoload_classes' ) ) {
	/**
	 * The Kirki class autoloader.
	 * Finds the path to a class that we're requiring and includes the file.
	 *
	 * @param string $class_name The name of the class we're trying to load.
	 */
	function kirki_autoload_classes( $class_name ) {
		$paths = array();
		if ( 0 === stripos( $class_name, 'Kirki' ) ) {

			// Build the filename.
			$filename = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';

			// Break class-name is parts.
			$name_parts = explode( '_', str_replace( 'Kirki_', '', $class_name ) );

			// Handle modules loading.
			if ( isset( $name_parts[0] ) && 'Modules' === $name_parts[0] ) {
				$path  = dirname( __FILE__ ) . '/modules/';
				$path .= strtolower( str_replace( '_', '-', str_replace( 'Kirki_Modules_', '', $class_name ) ) ) . '/';

				$paths[] = $path . $filename;
			}

			if ( isset( $name_parts[0] ) ) {

				// Handle controls loading.
				if ( 'Control' === $name_parts[0] ) {
					$path  = dirname( __FILE__ ) . '/controls/';
					$path .= strtolower( str_replace( '_', '-', str_replace( 'Kirki_Control_', '', $class_name ) ) ) . '/';

					$paths[] = $path . $filename;
				}

				// Handle settings loading.
				if ( 'Settings' === $name_parts[0] ) {
					$path  = dirname( __FILE__ ) . '/controls/';
					$path .= strtolower( str_replace( '_', '-', str_replace( array( 'Kirki_Settings_', '_Setting' ), '', $class_name ) ) ) . '/';

					$paths[] = $path . $filename;
				}
			}

			$paths[] = dirname( __FILE__ ) . '/core/' . $filename;
			$paths[] = dirname( __FILE__ ) . '/lib/' . $filename;

			$substr   = str_replace( 'Kirki_', '', $class_name );
			$exploded = explode( '_', $substr );
			$levels   = count( $exploded );

			$previous_path = '';
			for ( $i = 0; $i < $levels; $i++ ) {
				$paths[] = dirname( __FILE__ ) . '/' . $previous_path . strtolower( $exploded[ $i ] ) . '/' . $filename;
				$previous_path .= strtolower( $exploded[ $i ] ) . '/';
			}

			foreach ( $paths as $path ) {
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					include_once $path;
					return;
				}
			}
		} // End if().
	}
	// Run the autoloader.
	spl_autoload_register( 'kirki_autoload_classes' );
} // End if().
